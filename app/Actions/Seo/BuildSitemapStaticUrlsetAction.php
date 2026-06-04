<?php

namespace App\Actions\Seo;

use Illuminate\Support\Carbon;

/**
 * Urlset for non-directory pages (home, about, directories index, careers, …).
 */
final class BuildSitemapStaticUrlsetAction
{
    public function __invoke(): string
    {
        $lastmod = $this->fileLastModIso(base_path('routes/web.php')) ?? Carbon::now()->toAtomString();

        $lines = [];
        $lines[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $lines[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($this->staticUrls() as $loc) {
            $lines[] = $this->urlEl($loc, $lastmod);
        }

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

    private function urlEl(string $loc, string $lastmod): string
    {
        return '<url><loc>'.e($loc).'</loc><lastmod>'.e($lastmod).'</lastmod></url>';
    }

    private function fileLastModIso(string $path): ?string
    {
        if (! is_file($path)) {
            return null;
        }

        return Carbon::createFromTimestamp((int) filemtime($path))->toAtomString();
    }
}
