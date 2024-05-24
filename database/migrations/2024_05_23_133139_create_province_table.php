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
        Schema::create('province', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->char('name', 100);
            $table->char('alt_name', 100);
            $table->char('longitude', 100)->nullable();
            $table->char('latitude', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('province');
    }
};
