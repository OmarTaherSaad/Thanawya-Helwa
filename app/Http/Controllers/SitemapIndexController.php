<?php

namespace App\Http\Controllers;

use App\Actions\Seo\BuildSitemapIndexXmlAction;
use Illuminate\Http\Response;

class SitemapIndexController extends Controller
{
    public function __invoke(BuildSitemapIndexXmlAction $build): Response
    {
        return response($build(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
