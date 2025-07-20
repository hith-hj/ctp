<?php

namespace App\Http\Traits;

trait ReviewTrait
{
    public function getModelType($model_type): string
    {
        switch ($model_type) {
            case 'product':
                return 'App\Models\Product';
            case 'service':
                return 'App\Models\Service';
            case 'vendor':
                return 'App\Models\Admin';
            default:
                return '';
        }
    }

    public function getFavoritesByModelName($user, $type)
    {
        switch ($type) {
            case 'product':
                return $user->ProductReviews();
            case 'designer':
                return $user->ServiceReviews();
            default:
                return $user->ProductReviews();
        }
    }
}
