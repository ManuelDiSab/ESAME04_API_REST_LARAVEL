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
        Schema::create('episodi', function (Blueprint $table) {
            $table->id('idEpisodio');
            $table->unsignedBigInteger('idSerie')->unsigned();
            $table->string('durata',10);
            $table->integer('numero')->unsigned();
            $table->string('titolo',50);
            $table->tinyInteger('stagione');
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('idSerie')->references('idSerie')->on('serie_tv');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodi');
    }
};
