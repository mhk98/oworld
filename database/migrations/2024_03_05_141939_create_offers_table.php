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
        Schema::create('dn_offers', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->text('description')->nullable();
            $table->timestamp('offer_expiration')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('store_id');
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('dn_stores')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('category_id')->references('id')->on('dn_categories')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dn_offers');
    }
};
