<?php

namespace App\Actions\Tansik\Coordination;

use App\DataTransferObjects\Tansik\CoordinationTableRequestData;
use App\Models\Tansik\FacultyEdge;
use App\Support\Tansik\ThanawyaCoordinationSystem;
use App\Traits\ApiResultsTools;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Loads, groups, sorts, and paginates historical coordination rows for the public grid.
 *
 * A Thanawya system must be selected; rows are limited with {@see ThanawyaCoordinationSystem::applyCoordinationSystemScope}.
 */
final class FetchCoordinationEdgesAction
{
    use ApiResultsTools;

    public function __construct(
        private GetCoordinationDistinctYearsAction $yearsAction,
    ) {
    }

    public function __invoke(CoordinationTableRequestData $data): LengthAwarePaginator
    {
        $legacy = $data->toLegacyParamsArray();
        $system = $legacy['thanawya_system'] ?? null;
        if ($system === null || $system === '') {
            return $this->paginateCollection(collect(), $legacy['per_page'] ?? 100, $legacy['page'] ?? 1);
        }

        $years = ($this->yearsAction)($system, $legacy['section']);

        $edgesQuery = FacultyEdge::query();
        if ($legacy['filter']) {
            $edgesQuery = $this->searchQuery($edgesQuery, FacultyEdge::class, $legacy['filter']);
        }

        ThanawyaCoordinationSystem::applyCoordinationSystemScope($edgesQuery, $legacy['section'], $system);

        $edgesQuery = $edgesQuery
            ->orderBy('edge', 'desc')
            ->get()
            ->groupBy(static function (FacultyEdge $edge): string {
                $older = $edge->thanawya_system === ThanawyaCoordinationSystem::OLDER_CANDIDATES;

                return $edge->TempName.($older ? "\x01older_candidates" : '');
            });

        $allEdges = collect();
        foreach ($edgesQuery as $edgesOfName) {
            $edges = collect();
            $first = $edgesOfName->first();
            foreach ($edgesOfName as $edge) {
                $yearKey = $edge->year;
                $edges->put($yearKey, number_format((float) $edge->edge, 2) + 0);
            }
            $baseName = $first->TempName;
            $displayName = $baseName;
            if ($first->thanawya_system === ThanawyaCoordinationSystem::OLDER_CANDIDATES) {
                $displayName .= ' — أقدم';
            }
            $edges->put('name', $displayName);
            $edges->put('rowKey', sha1($baseName.'|'.($first->thanawya_system === ThanawyaCoordinationSystem::OLDER_CANDIDATES ? 'older' : 'main')));
            $edges->put('section', $first->section);
            $allEdges->push($edges);
        }

        foreach ($allEdges as $edge) {
            foreach ($years as $year) {
                if (! Arr::has($edge, $year)) {
                    $edge->put($year, 'غير موجود');
                }
            }
            $numericForAvg = $years->filter(function ($y) use ($edge) {
                $v = $edge->get($y);

                return is_numeric($v);
            })->map(function ($y) use ($edge) {
                return (float) $edge->get($y);
            });
            $edge->put('avg', $numericForAvg->isEmpty()
                ? 0
                : (number_format((float) $numericForAvg->avg(), 2) + 0));
        }

        if ($legacy['sort']) {
            $allEdges = $this->applySort($allEdges, $legacy['sort']);
        }

        return $this->paginateCollection(
            $allEdges,
            $legacy['per_page'] ?? 100,
            $legacy['page'] ?? 1
        );
    }

    /**
     * @param  Collection<int, Collection<string, mixed>>  $allEdges
     * @return Collection<int, Collection<string, mixed>>
     */
    private function applySort(Collection $allEdges, string $sort): Collection
    {
        $sort = explode('|', $sort);
        if (count($sort) < 2) {
            return $allEdges;
        }

        $field = $sort[0];
        $direction = $sort[1];

        if ($direction === 'asc') {
            if (is_numeric($field)) {
                return $allEdges->sortBy(function ($edge) use ($field) {
                    return is_numeric($edge[$field]) ? $edge[$field] : 500;
                })->values();
            }

            return $allEdges->sortBy($field)->values();
        }

        if (is_numeric($field)) {
            return $allEdges->sortByDesc(function ($edge) use ($field) {
                return is_numeric($edge[$field]) ? $edge[$field] : -1;
            })->values();
        }

        return $allEdges->sortByDesc($field)->values();
    }
}
