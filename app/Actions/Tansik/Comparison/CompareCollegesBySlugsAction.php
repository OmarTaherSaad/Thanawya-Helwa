<?php

namespace App\Actions\Tansik\Comparison;

use App\Models\Tansik\FacultyEdge;
use App\Models\Tansik\UniFac;
use Illuminate\Support\Collection;

/**
 * Builds a year × college matrix of coordination edges for a fixed section.
 */
final class CompareCollegesBySlugsAction
{
    /**
     * @param  array<int, string>  $slugs Active UniFac slugs (2–5).
     * @return array{colleges: Collection<int, UniFac>, years: Collection<int, int|string>, matrix: array<int, array<int|string, float|string|null>>, section: string}
     */
    public function __invoke(array $slugs, string $section = 'E'): array
    {
        $section = strtoupper($section) === 'A' ? 'A' : 'E';

        $colleges = UniFac::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->whereIn('slug', $slugs)
            ->with(['university', 'faculty'])
            ->orderBy('name')
            ->get();

        $ids = $colleges->pluck('id')->all();
        if (count($ids) < 2) {
            return [
                'colleges' => $colleges,
                'years' => collect(),
                'matrix' => [],
                'section' => $section,
            ];
        }

        $edges = FacultyEdge::query()
            ->whereIn('unifac_id', $ids)
            ->where('section', $section)
            ->orderBy('year')
            ->get(['unifac_id', 'year', 'edge']);

        $years = $edges->pluck('year')->unique()->sort()->values();

        $matrix = [];
        foreach ($colleges as $college) {
            $row = [];
            foreach ($years as $year) {
                $edge = $edges->first(function ($e) use ($college, $year) {
                    return (int) $e->unifac_id === (int) $college->id && (int) $e->year === (int) $year;
                });
                $row[$year] = $edge ? round((float) $edge->edge, 2) : null;
            }
            $matrix[$college->id] = $row;
        }

        return [
            'colleges' => $colleges,
            'years' => $years,
            'matrix' => $matrix,
            'section' => $section,
        ];
    }
}
