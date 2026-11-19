<?php

use Webkul\Customer\Models\Customer;

it('renders customer reviews page without 500 errors', function () {
    $customer = Customer::first() ?? (new Webkul\Faker\Helpers\Customer)->factory()->create();
    $this->actingAs($customer, 'customer');

    $response = $this->get(route('shop.customers.account.reviews.index'));

    $response->assertOk();
    $response->assertSee('Reviews');
});
