<?php

namespace Tests\Feature\Tansik;

use App\Actions\Tansik\Coordination\GetCoordinationDistinctYearsAction;
use App\Models\Tansik\FacultyEdge;
use App\Support\Tansik\ThanawyaCoordinationSystem;
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
            'year' => 2019,
            'edge' => 400.5,
            'thanawya_system' => ThanawyaCoordinationSystem::SINGLE_YEAR_PAPER,
        ]);
        FacultyEdge::factory()->create([
            'section' => 'E',
            'TempName' => 'كلية اختبار',
            'year' => 2020,
            'edge' => 410.25,
            'thanawya_system' => ThanawyaCoordinationSystem::SINGLE_YEAR_PAPER,
        ]);

        $response = $this->postJson(route('tansik.get_edges'), [
            'params' => [
                'section' => 'E',
                'filter' => '',
                'sort' => null,
                'page' => 1,
                'per_page' => 50,
                'thanawya_system' => ThanawyaCoordinationSystem::SINGLE_YEAR_PAPER,
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
        $this->assertArrayHasKey('rowKey', $row);
        $this->assertSame('كلية اختبار', $row['name']);
        $this->assertArrayHasKey('avg', $row);
        $y2019 = $row['2019'] ?? $row[2019] ?? null;
        $y2020 = $row['2020'] ?? $row[2020] ?? null;
        $this->assertNotNull($y2019);
        $this->assertNotNull($y2020);
        $this->assertEquals(400.5, (float) $y2019, '', 0.01);
        $this->assertEquals(410.25, (float) $y2020, '', 0.01);
    }

    public function test_distinct_years_scoped_to_system(): void
    {
        FacultyEdge::factory()->create([
            'section' => 'E',
            'TempName' => 'أ',
            'year' => 2019,
            'edge' => 300,
            'thanawya_system' => ThanawyaCoordinationSystem::SINGLE_YEAR_PAPER,
        ]);
        FacultyEdge::factory()->create([
            'section' => 'E',
            'TempName' => 'ب',
            'year' => 2023,
            'edge' => 320,
            'thanawya_system' => ThanawyaCoordinationSystem::ELECTRONIC_BANK,
        ]);

        $paper = (new GetCoordinationDistinctYearsAction())(ThanawyaCoordinationSystem::SINGLE_YEAR_PAPER, 'E');
        $this->assertTrue($paper->contains(2019));
        $this->assertFalse($paper->contains(2023));

        $bank = (new GetCoordinationDistinctYearsAction())(ThanawyaCoordinationSystem::ELECTRONIC_BANK, 'E');
        $this->assertTrue($bank->contains(2023));
        $this->assertFalse($bank->contains(2019));

        $empty = (new GetCoordinationDistinctYearsAction())(null, 'E');
        $this->assertTrue($empty->isEmpty());
    }

    public function test_coordination_table_fields_year_columns_match_thanawya_filter(): void
    {
        FacultyEdge::factory()->create([
            'section' => 'E',
            'TempName' => 'برنامج أ',
            'year' => 2019,
            'edge' => 300.0,
            'thanawya_system' => ThanawyaCoordinationSystem::SINGLE_YEAR_PAPER,
        ]);
        FacultyEdge::factory()->create([
            'section' => 'E',
            'TempName' => 'برنامج ب',
            'year' => 2023,
            'edge' => 370.0,
            'thanawya_system' => ThanawyaCoordinationSystem::ELECTRONIC_BANK,
        ]);

        $filtered = $this->postJson(route('tansik.coordination_table_fields'), [
            'params' => [
                'section' => 'E',
                'thanawya_system' => ThanawyaCoordinationSystem::ELECTRONIC_BANK,
                'page' => 1,
                'per_page' => 50,
            ],
        ]);

        $filtered->assertOk();
        $names = collect($filtered->json('fields'))->pluck('name');
        $this->assertTrue($names->contains('2023'));
        $this->assertFalse($names->contains('2019'));

        $this->postJson(route('tansik.coordination_table_fields'), [
            'params' => [
                'section' => 'E',
                'page' => 1,
                'per_page' => 50,
            ],
        ])->assertStatus(422);
    }

    public function test_get_edges_returns_422_when_thanawya_system_missing(): void
    {
        $this->postJson(route('tansik.get_edges'), [
            'params' => [
                'section' => 'E',
                'filter' => '',
                'sort' => null,
                'page' => 1,
                'per_page' => 50,
            ],
        ])->assertStatus(422);
    }

    public function test_coordination_json_filters_by_thanawya_system(): void
    {
        FacultyEdge::factory()->create([
            'section' => 'E',
            'TempName' => 'كلية موحده',
            'year' => 2022,
            'edge' => 360.0,
            'thanawya_system' => ThanawyaCoordinationSystem::ELECTRONIC_BANK,
        ]);
        FacultyEdge::factory()->create([
            'section' => 'E',
            'TempName' => 'كلية موحده',
            'year' => 2022,
            'edge' => 400.0,
            'thanawya_system' => ThanawyaCoordinationSystem::OLDER_CANDIDATES,
        ]);

        $filtered = $this->postJson(route('tansik.get_edges'), [
            'params' => [
                'section' => 'E',
                'filter' => '',
                'sort' => null,
                'page' => 1,
                'per_page' => 50,
                'thanawya_system' => ThanawyaCoordinationSystem::ELECTRONIC_BANK,
            ],
        ]);

        $filtered->assertOk();
        $this->assertCount(1, $filtered->json('data'));
        $this->assertSame(360.0, (float) $filtered->json('data.0.2022'));
    }

    public function test_legacy_null_thanawya_system_row_included_for_mainstream_bounds(): void
    {
        FacultyEdge::factory()->create([
            'section' => 'E',
            'TempName' => 'كلية تراث',
            'year' => 2022,
            'edge' => 350.5,
            'thanawya_system' => null,
        ]);

        $response = $this->postJson(route('tansik.get_edges'), [
            'params' => [
                'section' => 'E',
                'filter' => '',
                'sort' => null,
                'page' => 1,
                'per_page' => 50,
                'thanawya_system' => ThanawyaCoordinationSystem::ELECTRONIC_BANK,
            ],
        ]);

        $response->assertOk();
        $this->assertCount(1, $response->json('data'));
        $this->assertEquals(350.5, (float) $response->json('data.0.2022'), '', 0.01);
    }
}
