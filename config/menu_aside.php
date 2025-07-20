<?php

// Aside menu

use App\Models\Order;

return [

    'items' => [
        // Dashboard
        [
            'title' => config('app.title'),
            'root' => true,
            'icon' => 'assets/media/svg/icons/Design/Layers.svg', // or can be 'flaticon-home' or any flaticon-*
            'page' => 'admin.dashboard',
            'new-tab' => false,
        ],

        // Admins & Roles & Permissions & Users
        [
            'section' => 'Custom',
        ],
        [
            'title' => 'admin.users_management',
            'icon' => 'assets/media/svg/icons/Communication/Group.svg',
            'bullet' => 'line',
            'root' => true,
            'submenu' => [
                // [
                //     'title' => 'admin.admins',
                //     'permission' => 'list admins',
                //     'bullet' => 'dot',
                //     'submenu' => [
                //         [
                //             'title' => 'admin.all_admins',
                //             'page' => 'admin.admins.index',
                //             'permission' => 'list admins',
                //         ],
                //         // [
                //         //     'title' => 'admin.new_admin',
                //         //     'page' => 'admin.admins.create',
                //         //     'permission' => 'add admins',
                //         // ]
                //     ]
                // ],
                [
                    'title' => 'admin.users',
                    'bullet' => 'dot',
                    'permission' => 'list users',
                    'submenu' => [
                        [
                            'title' => 'admin.all_users',
                            'page' => 'admin.users.index',
                            'permission' => 'list users',
                        ],
                        // [
                        //     'title' => 'admin.new_user',
                        //     'page' => 'admin.users.create',
                        //     'permission' => 'add users',
                        // ]
                    ],
                ],

                // [
                //     'title' => 'admin.roles',
                //     'bullet' => 'dot',
                //     'permission' => 'list roles',
                //     'submenu' => [
                //         [
                //             'title' => 'admin.all_roles',
                //             'page' => 'admin.roles.index',
                //             'permission' => 'list roles',
                //         ],
                //         [
                //             'title' => 'admin.new_role',
                //             'page' => 'admin.roles.create',
                //             'permission' => 'add roles',
                //         ]
                //     ]
                // ]
            ],
        ],
        // Sliders
        [
            'section' => 'Custom',
        ],
        [

            'title' => 'admin.slider',
            'icon' => 'assets/media/svg/icons/Home/Picture.svg',
            'bullet' => 'line',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'admin.all_sliders',
                    'page' => 'admin.sliders.index',
                    'bullet' => 'dot',
                    'permission' => 'list sliders',
                ],
                [
                    'title' => 'admin.new_slider',
                    'page' => 'admin.sliders.create',
                    'bullet' => 'dot',
                    'permission' => 'add sliders',
                ],
            ],
        ],

        // Categories & Products
        [
            'section' => 'Custom',
        ],
        [
            'title' => 'admin.catalog_management',
            'icon' => 'assets/media/svg/icons/Home/Chair1.svg',
            'bullet' => 'line',
            'root' => true,
            'permission' => 'list products',
            'submenu' => [
                // [
                //     'title' => 'admin.attributes',
                //     'bullet' => 'dot',
                //     'submenu' => [
                //         [
                //             'title' => 'admin.all_attributes',
                //             'page' => 'admin.attributes.index',
                //             'permission' => 'list attributes',
                //         ],
                //         [
                //             'title' => 'admin.new_category',
                //             'page' => 'admin.attributes.create',
                //             'permission' => 'add attributes',
                //         ]
                //     ]
                // ],
                [
                    'title' => 'admin.categories',
                    'bullet' => 'dot',
                    'submenu' => [
                        [
                            'title' => 'admin.all_categories',
                            'page' => 'admin.categories.index',
                            'permission' => 'list categories',

                        ],
                        [
                            'title' => 'admin.new_category',
                            'page' => 'admin.categories.create',
                            'permission' => 'add categories',

                        ],
                    ],
                ],
                [
                    'title' => 'admin.products',
                    'bullet' => 'dot',
                    'permission' => 'list products',
                    'submenu' => [
                        [
                            'title' => 'admin.all_products',
                            'page' => 'admin.products.index',
                            'permission' => 'list products',
                        ],
                        [
                            'title' => 'admin.new_product',
                            'page' => 'admin.products.create',
                            'permission' => 'add products',
                        ],
                    ],
                ],
                [
                    'title' => 'admin.offers',
                    'bullet' => 'dot',
                    'page' => 'admin.offers.index',
                    'permission' => 'list products',
                ],
                [
                    'title' => 'admin.Inventory',
                    'bullet' => 'dot',
                    'page' => 'admin.inventory.index',
                    'permission' => 'list products',
                ],
            ],
        ],

        // [

        //     'title' => 'admin.coupons',
        //     'icon' => 'assets/media/svg/icons/Home/Picture.svg',
        //     'bullet' => 'line',
        //     'root' => true,
        //     'submenu' => [
        //         [
        //             'title' => 'admin.all_coupons',
        //             'page' => 'admin.coupons.index',
        //             'bullet' => 'dot',
        //             'permission' => 'list coupons',
        //         ],
        //         [
        //             'title' => 'admin.new_coupon',
        //             'page' => 'admin.coupons.create',
        //             'bullet' => 'dot',
        //             'permission' => 'add coupons',
        //         ]
        //     ]
        // ],
        // Admin Settings
        [

            'title' => 'admin.settings',
            'icon' => 'assets/media/svg/icons/General/Settings-1.svg',
            'bullet' => 'line',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'admin.general_settings',
                    'bullet' => 'dot',
                    'page' => 'admin.settings.index',
                    'permission' => 'list settings',
                    // 'submenu' => [
                    //     [
                    //         'title' => 'admin.all_settings',
                    //         'page' => 'admin.settings.index',
                    //         'permission' => 'list settings',
                    //     ],
                    //     [
                    //         'title' => 'admin.new_settings',
                    //         'page' => 'admin.settings.create',
                    //         'permission' => 'add settings',
                    //     ]
                    // ]
                ],
                [
                    'title' => 'admin.offers',
                    'bullet' => 'dot',
                    'page' => 'admin.offers',
                    'permission' => 'list offers',
                ],
                [
                    'title' => 'currency.currency',
                    'bullet' => 'dot',
                    'submenu' => [
                        [
                            'title' => 'currency.all_currencies',
                            'page' => 'admin.currencies.index',
                            'permission' => 'list currencies',

                        ],
                        [
                            'title' => 'currency.new_currency',
                            'page' => 'admin.currencies.create',
                            'permission' => 'add currencies',

                        ],
                    ],
                ],
                [
                    'title' => 'admin.site_map',
                    'bullet' => 'dot',
                    'permission' => 'list site map',
                    'submenu' => [
                        [
                            'title' => 'admin.about_us',
                            'page' => 'admin.settings.about',
                            'bullet' => 'line',
                            'permission' => 'list about us',
                        ],
                        [
                            'title' => 'admin.contact_us',
                            'page' => 'admin.settings.contact',
                            'bullet' => 'line',
                            'permission' => 'list contact us',
                        ],
                        [
                            'title' => 'admin.terms_of_service',
                            'page' => 'admin.settings.terms',
                            'bullet' => 'line',
                            'permission' => 'list terms',
                        ],
                        [
                            'title' => 'admin.privacy_policy',
                            'page' => 'admin.settings.privacy',
                            'bullet' => 'line',
                            'permission' => 'list privacy',
                        ],
                        [
                            'title' => 'admin.accessibility',
                            'page' => 'admin.settings.accessibility',
                            'bullet' => 'line',
                            'permission' => 'list accessibility',
                        ],
                    ],
                ],
                [
                    'title' => 'admin.admin_info',
                    'bullet' => 'dot',
                    'permission' => 'list admin info',
                    'submenu' => [
                        [
                            'title' => 'admin.admin_name',
                            'page' => 'admin.settings.adminName',
                            'bullet' => 'line',
                            'permission' => 'list admin name',
                        ],
                        [
                            'title' => 'admin.admin_email',
                            'page' => 'admin.settings.adminEmail',
                            'bullet' => 'line',
                            'permission' => 'list admin email',
                        ],
                    ],
                ],
                [
                    'title' => 'admin.about_info',
                    'bullet' => 'dot',
                    'permission' => 'list about info',
                    'submenu' => [
                        [
                            'title' => 'admin.about_us_title',
                            'page' => 'admin.settings.aboutTitle',
                            'bullet' => 'line',
                            'permission' => 'list about us title',
                        ],
                        [
                            'title' => 'admin.about_us',
                            'page' => 'admin.settings.about',
                            'bullet' => 'line',
                            'permission' => 'list about us',
                        ],
                        [
                            'title' => 'admin.about_us_image',
                            'page' => 'admin.settings.aboutImage',
                            'bullet' => 'line',
                            'permission' => 'list about us image',
                        ],
                        [
                            'title' => 'admin.about_us_album',
                            'page' => 'admin.settings.aboutAlbum',
                            'bullet' => 'line',
                            'permission' => 'list about us album',
                        ],
                    ],
                ],
                [
                    'title' => 'admin.site_info',
                    'bullet' => 'dot',
                    'permission' => 'list site info',
                    'submenu' => [
                        [
                            'title' => 'admin.site_phone',
                            'page' => 'admin.settings.sitePhone',
                            'bullet' => 'line',
                            'permission' => 'list site phone',
                        ],
                        [
                            'title' => 'admin.site_email',
                            'page' => 'admin.settings.siteEmail',
                            'bullet' => 'line',
                            'permission' => 'list site email',
                        ],
                        [
                            'title' => 'admin.new_arrival_image',
                            'page' => 'admin.settings.newArrivalImage',
                            'bullet' => 'line',
                            'permission' => 'list arrival',
                        ],
                        [
                            'title' => 'admin.footer_address',
                            'page' => 'admin.settings.footerAddress',
                            'bullet' => 'line',
                            'permission' => 'list footer address',
                        ],
                    ],
                ],
                // [
                //     'title' => 'admin.banners',
                //     'bullet' => 'dot',
                //     'submenu' => [
                //         [
                //             'title' => 'admin.all_banners',
                //             'page' => 'admin.banners.index',
                //             'permission' => 'list banners',
                //         ],
                //         [
                //             'title' => 'admin.new_banners',
                //             'page' => 'admin.banners.create',
                //             'permission' => 'add banners',
                //         ]
                //     ]
                // ],
            ],
        ],
        // Notifications
        // [
        //     'section' => 'Custom',
        // ],
        // [

        //     'title' => 'admin.notification',
        //     'icon' => 'assets/media/svg/icons/General/Notifications1.svg',
        //     'bullet' => 'line',
        //     'root' => true,
        //     'submenu' => [
        //         [
        //             'title' => 'admin.all_notifications',
        //             'page' => 'admin.notifications.index',
        //             'bullet' => 'dot',
        //             'permission' => 'list notifications',
        //         ],
        //         [
        //             'title' => 'admin.new_notification',
        //             'page' => 'admin.notifications.create',
        //             'bullet' => 'dot',
        //             'permission' => 'add notifications',
        //         ]
        //     ]
        // ],
        // Countries
        [
            'section' => 'Custom',
        ],
        [
            'title' => 'admin.countries_management',
            'icon' => 'assets/media/svg/icons/Communication/Flag.svg',
            'bullet' => 'line',
            'permission' => 'list countries',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'admin.countries',
                    'bullet' => 'dot',
                    'submenu' => [
                        [
                            'title' => 'admin.all_countries',
                            'page' => 'admin.countries.index',
                            'permission' => 'list countries',
                        ],
                        [
                            'title' => 'admin.new_country',
                            'page' => 'admin.countries.create',
                            'permission' => 'add countries',
                        ],
                    ],
                ],
                [
                    'title' => 'admin.cities',
                    'bullet' => 'dot',
                    'submenu' => [
                        [
                            'title' => 'admin.all_cities',
                            'page' => 'admin.cities.index',
                            'permission' => 'list cities',
                        ],
                        [
                            'title' => 'admin.new_city',
                            'page' => 'admin.cities.create',
                            'permission' => 'add cities',
                        ],
                    ],
                ],
            ],
        ],

        // Orders
        [
            'section' => 'Custom',
        ],
        [

            'title' => 'admin.orders',
            'icon' => 'assets/media/svg/icons/General/Clipboard.svg',
            'bullet' => 'line',
            'root' => true,
            'permission' => 'list orders',
            'submenu' => [
                [
                    'bullet' => 'dot',
                    'title' => 'admin.all_orders',
                    'page' => 'admin.orders.index',
                    'permission' => 'list orders',
                ],
                [
                    'bullet' => 'dot',
                    'title' => 'order.pending',
                    'page' => 'admin.orders.byStatus',
                    'params' => ['status' => Order::STATUS_PENDING],
                    'permission' => 'order pending',
                ],
                [
                    'bullet' => 'dot',
                    'title' => 'order.ongoing',
                    'page' => 'admin.orders.byStatus',
                    'params' => ['status' => Order::STATUS_ONGOING],
                    'permission' => 'order ongoing',
                ],
                [
                    'bullet' => 'dot',
                    'title' => 'order.cancelled',
                    'page' => 'admin.orders.byStatus',
                    'params' => ['status' => Order::STATUS_CANCELLED],
                    'permission' => 'order cancelled',
                ],
                [
                    'bullet' => 'dot',
                    'title' => 'order.delivered',
                    'page' => 'admin.orders.byStatus',
                    'params' => ['status' => Order::STATUS_DELIVERED],
                    'permission' => 'order delivered',
                ],
            ],
        ],
        // Reports
        [
            'section' => 'Custom',
        ],
        [
            'title' => 'admin.reports_management',
            'icon' => 'assets/media/svg/icons/Media/Equalizer.svg',
            'bullet' => 'line',
            'root' => true,
            'permission' => 'list reports',
            'submenu' => [
                // [
                //     'title' => 'admin.reports.date_wise_sales',
                //     'page' => 'admin.reports.dateWiseSalesIndex',
                // ],
                [
                    'title' => 'admin.reports.sales_details',
                    'page' => 'admin.reports.salesDetailsIndex',
                ],
                [
                    'title' => 'admin.reports.item_wise_sales',
                    'page' => 'admin.reports.itemWiseSalesIndex',
                ],
            ],
        ],
        // Reports
        [
            'section' => 'Custom',
        ],
        [
            'title' => 'admin.reviews_management',
            'icon' => 'assets/media/svg/icons/General/Half-star.svg',
            'bullet' => 'line',
            'page' => 'admin.reviews.index',
            'permission' => 'list reviews',
        ],
        // Reports
        [
            'section' => 'Custom',
        ],
        [
            'title' => 'admin.all_bookings',
            'icon' => 'assets/media/svg/icons/General/Half-star.svg',
            'bullet' => 'line',
            'page' => 'admin.bookings.index',
            'permission' => 'list bookings',
        ],
    ],
];
