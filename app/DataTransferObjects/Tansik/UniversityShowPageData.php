<?php

namespace App\DataTransferObjects\Tansik;

use App\Models\Tansik\UniFac;
use App\Models\Tansik\University;
use Illuminate\Database\Eloquent\Collection;

/**
 * View data for the public university profile (faculties / UniFac entries).
 */
final class UniversityShowPageData
{
    /**
     * @param  Collection<int, UniFac>  $colleges
     */
    public function __construct(
        public readonly University $university,
        public readonly Collection $colleges,
    ) {
    }
}
