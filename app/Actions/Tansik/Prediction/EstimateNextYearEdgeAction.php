<?php

namespace App\Actions\Tansik\Prediction;

use App\Models\Tansik\FacultyEdge;
use App\Models\Tansik\UniFac;

/**
 * Non-official heuristic: average of the last up to three recorded edges.
 *
 * Output is informational only; MoE rules and year noise dominate real outcomes.
 */
final class EstimateNextYearEdgeAction
{
    /**
     * @return array{estimate: ?float, years_used: array<int, int>, disclaimer: string, method: string}
     */
    public function __invoke(UniFac $college, string $section = 'E'): array
    {
        $section = strtoupper($section) === 'A' ? 'A' : 'E';

        $edges = FacultyEdge::query()
            ->where('unifac_id', $college->id)
            ->where('section', $section)
            ->orderByDesc('year')
            ->limit(5)
            ->get(['year', 'edge']);

        $lastThree = $edges->take(3);
        if ($lastThree->isEmpty()) {
            return [
                'estimate' => null,
                'years_used' => [],
                'disclaimer' => 'لا توجد بيانات تنسيق كافية لهذه الكلية في الشعبة المختارة.',
                'method' => 'none',
            ];
        }

        $avg = round((float) $lastThree->avg('edge'), 2);
        $yearsUsed = $lastThree->pluck('year')->map(fn ($y) => (int) $y)->all();

        return [
            'estimate' => $avg,
            'years_used' => $yearsUsed,
            'disclaimer' => 'تقدير تجريبي وليس تنبؤًا رسميًا ولا يغني عن موقع التنسيق أو إرشاد المدرسة.',
            'method' => 'avg_last_'.$lastThree->count().'_years',
        ];
    }
}
