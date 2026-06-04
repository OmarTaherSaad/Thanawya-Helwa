<?php

namespace App\Actions\Tansik\Coordination;

use App\DataTransferObjects\Tansik\CoordinationTableRequestData;
use App\Models\Tansik\FacultyEdge;
use App\Traits\ApiResultsTools;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Loads, groups, sorts, and paginates historical coordination rows for the public grid.
 *
 * Behaviour matches the legacy {@see \App\Http\Controllers\PagesController::getEdges} implementation
 * so existing Vuetable clients keep working without changes.
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
        $years = ($this->yearsAction)();

        $edgesQuery = FacultyEdge::query();
        if ($legacy['filter']) {
            $edgesQuery = $this->searchQuery($edgesQuery, FacultyEdge::class, $legacy['filter']);
        }

        $edgesQuery = $edgesQuery
            ->where('section', $legacy['section'])
            ->orderBy('edge', 'desc')
            ->get()
            ->groupBy('TempName');

        $allEdges = collect();
        foreach ($edgesQuery as $name => $edgesOfName) {
            $edges = collect();
            foreach ($edgesOfName as $edge) {
                $yearKey = $edge->year;
                $edges->put($yearKey, number_format((float) $edge->edge, 2) + 0);
            }
            $edges->put('avg', number_format((float) ($edges->sum() / max($edges->count(), 1)), 2) + 0);
            $edges->put('name', $name);
            $edges->put('section', $edgesOfName->first()->section);
            $allEdges->push($edges);
        }

        foreach ($allEdges as $edge) {
            foreach ($years as $year) {
                if (! Arr::has($edge, $year)) {
                    $edge->put($year, 'غير موجود');
                }
            }
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
