<?php

namespace App\Actions\Tansik\Coordination;

use Illuminate\Support\Collection;

/**
 * Builds Vuetable "fields" metadata for the historical coordination grid.
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
    public function __invoke(): Collection
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

        foreach (($this->yearsAction)() as $year) {
            $fields->push([
                'name' => (string) $year,
                'sortField' => (string) $year,
                'callback' => 'edgeView',
            ]);
        }

        return $fields;
    }
}
