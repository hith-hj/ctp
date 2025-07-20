<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\City;
use App\Models\Currency;
use App\Models\Offer;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        dump('cities');
        City::factory()->count(6)->create();
        dump('currencies');
        Currency::factory()->usd()->create();
        Currency::factory()->sar()->create();
        dump('admins');
        Admin::factory()->admin()->create();
        Admin::factory()->vendor()->create();
        Admin::factory()->client()->create();
        Admin::factory()->shipping()->create();
        $this->call([
            AdminSeeder::class,
            AdminSettingsSeeder::class,
            SettingSeeder::class,
        ]);
        dump('categories');
        $categories = Category::factory()->count(10)->create();
        dump('attrs');
        $attributes = Attribute::factory()->count(10)->create();
        dump('products');
        $products = Product::factory()->count(10)->create();
        dump('users');
        User::factory()->count(5)->create();
        User::factory()->create([
            'email' => 'user@gmail.com',
        ]);
        dump('category attrs');
        $categories->each(function ($category) {
            $attributes = Attribute::inRandomOrder()->limit(3)->get();
            $category->attributes()->attach($attributes);
        });

        dump('product attrs');
        foreach ($products as $product) {
            foreach ($attributes as $attribute) {
                if ($attribute->categories->contains($product->category)) {
                    ProductAttribute::create([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute->id,
                        'value' => $attribute->type == 'checkbox' ? '1' : rand(1, 99999),
                    ]);
                }
            }
        }
        dump('sliders');
        Slider::factory(4)->create();
        dump('offers');
        Offer::factory()->winter()->create();
        Offer::factory()->summer()->create();
    }
}
