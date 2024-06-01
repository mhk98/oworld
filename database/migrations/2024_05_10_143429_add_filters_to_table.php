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
        Schema::table('dn_filters', function (Blueprint $table) {
            $table->boolean('men')->default(false);
            $table->boolean('women')->default(false);
            $table->boolean('imported')->default(false);
            $table->boolean('local')->default(false);
            $table->boolean('cuisine')->default(false);
            $table->boolean('indoor')->default(false);
            $table->boolean('outdoor')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       //
    }
};
