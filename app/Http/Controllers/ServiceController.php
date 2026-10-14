<?php

namespace App\Http\Controllers;

use App\Support\Content;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function __construct(private Content $content) {}

    public function index(): View
    {
        return view('services.index', [
            'services' => $this->content->services(),
            'challenges' => $this->content->challenges(),
        ]);
    }

    public function show(string $slug): View
    {
        $service = $this->content->service($slug) ?? abort(404);
        $services = $this->content->services();

        return view('services.show', [
            'service' => $service,
            'approach' => $this->content->approach(),
            'related' => $services->except($slug)->take(3),
            'next' => $services->skipUntil(fn ($s) => $s['slug'] === $slug)->skip(1)->first() ?? $services->first(),
            'work' => $this->content->work()->filter(fn ($p) => in_array($slug, $p['services'] ?? [], true)),
        ]);
    }
}
