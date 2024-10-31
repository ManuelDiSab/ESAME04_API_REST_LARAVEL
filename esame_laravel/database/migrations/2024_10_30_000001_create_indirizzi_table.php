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
            Schema::create('indirizzi', function (Blueprint $table) {
                $table->id("idIndirizzo");
                $table->unsignedBigInteger("idUser")->unsigned();
                $table->unsignedBigInteger("idTipologiaIndirizzo")->unsigned();
                $table->unsignedBigInteger("idNazione")->unsigned();
                $table->unsignedBigInteger("idComune")->unsigned();
                $table->string('cap', 15)->nullable();
                $table->string('indirizzo', 255);
                $table->string('civico', 15)->nullable();
                $table->string('località', 255)->nullable();
                $table->softDeletes();
                $table->timestamps();
                
                $table->foreign('idTipologiaIndirizzo')->references('idTipologiaIndirizzo')->on('tipologia_indirizzi');
                $table->foreign('idNazione')->references('idNazione')->on('nazioni');
                $table->foreign('idUser')->references('idUser')->on('users');
                $table->foreign('idComune')->references('idComune')->on('comuni');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indirizzi');
    }
};
