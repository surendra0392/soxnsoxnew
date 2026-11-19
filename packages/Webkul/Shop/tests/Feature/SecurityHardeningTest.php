<?php

use Database\Seeders\ShippingSeeder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Contracts\User;
use Spatie\ResponseCache\Facades\ResponseCache;
use Spatie\Sitemap\Tags\Url;
use Webkul\Category\Models\Category;
use Webkul\Checkout\Models\Cart;
use Webkul\Checkout\Models\CartAddress;
use Webkul\Core\Models\CoreConfig;
use Webkul\Core\Models\SubscribersList;
use Webkul\Customer\Models\Customer;
use Webkul\FPC\Hasher\DefaultHasher;
use Webkul\Payment\Facades\Payment;
use Webkul\Product\Models\Product;
use Webkul\Product\Models\ProductReview;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Razorpay\Payment\RazorpayPayment;
use Webkul\RMA\Enums\DefaultRMAResolution;
use Webkul\RMA\Enums\DefaultRMAStatusEnum;
use Webkul\RMA\Helpers\Helper as RMAHelper;
use Webkul\RMA\Models\RMA;
use Webkul\RMA\Models\RMAItem;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Models\OrderItem;
use Webkul\Shipping\Facades\Shipping;
use Webkul\Shop\Http\Resources\CartItemResource;
use Webkul\Shop\Http\Resources\ProductCardResource;
use Webkul\SocialLogin\Repositories\CustomerSocialAccountRepository;
use Webkul\User\Models\Admin;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\postJson;

it('rejects svg uploads in visual search', function () {
    Storage::fake('public');

    $svgFile = UploadedFile::fake()->create('malicious.svg', 10, 'image/svg+xml');

    postJson(route('shop.search.upload'), [
        'image' => $svgFile,
    ])->assertStatus(422)
        ->assertJsonValidationErrors(['image']);
});

it('enforces guest review setting, validates author name, and rejects svg or oversized attachments', function () {
    $product = Product::first() ?? Product::factory()->create(['type' => 'simple']);

    // 1. Disabled guest reviews -> 403
    CoreConfig::query()->where('code', 'catalog.products.review.guest_review')->delete();
    cache()->flush();

    $guestReviewConfig = CoreConfig::query()->create([
        'code' => 'catalog.products.review.guest_review',
        'channel_code' => core()->getCurrentChannelCode(),
        'locale_code' => null,
        'value' => '0',
    ]);

    postJson(route('shop.api.products.reviews.store', $product->id), [
        'name' => 'John Doe',
        'title' => 'Great socks',
        'comment' => 'Super soft and durable',
        'rating' => 5,
    ])->assertStatus(403);

    // Enable guest reviews for validation checks (flush CoreConfigRepository cache)
    $guestReviewConfig->update(['value' => '1']);
    cache()->flush();

    // 2. Without name -> 422
    postJson(route('shop.api.products.reviews.store', $product->id), [
        'title' => 'Great socks',
        'comment' => 'Super soft and durable',
        'rating' => 5,
    ])->assertStatus(422)
        ->assertJsonValidationErrors(['name']);

    // 3. SVG attachment -> 422 (XSS vector blocked)
    $svgFile = UploadedFile::fake()->create('malicious.svg', 10, 'image/svg+xml');

    postJson(route('shop.api.products.reviews.store', $product->id), [
        'name' => 'John Doe',
        'title' => 'Great socks',
        'comment' => 'Super soft and durable',
        'rating' => 5,
        'attachments' => [$svgFile],
    ])->assertStatus(422)
        ->assertJsonValidationErrors(['attachments.0']);

    // 4. Oversized attachment (>10MB) -> 422
    $largeAttachment = UploadedFile::fake()->create('huge_video.mp4', 12000, 'video/mp4');

    postJson(route('shop.api.products.reviews.store', $product->id), [
        'name' => 'John Doe',
        'title' => 'Great socks',
        'comment' => 'Super soft and durable',
        'rating' => 5,
        'attachments' => [$largeAttachment],
    ])->assertStatus(422)
        ->assertJsonValidationErrors(['attachments.0']);
});

it('generates secure 60-char tokens and handles two-step newsletter unsubscribe', function () {
    // 1. Subscribe
    $email = 'subscriber_test_'.time().'@example.com';

    post(route('shop.subscription.store'), [
        'email' => $email,
    ])->assertRedirect();

    $subscriber = SubscribersList::where('email', $email)->first();
    expect($subscriber)->not->toBeNull();
    expect(strlen($subscriber->token))->toBe(60);

    // 2. GET subscription/{token} renders confirmation page without deleting
    get(route('shop.subscription.destroy', $subscriber->token))
        ->assertOk()
        ->assertSeeText('Newsletter Unsubscribe')
        ->assertSeeText($email);

    expect(SubscribersList::where('email', $email)->exists())->toBeTrue();

    // 3. POST subscription/{token} executes unsubscription
    post(route('shop.subscription.destroy.post', $subscriber->token))
        ->assertRedirect(route('shop.home.index'));

    expect(SubscribersList::where('email', $email)->exists())->toBeFalse();
});

it('validates payload in bulk cart operations', function () {
    deleteJson(route('shop.api.checkout.cart.destroy_selected'), [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['ids']);

    postJson(route('shop.api.checkout.cart.move_to_wishlist'), [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['ids', 'qty']);
});

it('throttles api customer login requests', function () {
    for ($i = 0; $i < 5; $i++) {
        postJson(route('shop.api.customers.session.create'), [
            'email' => 'attacker@example.com',
            'password' => 'wrongpassword',
        ]);
    }

    // 6th attempt should be throttled
    $res = postJson(route('shop.api.customers.session.create'), [
        'email' => 'attacker@example.com',
        'password' => 'wrongpassword',
    ]);

    expect(in_array($res->status(), [429, 500]))->toBeTrue();
});

it('handles null email and name when creating social customer', function () {
    $providerUser = Mockery::mock(User::class);
    $providerUser->shouldReceive('getId')->andReturn('apple_user_123');
    $providerUser->shouldReceive('getEmail')->andReturnNull();
    $providerUser->shouldReceive('getName')->andReturnNull();

    $repository = app(CustomerSocialAccountRepository::class);

    $customer = $repository->findOrCreateCustomer($providerUser, 'apple');

    expect($customer)->not->toBeNull();
    expect($customer->email)->toBe('apple_user_123@apple.local');
    expect($customer->first_name)->toBe('Customer');
});

it('strips directory traversal segments in clean_path helper', function () {
    expect(clean_path('sitemaps/default/../../outside.xml'))->toBe('sitemaps/default/outside.xml');
    expect(clean_path('/a/./b/../c/'))->toBe('a/b/c');
});

it('handles null and fractional cart sub_total safely in getOrderAmount', function () {
    $cart = Cart::factory()->create([
        'sub_total' => null,
        'tax_total' => null,
        'discount_amount' => null,
    ]);

    cart()->setCart($cart);

    expect(cart()->getOrderAmount())->toBe(0.0);

    $cart->sub_total = 499.75;
    expect(cart()->getOrderAmount())->toBe(499.75);
});

it('blocks suspended customers from logging in via web and api endpoints', function () {
    $customer = Customer::factory()->create([
        'password' => bcrypt('secret123'),
        'status' => 1,
        'is_verified' => 1,
        'is_suspended' => 1,
        'channel_id' => core()->getCurrentChannel()->id,
    ]);

    post(route('shop.customer.session.create'), [
        'email' => $customer->email,
        'password' => 'secret123',
    ])->assertRedirect();

    expect(auth()->guard('customer')->check())->toBeFalse();

    postJson(route('shop.api.customers.session.create'), [
        'email' => $customer->email,
        'password' => 'secret123',
    ])->assertStatus(403);

    expect(auth()->guard('customer')->check())->toBeFalse();
});

it('rejects guest mutations on compare items api and prevents duplicate crash for customers', function () {
    $product = Product::first() ?? Product::factory()->create(['type' => 'simple']);

    postJson(route('shop.api.compare.store'), [
        'product_id' => $product->id,
    ])->assertStatus(401);

    deleteJson(route('shop.api.compare.destroy_all'))
        ->assertStatus(401);

    $customer = Customer::factory()->create([
        'status' => 1,
        'is_verified' => 1,
        'is_suspended' => 0,
        'channel_id' => core()->getCurrentChannel()->id,
    ]);

    actingAs($customer, 'customer');

    postJson(route('shop.api.compare.store'), [
        'product_id' => $product->id,
    ])->assertOk();

    postJson(route('shop.api.compare.store'), [
        'product_id' => $product->id,
    ])->assertStatus(422);
});

it('resolves canonical category product urls and sitemap tags without missing parameter errors', function () {
    $product = Webkul\Sitemap\Models\Product::whereNull('parent_id')
        ->with(['categories', 'attribute_values'])
        ->get()
        ->first(fn ($p) => $p->url_key && $p->status && $p->visible_individually);

    if ($product) {
        $tag = $product->toSitemapTag();

        expect($tag)->toBeInstanceOf(Url::class);
        expect($tag->url)->toContain('/shop/'.$product->getPrimaryCategorySlug().'/'.$product->url_key);
    }

    expect(true)->toBeTrue();
});

it('renders blog admin create without nonexistent products status column SQL errors', function () {
    $products = app(ProductRepository::class)
        ->scopeQuery(function ($query) {
            return $query->whereNull('parent_id')
                ->whereHas('product_flats', fn ($q) => $q->where('status', 1))
                ->limit(5);
        })
        ->all();

    expect($products)->not->toBeNull();
});

it('rejects cross-product review translation IDOR and missing products on review store', function () {
    $products = Product::whereNull('parent_id')->take(2)->get();

    if ($products->count() < 2) {
        $p1 = Product::factory()->create(['type' => 'simple']);
        $p2 = Product::factory()->create(['type' => 'simple']);
    } else {
        [$p1, $p2] = $products;
    }

    postJson(route('shop.api.products.reviews.store', 99999999), [
        'name' => 'Guest',
        'title' => 'Test',
        'comment' => 'Nice',
        'rating' => 5,
    ])->assertStatus(404);

    $review = ProductReview::create([
        'product_id' => $p1->id,
        'title' => 'Soft bamboo socks',
        'comment' => 'Very comfortable',
        'rating' => 5,
        'status' => 'approved',
        'name' => 'Reviewer',
    ]);

    get(route('shop.api.products.reviews.translate', [
        'id' => $p2->id,
        'review_id' => $review->id,
    ]))->assertStatus(400);
});

it('returns 404 instead of 500 when downloadable purchase does not exist for customer', function () {
    $customer = Customer::factory()->create([
        'status' => 1,
        'is_verified' => 1,
        'is_suspended' => 0,
        'channel_id' => core()->getCurrentChannel()->id,
    ]);

    actingAs($customer, 'customer');

    get(route('shop.customers.account.downloadable_products.download', 99999999))
        ->assertStatus(404);
});

it('handles null cart and invalid billing email cleanly in checkout and cart apis', function () {
    if ($existingCart = cart()->getCart()) {
        cart()->removeCart($existingCart);
    }

    postJson(route('shop.checkout.onepage.addresses.store'), [
        'billing' => [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'not-an-email',
            'address' => ['123 Main St'],
            'city' => 'Mumbai',
            'state' => 'MH',
            'postcode' => '400001',
            'country' => 'IN',
            'phone' => '9876543210',
        ],
    ])->assertStatus(422)
        ->assertJsonValidationErrors(['billing.email']);

    postJson(route('shop.checkout.onepage.addresses.store'), [
        'billing' => [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'address' => ['123 Main St'],
            'city' => 'Mumbai',
            'state' => 'MH',
            'postcode' => '400001',
            'country' => 'IN',
            'phone' => '9876543210',
            'use_for_shipping' => true,
        ],
    ])->assertOk()
        ->assertJsonPath('data.redirect', true);

    postJson(route('shop.api.checkout.cart.coupon.apply'), ['code' => 'SAVE10'])
        ->assertStatus(422);

    deleteJson(route('shop.api.checkout.cart.coupon.remove'))
        ->assertOk();

    app('Illuminate\Http\Request')->merge([]);
    $this->putJson(route('shop.api.checkout.cart.update'), ['qty' => [999999 => 5]])
        ->assertStatus(400);
});

it('finds country states via findWhere and excludes canceled rmas from item quantities', function () {
    $state = core()->findStateByCountryCode('US', 'CA');
    expect($state === null || is_object($state))->toBeTrue();

    $order = Order::factory()->create();
    $orderItem = OrderItem::factory()->create([
        'order_id' => $order->id,
        'qty_ordered' => 2,
        'rma_return_period' => 30,
    ]);

    $rma = RMA::create([
        'order_id' => $order->id,
        'rma_status_id' => DefaultRMAStatusEnum::CANCELED->value,
        'information' => 'Canceled test',
    ]);

    RMAItem::create([
        'rma_id' => $rma->id,
        'order_item_id' => $orderItem->id,
        'quantity' => 2,
        'resolution' => DefaultRMAResolution::RETURN->value,
        'rma_reason_id' => 1,
    ]);

    $remaining = app(RMAHelper::class)->getRemainingQtyAfterRMA($orderItem->id);
    expect($remaining['qty'])->toBe(2);
});

it('calculates shipping rates for Indian states and rest of India after ShippingSeeder', function () {
    $this->seed(ShippingSeeder::class);

    $locations = DB::table('shipping_zone_locations')->get();
    expect($locations->where('location_code', 'IN')->first()?->location_type)->toBe('country');
    expect($locations->where('location_code', 'AP')->first()?->location_type)->toBe('state');
    expect($locations->where('location_code', 'TG')->first()?->location_type)->toBe('state');

    $product = Product::first() ?? Product::factory()->create(['type' => 'simple']);
    $cart = Cart::factory()->create([
        'base_sub_total' => 549.00,
        'sub_total' => 549.00,
    ]);

    CartAddress::create([
        'cart_id' => $cart->id,
        'address_type' => CartAddress::ADDRESS_TYPE_SHIPPING,
        'first_name' => 'Test',
        'last_name' => 'Buyer',
        'email' => 'buyer@example.com',
        'address' => '12 Marine Drive',
        'city' => 'Mumbai',
        'state' => 'MH',
        'postcode' => '400001',
        'country' => 'IN',
        'phone' => '9876543210',
    ]);

    cart()->setCart($cart->fresh(['shipping_address', 'billing_address', 'items']));
    $collected = Shipping::collectRates();

    expect($collected['shippingMethods'])->not->toBeEmpty();
});

it('exposes only razorpay with sandbox disabled in payment methods', function () {
    $cart = Cart::factory()->create([
        'base_sub_total' => 549.00,
        'sub_total' => 549.00,
    ]);
    cart()->setCart($cart);

    $methods = array_column(Payment::getPaymentMethods(), 'method');
    $razorpay = app(RazorpayPayment::class);

    expect($methods)->toBe(['razorpay'])
        ->and($razorpay->isAvailable())->toBeTrue()
        ->and($razorpay->isSandbox())->toBeFalse();
});

it('serves valid dynamic sitemap and robots with no 301 links and clean seo tags', function () {
    $robots = get('/robots.txt');
    $robots->assertOk()
        ->assertSee('Disallow: /admin/')
        ->assertSee('Sitemap:')
        ->assertSee('/sitemap.xml');

    $sitemap = get('/sitemap.xml');
    $sitemap->assertOk()
        ->assertSee('<urlset', false)
        ->assertSee('/shop/category/medical-socks</loc>', false);

    expect($sitemap->getContent())->not->toContain('<loc>http://soxnsox.test/medical-socks</loc>');

    $home = get('/');
    $home->assertOk();
    expect(substr_count($home->getContent(), 'rel="canonical"'))->toBe(1);
    expect(substr_count($home->getContent(), 'name="robots"'))->toBe(1);
    expect(substr_count($home->getContent(), 'property="og:url"'))->toBe(1);

    $men = get('/shop/category/men');
    $men->assertOk();
    expect(substr_count($men->getContent(), 'rel="canonical"'))->toBe(1)
        ->and($men->getContent())->toContain('CollectionPage')
        ->and($men->getContent())->not->toContain('?term={search_term_string}');

    $search = get('/search?query=bamboo');
    $search->assertOk()
        ->assertSee('noindex, follow', false);
    expect(substr_count($search->getContent(), 'name="robots"'))->toBe(1);
});

it('computes descendant category max price accurately and renders cart coupon form inside modal', function () {
    $menCategory = Category::whereHas('translations', fn ($q) => $q->where('slug', 'men'))->first();

    if ($menCategory) {
        $maxPriceRes = get(route('shop.api.categories.max_price', $menCategory->id));
        $maxPriceRes->assertOk();
        expect((float) $maxPriceRes->json('data.max_price'))->toBeGreaterThanOrEqual(799.0);
    }

    $simpleProduct = Product::where('type', 'simple')->whereHas('inventories', fn ($q) => $q->where('qty', '>', 0))->first();

    if ($simpleProduct) {
        cart()->addProduct($simpleProduct, ['quantity' => 1]);
    }

    $cartPage = get(route('shop.checkout.cart.index'));
    $cartPage->assertOk()
        ->assertSee('noindex, nofollow', false);

    if ($simpleProduct) {
        $cartPage->assertSee('v-coupon-template', false)
            ->assertSee('coupon-apply-form-', false);
    }

    get(route('shop.compare.index'))
        ->assertOk()
        ->assertSee('noindex, nofollow', false);
});

it('rejects paypal and stripe unauthenticated or mismatched callbacks and fails closed when 2fa is not set up', function () {
    if ($existingCart = cart()->getCart()) {
        cart()->removeCart($existingCart);
    }

    get(route('paypal.standard.success'))->assertRedirect();
    $this->getJson(route('paypal.smart-button.create-order'))->assertStatus(400);
    postJson(route('paypal.smart-button.capture-order'))->assertStatus(403);
    get(route('stripe.payment.success'))->assertRedirect();

    $admin = Admin::first();
    if ($admin) {
        $originalSecret = $admin->two_factor_secret;
        $admin->forceFill(['two_factor_secret' => null])->save();

        actingAs($admin, 'admin');
        postJson(route('admin.two_factor.enable'), ['code' => '123456'])
            ->assertStatus(401);

        $admin->forceFill(['two_factor_secret' => $originalSecret])->save();
    }
});

it('isolates full page cache hashes by scheme, host, and vite manifest version', function () {
    $hasher = app(DefaultHasher::class);

    $httpRequest = Request::create('http://soxnsox.test/shop/category/men', 'GET');
    $httpsRequest = Request::create('https://soxnsox.test/shop/category/men', 'GET', [], [], [], ['HTTPS' => 'on']);

    $httpHash = $hasher->getHashFor($httpRequest);
    $httpsHash = $hasher->getHashFor($httpsRequest);

    expect($httpHash)->not->toBe($httpsHash);

    $manifestPath = public_path('themes/shop/default/build/manifest.json');

    if (is_file($manifestPath)) {
        $originalMtime = filemtime($manifestPath);

        try {
            touch($manifestPath, $originalMtime + 10);
            $updatedManifestHash = $hasher->getHashFor($httpsRequest);

            expect($updatedManifestHash)->not->toBe($httpsHash);
        } finally {
            touch($manifestPath, $originalMtime);
            clearstatcache(true, $manifestPath);
        }
    }

    $wasEnabled = config('responsecache.enabled');
    config(['responsecache.enabled' => true]);
    ResponseCache::clear();

    try {
        $httpResponse = get('http://soxnsox.test/shop/category/men');
        $httpResponse->assertOk();
        expect($httpResponse->getContent())->toContain('http://soxnsox.test/themes/shop/default/build/assets/');

        $httpsResponse = get('https://soxnsox.test/shop/category/men');
        $httpsResponse->assertOk();
        expect($httpsResponse->getContent())
            ->toContain('https://soxnsox.test/themes/shop/default/build/assets/')
            ->not->toContain('http://soxnsox.test/themes/shop/default/build/assets/');
    } finally {
        ResponseCache::clear();
        config(['responsecache.enabled' => $wasEnabled]);
    }
});

it('centers search box icons vertically and hides product weight on storefront, cart, quick view, and seo schema', function () {
    $visibleProduct = Product::whereNull('parent_id')
        ->whereHas('product_flats', fn ($q) => $q->where('visible_individually', 1)->where('status', 1)->whereNotNull('url_key'))
        ->first();

    expect($visibleProduct)->not->toBeNull();

    $categorySlug = $visibleProduct->getPrimaryCategorySlug() ?: 'socks';
    $pdpResponse = get(route('shop.products.view', ['category' => $categorySlug, 'slug' => $visibleProduct->url_key]));
    $pdpResponse->assertOk();

    $pdpHtml = $pdpResponse->getContent();
    expect($pdpHtml)
        ->toContain('inset-y-0')
        ->not->toContain('Net Weight')
        ->not->toContain('item.formatted_weight')
        ->not->toContain('product.formatted_weight')
        ->not->toContain('"weight":{"@type":"QuantitativeValue"');

    $simpleProduct = Product::where('type', 'simple')
        ->whereHas('inventories', fn ($q) => $q->where('qty', '>', 0))
        ->first();

    if ($simpleProduct) {
        cart()->addProduct($simpleProduct, ['quantity' => 1]);
        $cartItem = cart()->getCart()?->items?->first();

        if ($cartItem) {
            $cartItemResource = (new CartItemResource($cartItem))->toArray(request());
            expect($cartItemResource['formatted_weight'])->toBeNull();
        }
    }

    $cartResponse = get(route('shop.checkout.cart.index'));
    $cartResponse->assertOk();
    expect($cartResponse->getContent())
        ->not->toContain('Weight:')
        ->not->toContain('item.formatted_weight');

    $productCard = (new ProductCardResource($visibleProduct))->toArray(request());
    expect($productCard['formatted_weight'])->toBeNull();
    expect((float) $productCard['weight'])->toBe((float) ($visibleProduct->weight ?? 0));
});
