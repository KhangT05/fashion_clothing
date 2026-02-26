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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('phone', 10)->unique();
            $table->string('email')->unique();
            $table->string('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('copyright')->nullable();
            $table->tinyInteger('publish')->default(2);
            $table->text('sales_info')->nullable();
            $table->text('sales_services')->nullable();
            $table->text('shipping_policy')->nullable();
            $table->text('about_us')->nullable();
            $table->text('return_policy')->nullable();
            $table->text('warranty_policy')->nullable();
            $table->text('privacy_policy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
