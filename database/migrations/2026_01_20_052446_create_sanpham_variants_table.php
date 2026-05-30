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
        Schema::create('sanpham_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sanpham_id')->nullable()->constrained('sanpham')->onDelete('set null');
            $table->integer('soluong')->default(0);
            $table->decimal('giaban', 15, 2)->nullable();
            $table->string('sku', 50)->unique();
            $table->json('album')->nullable();
            $table->tinyInteger('trangthai')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanpham_variants');
    }
};
