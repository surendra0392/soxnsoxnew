<?php

return [
    [
        'key' => 'blogs',
        'name' => 'blog::app.admin.acl.blogs',
        'route' => 'admin.blogs.index',
        'sort' => 5,
    ],
    [
        'key' => 'blogs.create',
        'name' => 'blog::app.admin.acl.create',
        'route' => 'admin.blogs.store',
        'sort' => 1,
    ],
    [
        'key' => 'blogs.edit',
        'name' => 'blog::app.admin.acl.edit',
        'route' => 'admin.blogs.update',
        'sort' => 2,
    ],
    [
        'key' => 'blogs.delete',
        'name' => 'blog::app.admin.acl.delete',
        'route' => 'admin.blogs.destroy',
        'sort' => 3,
    ],
];
