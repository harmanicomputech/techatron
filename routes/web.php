<?php

use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

/*
| Legacy URLs from the previous website. The old site could not be crawled
| during the rebuild, so these cover the usual WordPress paths; add any
| others from the old sitemap or Search Console before launch.
*/
Route::permanentRedirect('/home', '/');
Route::permanentRedirect('/about-us', '/about');
Route::permanentRedirect('/contact-us', '/contact');
Route::permanentRedirect('/our-services', '/services');
Route::permanentRedirect('/portfolio', '/work');
Route::permanentRedirect('/projects', '/work');
Route::permanentRedirect('/blog', '/insights');
Route::permanentRedirect('/privacy-policy', '/privacy');
Route::permanentRedirect('/services/managed-services', '/services/managed-it');
Route::permanentRedirect('/services/mobile-development', '/services/mobile-apps');
Route::permanentRedirect('/services/cloud-services', '/services/cloud-infrastructure');
Route::permanentRedirect('/services/data-center', '/services/cloud-infrastructure');

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/approach', [PageController::class, 'approach'])->name('approach');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/work', [WorkController::class, 'index'])->name('work.index');
Route::get('/work/{slug}', [WorkController::class, 'show'])->name('work.show');

Route::get('/insights', [InsightController::class, 'index'])->name('insights.index');
Route::get('/insights/{slug}', [InsightController::class, 'show'])->name('insights.show');

Route::get('/contact', [EnquiryController::class, 'create'])->name('contact');
Route::post('/contact', [EnquiryController::class, 'store'])
    ->middleware('throttle:enquiries')
    ->name('contact.store');

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots']);
