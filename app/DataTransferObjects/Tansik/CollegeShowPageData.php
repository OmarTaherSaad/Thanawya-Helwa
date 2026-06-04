<?php

namespace App\DataTransferObjects\Tansik;

use App\Models\Tansik\UniFac;
use Illuminate\Database\Eloquent\Collection;

/**
 * View data for the public college (UniFac) profile page.
 */
final class CollegeShowPageData
{
    /**
     * @param  Collection<int, \App\Models\Tansik\FacultyEdge>  $edges
     */
    public function __construct(
        public readonly UniFac $college,
        public readonly Collection $edges,
    ) {
    }
}
