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
        Schema::create('sanpham', function (Blueprint $table) {
            $table->id();
            $table->string('tensp');
            $table->string('hinhnen')->nullable();
            $table->decimal('giaban', 15, 2);
            $table->decimal('discount', 15, 2)->default(0);
            $table->integer('view')->default(0);
            $table->string('slug');
            $table->string('mota')->nullable();
            $table->tinyInteger('trangthai')->default(1);
            $table->foreignId('thuonghieu_id')->nullable()->constrained('thuonghieu')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('sanpham');
    }
};
