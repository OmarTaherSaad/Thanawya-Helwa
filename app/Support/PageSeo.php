<?php

namespace App\Support;

use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class PageSeo
{
    /**
     * Full meta + Open Graph + Twitter Card + JSON-LD for indexable public pages.
     */
    public static function apply(
        string $title,
        string $description,
        ?string $canonicalUrl = null,
        string $robots = 'index,follow',
        ?string $ogImageUrl = null
    ): void {
        $canonical = $canonicalUrl ?? URL::current();
        $description = Str::limit(trim($description), 300, '');

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical($canonical);
        SEOMeta::setRobots($robots);

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl($canonical);
        OpenGraph::setType('website');
        OpenGraph::setSiteName(config('app.name', 'Thanawya Helwa'));

        $image = $ogImageUrl ?: (string) config('seo.default_og_image', '');
        if ($image !== '') {
            OpenGraph::addImage($image);
            TwitterCard::setImage($image);
        }

        TwitterCard::setType('summary_large_image');
        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        TwitterCard::setUrl($canonical);
        if ($site = (string) config('seo.twitter_site', '')) {
            TwitterCard::setSite($site);
        }

        JsonLd::setTitle($title);
        JsonLd::setDescription($description);
        JsonLd::setUrl($canonical);
        JsonLd::setType('WebPage');
    }

    /**
     * Login, search results, admin entry, etc.
     */
    public static function applyNoindex(string $title, string $description, ?string $canonicalUrl = null): void
    {
        self::apply($title, $description, $canonicalUrl ?? URL::current(), 'noindex,nofollow');
    }

    /**
     * Search-style pages: allow link equity to pass through internal links without indexing SERP-like views.
     */
    public static function applyNoindexFollow(string $title, string $description, ?string $canonicalUrl = null): void
    {
        self::apply($title, $description, $canonicalUrl ?? URL::current(), 'noindex,follow');
    }
}
