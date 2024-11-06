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
        Schema::create('billbooks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('municipality');
            $table->string('address');
            $table->string('image_citizen')->nullable();
            $table->string('image_front')->nullable();
            $table->string('image')->nullable();
            $table->enum('vehicle_type', ['2_wheeler', '4_wheeler', 'others']);
            $table->enum('status', ['on_review', 'completed', 'cancelled'])->default('on_review');
            $table->date('renewal_date')->nullable();
            $table->enum('billbook_status', ['active', 'notice_time', 'expiry'])->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billbooks');
    }
};
