<?php

namespace App\Http\Controllers;

use App\Actions\Seo\BuildSitemapCollegesUrlsetAction;
use App\Actions\Seo\BuildSitemapStaticUrlsetAction;
use App\Actions\Seo\BuildSitemapUniversitiesUrlsetAction;
use Illuminate\Http\Response;

class SitemapSegmentController extends Controller
{
    public function __invoke(
        string $segment,
        BuildSitemapStaticUrlsetAction $static,
        BuildSitemapCollegesUrlsetAction $colleges,
        BuildSitemapUniversitiesUrlsetAction $universities,
    ): Response {
        $xml = match ($segment) {
            'static' => $static(),
            'colleges' => $colleges(),
            'universities' => $universities(),
            default => abort(404),
        };

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
