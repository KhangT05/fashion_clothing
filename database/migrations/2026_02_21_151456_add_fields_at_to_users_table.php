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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 10)->nullable()->after('email');
            $table->tinyInteger('gender')->default(1)->after('phone');
            $table->date('birthday')->nullable()->after('gender');
            $table->text('avatar')->nullable()->after('birthday');
            $table->tinyInteger('publish')->default(2)->after('avatar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
