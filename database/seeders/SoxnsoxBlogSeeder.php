<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\Blog\Database\Seeders\BlogTableSeeder;

class SoxnsoxBlogSeeder extends Seeder
{
    /**
     * Seed the blog articles.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BlogTableSeeder::class);
    }
}
