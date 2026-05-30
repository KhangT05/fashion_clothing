<?php

return [
    'module' => [
        [
            'name' => 'dashboard',
            'title' => 'Dashboard',
            'icon' => 'fa fa-th-large',
            'route' => 'server.dashboard',
        ],
        [
            'name' => 'users',
            'title' => 'Quản lý người dùng',
            'icon' => 'fa fa-user',
            'route' => 'users.index',
            'children' => [
                ['title' => 'Danh sách người dùng', 'route' => 'users.index'],
                ['title' => 'Thêm mới người dùng', 'route' => 'users.create'],
            ]
        ],
        [
            'name' => 'roles',
            'title' => 'Quản lý Vai Trò',
            'icon' => 'fa fa fa-lock',
            'route' => 'roles.index',
            'children' => [
                ['title' => 'Danh sách vai trò', 'route' => 'roles.index'],
                ['title' => 'Thêm mới vai trò', 'route' => 'roles.create'],
            ]
        ],
        [
            'name' => 'categories',
            'title' => 'Quản lý Danh mục',
            'icon' => 'fa fa-list',
            'route' => 'categories.index',
            'children' => [
                ['title' => 'Danh sách danh mục', 'route' => 'categories.index'],
                ['title' => 'Thêm mới danh mục', 'route' => 'categories.create'],
            ]
        ],
        [
            'name' => 'products',
            'title' => 'Quản lý Sản phẩm',
            'icon' => 'fa fa-boxes-stacked',
            'route' => 'products.index',
            'children' => [
                ['title' => 'Danh sách sản phẩm', 'route' => 'products.index'],
                ['title' => 'Thêm sản phẩm', 'route' => 'products.create'],
            ]
        ],
        // [
        //     'name' => 'brands',
        //     'title' => 'Quản lý Thương hiệu',
        //     'icon' => 'fa fa-building',
        //     'route' => 'brands.index',
        //     'children' => [
        //         ['title' => 'Danh sách thương hiệu', 'route' => 'brands.index'],
        //         ['title' => 'Thêm mới thương hiệu', 'route' => 'brands.create'],
        //     ]
        // ],
        [
            'name' => 'orders',
            'title' => 'Quản lý Hóa đơn',
            'icon' => 'fa fa-credit-card',
            'route' => 'orders.index',
            'children' => [
                ['title' => 'Danh sách hóa đơn', 'route' => 'orders.index'],
            ]
        ],
        // [
        //     'name' => 'variants',
        //     'title' => 'Quản lý Biến thể',
        //     'icon' => 'fa fa-layer-group',
        //     'route' => 'variants.index',
        //     'children' => [
        //         ['title' => 'Danh sách biến thể', 'route' => 'variants.index'],
        //         ['title' => 'Thêm mới biến thể', 'route' => 'variants.create'],
        //     ]
        // ],
        [
            'name' => 'contacts',
            'title' => 'Quản lý Liên hệ',
            'icon' => 'fa fa-address-book',
            'route' => 'contacts.index',
            'children' => [
                ['title' => 'Danh sách liên hệ', 'route' => 'contacts.index'],
                // ['title' => 'Danh sách', 'route' => 'users.index'],
            ]
        ],
        [
            'name' => 'slides',
            'title' => 'Quản lý Slide',
            'icon' => 'fa fa-images',
            'route' => 'slides.index',
            'children' => [
                ['title' => 'Danh sách slide', 'route' => 'slides.index'],
                ['title' => 'Thêm mới slide', 'route' => 'slides.create'],
            ]
        ],
        [
            'name' => 'comment',
            'title' => 'Quản lý Bình luận ',
            'icon' => 'fa fa-images',
            'route' => 'comment.index',
            'children' => [
                ['title' => 'Danh sách Bình luận', 'route' => 'comment.index'],
            ]
        ],
    ]
];
