<?php

it('renders the blog index page', function () {
    $response = $this->get(route('shop.blogs.index'));

    $response->assertSuccessful();
});

it('redirects query parameter category to clean url', function () {
    $response = $this->get('/blog?category=Foot+Care');

    $response->assertStatus(301);
});
