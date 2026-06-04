<?php

namespace App\Actions\Tansik\Coordination;

use App\Models\Tansik\FacultyEdge;
use App\Support\Tansik\ThanawyaCoordinationSystem;
use Illuminate\Support\Collection;

/**
 * Returns distinct admission years for the coordination grid, sorted ascending.
 *
 * Years are scoped to {@see $section} and the selected Thanawya system (required for the public grid).
 * Legacy rows with null {@see FacultyEdge::$thanawya_system} are included when their admission year
 * falls in the mainstream range for that system.
 */
final class GetCoordinationDistinctYearsAction
{
    /**
     * @return Collection<int, int|string>
     */
    public function __invoke(?string $thanawyaSystem, string $section = 'E'): Collection
    {
        $section = strtoupper($section) === 'A' ? 'A' : 'E';
        $system = $this->normalizeSystem($thanawyaSystem);
        if ($system === null) {
            return collect();
        }

        $query = FacultyEdge::query();
        ThanawyaCoordinationSystem::applyCoordinationSystemScope($query, $section, $system);

        return $query->distinct()
            ->orderBy('year')
            ->pluck('year')
            ->unique()
            ->sort()
            ->values();
    }

    private function normalizeSystem(?string $thanawyaSystem): ?string
    {
        if ($thanawyaSystem === null || $thanawyaSystem === '') {
            return null;
        }

        return in_array($thanawyaSystem, ThanawyaCoordinationSystem::all(), true) ? $thanawyaSystem : null;
    }

    public static function forgetCache(): void
    {
        // Historical name: coordination years are no longer cached globally.
    }
}
