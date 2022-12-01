<?php

namespace App\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use \Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

/**
 * Trait to add Searching, Filteration, Sorting, and Pagination functionality to API controllers.
 */
trait ApiResultsTools
{

    #region With-Request Methods

    /**
     * Search all columns of a model for a search term in request
     * @param Request $request
     * @param Builder $query
     * @param string $searchable Model
     * @return Builder
     */
    public function search(Request $request, Builder $query, $searchable)
    {
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $columns = Schema::getColumnListing($searchable);
            $query = $query->where(function ($query) use ($searchTerm, $columns) {
                foreach ($columns as $column) {
                    $query->orWhereRaw("UPPER({$column}) LIKE '%" . strtoupper($searchTerm) . "%'");
                }
            });
        }
        return $query;
    }

    /**
     * Filter results by filters in request
     * @param Request $request
     * @param Builder $query
     * @param string $filterable Model
     * @return Builder
     */
    public function filter(Request $request, Builder $query, $filterable = null)
    {
        $filters = collect($request->input('filters'))->map(function ($filter) {
            return explode(',', $filter);
        })->map(function ($filter) {
            return [
                'field_name' => $filter[0],
                'operator' => $filter[1],
                'value' => $filter[2]
            ];
        });
        foreach ($filters as $filter) {
            $where = 'where';
            $value = $filter['value'];
            if (isset($filterable) && in_array(Schema::getColumnType($filterable, $filter['field_name']), ['date', 'datetime'])) {
                $where = 'whereDate';
                $value = Carbon::createFromFormat('d-m-Y', $filter['value']);
            }
            $query = $query->$where($filter['field_name'], $filter['operator'], $value);
        }
        return $query;
    }

    /**
     * Sort results by sort in request
     * @param Request $request
     * @param Builder $query
     * @param string $sortable Model
     * @return Builder
     */
    public function sort(Request $request, Builder $query, $sortable = null)
    {
        if ($request->filled('sort')) {
            $sort = explode(',', $request->input('sort'));
            $columns = Schema::getColumnListing($sortable);
            if (in_array($sort[0], $columns)) {
                $query = $query->orderBy($sort[0], $sort[1]);
            }
        }
        return $query;
    }

    /**
     * Paginate results by pagination in request
     * @param Request $request
     * @param Builder $query
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(Request $request, Builder $query)
    {
        $page_size = $request->input('page_size') ?? 20;
        return $query->paginate($page_size);
    }

    public function paginateCollection($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    #endregion

    #region No-Request Methods

    /**
     * Filter results by filters provided
     * @param Builder $query
     * @param string $filterable Model
     * @param array $filters
     * @return Builder
     */
    public function filterNoRequest(Builder $query, $filterable = null, array $filters = [])
    {
        $filters = collect($filters)->map(function ($filter) {
            return explode(',', $filter);
        })->map(function ($filter) {
            return [
                'field_name' => $filter[0],
                'operator' => $filter[1],
                'value' => $filter[2]
            ];
        });
        foreach ($filters as $filter) {
            $where = 'where';
            $value = $filter['value'];
            try {
                if (isset($filterable) && in_array(Schema::getColumnType($filterable, $filter['field_name']), ['date', 'datetime'])) {
                    $where = 'whereDate';
                    $value = Carbon::createFromFormat('d-m-Y', $filter['value']);
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
            $query = $query->$where($filter['field_name'], $filter['operator'], $value);
        }
        return $query;
    }

    /**
     * Sort results by sort order provided
     * @param Builder $query
     * @param string $sortable Model
     * @param string $sortOrder
     * @return Builder
     */
    public function sortNoRequest(Builder $query, $sortable = null, $sortOrder = null)
    {
        if (isset($sortOrder)) {
            $sort = explode(',', $sortOrder);
            $columns = Schema::getColumnListing($sortable);
            if (in_array($sort[0], $columns)) {
                $query = $query->orderBy($sort[0], $sort[1]);
            }
        }
        return $query;
    }

    /**
     * Search all columns of a model for a search term provided
     * @param Builder $query
     * @param string $searchable Model
     * @param string $searchTerm
     * @return Builder
     */
    public function searchQuery(Builder $query, $searchable, string $searchTerm)
    {
        if (!empty($searchTerm)) {
            $columns = Schema::getColumnListing($searchable);
            $query = $query->where(function ($query) use ($searchTerm, $columns) {
                foreach ($columns as $column) {
                    $query->orWhereRaw("UPPER({$column}) LIKE '%" . strtoupper($searchTerm) . "%'");
                }
            });
        }
        return $query;
    }
    #endregion


    #region Collection Methods

    /**
     * Filter results by filters provided
     * @param Collection $collection
     * @param string $filterable Model
     * @param array $filters
     * @return Collection
     */
    public function filterCollection(Collection $collection, $filterable = null, array $filters = [])
    {
        $filters = collect($filters)->map(function ($filter) {
            return explode(',', $filter);
        })->map(function ($filter) {
            return [
                'field_name' => $filter[0],
                'operator' => $filter[1],
                'value' => $filter[2]
            ];
        });
        foreach ($filters as $filter) {
            $where = 'where';
            $value = $filter['value'];
            try {
                if (isset($filterable) && in_array(Schema::getColumnType($filterable, $filter['field_name']), ['date', 'datetime'])) {
                    $where = 'whereDate';
                    $value = Carbon::createFromFormat('d-m-Y', $filter['value']);
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
            $collection = $collection->$where($filter['field_name'], $filter['operator'], $value);
        }
        return $collection;
    }

    /**
     * Sort collection by sort order provided
     * @param Collection $collection
     * @param string $sortable Model
     * @param string $sortOrder
     * @return Collection
     */
    public function sortCollection(Collection $collection, $sortable = null, $sortOrder = null)
    {
        if (isset($sortOrder)) {
            $sort = explode(',', $sortOrder);
            $columns = Schema::getColumnListing($sortable);
            if (in_array($sort[0], $columns)) {
                $collection = $collection->sortBy($sort[0], SORT_REGULAR, strtolower($sort[1]) == 'desc');
            }
        }
        return $collection;
    }

    /**
     * Search all columns of a model in collection for a search term provided
     * @param Collection $collection
     * @param string $searchable Model
     * @param string $searchTerm
     * @return Collection
     */
    public function searchCollection(Collection $collection, $searchable, string $searchTerm)
    {
        if (!empty($searchTerm)) {
            $columns = Schema::getColumnListing($searchable);
            $collection = $collection->where(function ($collection) use ($searchTerm, $columns) {
                foreach ($columns as $column) {
                    $collection->orWhereRaw("UPPER({$column}) LIKE '%" . strtoupper($searchTerm) . "%'");
                }
            });
        }
        return $collection;
    }
    #endregion

    /**
     * Make search, filtration, sorting, and pagination on given query of given table, respectivly.
     * @param Request $request
     * @param Builder $query
     * @param string $table Name of the table to search, filter, sort, and paginate.
     * @param bool $paginate Whether to paginate or not.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Builder
     */
    public function queryRefinements(Request $request, Builder $query, $table, bool $paginate = true)
    {
        $query = $this->search($request, $query, $table);
        $query = $this->filter($request, $query, $table);
        $query = $this->sort($request, $query, $table);
        if ($paginate) {
            $query = $this->paginate($request, $query)->appends($request->only('search', 'filters', 'sort'));
        }
        return $query;
    }

    /**
     * Make search, filtration, sorting, and pagination on given query of given table, respectivly.
     * @param Builder $query
     * @param string $table Name of the table to search, filter, sort, and paginate.
     * @param string $searchTerm Search term.
     * @param array $filters Filters to apply.
     * @param string $sortOrder Sort order.
     * @return Builder
     */
    public function queryRefinementsNoRequest(Builder $query, $table, $searchTerm = '', array $filters = [], $sortOrder = '')
    {
        if (!empty($searchTerm)) {
            $query = $this->searchQuery($query, $table, $searchTerm);
        }
        if (count($filters) > 0) {
            $query = $this->filterNoRequest($query, $table, $filters);
        }
        if (!empty($sortOrder)) {
            $query = $this->sortNoRequest($query, $table, $sortOrder);
        }
        return $query;
    }

    /**
     * Make search, filtration, sorting, and pagination on given collection of given table, respectivly.
     * @param Collection $collection
     * @param string $table Name of the table to search, filter, sort, and paginate.
     * @param string $searchTerm Search term.
     * @param array $filters Filters to apply.
     * @param string $sortOrder Sort order.
     * @return Collection
     */
    public function queryRefinementsCollection(Collection $collection, $table, $searchTerm = '', array $filters = [], $sortOrder = '')
    {
        if (!empty($searchTerm)) {
            $collection = $this->searchCollection($collection, $table, $searchTerm);
        }
        if (count($filters) > 0) {
            $collection = $this->filterCollection($collection, $table, $filters);
        }
        if (!empty($sortOrder)) {
            $collection = $this->sortCollection($collection, $table, $sortOrder);
        }
        return $collection;
    }
}
