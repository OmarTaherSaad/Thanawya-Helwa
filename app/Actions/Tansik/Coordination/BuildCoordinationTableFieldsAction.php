<?php

namespace App\Actions\Tansik\Coordination;

use Illuminate\Support\Collection;

/**
 * Builds Vuetable "fields" metadata for the historical coordination grid.
 *
 * @param  string  $section  E (علمي) or A (أدبي)
 * @param  string|null  $thanawyaSystem  When null/empty, only name + avg columns (no year columns).
 */
final class BuildCoordinationTableFieldsAction
{
    public function __construct(
        private GetCoordinationDistinctYearsAction $yearsAction,
    ) {
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function __invoke(string $section = 'E', ?string $thanawyaSystem = null): Collection
    {
        $fields = collect();
        $fields->push([
            'title' => 'اسم الكلية',
            'name' => 'name',
            'sortField' => 'name',
        ]);
        $fields->push([
            'title' => 'المتوسط',
            'name' => 'avg',
            'sortField' => 'avg',
            'callback' => 'edgeView',
        ]);

        if ($thanawyaSystem === null || $thanawyaSystem === '') {
            return $fields;
        }

        foreach (($this->yearsAction)($thanawyaSystem, $section) as $year) {
            $yearLabel = (string) $year;
            $fields->push([
                'title' => $yearLabel,
                'name' => $yearLabel,
                'sortField' => $yearLabel,
                'callback' => 'edgeView',
            ]);
        }

        return $fields;
    }
}
