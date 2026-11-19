<?php

namespace Webkul\Shop\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'type' => $this->type,
            'name' => $this->name,
            'price' => $this->price,
            'formatted_price' => core()->formatPrice($this->price),
            'price_incl_tax' => $this->price_incl_tax,
            'formatted_price_incl_tax' => core()->formatPrice($this->price_incl_tax),
            'total' => $this->total,
            'formatted_total' => core()->formatPrice($this->total),
            'total_incl_tax' => $this->total_incl_tax,
            'formatted_total_incl_tax' => core()->formatPrice($this->total_incl_tax),
            'discount_amount' => $this->discount_amount,
            'formatted_discount_amount' => core()->formatPrice($this->discount_amount),
            'base_image' => $this->getTypeInstance()->getBaseImage($this),
            'product_url_key' => $this->product?->url_key,
            'options' => $this->formatAdditionalAttributes(),
            'can_change_qty' => $this->product ? $this->product->getTypeInstance()->showQuantityBox() : false,
            'weight' => $weight = (float) ($this->weight ?? $this->product?->weight ?? 0),
            'formatted_weight' => filter_var(core()->getConfigData('catalog.rich_snippets.products.show_weight'), FILTER_VALIDATE_BOOLEAN)
                ? $this->formatWeight($weight)
                : null,
            'regular_price' => $regularPrice = (float) ($this->child?->product?->price ?? $this->product?->price ?? $this->price),
            'formatted_regular_price' => core()->formatPrice($regularPrice),
            'has_discount' => ($regularPrice > (float) $this->price),
            'unit_discount' => max(0, $regularPrice - (float) $this->price),
            'formatted_unit_discount' => core()->formatPrice(max(0, $regularPrice - (float) $this->price)),
            'regular_total' => $regularPrice * $this->quantity,
            'formatted_regular_total' => core()->formatPrice($regularPrice * $this->quantity),
        ];
    }

    /**
     * Format weight: under 1kg in grams (e.g. 200g, 250g), 1kg or more in kg (e.g. 1kg, 1.5kg).
     */
    public function formatWeight(float $weight): ?string
    {
        if ($weight <= 0) {
            return null;
        }

        if ($weight < 1) {
            $grams = round($weight * 1000);

            return $grams.'g';
        }

        $kg = (float) rtrim(rtrim(number_format($weight, 2, '.', ''), '0'), '.');

        return $kg.'kg';
    }

    /**
     * Format the additional attributes.
     */
    public function formatAdditionalAttributes(): array
    {
        $attributes = $this->resource->additional['attributes'] ?? [];

        if (! empty($attributes)) {
            return collect($attributes)
                ->map(function ($attribute) {
                    if (
                        isset($attribute['attribute_type'])
                        && $attribute['attribute_type'] == 'file'
                    ) {
                        $attribute['file_name'] = File::basename($attribute['option_label']);

                        $attribute['file_url'] = Storage::url($attribute['option_label']);
                    }

                    return $attribute;
                })
                ->values()
                ->toArray();
        }

        return [];
    }
}
