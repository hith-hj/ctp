<?php

namespace Database\Factories;

use App\Helpers\FakerHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    public function definition()
    {
        return [
            //
        ];
    }

    public function winter()
    {
        return $this->state([
            'title' => 'Winter Collection',
            'description' => 'Save 50% on our new winter collection',
            'sort_order' => '1',
            'product_id' => '1',
            'image' => FakerHelper::getImageUrl(),
        ]);
    }

    public function summer()
    {
        return $this->state([
            'title' => 'Summer Collection',
            'description' => 'Save 50% on our new Summer collection',
            'sort_order' => '1',
            'product_id' => '2',
            'image' => FakerHelper::getImageUrl(),
        ]);
    }
}
