<?php

namespace Database\Factories;

use App\Helpers\FakerHelper;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $height = rand(600, 900);
        $width = intval($height * 2 / 3);
        $randomCategory = Category::query()->inRandomOrder()->first();
        $randomVendor = Admin::role('Admin')->inRandomOrder()->first();
        $price = (float) mt_rand(1.00, 99.00);

        return [
            'name:en' => fake()->name,
            'description:en' => fake()->text,
            'sku' => fake()->name,
            'category_id' => $randomCategory->id,
            'price' => (float) $price / 2,
            'price_before_discount' => $price,
            'status' => 1,
            'sort_order' => fake()->numberBetween(1, 100),
            'admin_id' => $randomVendor->id,
            'images' => [
                FakerHelper::getImageUrl($width, $height, 'NOT USED', false),
                FakerHelper::getImageUrl($width, $height, 'NOT USED', false),
            ],
            'featured_image' => FakerHelper::getImageUrl($width, $height, 'NOT USED', false),
            'shipping_price' => mt_rand(2, 10),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $inventory = DB::table('inventory')->where('product_id', $product->id);
            if (! $inventory->exists()) {
                return $inventory->insert([
                    'product_id' => $product->id,
                    'quantity' => 50,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
