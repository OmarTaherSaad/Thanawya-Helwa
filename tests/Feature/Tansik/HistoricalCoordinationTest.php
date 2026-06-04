<?php

namespace Tests\Feature\Tansik;

use App\Actions\Tansik\Coordination\GetCoordinationDistinctYearsAction;
use App\Models\Tansik\FacultyEdge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HistoricalCoordinationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    public function test_previous_edges_page_is_successful(): void
    {
        $response = $this->get(route('tansik.previous_edges'));

        $response->assertOk();
        $response->assertSee('edgesApp', false);
    }

    public function test_coordination_edges_json_groups_rows_and_paginates(): void
    {
        FacultyEdge::factory()->create([
            'section' => 'E',
            'TempName' => 'كلية اختبار',
            'year' => 2020,
            'edge' => 400.5,
        ]);
        FacultyEdge::factory()->create([
            'section' => 'E',
            'TempName' => 'كلية اختبار',
            'year' => 2021,
            'edge' => 410.25,
        ]);

        $response = $this->postJson(route('tansik.get_edges'), [
            'params' => [
                'section' => 'E',
                'filter' => '',
                'sort' => null,
                'page' => 1,
                'per_page' => 50,
            ],
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'data',
            'current_page',
            'per_page',
            'total',
        ]);

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $row = $data[0];
        $this->assertSame('كلية اختبار', $row['name']);
        $this->assertArrayHasKey('avg', $row);
        $y2020 = $row['2020'] ?? $row[2020] ?? null;
        $y2021 = $row['2021'] ?? $row[2021] ?? null;
        $this->assertNotNull($y2020);
        $this->assertNotNull($y2021);
        $this->assertEquals(400.5, (float) $y2020, '', 0.01);
        $this->assertEquals(410.25, (float) $y2021, '', 0.01);
    }

    public function test_distinct_years_cache_is_invalidated_when_edge_saved(): void
    {
        GetCoordinationDistinctYearsAction::forgetCache();

        FacultyEdge::factory()->create([
            'section' => 'E',
            'TempName' => 'أ',
            'year' => 2019,
            'edge' => 300,
        ]);

        $first = (new GetCoordinationDistinctYearsAction())();
        $this->assertTrue($first->contains(2019));

        FacultyEdge::factory()->create([
            'section' => 'E',
            'TempName' => 'ب',
            'year' => 2022,
            'edge' => 320,
        ]);

        $second = (new GetCoordinationDistinctYearsAction())();
        $this->assertTrue($second->contains(2022));
    }
}
