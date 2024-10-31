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
        Schema::create('comuni', function (Blueprint $table) {
            $table->id('idComune');
            $table->string("nome",45);
            $table->string("regione", 45);
            $table->string('metropolitana', 45)->nullable();
            $table->string('provincia', 45);
            $table->string('siglaAuto', 2);
            $table->string('codCat',4);
            $table->string('capoluogo',50)->nullable();
            $table->string('multicap',3)->nullable();
            $table->string('cap',10);
            $table->string('capFine',10)->nullable();
            $table->string('capInizio',10)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comuni');
    }
};
