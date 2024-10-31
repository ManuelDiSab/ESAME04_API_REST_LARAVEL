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
        Schema::create('film', function (Blueprint $table) {
            $table->id('idFilm');
            $table->unsignedBigInteger('idGenere')->unsigned();
            $table->string('titolo',45);
            $table->string('trama', 255)->nullable();
            $table->string('regista',45);
            $table->string('durata',10);
            $table->string('anno',4);
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
        Schema::dropIfExists('film');
    }
};
