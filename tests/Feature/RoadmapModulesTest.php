<?php

namespace Tests\Feature;

use App\Models\Tansik\FacultyEdge;
use App\Models\Tansik\UniFac;
use App\Models\Tansik\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoadmapModulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_careers_page_ok(): void
    {
        $this->get(route('careers.index'))->assertOk()->assertSee('تنسيق السنوات السابقة', false);
    }

    public function test_sitemap_returns_xml(): void
    {
        $r = $this->get('/sitemap.xml');
        $r->assertOk();
        $r->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $this->assertStringContainsString('<urlset', $r->getContent());
        $this->assertStringContainsString('</urlset>', $r->getContent());
    }

    public function test_search_finds_university_name(): void
    {
        University::factory()->create(['name' => 'جامعة البحث الفريد']);

        $this->get(route('search.index', ['q' => 'البحث الفريد']))
            ->assertOk()
            ->assertSee('جامعة البحث الفريد', false);
    }

    public function test_college_compare_matrix(): void
    {
        $uni = University::factory()->create();
        $c1 = UniFac::factory()->create(['university_id' => $uni->id, 'name' => 'كلية أ']);
        $c2 = UniFac::factory()->create(['university_id' => $uni->id, 'name' => 'كلية ب']);
        $c1->refresh();
        $c2->refresh();

        FacultyEdge::factory()->create(['unifac_id' => $c1->id, 'section' => 'E', 'year' => 2021, 'edge' => 400, 'TempName' => 't1']);
        FacultyEdge::factory()->create(['unifac_id' => $c2->id, 'section' => 'E', 'year' => 2021, 'edge' => 410, 'TempName' => 't2']);

        $slugs = $c1->slug.','.$c2->slug;
        $this->get(route('colleges.compare', ['slugs' => $slugs, 'section' => 'E']))
            ->assertOk()
            ->assertSee('2021', false)
            ->assertSee('400', false)
            ->assertSee('410', false);
    }

    public function test_coordination_estimate_post(): void
    {
        $college = UniFac::factory()->create();
        $college->refresh();

        FacultyEdge::factory()->create([
            'unifac_id' => $college->id,
            'section' => 'E',
            'year' => 2020,
            'edge' => 390,
            'TempName' => 'x',
        ]);
        FacultyEdge::factory()->create([
            'unifac_id' => $college->id,
            'section' => 'E',
            'year' => 2021,
            'edge' => 400,
            'TempName' => 'x',
        ]);

        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $this->post(route('tansik.coordination_estimate.submit'), [
            'college_slug' => $college->slug,
            'section' => 'E',
        ])->assertOk()->assertSee('395', false);
    }
}
