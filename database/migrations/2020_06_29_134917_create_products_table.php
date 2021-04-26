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
        // Some times, in some countries, some products has different type of tax rates.
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->string('price')->nullable();
            $table->string('sku')->nullable()->comment("product's stock keeping unit");
            $table->string('discount')->nullable();
            $table->string('units')->nullable();
            $table->string('tax_type_1')->nullable();  // TaxRate 
            $table->string('tax_type_2')->nullable();  // TaxRate 
            $table->string('tax_type_3')->nullable();  // TaxRate 
            $table->integer('product_group_id')->nullable();
            $table->enum('status',['active', 'inactive'])->default('active');
            $table->bigInteger('created_by_id')->nullable();
            $table->timestamps();
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
