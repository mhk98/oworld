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
        Schema::create('dn_featured_stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('featured_section_id');
            $table->unsignedBigInteger('store_id');
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('featured_section_id')->references('id')->on('dn_featured_sections')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('dn_stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dn_featured_stores');
    }
};
