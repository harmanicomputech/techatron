<?php

/*
| Front controller for DirectAdmin / shared hosting.
|
| The Laravel application lives in a folder named "techatron_app" outside the
| web root. This file finds it whether the site is served from the domain's
| public_html (domains/example.com/public_html) or from a subdomain folder
| inside it (domains/example.com/public_html/preview).
*/

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$appPath = null;
foreach ([__DIR__.'/../techatron_app', __DIR__.'/../../techatron_app', __DIR__.'/techatron_app'] as $candidate) {
    if (is_file($candidate.'/bootstrap/app.php')) {
        $appPath = realpath($candidate);
        break;
    }
}

if ($appPath === null) {
    http_response_code(500);
    exit('Application folder "techatron_app" not found. Upload it next to public_html (see INSTALL.txt).');
}

if (file_exists($maintenance = $appPath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $appPath.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $appPath.'/bootstrap/app.php';

// Assets (build/, images/, favicon) are served from this folder.
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
