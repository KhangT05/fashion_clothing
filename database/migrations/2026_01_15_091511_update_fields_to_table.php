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
        Schema::table('settings', function (Blueprint $table) {
            $table->text('sales_info')->nullable();
            $table->text('sales_services')->nullable();
            $table->text('shipping_policy')->nullable();
            $table->text('about_us')->nullable();
            $table->text('return_policy')->nullable();
            $table->text('warranty_policy')->nullable();
            $table->text('privacy_policy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('table', function (Blueprint $table) {
            // $table->dropColumn('sales_info');
            // $table->dropColumn('sales_services');
            // $table->dropColumn('shipping_policy');
            // $table->dropColumn('return_policy');
            // $table->dropColumn('about_us');
            // $table->dropColumn('warranty_policy');
            // $table->dropColumn('privacy_policy');
        });
    }
};
