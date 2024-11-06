<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add category_id column
            $table->foreignId('category_id')->constrained();

            // Make sub_category_id nullable
            $table->foreignId('sub_category_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop category_id column
            $table->dropColumn('category_id');

            // Make sub_category_id non-nullable
            $table->foreignId('sub_category_id')->nullable(false)->change();
        });
    }
};
