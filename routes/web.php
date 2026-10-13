<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| Packages define their own routes, but application-level fallbacks
| and utilities can be registered here.
|
*/

/**
 * Storage Fallback Route
 *
 * Ensures all public storage files (product images, categories, avatars, banners)
 * are served reliably across all hosting environments (cPanel, LiteSpeed, VPS),
 * even if symbolic links are disabled, missing, or misconfigured.
 */
Route::get('storage/{path}', function (string $path) {
    $sanitized = str_replace(['../', '..\\', '/..', '\\..'], '', $path);
    $fullPath = realpath(storage_path('app/public/'.ltrim($sanitized, '/\\')));
    $basePath = realpath(storage_path('app/public'));

    if (
        ! $fullPath
        || ! $basePath
        || ! str_starts_with($fullPath, $basePath)
        || ! file_exists($fullPath)
    ) {
        abort(404);
    }

    return response()->file($fullPath, [
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->where('path', '.*')->name('storage.fallback');
