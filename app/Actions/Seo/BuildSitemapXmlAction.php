<?php

namespace App\Actions\Seo;

use App\Models\Tansik\UniFac;
use App\Models\Tansik\University;

/**
 * Builds a single-urlset sitemap for indexable public routes.
 */
final class BuildSitemapXmlAction
{
    public function __invoke(): string
    {
        $lines = [];
        $lines[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $lines[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($this->staticUrls() as $loc) {
            $lines[] = $this->urlEl($loc);
        }

        UniFac::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->orderBy('id')
            ->select(['id', 'slug'])
            ->chunkById(500, function ($rows) use (&$lines): void {
                foreach ($rows as $row) {
                    $lines[] = $this->urlEl(route('colleges.show', ['college' => $row->slug]));
                }
            });

        University::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->orderBy('id')
            ->select(['id', 'slug'])
            ->chunkById(500, function ($rows) use (&$lines): void {
                foreach ($rows as $row) {
                    $lines[] = $this->urlEl(route('universities.show', ['university' => $row->slug]));
                }
            });

        $lines[] = '</urlset>';

        return implode("\n", $lines);
    }

    /**
     * @return list<string>
     */
    private function staticUrls(): array
    {
        return array_values(array_unique(array_filter([
            url('/'),
            route('about-us'),
            route('join-us'),
            route('contact'),
            route('tansik.previous_edges'),
            route('colleges.index'),
            route('colleges.compare'),
            route('universities.index'),
            route('careers.index'),
        ])));
    }

    private function urlEl(string $loc): string
    {
        return '<url><loc>'.e($loc).'</loc></url>';
    }
}
