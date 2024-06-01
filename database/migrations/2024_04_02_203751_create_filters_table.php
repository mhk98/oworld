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
        Schema::create('dn_filters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->boolean('pre_order')->default(false);
            $table->boolean('in_stock')->default(false);
            $table->boolean('organic')->default(false);
            $table->boolean('home_delivery')->default(false);
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('dn_stores');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dn_filters');
    }
};
