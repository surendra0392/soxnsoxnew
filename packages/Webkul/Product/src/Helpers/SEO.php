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
        $catSlug = $product->getPrimaryCategorySlug();

        $data = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => trim(html_entity_decode(strip_tags((string) $product->description), ENT_QUOTES | ENT_HTML5, 'UTF-8')),
            'url' => route('shop.products.view', ['category' => $catSlug, 'slug' => $product->url_key]),
            'brand' => [
                '@type' => 'Brand',
                'name' => 'SOX N SOX',
            ],
        ];

        if (core()->getConfigData('catalog.rich_snippets.products.show_sku')) {
            $data['sku'] = $product->sku;
        }

        if (core()->getConfigData('catalog.rich_snippets.products.show_weight') && (float) $product->weight > 0) {
            $weightUnit = core()->getConfigData('general.general.locale_options.weight_unit') ?: 'kgs';
            $unitCode = match ($weightUnit) {
                'grams' => 'GRM',
                'lbs' => 'LBR',
                default => 'KGM',
            };

            $data['weight'] = [
                '@type' => 'QuantitativeValue',
                'value' => (float) $product->weight,
                'unitCode' => $unitCode,
            ];
        }

        if (core()->getConfigData('catalog.rich_snippets.products.show_categories')) {
            $data['category'] = $this->getProductCategories($product);
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

            $url = $image->url;
            $images[] = str_starts_with($url, 'http') ? $url : url($url);
        }

        if (empty($images)) {
            $base = product_image()->getProductBaseImage($product);
            if (! empty($base['large_image_url'])) {
                $images[] = str_starts_with($base['large_image_url'], 'http')
                    ? $base['large_image_url']
                    : url($base['large_image_url']);
            }
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
        $typeInstance = $product->getTypeInstance();
        $catSlug = $product->getPrimaryCategorySlug();

        return [
            '@type' => 'Offer',
            'priceCurrency' => core()->getCurrentCurrencyCode(),
            'price' => (float) $typeInstance->getMinimalPrice(),
            'priceValidUntil' => now()->addYear()->format('Y-12-31'),
            'availability' => $typeInstance->isSaleable()
                ? 'https://schema.org/InStock'
                : 'https://schema.org/OutOfStock',
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
    public function getCategoryJsonLd($category, ?string $canonicalUrl = null)
    {
        $resolvedUrl = $canonicalUrl ?: (
            $category->id == (core()->getCurrentChannel()->root_category_id ?? 1)
                ? route('shop.products.index')
                : route('shop.category.view', $category->slug)
        );

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            '@id' => $resolvedUrl.'#collectionpage',
            'url' => $resolvedUrl,
            'name' => $category->name,
            'description' => trim(html_entity_decode(strip_tags((string) $category->description), ENT_QUOTES | ENT_HTML5, 'UTF-8')),
            'isPartOf' => [
                '@id' => url('/').'/#website',
            ],
        ];

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
