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
        Schema::create('dn_featured_contents', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('featured_section_id')->nullable();
            $table->integer('featured_content_id')->unique();
            $table->unsignedBigInteger('store_id')->nullable();

            $table->string('title');
            $table->string('thumbnail')->nullable();
            $table->json('images')->nullable();
            $table->text('description')->nullable();

            $table->enum('status', ['draft', 'published', 'private'])->default('draft');

            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('featured_section_id')->references('id')->on('dn_featured_sections')->onDelete('set null');
            $table->foreign('store_id')->references('id')->on('dn_stores')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dn_featured_contents');
    }
};
