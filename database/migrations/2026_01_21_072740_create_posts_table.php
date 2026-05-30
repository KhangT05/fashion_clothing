<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');            // Tiêu đề
            $table->string('slug')->unique();   // Đường dẫn (vd: bai-viet-1)
            $table->text('summary')->nullable();// Tóm tắt ngắn
            $table->longText('content');        // Nội dung chính
            $table->string('image')->nullable();// Ảnh đại diện
            $table->boolean('is_active')->default(true); // 1 = Hiện, 0 = Ẩn
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};