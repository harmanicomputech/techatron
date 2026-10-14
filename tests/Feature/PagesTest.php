<?php

namespace Tests\Feature;

use App\Support\Content;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PagesTest extends TestCase
{
    public static function pages(): array
    {
        return [
            'home' => ['/', 'We engineer the software your business'],
            'services' => ['/services', 'Engineering and advice for every stage'],
            'approach' => ['/approach', 'A disciplined path from idea'],
            'about' => ['/about', 'A technology partner'],
            'contact' => ['/contact', 'Tell us what you are trying to achieve.'],
            'work' => ['/work', 'Projects told as stories'],
            'privacy' => ['/privacy', 'Privacy notice'],
        ];
    }

    #[DataProvider('pages')]
    public function test_page_renders_with_its_own_metadata(string $uri, string $heading): void
    {
        $response = $this->get($uri);

        $response->assertOk()
            ->assertSee($heading)
            ->assertSee('<link rel="canonical" href="'.url($uri === '/' ? '/' : $uri).'">', false)
            ->assertSee('<meta property="og:image"', false)
            ->assertSee('application/ld+json', false);

        $this->assertSame(1, substr_count($response->getContent(), '<h1'), "{$uri} should have exactly one h1");
    }

    public function test_every_service_has_a_page_linked_from_the_index(): void
    {
        $services = app(Content::class)->services();
        $index = $this->get('/services')->assertOk();

        foreach ($services as $slug => $service) {
            $index->assertSee(route('services.show', $slug), false);

            $this->get("/services/{$slug}")
                ->assertOk()
                ->assertSee(e($service['headline']), false)
                ->assertSee('"@type":"Service"', false)
                ->assertSee(route('contact', ['service' => $slug]), false);
        }
    }

    public function test_unknown_pages_return_a_branded_404(): void
    {
        $this->get('/services/blockchain-magic')->assertNotFound()->assertSee('This page does not exist.');
        $this->get('/work/made-up-project')->assertNotFound();
        $this->get('/nothing-here')->assertNotFound();
    }

    public function test_empty_sections_are_hidden_rather_than_faked(): void
    {
        // No case studies, testimonials or articles are published yet.
        $home = $this->get('/')->assertOk();
        $home->assertDontSee('Selected work')
            ->assertDontSee(route('work.index'), false)
            ->assertDontSee(route('insights.index'), false);

        $this->get('/insights')->assertNotFound();
        $this->get('/work')->assertOk()->assertSee('noindex, follow', false);
    }

    public function test_legacy_urls_redirect_permanently(): void
    {
        $this->get('/about-us')->assertMovedPermanently()->assertRedirect('/about');
        $this->get('/contact-us')->assertMovedPermanently()->assertRedirect('/contact');
        $this->get('/services/managed-services')->assertRedirect('/services/managed-it');
    }

    public function test_sitemap_lists_public_pages_only(): void
    {
        $response = $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $response->assertSee('<loc>'.route('services.show', 'mobile-apps').'</loc>', false)
            ->assertSee('<loc>'.route('contact').'</loc>', false)
            ->assertDontSee('<loc>'.route('work.index').'</loc>', false);
    }

    public function test_robots_blocks_crawlers_outside_production(): void
    {
        $this->get('/robots.txt')->assertOk()->assertSee('Disallow: /');

        $this->app['env'] = 'production';
        $this->get('/robots.txt')->assertSee('Sitemap: '.route('sitemap'));
    }

    public function test_security_headers_are_sent(): void
    {
        $this->get('/')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Content-Security-Policy');
    }

    public function test_contact_page_preselects_a_valid_service_from_the_query(): void
    {
        $this->get('/contact?service=cybersecurity')
            ->assertOk()
            ->assertSee('value="cybersecurity"
                                                checked', false);

        $this->get('/contact?service=<script>')->assertOk()->assertDontSee('<script>', false);
    }
}
