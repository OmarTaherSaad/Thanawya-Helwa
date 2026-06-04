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

    public function test_university_slug_is_derived_from_title_not_numeric_id_stub(): void
    {
        $university = University::factory()->create(['name' => 'جامعة تجريبية']);

        $this->assertStringStartsNotWith('university-', (string) $university->fresh()->slug);
        $this->assertSame('gamaa-tgryby', $university->fresh()->slug);
    }

    public function test_legacy_university_id_slug_redirects_to_canonical_slug(): void
    {
        $university = University::factory()->create(['name' => 'جامعة ألفا']);
        $canonical = 'gamaa-alfa';
        $university->forceFill(['slug' => $canonical])->saveQuietly();

        $legacy = 'university-'.$university->id;

        $this->get(route('universities.show', ['university' => $legacy]))
            ->assertStatus(301)
            ->assertRedirect(route('universities.show', ['university' => $canonical]));
    }

    public function test_legacy_university_id_slug_still_resolves_when_it_is_canonical(): void
    {
        $university = University::factory()->create(['name' => 'جامعة بيتا']);
        $legacy = 'university-'.$university->id;
        $university->forceFill(['slug' => $legacy])->saveQuietly();

        $this->get(route('universities.show', ['university' => $legacy]))->assertOk();
    }
}
