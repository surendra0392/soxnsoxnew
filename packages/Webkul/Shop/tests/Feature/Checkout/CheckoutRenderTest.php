<?php

use Webkul\Core\Models\CoreConfig;
use Webkul\Faker\Helpers\Product as ProductFaker;

use function Pest\Laravel\get;
use function Pest\Laravel\postJson;

it('loads checkout onepage without any server errors', function () {
    CoreConfig::where('code', 'sales.order_settings.minimum_order.enable')->update(['value' => '0']);

    $product = (new ProductFaker([
        'attributes' => [
            26 => 'guest_checkout',
        ],
        'attribute_value' => [
            'guest_checkout' => [
                'boolean_value' => true,
            ],
        ],
    ]))->getSimpleProductFactory()->create();

    postJson(route('shop.api.checkout.cart.store'), [
        'product_id' => $product->id,
        'quantity' => 1,
    ])->assertOk();

    get(route('shop.checkout.onepage.index'))
        ->assertOk();
});
