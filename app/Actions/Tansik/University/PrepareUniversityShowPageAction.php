<?php

namespace App\Actions\Tansik\University;

use App\DataTransferObjects\Tansik\UniversityShowPageData;
use App\Models\Tansik\University;

/**
 * Loads public college (UniFac) rows for one university.
 */
final class PrepareUniversityShowPageAction
{
    public function __invoke(University $university): UniversityShowPageData
    {
        $colleges = $university->uniFacs()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->with('faculty')
            ->orderBy('name')
            ->get();

        return new UniversityShowPageData($university, $colleges);
    }
}
