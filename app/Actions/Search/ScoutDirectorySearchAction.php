<?php

namespace App\Actions\Search;

use App\Models\Tansik\UniFac;
use App\Models\Tansik\University;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Str;

/**
 * Directory search via Laravel Scout (database / Meilisearch / collection per config).
 */
final class ScoutDirectorySearchAction
{
    private const TAKE = 20;

    /**
     * @return array{universities: EloquentCollection<int, University>, colleges: EloquentCollection<int, UniFac>}
     */
    public function __invoke(string $query): array
    {
        $query = trim($query);
        if (Str::length($query) < 2) {
            return [
                'universities' => new EloquentCollection,
                'colleges' => new EloquentCollection,
            ];
        }

        $uniIds = University::search($query)->take(self::TAKE)->keys()->all();
        $universities = $uniIds === [] ? new EloquentCollection : University::query()
            ->whereIn('id', $uniIds)
            ->get()
            ->filter(fn (University $m) => $m->shouldBeSearchable())
            ->sortBy(fn (University $m) => array_search($m->id, $uniIds, true))
            ->values();

        $collegeIds = UniFac::search($query)->take(self::TAKE)->keys()->all();
        $colleges = $collegeIds === [] ? new EloquentCollection : UniFac::query()
            ->whereIn('id', $collegeIds)
            ->with(['university', 'faculty'])
            ->get()
            ->filter(fn (UniFac $m) => $m->shouldBeSearchable())
            ->sortBy(fn (UniFac $m) => array_search($m->id, $collegeIds, true))
            ->values();

        return compact('universities', 'colleges');
    }
}
