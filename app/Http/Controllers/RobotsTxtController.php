<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

/**
 * Dynamic robots.txt so Sitemap: can use the configured application URL (APP_URL).
 */
class RobotsTxtController extends Controller
{
    public function __invoke(): Response
    {
        $base = rtrim((string) config('app.url'), '/');
        $body = "User-agent: *\nDisallow:\n\nSitemap: {$base}/sitemap.xml\n";

        return response($body, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}
