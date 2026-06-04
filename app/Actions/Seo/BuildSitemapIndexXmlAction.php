<?php

namespace App\Actions\Seo;

use App\Models\Tansik\UniFac;
use App\Models\Tansik\University;
use Illuminate\Support\Carbon;

/**
 * Sitemap index pointing at segment urlsets (static, colleges, universities).
 */
final class BuildSitemapIndexXmlAction
{
    public function __invoke(): string
    {
        $lines = [];
        $lines[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $lines[] = '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $staticLm = $this->fileLastModIso(base_path('routes/web.php'));

        $collegeLm = UniFac::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->max('updated_at');

        $uniLm = University::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->max('updated_at');

        $lines[] = $this->sitemapEntry(route('sitemap.segment', ['segment' => 'static']), $staticLm);
        $lines[] = $this->sitemapEntry(route('sitemap.segment', ['segment' => 'colleges']), $collegeLm);
        $lines[] = $this->sitemapEntry(route('sitemap.segment', ['segment' => 'universities']), $uniLm);

        $lines[] = '</sitemapindex>';

        return implode("\n", $lines);
    }

    private function sitemapEntry(string $loc, mixed $lastmod): string
    {
        $el = '<sitemap><loc>'.e($loc).'</loc>';
        if ($lastmod) {
            $el .= '<lastmod>'.e(Carbon::parse($lastmod)->toAtomString()).'</lastmod>';
        }

        return $el.'</sitemap>';
    }

    private function fileLastModIso(string $path): ?string
    {
        if (! is_file($path)) {
            return null;
        }

        return Carbon::createFromTimestamp((int) filemtime($path))->toAtomString();
    }
}
