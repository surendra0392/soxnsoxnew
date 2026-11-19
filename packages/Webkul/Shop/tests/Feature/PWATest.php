<?php

use function Pest\Laravel\get;

it('serves the web app manifest with correct metadata and icons', function () {
    $manifestPath = public_path('manifest.webmanifest');

    expect(file_exists($manifestPath))->toBeTrue();

    $content = json_decode(file_get_contents($manifestPath), true);

    expect($content)->toBeArray()
        ->and($content['short_name'])->toBe('SOX N SOX')
        ->and($content['display'])->toBe('standalone')
        ->and($content['theme_color'])->toBe('#133b63')
        ->and($content['background_color'])->toBe('#ffffff')
        ->and($content['icons'])->toBeArray()
        ->and(count($content['icons']))->toBeGreaterThanOrEqual(8);

    // Verify all icon files specified in manifest exist on disk
    foreach ($content['icons'] as $icon) {
        $iconPath = public_path(ltrim($icon['src'], '/'));
        expect(file_exists($iconPath))->toBeTrue("Icon {$icon['src']} must exist on disk");
    }

    // Verify public shortcuts do not reference stale 404 paths like /diabetic-socks
    $shortcutUrls = collect($content['shortcuts'] ?? [])->pluck('url')->implode(' ');
    expect($shortcutUrls)->not->toContain('/diabetic-socks');
    expect($shortcutUrls)->toContain('/shop/category/medical-socks');
});

it('serves the service worker script with required cache strategies and bypass safety rails', function () {
    $swPath = public_path('sw.js');

    expect(file_exists($swPath))->toBeTrue();

    $swContent = file_get_contents($swPath);

    expect($swContent)->toContain('addEventListener(\'install\'')
        ->and($swContent)->toContain('addEventListener(\'activate\'')
        ->and($swContent)->toContain('addEventListener(\'fetch\'')
        ->and($swContent)->toContain('/admin')
        ->and($swContent)->toContain('/checkout')
        ->and($swContent)->toContain('/customer')
        ->and($swContent)->toContain('/api')
        ->and($swContent)->toContain('/offline');
});

it('returns HTTP 200 for the offline fallback route', function () {
    get(route('shop.home.offline'))
        ->assertOk()
        ->assertSeeText('Offline')
        ->assertSeeText('No Internet Connection');
});

it('renders PWA manifest link and theme color meta tags on the storefront', function () {
    get(route('shop.home.index'))
        ->assertOk()
        ->assertSee('manifest.webmanifest')
        ->assertSee('theme-color')
        ->assertSee('#133b63')
        ->assertSee('mobile-web-app-capable')
        ->assertSee('soxnsox-pwa-install-banner');
});
