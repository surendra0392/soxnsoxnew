<?php

namespace Webkul\Blog\Repositories;

use Webkul\Core\Eloquent\Repository;

class BlogRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return 'Webkul\Blog\Contracts\Blog';
    }
}
