<?php

namespace App\Http\Controllers;

use App\Support\Content;
use Illuminate\View\View;

class WorkController extends Controller
{
    public function __construct(private Content $content) {}

    public function index(): View
    {
        return view('work.index', ['work' => $this->content->work()]);
    }

    public function show(string $slug): View
    {
        $project = $this->content->project($slug) ?? abort(404);

        return view('work.show', [
            'project' => $project,
            'services' => $this->content->services()->only($project['services'] ?? []),
            'more' => $this->content->work()->except($slug)->take(2),
        ]);
    }
}
