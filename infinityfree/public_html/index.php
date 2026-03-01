<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/**
 * InfinityFree shared hosting front controller.
 *
 * Upload this file to public_html/index.php and keep the Laravel app
 * (app, bootstrap, vendor, storage, etc.) outside public_html in one of
 * the supported sibling folders below.
 */

$appBaseCandidates = [
    realpath(__DIR__.'/../mydash_app'),
    realpath(__DIR__.'/../mydash'),
    realpath(__DIR__.'/..'),
];

$appBasePath = null;

foreach ($appBaseCandidates as $candidate) {
    if (! is_string($candidate) || $candidate === '') {
        continue;
    }

    if (file_exists($candidate.'/vendor/autoload.php') && file_exists($candidate.'/bootstrap/app.php')) {
        $appBasePath = $candidate;
        break;
    }
}

if (! is_string($appBasePath)) {
    http_response_code(500);
    echo 'Laravel app path was not found. Place app files in ../mydash_app or ../mydash.';
    exit;
}

if (file_exists($maintenance = $appBasePath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $appBasePath.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $appBasePath.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
