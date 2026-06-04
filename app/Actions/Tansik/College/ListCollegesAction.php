<?php

namespace App\Actions\Tansik\College;

use App\Models\Tansik\UniFac;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Paginated list of active colleges for the public directory.
 */
final class ListCollegesAction
{
    /**
     * @return LengthAwarePaginator<int, UniFac>
     */
    public function __invoke(): LengthAwarePaginator
    {
        return UniFac::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->with(['university', 'faculty'])
            ->orderBy('name')
            ->paginate(config('app.pagination_max'));
    }
}
