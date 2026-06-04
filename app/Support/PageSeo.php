<?php

namespace App\Support;

use Artesaos\SEOTools\Facades\JsonLdMulti;
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
        OpenGraph::setSiteName((string) (config('seo.site_name') ?: config('app.name', 'Thanawya Helwa')));
        $locale = (string) config('seo.og_locale', 'ar_EG');
        if ($locale !== '') {
            OpenGraph::addProperty('locale', $locale);
        }

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

        // SEO::generate() renders json-ld-multi, not the json-ld singleton — keep them in sync.
        JsonLdMulti::select(0);
        JsonLdMulti::setTitle($title);
        JsonLdMulti::setDescription($description);
        JsonLdMulti::setUrl($canonical);
        JsonLdMulti::setType('WebPage');

        self::appendSiteStructuredData();
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

    /**
     * Global Organization + WebSite (SearchAction) graph nodes for richer results / discoverability.
     */
    protected static function appendSiteStructuredData(): void
    {
        $baseUrl = rtrim((string) config('app.url'), '/');
        $siteName = (string) (config('seo.site_name') ?: config('app.name', 'Thanawya Helwa'));

        $orgValues = array_filter([
            '@id' => $baseUrl.'#organization',
            'name' => $siteName,
            'url' => $baseUrl,
        ]);

        $logo = trim((string) config('seo.organization_logo', ''));
        if ($logo !== '') {
            $orgValues['logo'] = [
                '@type' => 'ImageObject',
                'url' => $logo,
            ];
        }

        JsonLdMulti::newJsonLd()
            ->setType('Organization')
            ->addValues($orgValues);

        $searchTemplate = route('search.index', [], true).'?q={search_term_string}';

        JsonLdMulti::newJsonLd()
            ->setType('WebSite')
            ->addValues([
                '@id' => $baseUrl.'#website',
                'name' => $siteName,
                'url' => $baseUrl,
                'publisher' => ['@id' => $baseUrl.'#organization'],
                'potentialAction' => [
                    '@type' => 'SearchAction',
                    'target' => [
                        '@type' => 'EntryPoint',
                        'urlTemplate' => $searchTemplate,
                    ],
                    'query-input' => 'required name=search_term_string',
                ],
            ]);
    }
}
