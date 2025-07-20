<?php

return [
    [
        'id' => 'AppliesToProducts',
        'isModel' => true,
        'name' => 'products',
        'model' => 'App\Models\Product',
        'displayColumn' => 'name',
        'searchColumns' => [
            [
                'columnName' => 'name',
                'isTranslate' => true,
            ],
            [
                'columnName' => 'description',
                'isTranslate' => true,
            ],
            [
                'columnName' => 'sku',
                'isTranslate' => false,
            ],
        ],

    ],
    [
        'id' => 'AppliesToCategories',
        'isModel' => true,
        'name' => 'categories',
        'model' => 'App\Models\Category',
        'displayColumn' => 'name',
        'searchColumns' => [
            [
                'columnName' => 'name',
                'isTranslate' => true,
            ],
        ],

    ],

];
