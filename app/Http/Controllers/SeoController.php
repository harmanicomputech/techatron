<?php

namespace App\Http\Controllers;

use App\Support\Content;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(Content $content): Response
    {
        $urls = collect([
            route('home'),
            route('services.index'),
            ...$content->services()->keys()->map(fn ($slug) => route('services.show', $slug)),
            route('approach'),
            route('about'),
            route('contact'),
            route('privacy'),
        ]);

        if ($content->work()->isNotEmpty()) {
            $urls->push(route('work.index'));
            $urls->push(...$content->work()->keys()->map(fn ($slug) => route('work.show', $slug)));
        }

        if ($content->insights()->isNotEmpty()) {
            $urls->push(route('insights.index'));
            $urls->push(...$content->insights()->keys()->map(fn ($slug) => route('insights.show', $slug)));
        }

        return response()
            ->view('seo.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $lines = app()->isProduction()
            ? ['User-agent: *', 'Disallow:', '', 'Sitemap: '.route('sitemap')]
            : ['User-agent: *', 'Disallow: /'];

        return response(implode("\n", $lines)."\n")->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
