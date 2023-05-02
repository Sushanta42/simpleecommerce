<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->foreignId('sub_category_id')->constrained();
            $table->string('image');
            $table->double('price');
            $table->double('discount_percent')->default(0);
            $table->double('sale_price');
            $table->enum('availability', ['many_in_stock', 'less_in_stock', 'out_of_stock'])->default('many_in_stock');
            $table->enum('label', ['hot', 'sale', 'new'])->default('new');
            $table->integer('views')->default(0);
            $table->string('slug');
            $table->foreignId('vendor_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
