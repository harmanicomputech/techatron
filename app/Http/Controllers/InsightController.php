<?php

namespace App\Http\Controllers;

use App\Support\Content;
use Illuminate\View\View;

class InsightController extends Controller
{
    public function __construct(private Content $content) {}

    public function index(): View
    {
        $insights = $this->content->insights();

        abort_if($insights->isEmpty(), 404);

        return view('insights.index', ['insights' => $insights]);
    }

    public function show(string $slug): View
    {
        return view('insights.show', [
            'article' => $this->content->insight($slug) ?? abort(404),
        ]);
    }
}
