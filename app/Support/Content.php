<?php

namespace App\Support;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Read-only access to the site copy in resources/content.
 *
 * Copy lives in plain PHP arrays so it can be reviewed and edited without
 * touching templates, and is cached in memory for the request.
 */
class Content
{
    /** @var array<string, array<mixed>> */
    private array $loaded = [];

    public function services(): Collection
    {
        return collect($this->load('services'))
            ->map(fn (array $service, string $slug) => ['slug' => $slug] + $service);
    }

    /** Services in a group: specialty, digital or technology. */
    public function servicesIn(string $group): Collection
    {
        return $this->services()->where('group', $group);
    }

    public function service(string $slug): ?array
    {
        return $this->services()->get($slug);
    }

    public function approach(): Collection
    {
        return collect($this->load('approach'));
    }

    public function engagements(): Collection
    {
        return collect($this->load('engagements'));
    }

    public function challenges(): Collection
    {
        return collect($this->load('challenges'));
    }

    public function principles(): Collection
    {
        return collect($this->load('principles'));
    }

    public function platforms(): Collection
    {
        return collect($this->load('platforms'));
    }

    public function work(): Collection
    {
        return collect($this->load('work'))
            ->map(fn (array $project, string $slug) => ['slug' => $slug] + $project);
    }

    public function project(string $slug): ?array
    {
        return $this->work()->get($slug);
    }

    public function testimonials(): Collection
    {
        return collect($this->load('testimonials'));
    }

    public function insights(): Collection
    {
        return collect($this->load('insights'))
            ->map(fn (array $article, string $slug) => [
                'slug' => $slug,
                'date' => Carbon::parse($article['published']),
            ] + $article)
            ->sortByDesc('date');
    }

    public function insight(string $slug): ?array
    {
        $article = $this->insights()->get($slug);

        if (! $article) {
            return null;
        }

        $path = resource_path("content/insights/{$slug}.md");
        $article['body'] = is_file($path) ? Str::markdown(file_get_contents($path), [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]) : '';

        return $article;
    }

    private function load(string $name): array
    {
        return $this->loaded[$name] ??= require resource_path("content/{$name}.php");
    }
}
