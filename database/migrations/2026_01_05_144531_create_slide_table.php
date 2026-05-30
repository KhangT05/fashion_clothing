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
        Schema::create('slide', function (Blueprint $table) {
            $table->id();
            $table->string('tieude');
            $table->string('hinhthunho')->nullable();
            $table->integer('stt')->default(1);
            $table->string('linklienket')->nullable();
            $table->tinyInteger('trangthai')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slide');
    }
};
