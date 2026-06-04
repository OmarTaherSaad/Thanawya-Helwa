<?php

namespace App\Support\Tansik;

/**
 * Classifies coordination (حد أدنى) rows by the Thanawya era that produced comparable totals,
 * plus a separate bucket for «أقدم» tables published alongside the mainstream year file.
 *
 * Year boundaries follow Egyptian secondary reforms (single-year rollout, electronic banks,
 * post‑2024 subject load changes) and can be adjusted in one place if ministry policy shifts.
 */
final class ThanawyaCoordinationSystem
{
    /** Secondary still structured as two study years; coordination totals not comparable to later eras. */
    public const PRE_SINGLE_YEAR = 'pre_single_year';

    /** Single-year Thanawya, pre‑wide electronic question banks (roughly 2015–2020 admissions). */
    public const SINGLE_YEAR_PAPER = 'single_year_paper';

    /** Electronic MCQ / bank-style national exams (roughly 2021–2024 admissions). */
    public const ELECTRONIC_BANK = 'electronic_bank';

    /** Major 2024/25 curriculum and subject-weight changes affecting 12th-grade totals (2025+ admissions). */
    public const NEW_CURRICULUM = 'new_curriculum';

    /** «دفعات أقدم» limits from Limit*O*.htm (parallel table for older repeat / deferred cohorts). */
    public const OLDER_CANDIDATES = 'older_candidates';

    /**
     * @return array<string, string> slug => Arabic label for UI filters
     */
    public static function filterLabels(): array
    {
        return [
            self::PRE_SINGLE_YEAR => 'قبل التحول لسنة واحدة (مجموع مختلف)',
            self::SINGLE_YEAR_PAPER => 'سنة واحدة — امتحان ورقي تقليدي (حوالي 2015–2020)',
            self::ELECTRONIC_BANK => 'بنوك أسئلة إلكترونية (حوالي 2021–2024)',
            self::NEW_CURRICULUM => 'هيكلة مناهج 2024/25 فأحدث (2025+)',
            self::OLDER_CANDIDATES => 'حدود «أقدم» (ملفات منفصلة على موقع التنسيق)',
        ];
    }

    /**
     * @return list<string>
     */
    public static function all(): array
    {
        return [
            self::PRE_SINGLE_YEAR,
            self::SINGLE_YEAR_PAPER,
            self::ELECTRONIC_BANK,
            self::NEW_CURRICULUM,
            self::OLDER_CANDIDATES,
        ];
    }

    public static function resolveForMainStreamAdmissionYear(int $admissionYear): string
    {
        if ($admissionYear <= 2014) {
            return self::PRE_SINGLE_YEAR;
        }
        if ($admissionYear <= 2020) {
            return self::SINGLE_YEAR_PAPER;
        }
        if ($admissionYear <= 2024) {
            return self::ELECTRONIC_BANK;
        }

        return self::NEW_CURRICULUM;
    }

    public static function resolve(bool $isOlderCandidatesLimitFile, int $admissionYear): string
    {
        if ($isOlderCandidatesLimitFile) {
            return self::OLDER_CANDIDATES;
        }

        return self::resolveForMainStreamAdmissionYear($admissionYear);
    }

    /**
     * Admission-year range (inclusive) for each mainstream coordination slug.
     * Used to include legacy rows with null {@see FacultyEdge::$thanawya_system} in the public grid.
     *
     * @return array{0: int, 1: int}|null null if slug is not a mainstream bucket
     */
    public static function admissionYearBoundsForMainStreamSlug(string $slug): ?array
    {
        return match ($slug) {
            self::PRE_SINGLE_YEAR => [1, 2014],
            self::SINGLE_YEAR_PAPER => [2015, 2020],
            self::ELECTRONIC_BANK => [2021, 2024],
            self::NEW_CURRICULUM => [2025, 2100],
            default => null,
        };
    }

    /**
     * Limits a faculty_edges query to rows visible for the public coordination explorer.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\App\Models\Tansik\FacultyEdge>  $query
     */
    public static function applyCoordinationSystemScope(\Illuminate\Database\Eloquent\Builder $query, string $section, string $system): void
    {
        $section = strtoupper($section) === 'A' ? 'A' : 'E';
        $query->where('section', $section);

        if ($system === self::OLDER_CANDIDATES) {
            $query->where('thanawya_system', self::OLDER_CANDIDATES);

            return;
        }

        $bounds = self::admissionYearBoundsForMainStreamSlug($system);
        if ($bounds === null) {
            $query->whereRaw('1 = 0');

            return;
        }

        [$minYear, $maxYear] = $bounds;

        $query->where(function ($outer) use ($system, $minYear, $maxYear): void {
            $outer->where('thanawya_system', $system)
                ->orWhere(function ($inner) use ($minYear, $maxYear): void {
                    $inner->whereNull('thanawya_system')
                        ->whereBetween('year', [$minYear, $maxYear]);
                });
        });
    }

    /**
     * Short guidance for the coordination explorer (shown under the system filter).
     *
     * @return array<string, string> slug => hint
     */
    public static function studentFilterHints(): array
    {
        return [
            self::PRE_SINGLE_YEAR => 'مناسب لو بتقارن أو تذاكر سنوات قبل تحويل الثانوية لسنة واحدة (المجموع الكلي كان مختلف عن اللي بعده).',
            self::SINGLE_YEAR_PAPER => 'يناسب دفعات تقريبًا ٢٠١٥–٢٠٢٠: ثانوية عامة سنة واحدة وتنسيق ورقي تقليدي بمجموع حتى ٤١٠.',
            self::ELECTRONIC_BANK => 'يناسب دفعات تقريبًا ٢٠٢١–٢٠٢٤: بنوك أسئلة إلكترونية وتنسيق بنفس أسلوب المجموع الحديث (٤١٠).',
            self::NEW_CURRICULUM => 'يناسب دفعات بعد هيكلة مناهج ٢٠٢٤/٢٠٢٥؛ لسه التنسيق يظهر تدريجيًا. النسبة في الوضع «٪» تُحسب تقريبًا على ٤١٠ إلى حين ثبوت حد أقصى رسمي جديد.',
            self::OLDER_CANDIDATES => 'دي جداول «أقدم» المنشورة جنب السنة على موقع التنسيق — مجموعات مختلفة عن الطلبة الجدد لنفس السنة.',
        ];
    }

    /**
     * Approximate maximum coordination total used only for the optional % column in the UI.
     * Tune when the ministry publishes a new cap for the post‑2024 track.
     *
     * @return array<string, int>
     */
    public static function percentMaxTotalsForFrontend(): array
    {
        $cap410 = 410;

        return [
            self::PRE_SINGLE_YEAR => $cap410,
            self::SINGLE_YEAR_PAPER => $cap410,
            self::ELECTRONIC_BANK => $cap410,
            self::NEW_CURRICULUM => $cap410,
            self::OLDER_CANDIDATES => $cap410,
        ];
    }
}
