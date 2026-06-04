<?php

namespace App\Actions\Tansik\College;

use App\DataTransferObjects\Tansik\CollegeShowPageData;
use App\Models\Tansik\UniFac;
use App\Support\Tansik\ThanawyaCoordinationSystem;

/**
 * Loads coordination rows for a single college profile.
 */
final class PrepareCollegeShowPageAction
{
    public function __invoke(UniFac $college): CollegeShowPageData
    {
        $college->loadMissing(['university', 'faculty']);

        $edges = $college->edges()
            ->where(function ($q): void {
                $q->whereNull('thanawya_system')
                    ->orWhere('thanawya_system', '<>', ThanawyaCoordinationSystem::OLDER_CANDIDATES);
            })
            ->orderByDesc('year')
            ->orderBy('section')
            ->get();

        return new CollegeShowPageData($college, $edges);
    }
}
