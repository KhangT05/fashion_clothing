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
        //bảng giá trị thuộc tính
        Schema::create('bienthe_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bienthe_id')->nullable()->constrained('bienthe')->onDelete('set null');
            $table->string('value');
            $table->string('code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bienthe_values');
    }
};
