<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('sku')->unique();
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2);
            $table->decimal('capital_price', 10, 2)->nullable();
            $table->decimal('shipping_price', 10, 2)->default(0);
            $table->decimal('price_before_discount', 10, 2)->nullable();
            $table->string('featured_image')->nullable();
            $table->text('images')->nullable();
            $table->boolean('status')->default(0);
            $table->integer('sort_order');
            $table->timestamps();
            $table->index(['sku'], 'idx_product_sku');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
