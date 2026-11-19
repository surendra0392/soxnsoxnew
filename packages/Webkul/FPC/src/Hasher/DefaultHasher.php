<?php

namespace Webkul\FPC\Hasher;

use Illuminate\Http\Request;
use Spatie\ResponseCache\Hasher\DefaultHasher as BaseDefaultHasher;

class DefaultHasher extends BaseDefaultHasher
{
    /**
     * Get the hash for the given request.
     *
     * Isolates cache entries by request scheme, host/port, and active theme
     * Vite manifest timestamp so HTTP/HTTPS responses and rebuilt bundles
     * never poison Full Page Cache with mixed-content or 404 asset links.
     */
    public function getHashFor(Request $request): string
    {
        $cacheNameSuffix = $this->getCacheNameSuffix($request);
        $assetVersion = $this->getAssetBuildVersion();

        return 'responsecache-'.hash(
            'xxh128',
            "{$request->getScheme()}-{$request->getHttpHost()}-{$this->getNormalizedRequestUri($request)}-{$request->getMethod()}/{$cacheNameSuffix}/{$assetVersion}"
        );
    }

    /**
     * Get the normalized request URI for the given request.
     */
    protected function getNormalizedRequestUri(Request $request): string
    {
        if (
            $request->routeIs('shop.search.index')
            && $request->has('query')
        ) {
            $queryString = "?query={$request->query('query')}";

            return $request->getBaseUrl().$request->getPathInfo().$queryString;
        }

        return $request->getBaseUrl().$request->getPathInfo();
    }

    /**
     * Get the cache name suffix for the given request.
     */
    protected function getCacheNameSuffix(Request $request): string
    {
        if ($request->attributes->has('responsecache.cacheNameSuffix')) {
            return $request->attributes->get('responsecache.cacheNameSuffix');
        }

        $cacheNameSuffix = core()->getCurrentChannel()->code
            .'-'.core()->getCurrentLocale()->code
            .'-'.core()->getCurrentCurrency()->code
            .'-'.$this->cacheProfile->useCacheNameSuffix($request);

        return $cacheNameSuffix;
    }

    /**
     * Resolve the current shop theme's Vite asset build version.
     */
    protected function getAssetBuildVersion(): string
    {
        try {
            $channelTheme = core()->getCurrentChannel()?->theme ?: config('themes.shop-default', 'default');
        } catch (\Throwable) {
            $channelTheme = config('themes.shop-default', 'default');
        }

        $viteConfig = config("themes.shop.{$channelTheme}.vite", config('themes.shop.default.vite', []));
        $hotFile = $viteConfig['hot_file'] ?? 'shop-default-vite.hot';
        $buildDir = $viteConfig['build_directory'] ?? 'themes/shop/default/build';

        $hotPath = public_path($hotFile);
        clearstatcache(true, $hotPath);

        if (is_file($hotPath)) {
            return 'hot-'.(@filemtime($hotPath) ?: 0);
        }

        $manifestPath = public_path(trim($buildDir, '/').'/manifest.json');
        clearstatcache(true, $manifestPath);

        if (is_file($manifestPath)) {
            return 'build-'.(@filemtime($manifestPath) ?: 0);
        }

        return 'none';
    }
}
