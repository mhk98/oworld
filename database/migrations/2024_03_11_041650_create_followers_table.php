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
        Schema::create('dn_followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        
            $table->foreign('store_id')->references('id')->on('dn_stores')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('user_id')->references('id')->on('dn_users')->onDelete('cascade')->onUpdate('no action');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dn_followers');
    }
};
