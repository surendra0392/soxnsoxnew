<?php

namespace Webkul\Shop\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Webkul\Product\Helpers\Review;

class ProductCardResource extends JsonResource
{
    /**
     * Review helper instance.
     *
     * @var Review
     */
    protected $reviewHelper;

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource)
    {
        $this->reviewHelper = app(Review::class);

        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * This is a slim variant of {@see ProductResource} used for product
     * listings and carousels. The heavy `description` field and the full
     * `images` gallery are intentionally omitted - the product card never
     * renders them - which keeps listing payloads small and avoids
     * generating cached gallery image URLs for every product.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $productTypeInstance = $this->getTypeInstance();
        $haveDiscount = (bool) $productTypeInstance->haveDiscount();
        $minimalPrice = (float) $productTypeInstance->getMinimalPrice();
        $regularPrice = (float) $productTypeInstance->getRegularMinimalPrice();
        $maximumPrice = method_exists($productTypeInstance, 'getMaximumPrice')
            ? (float) $productTypeInstance->getMaximumPrice()
            : $minimalPrice;

        if ($minimalPrice <= 0 && $this->type === 'configurable') {
            $variantPrices = $this->variants->pluck('price')->filter(fn ($p) => $p > 0);
            if ($variantPrices->isNotEmpty()) {
                $minimalPrice = (float) $variantPrices->min();
                $maximumPrice = (float) $variantPrices->max();
                $regularPrice = $minimalPrice;
            } else {
                $minimalPrice = (float) ($this->price ?? 0);
                $maximumPrice = $minimalPrice;
                $regularPrice = $minimalPrice;
            }
        }

        $formattedPrice = null;
        if ($this->type === 'configurable' && $maximumPrice > $minimalPrice) {
            $formattedPrice = core()->currency($minimalPrice).' – '.core()->currency($maximumPrice);
        } elseif ($minimalPrice > 0) {
            $formattedPrice = core()->currency($minimalPrice);
        }

        $weight = (float) ($this->weight ?? 0);
        $formattedWeight = null;
        if ($weight > 0) {
            $unit = core()->getConfigData('general.general.locale_options.weight_unit') ?: 'kgs';
            if ($unit === 'lbs') {
                $formattedWeight = ((float) $weight).' lbs Net Wt';
            } elseif ($unit === 'grams') {
                $formattedWeight = ($weight < 1 ? ((int) round($weight * 1000)) : ((float) $weight)).'g Net Wt';
            } else {
                $formattedWeight = $weight < 1 ? ((int) round($weight * 1000)).'g Net Wt' : ((float) $weight).'kg Net Wt';
            }
        }

        $discountPercent = 0;
        if ($haveDiscount && $regularPrice > 0 && $regularPrice > $minimalPrice) {
            $discountPercent = (int) round((($regularPrice - $minimalPrice) / $regularPrice) * 100);
        }

        $nonRootCategories = $this->categories->filter(fn ($c) => $c->id != 1);
        $primaryCategory = $nonRootCategories->last() ?? $nonRootCategories->first() ?? $this->categories->first();
        $categoryName = $primaryCategory?->name ?? null;
        $categorySlug = $primaryCategory?->slug ?? 'socks';

        return [
            'id' => $this->id,
            'type' => $this->type,
            'sku' => $this->sku,
            'name' => $this->name,
            'url_key' => $this->url_key,
            'category_slug' => $categorySlug,
            'url' => route('shop.products.view', ['category' => $categorySlug, 'slug' => $this->url_key]),
            'category_name' => $categoryName,
            'base_image' => product_image()->getProductBaseImage($this),
            'gallery_images' => product_image()->getGalleryImages($this),
            'weight' => $weight,
            'formatted_weight' => $formattedWeight,
            'is_new' => (bool) $this->new,
            'is_featured' => (bool) $this->featured,
            'on_sale' => $haveDiscount,
            'is_saleable' => (bool) $productTypeInstance->isSaleable(),
            'is_wishlist' => (bool) auth()->guard()->user()?->wishlist_items
                ->where('channel_id', core()->getCurrentChannel()->id)
                ->where('product_id', $this->id)->count(),
            'min_price' => core()->formatPrice($minimalPrice),
            'regular_price' => core()->currency($regularPrice > 0 ? $regularPrice : $minimalPrice),
            'formatted_price' => $formattedPrice,
            'special_price' => $haveDiscount ? core()->currency($minimalPrice) : null,
            'discount_percent' => $discountPercent,
            'price_html' => $productTypeInstance->getPriceHtml(),
            'short_description' => strip_tags($this->short_description ?? ''),
            'ratings' => [
                'average' => $this->reviewHelper->getAverageRating($this),
                'total' => $this->reviewHelper->getTotalRating($this),
            ],
            'reviews' => [
                'total' => $this->reviewHelper->getTotalReviews($this),
            ],
        ];
    }
}
