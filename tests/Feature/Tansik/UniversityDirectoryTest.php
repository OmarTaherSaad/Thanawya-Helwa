<?php

namespace Tests\Feature\Tansik;

use App\Models\Tansik\UniFac;
use App\Models\Tansik\University;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UniversityDirectoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_universities_index_lists_active_universities(): void
    {
        University::factory()->create(['name' => 'جامعة ظاهرة']);

        $response = $this->get(route('universities.index'));

        $response->assertOk();
        $response->assertSee('جامعة ظاهرة', false);
    }

    public function test_university_show_lists_linked_colleges(): void
    {
        $university = University::factory()->create(['name' => 'جامعة تجريبية']);
        UniFac::factory()->create([
            'university_id' => $university->id,
            'name' => 'كلية الطب التجريبية',
        ]);

        $response = $this->get(route('universities.show', $university));

        $response->assertOk();
        $response->assertSee('جامعة تجريبية', false);
        $response->assertSee('كلية الطب التجريبية', false);
    }

    public function test_inactive_university_returns_not_found(): void
    {
        $university = University::factory()->create(['name' => 'مخفية']);
        $university->is_active = false;
        $university->saveQuietly();

        $slug = $university->slug;
        $this->assertNotNull($slug);

        $this->get(route('universities.show', ['university' => $slug]))->assertNotFound();
    }
}
