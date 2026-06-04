<?php

namespace App\Actions\Tansik\University;

use App\Models\Tansik\University;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Paginated list of active universities for the public directory.
 */
final class ListUniversitiesAction
{
    /**
     * @return LengthAwarePaginator<int, University>
     */
    public function __invoke(): LengthAwarePaginator
    {
        return University::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->orderBy('name')
            ->paginate(config('app.pagination_max'));
    }
}
