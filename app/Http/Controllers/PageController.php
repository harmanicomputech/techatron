<?php

namespace App\Http\Controllers;

use App\Support\Content;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(private Content $content) {}

    public function home(): View
    {
        return view('pages.home', [
            'services' => $this->content->services(),
            'challenges' => $this->content->challenges(),
            'approach' => $this->content->approach(),
            'principles' => $this->content->principles(),
            'platforms' => $this->content->platforms(),
            'work' => $this->content->work()->take(3),
            'testimonials' => $this->content->testimonials(),
            'insights' => $this->content->insights()->take(3),
        ]);
    }

    public function about(): View
    {
        return view('pages.about', [
            'services' => $this->content->services(),
            'principles' => $this->content->principles(),
            'engagements' => $this->content->engagements(),
        ]);
    }

    public function approach(): View
    {
        return view('pages.approach', [
            'approach' => $this->content->approach(),
            'principles' => $this->content->principles(),
            'engagements' => $this->content->engagements(),
        ]);
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }
}
