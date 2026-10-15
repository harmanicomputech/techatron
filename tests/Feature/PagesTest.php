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
            'home' => ['/', 'Turn ideas into'],
            'services' => ['/services', 'Everything your digital presence needs'],
            'approach' => ['/approach', 'A disciplined path from idea'],
            'about' => ['/about', 'A digital agency that thinks like an engineer'],
            'contact' => ['/contact', 'Let’s build something remarkable together.'],
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

    public function test_structured_data_is_valid_json_on_every_page(): void
    {
        $uris = ['/', '/about', '/approach', '/contact', '/services'];
        foreach (app(Content::class)->services()->keys() as $slug) {
            $uris[] = "/services/{$slug}";
        }

        foreach ($uris as $uri) {
            $html = $this->get($uri)->assertOk()->getContent();
            preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $blocks);
            $this->assertNotEmpty($blocks[1], "{$uri} has no structured data");

            foreach ($blocks[1] as $json) {
                $data = json_decode($json, true);
                $this->assertIsArray($data, "{$uri} has invalid JSON-LD");
                $this->assertSame('https://schema.org', $data['@context'] ?? null, "{$uri} JSON-LD is missing @context");
                $this->assertStringNotContainsString('<?php', $json);
            }
        }
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
        $this->get('/services/mobile-apps')->assertRedirect('/services/mobile-app-development');
        $this->get('/services/custom-software')->assertRedirect('/services/software-development');
    }

    public function test_sitemap_lists_public_pages_only(): void
    {
        $response = $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $response->assertSee('<loc>'.route('services.show', 'mobile-app-development').'</loc>', false)
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

    public function test_the_agency_positioning_and_specialties_lead_the_homepage(): void
    {
        $home = $this->get('/')->assertOk();

        $home->assertSee('Digital agency')
            ->assertSeeInOrder(['Website Development', 'Software Development', 'Mobile App Development'])
            ->assertSee(route('services.show', 'digital-marketing'), false)
            ->assertSee('data-theme-toggle', false)
            ->assertSee(asset('images/logo.png'), false)
            ->assertSee(asset('images/logo-dark.png'), false);
    }

    public function test_services_are_grouped_into_specialty_digital_and_technology(): void
    {
        $content = app(Content::class);

        $this->assertSame(
            ['website-development', 'software-development', 'mobile-app-development'],
            $content->servicesIn('specialty')->keys()->all(),
        );
        $this->assertSame(['digital-marketing', 'brand-and-design'], $content->servicesIn('digital')->keys()->all());
        $this->assertSame($content->services()->count(), $content->services()->whereIn('group', ['specialty', 'digital', 'technology'])->count());
    }

    public function test_contact_details_and_social_links_are_published(): void
    {
        foreach (['/', '/contact'] as $uri) {
            $this->get($uri)
                ->assertSee('href="tel:+2349022016978"', false)
                ->assertSee('href="tel:+2347045414419"', false)
                ->assertSee('0902 201 6978')
                ->assertSee('13 Adepele Street, Ikeja, Lagos, Nigeria')
                ->assertSee('mailto:hello@techatronagency.com', false)
                ->assertSee('https://www.tiktok.com/@techatronconsultingltd', false)
                ->assertSee('https://www.linkedin.com/company/techatron-consulting-limited/', false)
                ->assertSee('https://web.facebook.com/techatronconsultingltd', false)
                ->assertSee('https://x.com/techatronagency', false)
                ->assertSee('https://www.instagram.com/techatronconsultingltd/', false);
        }

        $this->get('/')
            ->assertSee('"telephone":"+2349022016978"', false)
            ->assertSee('"streetAddress":"13 Adepele Street, Ikeja"', false)
            ->assertSee('"sameAs":["https://www.linkedin.com/company/techatron-consulting-limited/"', false);
    }

    public function test_client_logos_are_listed_with_names_and_files(): void
    {
        $clients = app(Content::class)->clients();

        $this->assertGreaterThanOrEqual(6, $clients->count());
        foreach ($clients as $client) {
            $this->assertFileExists(public_path($client['logo']), "{$client['name']} logo is missing");
            $this->assertLessThanOrEqual(150, $client['width']);
            $this->assertLessThanOrEqual(62, $client['height']);
        }

        $html = $this->get('/')->assertOk()
            ->assertSee('id="clients"', false)
            ->assertSee('alt="Brick Homes"', false)
            ->assertSee('alt="Zealot Chemicals Limited"', false)
            ->getContent();

        // Two rows, each duplicated for a seamless loop; the copies are hidden
        // from assistive technology so every name is announced once.
        $this->assertSame(4, substr_count($html, 'class="clients__group"'));
        $this->assertSame(1, substr_count($html, 'alt="Brick Homes"'));
        $this->assertStringContainsString('is-scrolling', $html);
    }

    public function test_client_section_is_hidden_without_clients(): void
    {
        app(Content::class)->override('clients', []);

        $this->get('/')->assertOk()->assertDontSee('id="clients"', false);
    }

    public function test_a_few_client_logos_sit_in_a_static_row_with_optional_links(): void
    {
        app(Content::class)->override('clients', [
            'one' => ['name' => 'One', 'logo' => 'images/clients/one.svg', 'url' => 'https://one.example'],
            'two' => ['name' => 'Two', 'logo' => 'images/clients/two.svg'],
        ]);

        $html = $this->get('/')->assertOk()->assertSee('href="https://one.example"', false)->getContent();
        $this->assertStringNotContainsString('is-scrolling', $html);
        $this->assertSame(1, substr_count($html, 'class="clients__group"'));
    }

    public function test_footer_lists_technologies_without_claiming_partnerships(): void
    {
        $html = $this->get('/')->assertOk()
            ->assertSee('Technologies we build with')
            ->assertSeeInOrder(['Google', 'AWS', 'Java', 'Microsoft', 'Meta'])
            ->getContent();

        preg_match('/<div class="footer__tech">(.*?)<\/ul>/s', $html, $row);
        $this->assertNotEmpty($row);
        $this->assertStringNotContainsStringIgnoringCase('partner', $row[1]);
    }

    public function test_hero_studio_has_accessible_tabs_for_each_specialty(): void
    {
        $html = $this->get('/')->assertOk()
            ->assertSee('role="tablist"', false)
            ->assertSeeInOrder(['Website', 'Mobile app', 'Software'])
            ->getContent();

        $this->assertSame(3, substr_count($html, 'role="tab"'));
        $this->assertSame(3, substr_count($html, 'role="tabpanel"'));
        $this->assertSame(1, substr_count($html, 'aria-selected="true"'));
    }

    public function test_contact_page_preselects_a_valid_service_from_the_query(): void
    {
        $html = $this->get('/contact?service=cybersecurity')->assertOk()->getContent();
        $this->assertMatchesRegularExpression('/value="cybersecurity"\s+checked/', $html);
        $this->assertDoesNotMatchRegularExpression('/value="managed-it"\s+checked/', $html);

        $this->get('/contact?service=<script>')->assertOk()->assertDontSee('<script>', false);
    }
}
