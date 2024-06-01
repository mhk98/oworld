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
        Schema::create('dn_category_serials', function (Blueprint $table) {
            $table->id();
            $table->string('section');
            $table->unsignedBigInteger('category_id');
            $table->integer('serial');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('dn_categories')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dn_category_serials');
    }
};
