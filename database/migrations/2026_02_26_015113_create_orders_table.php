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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20);
            $table->text('address');
            $table->string('publish')->default('pending');
            $table->string('payment_methoad')->default('cod');
            // Trạng thái thanh toán
            $table->string('payment_status')->default('unpaid');

            $table->text('note')->nullable();
            $table->decimal('total_amount', 15, 2);
            // tổng đơn hàng
            $table->string('province_code', 2)->nullable();
            $table->string('ward_code', 6)->nullable();
            $table->foreign('province_code')->references('province_code')->on('provinces')->onDelete('set null');
            $table->foreign('ward_code')->references('ward_code')->on('wards')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
