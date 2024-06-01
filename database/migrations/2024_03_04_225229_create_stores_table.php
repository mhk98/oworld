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
        Schema::create('dn_stores', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('profile_picture')->nullable();
            $table->string('cover_picture')->nullable();

            $table->string('store_type');
            $table->unsignedBigInteger('category_id')->nullable();

            $table->text('intro')->nullable();
            $table->string('address')->nullable();
            $table->string('area')->nullable();

            $table->string('phone')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('website')->nullable();

            $table->json('opening_hours')->nullable();

            $table->string('status');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('dn_categories')->onDelete('set null')
            ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dn_stores');
    }
};
