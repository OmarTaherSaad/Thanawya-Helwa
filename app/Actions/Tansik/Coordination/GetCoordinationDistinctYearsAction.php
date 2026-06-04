<?php

namespace App\Actions\Tansik\Coordination;

use App\Models\Tansik\FacultyEdge;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Returns distinct admission years present in coordination data, sorted ascending.
 *
 * Result is cached to avoid repeated full-table scans on popular pages.
 */
final class GetCoordinationDistinctYearsAction
{
    public const CACHE_KEY = 'tansik.coordination.distinct_years';

    /**
     * Cache TTL in seconds (1 hour). Coordination data changes infrequently; editors
     * still get fresh years shortly after edits via {@see FacultyEdge} model events.
     */
    private const TTL = 3600;

    /**
     * @return Collection<int, int|string>
     */
    public function __invoke(): Collection
    {
        /** @var array<int, int|string> $years */
        $years = Cache::remember(self::CACHE_KEY, self::TTL, function (): array {
            return FacultyEdge::query()
                ->distinct()
                ->orderBy('year')
                ->pluck('year')
                ->values()
                ->all();
        });

        return collect($years)->unique()->sort()->values();
    }

    public static function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
