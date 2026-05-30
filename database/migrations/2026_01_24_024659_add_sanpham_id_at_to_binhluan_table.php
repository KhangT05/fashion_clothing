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
        Schema::table('binhluan', function (Blueprint $table) {
            $table->tinyInteger('danhgia')->default(0);
            $table->foreignId('sanpham_id')->nullable()->constrained('sanpham')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('binhluan', function (Blueprint $table) {
            //
        });
    }
};
