<?php

namespace Tests\Feature\Tansik;

use App\Models\Tansik\FacultyEdge;
use App\Models\Tansik\UniFac;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollegeDirectoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_colleges_index_lists_active_colleges(): void
    {
        UniFac::factory()->create([
            'name' => 'كلية ظاهرة',
            'is_active' => true,
        ]);

        $response = $this->get(route('colleges.index'));

        $response->assertOk();
        $response->assertSee('كلية ظاهرة', false);
    }

    public function test_college_show_displays_edges(): void
    {
        $college = UniFac::factory()->create(['name' => 'كلية تجريبية']);

        FacultyEdge::factory()->create([
            'unifac_id' => $college->id,
            'section' => 'E',
            'TempName' => 'legacy',
            'year' => 2022,
            'edge' => 385.5,
        ]);

        $response = $this->get(route('colleges.show', $college));

        $response->assertOk();
        $response->assertSee('كلية تجريبية', false);
        $response->assertSee('2022', false);
        $response->assertSee('385.5', false);
    }

    public function test_inactive_college_returns_not_found(): void
    {
        $college = UniFac::factory()->create(['name' => 'مخفية']);
        $college->is_active = false;
        $college->saveQuietly();

        $slug = $college->slug;
        $this->assertNotNull($slug);

        $this->get(route('colleges.show', ['college' => $slug]))->assertNotFound();
    }
}
