<?php

namespace App\Actions\Seo;

use App\Models\Tansik\UniFac;
use Illuminate\Support\Carbon;

final class BuildSitemapCollegesUrlsetAction
{
    public function __invoke(): string
    {
        $lines = [];
        $lines[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $lines[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        UniFac::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->orderBy('id')
            ->select(['id', 'slug', 'updated_at'])
            ->chunkById(500, function ($rows) use (&$lines): void {
                foreach ($rows as $row) {
                    $loc = route('colleges.show', ['college' => $row->slug]);
                    $lm = Carbon::parse($row->updated_at)->toAtomString();
                    $lines[] = '<url><loc>'.e($loc).'</loc><lastmod>'.e($lm).'</lastmod></url>';
                }
            });

        $lines[] = '</urlset>';

        return implode("\n", $lines);
    }
}
