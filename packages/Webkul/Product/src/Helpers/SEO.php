<?php

namespace Webkul\Product\Helpers;

use Illuminate\Support\Facades\Storage;
use Webkul\Category\Contracts\Category;
use Webkul\Product\Contracts\Product;

class SEO
{
    /**
     * Returns product json ld data for product
     *
     * @param  Product  $product
     * @return string
     */
    public function getProductJsonLd($product)
    {
        $nonRootCats = $product->categories->filter(fn ($c) => $c->id != 1);
        $primaryCat = $nonRootCats->last() ?? $nonRootCats->first();
        $catSlug = $primaryCat?->slug ?? 'socks';

        $data = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => htmlspecialchars(trim(strip_tags($product->description))),
            'url' => route('shop.products.view', ['category' => $catSlug, 'slug' => $product->url_key]),
            'brand' => [
                '@type' => 'Brand',
                'name' => 'SOX N SOX',
            ],
        ];

        if (core()->getConfigData('catalog.rich_snippets.products.show_sku')) {
            $data['sku'] = $product->sku;
        }

        if (core()->getConfigData('catalog.rich_snippets.products.show_weight')) {
            $data['weight'] = $product->weight;
        }

        if (core()->getConfigData('catalog.rich_snippets.products.show_categories')) {
            $data['categories'] = $this->getProductCategories($product);
        }

        if (core()->getConfigData('catalog.rich_snippets.products.show_images')) {
            $data['image'] = $this->getProductImages($product);
        }

        if (core()->getConfigData('catalog.rich_snippets.products.show_reviews')) {
            $reviews = $this->getProductReviews($product);
            if (! empty($reviews)) {
                $data['review'] = $reviews;
            }
        }

        if (core()->getConfigData('catalog.rich_snippets.products.show_ratings')) {
            $ratingData = $this->getProductAggregateRating($product);
            if (! empty($ratingData['reviewCount']) && $ratingData['reviewCount'] > 0) {
                $data['aggregateRating'] = $ratingData;
            }
        }

        if (core()->getConfigData('catalog.rich_snippets.products.show_offers')) {
            $data['offers'] = $this->getProductOffers($product);
        }

        return json_encode($data);
    }

    /**
     * Returns product categories
     *
     * @param  Product  $product
     * @return string
     */
    public function getProductCategories($product)
    {
        $categories = $product->categories;

        $names = [];

        foreach ($categories as $key => $category) {
            $names[] = $category->name;
        }

        return implode(', ', $names);
    }

    /**
     * Returns product images
     *
     * @param  Product  $product
     * @return array
     */
    public function getProductImages($product)
    {
        $images = [];

        foreach ($product->images as $image) {
            if (! Storage::has($image->path)) {
                continue;
            }

            $images[] = $image->url;
        }

        return $images;
    }

    /**
     * Returns product reviews
     *
     * @param  Product  $product
     * @return array
     */
    public function getProductReviews($product)
    {
        $reviews = [];

        foreach ($product->reviews()->where('status', 'approved')->get() as $review) {
            $reviews[] = [
                '@type' => 'Review',
                'reviewRating' => [
                    '@type' => 'Rating',
                    'ratingValue' => $review->rating,
                    'bestRating' => '5',
                ],
                'author' => [
                    '@type' => 'Person',
                    'name' => $review->name,
                ],
            ];
        }

        return $reviews;
    }

    /**
     * Returns product average ratings
     *
     * @param  Product  $product
     * @return array
     */
    public function getProductAggregateRating($product)
    {
        $reviewHelper = app('Webkul\Product\Helpers\Review');

        return [
            '@type' => 'AggregateRating',
            'ratingValue' => $reviewHelper->getAverageRating($product),
            'reviewCount' => $reviewHelper->getTotalReviews($product),
        ];
    }

    /**
     * Returns product average ratings
     *
     * @param  Product  $product
     * @return array
     */
    public function getProductOffers($product)
    {
        $nonRootCats = $product->categories->filter(fn ($c) => $c->id != 1);
        $primaryCat = $nonRootCats->last() ?? $nonRootCats->first();
        $catSlug = $primaryCat?->slug ?? 'socks';

        return [
            '@type' => 'Offer',
            'priceCurrency' => core()->getCurrentCurrencyCode(),
            'price' => (float) $product->getTypeInstance()->getMinimalPrice(),
            'priceValidUntil' => now()->addYear()->format('Y-12-31'),
            'availability' => 'https://schema.org/InStock',
            'itemCondition' => 'https://schema.org/NewCondition',
            'url' => route('shop.products.view', ['category' => $catSlug, 'slug' => $product->url_key]),
            'seller' => [
                '@type' => 'Organization',
                'name' => 'SOX N SOX',
            ],
        ];
    }

    /**
     * Returns product json ld data for category
     *
     * @param  Category  $category
     * @return array
     */
    public function getCategoryJsonLd($category)
    {
        $data = [
            '@type' => 'WebSite',
            '@context' => 'http://schema.org',
            'url' => config('app.url'),
        ];

        if (core()->getConfigData('catalog.rich_snippets.categories.show_search_input_field')) {
            $data['potentialAction'] = [
                '@type' => 'SearchAction',
                'target' => config('app.url').'/search/?term={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ];
        }

        return json_encode($data);
    }
}
