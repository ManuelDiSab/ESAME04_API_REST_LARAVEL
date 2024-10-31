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
        Schema::create('serie_tv', function (Blueprint $table) {
            $table->id('idSerie');
            $table->unsignedBigInteger('idGenere')->unsigned();
            $table->string('titolo',50);
            $table->string('trama',255)->nullable();
            $table->tinyInteger('n_stagioni');
            $table->string('anno_inizio',4);
            $table->string('anno_fine',10)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('idGenere')->references('idGenere')->on('generi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serie_tv');
    }
};
