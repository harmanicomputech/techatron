<?php

/*
|--------------------------------------------------------------------------
| Case studies
|--------------------------------------------------------------------------
|
| Only publish delivered, verified client work, with the client's permission.
| Concept or internal work must set 'type' => 'concept' so it is labelled as
| such. While this list is empty the homepage hides the Work section.
|
| Shape of an entry (keyed by URL slug):
|
| 'example-slug' => [
|     'type' => 'client',              // client | product | concept
|     'client' => 'Client or product name',
|     'title' => 'One-line headline of what was achieved',
|     'sector' => 'Sector',
|     'year' => '2026',
|     'summary' => 'One or two sentences for cards.',
|     'context' => 'Business context.',
|     'challenge' => 'The problem.',
|     'solution' => 'What we built and why.',
|     'capabilities' => ['Mobile app', 'API'],
|     'services' => ['mobile-apps'],      // keys from services.php
|     'stack' => ['Laravel', 'Flutter'],
|     'outcomes' => ['Verified outcome'], // verified results only
|     'url' => 'https://live-product.example',
|     'image' => 'images/work/example.webp', // under public/, 1600x1000
| ],
|
*/

return [];
