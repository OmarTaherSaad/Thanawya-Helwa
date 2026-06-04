<?php

namespace App\Actions\Search;

use App\Models\Tansik\UniFac;
use App\Models\Tansik\University;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Str;

/**
 * Bounded LIKE search across university and college (UniFac) names only.
 */
final class InternalSearchAction
{
    private const LIMIT = 20;

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

        $like = '%'.addcslashes($query, '%_\\').'%';

        $universities = University::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->where('name', 'like', $like)
            ->orderBy('name')
            ->limit(self::LIMIT)
            ->get();

        $colleges = UniFac::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->where('name', 'like', $like)
            ->with(['university', 'faculty'])
            ->orderBy('name')
            ->limit(self::LIMIT)
            ->get();

        return compact('universities', 'colleges');
    }
}
