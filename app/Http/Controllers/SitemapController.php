<?php

namespace App\Http\Controllers;

use App\Actions\Seo\BuildSitemapXmlAction;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(BuildSitemapXmlAction $build): Response
    {
        $xml = $build();

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
