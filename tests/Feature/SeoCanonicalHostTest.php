<?php

namespace Tests\Feature;

use Tests\TestCase;

class SeoCanonicalHostTest extends TestCase
{
    public function test_redirects_when_request_host_differs_from_app_url_host(): void
    {
        config([
            'app.url' => 'https://www.example.com',
            'seo.canonical_host_redirect' => true,
        ]);

        $this->call('GET', 'https://example.com/robots.txt', [], [], [], ['HTTPS' => 'on'])
            ->assertStatus(301)
            ->assertRedirect('https://www.example.com/robots.txt');
    }

    public function test_no_redirect_when_host_matches_app_url(): void
    {
        config([
            'app.url' => 'https://www.example.com',
            'seo.canonical_host_redirect' => true,
        ]);

        $this->call('GET', 'https://www.example.com/robots.txt', [], [], [], ['HTTPS' => 'on'])
            ->assertOk();
    }

    public function test_redirect_can_be_disabled(): void
    {
        config([
            'app.url' => 'https://www.example.com',
            'seo.canonical_host_redirect' => false,
        ]);

        $this->call('GET', 'https://example.com/robots.txt', [], [], [], ['HTTPS' => 'on'])
            ->assertOk();
    }
}
