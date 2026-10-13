<?php

use Illuminate\Support\Facades\Route;
use Webkul\Blog\Http\Controllers\Shop\BlogController;

Route::group([
    'middleware' => ['web', 'locale', 'theme', 'currency'],
], function () {
    // Canonical storefront blog routes
    Route::get('/blog', [BlogController::class, 'index'])->name('shop.blogs.index');
    Route::get('/blog/category/{category_slug}', [BlogController::class, 'category'])->name('shop.blogs.category');
    Route::get('/blog/{category_slug}/article/{url_key}', [BlogController::class, 'view'])->name('shop.blogs.view');

    // Friendly alias redirects for blog listing
    Route::get('/articles', function () {
        return redirect()->route('shop.blogs.index', [], 301);
    });

    Route::get('/article', function () {
        return redirect()->route('shop.blogs.index', [], 301);
    });

    Route::get('/blogs', function () {
        return redirect()->route('shop.blogs.index', [], 301);
    });

    // 301 Redirect legacy /article/{url_key} and /articles/{url_key} to canonical /blog/{category_slug}/article/{url_key}
    Route::get('/article/{url_key}', [BlogController::class, 'legacyArticleRedirect'])->where('url_key', '.*');
    Route::get('/articles/{url_key}', [BlogController::class, 'legacyArticleRedirect'])->where('url_key', '.*');

    // 301 Redirect legacy /blog/{url_key} and /blogs/{url_key} to canonical URLs
    Route::get('/blog/{url_key}', [BlogController::class, 'legacyBlogSegmentRedirect'])->where('url_key', '.*');
    Route::get('/blogs/{url_key}', [BlogController::class, 'legacyBlogSegmentRedirect'])->where('url_key', '.*');

    // Legacy recipe route 301 redirects to blog
    Route::get('/recipes', function () {
        return redirect()->route('shop.blogs.index', [], 301);
    });

    Route::get('/recipes/{url_key}', function () {
        return redirect()->route('shop.blogs.index', [], 301);
    })->where('url_key', '.*');
});
