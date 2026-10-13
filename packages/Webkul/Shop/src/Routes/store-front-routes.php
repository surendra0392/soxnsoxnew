<?php

use Illuminate\Support\Facades\Route;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Core\Http\Middleware\NoCacheMiddleware;
use Webkul\Shop\Http\Controllers\BookingProductController;
use Webkul\Shop\Http\Controllers\CompareController;
use Webkul\Shop\Http\Controllers\EUWithdrawalController;
use Webkul\Shop\Http\Controllers\HomeController;
use Webkul\Shop\Http\Controllers\PageController;
use Webkul\Shop\Http\Controllers\ProductController;
use Webkul\Shop\Http\Controllers\ProductsCategoriesProxyController;
use Webkul\Shop\Http\Controllers\SearchController;
use Webkul\Shop\Http\Controllers\SitemapController;
use Webkul\Shop\Http\Controllers\SubscriptionController;

/**
 * EU Withdrawal — public guest flow (Directive (EU) 2023/2673, Art. 11a).
 *
 * Declared before the catch-all fallback so its URLs match first.
 */
Route::prefix('withdraw')->middleware([NoCacheMiddleware::class])->group(function () {
    Route::controller(EUWithdrawalController::class)->group(function () {
        Route::get('/', 'lookupForm')
            ->middleware('throttle:eu-withdraw-lookup')
            ->name('shop.eu-withdrawal.guest.lookup');

        Route::post('lookup', 'lookupSubmit')
            ->middleware('throttle:eu-withdraw-lookup')
            ->name('shop.eu-withdrawal.guest.lookup.submit');

        Route::get('{orderId}/create', 'guestCreate')
            ->middleware(['signed', 'throttle:eu-withdraw-submit'])
            ->name('shop.eu-withdrawal.guest.create');

        Route::post('{orderId}/store', 'guestStore')
            ->middleware(['signed', 'throttle:eu-withdraw-submit'])
            ->name('shop.eu-withdrawal.guest.store');

        Route::get('confirmation/{uuid}', 'guestConfirmation')
            ->middleware('signed')
            ->name('shop.eu-withdrawal.guest.confirmation');
    });
});

/**
 * CMS pages.
 */
Route::get('page/{slug}', [PageController::class, 'view'])
    ->where('slug', '.*')
    ->name('shop.cms.page')
    ->middleware('cache.response');

/**
 * Direct Multi-Page Aliases for SOXNSOX Header Navigation
 */
Route::get('about-us', fn () => app(PageController::class)->view('about-us'))
    ->name('shop.about_us')
    ->middleware('cache.response');

Route::get('why-choose-us', fn () => app(PageController::class)->view('why-choose-us'))
    ->name('shop.why_choose_us')
    ->middleware('cache.response');

Route::get('how-it-works', fn () => app(PageController::class)->view('how-it-works'))
    ->name('shop.how_it_works')
    ->middleware('cache.response');

$shopCatalogHandler = function () {
    $rootId = core()->getCurrentChannel()->root_category_id ?? 1;
    $category = app(CategoryRepository::class)->find($rootId);

    if ($category) {
        $category = clone $category;
        $category->name = 'All Bamboo Socks';
        $category->description = '<p>Explore our full lineup of doctor-approved bamboo socks crafted with thermo-regulating fibers, seamless toe stitching, and blister-free cushioned support for all-day freshness.</p>';
        $category->meta_title = 'Shop All Bamboo Socks | SOX N SOX';
        $category->meta_description = 'Browse our complete catalog of premium bamboo socks — diabetic care, ankle, crew, sports & dress socks.';

        return view('shop::categories.view', [
            'category' => $category,
            'params' => [
                'sort' => request()->query('sort'),
                'limit' => request()->query('limit'),
                'mode' => request()->query('mode'),
            ],
        ]);
    }

    return redirect()->route('shop.home.index');
};

Route::get('shop', $shopCatalogHandler)->name('shop.products.index');
Route::get('products', $shopCatalogHandler)->name('shop.products.catalog');
Route::get('all-socks', $shopCatalogHandler)->name('shop.products.all_socks');
Route::get('all-products', $shopCatalogHandler)->name('shop.products.all_products');

Route::get('shop/category/{slug}', [ProductsCategoriesProxyController::class, 'categoryView'])
    ->where('slug', '.*')
    ->name('shop.category.view')
    ->middleware('cache.response');

Route::get('shop/{category}/{slug}', [ProductsCategoriesProxyController::class, 'productView'])
    ->name('shop.products.view')
    ->middleware('cache.response');

Route::get('shop/{slug}', [ProductsCategoriesProxyController::class, 'shopSingleSegment'])
    ->where('slug', '.*')
    ->name('shop.products.view.single')
    ->middleware('cache.response');

/**
 * Fallback route.
 */
Route::fallback(ProductsCategoriesProxyController::class.'@index')
    ->name('shop.product_or_category.index')
    ->middleware('cache.response');

/**
 * Search-engine / agent discovery. Declared before the catch-all fallback so
 * `sitemap.xml` and `robots.txt` are not swallowed by the slug route.
 */
Route::get('sitemap.xml', [SitemapController::class, 'index'])
    ->name('shop.sitemap.index');

Route::get('robots.txt', [SitemapController::class, 'robots'])
    ->name('shop.robots');

/**
 * Store front home.
 */
Route::get('/', [HomeController::class, 'index'])
    ->name('shop.home.index')
    ->middleware('cache.response');

Route::get('contact-us', [HomeController::class, 'contactUs'])
    ->name('shop.home.contact_us')
    ->middleware('cache.response');

Route::post('contact-us/send-mail', [HomeController::class, 'sendContactUsMail'])
    ->name('shop.home.contact_us.send_mail')
    ->middleware('cache.response');

/**
 * Store front search.
 */
Route::get('search', [SearchController::class, 'index'])
    ->name('shop.search.index')
    ->middleware('cache.response');

Route::post('search/upload', [SearchController::class, 'upload'])->name('shop.search.upload');

/**
 * Subscription routes.
 */
Route::controller(SubscriptionController::class)->group(function () {
    Route::post('subscription', 'store')->name('shop.subscription.store');

    Route::get('subscription/{token}', 'destroy')->name('shop.subscription.destroy');
});

/**
 * Compare products
 */
Route::get('compare', [CompareController::class, 'index'])
    ->name('shop.compare.index')
    ->middleware('cache.response');

/**
 * Downloadable products
 */
Route::controller(ProductController::class)->group(function () {
    Route::get('downloadable/download-sample/{type}/{id}', 'downloadSample')->name('shop.downloadable.download_sample');

    Route::get('product/{id}/{attribute_id}', 'download')->name('shop.product.file.download');
});

/**
 * Booking products
 */
Route::get('booking-slots/{id}', [BookingProductController::class, 'index'])
    ->name('shop.booking-product.slots.index');
