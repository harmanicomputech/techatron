<?php

namespace App\Providers;

use App\Support\Content;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Content::class);
    }

    public function boot(): void
    {
        RateLimiter::for('enquiries', fn (Request $request) => [
            Limit::perMinute(3)->by($request->ip()),
            Limit::perDay(20)->by($request->ip()),
        ]);

        View::composer('layouts.*', function ($view) {
            $content = $this->app->make(Content::class);

            $view->with([
                'navServices' => $content->services(),
                'navGroups' => [
                    'Our specialty' => $content->servicesIn('specialty'),
                    'Digital agency' => $content->servicesIn('digital'),
                    'Technology' => $content->servicesIn('technology'),
                ],
                'hasWork' => $content->work()->isNotEmpty(),
                'hasInsights' => $content->insights()->isNotEmpty(),
            ]);
        });
    }
}
