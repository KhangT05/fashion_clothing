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
        Schema::create('ct_hoadon', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            //tổng từng sản phẩm
            $table->decimal('thanhtien', 15, 2);
            $table->decimal('dongia', 15, 2);
            $table->integer('soluong');
            $table->tinyInteger('trangthai')->default(1);
            $table->string('sku')->nullable();
            $table->decimal('discount', 15, 2);
            $table->foreignId('hoadon_id')->nullable()->constrained('hoadon')->onDelete('set null');
            $table->foreignId('sanpham_id')->nullable()->constrained('sanpham')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_hoadon');
    }
};
