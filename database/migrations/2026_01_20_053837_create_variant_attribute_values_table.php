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
        Schema::create('variant_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_id')->constrained('sanpham_variants')->cascadeOnDelete();
            $table->foreignId('bienthe_value_id')->constrained('bienthe_values')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['variant_id', 'bienthe_value_id']);
        });
    }
    // set null - set về null khi xóa cha
    // cascade - xóa luôn con khi xóa cha
    // restrict - không cho xóa khi còn con
    // no action giống restrict
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_attribute_values');
    }
};
