<?php

use App\Models\Tansik\UniFac;
use App\Models\Tansik\University;
use App\Support\SeoSlug;
use Illuminate\Database\Migrations\Migration;

/**
 * Replace legacy university-{id} / college-{id} slugs with transliterated title-based URLs for SEO.
 */
return new class extends Migration
{
    public function up(): void
    {
        foreach (University::query()->orderBy('id')->cursor() as $university) {
            $base = SeoSlug::fromTitle((string) $university->name, 'university');
            $slug = SeoSlug::unique(
                $base,
                fn (string $candidate): bool => University::query()
                    ->where('slug', $candidate)
                    ->whereKeyNot($university->getKey())
                    ->exists()
            );

            if ($university->slug !== $slug) {
                $university->forceFill(['slug' => $slug])->saveQuietly();
            }
        }

        foreach (UniFac::query()->with('university')->orderBy('id')->cursor() as $row) {
            $title = implode(' ', array_filter([(string) $row->name, $row->university?->name]));
            $base = SeoSlug::fromTitle($title, 'college');
            $slug = SeoSlug::unique(
                $base,
                fn (string $candidate): bool => UniFac::query()
                    ->where('slug', $candidate)
                    ->whereKeyNot($row->getKey())
                    ->exists()
            );

            if ($row->slug !== $slug) {
                $row->forceFill(['slug' => $slug])->saveQuietly();
            }
        }
    }

    public function down(): void
    {
        foreach (University::query()->orderBy('id')->cursor() as $university) {
            $university->forceFill(['slug' => 'university-'.$university->getKey()])->saveQuietly();
        }

        foreach (UniFac::query()->orderBy('id')->cursor() as $row) {
            $row->forceFill(['slug' => 'college-'.$row->getKey()])->saveQuietly();
        }
    }
};
