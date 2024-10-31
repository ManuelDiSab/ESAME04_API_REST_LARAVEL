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
        Schema::create('abbonamenti', function (Blueprint $table) {
            $table->id('idAbbonamento');
            $table->string('nome');
            $table->integer('costo');
            $table->timestamps();
            $table->softDeletes();
        });

        //modifica dello schema della tabella 'users' 
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger("idAbbonamento")->unsigned()->default(1)->after('idRuolo');//uso ->after() per dirgli dove posizionare la nuova colonna    
            $table->foreign("idAbbonamento")->references("idAbbonamento")->on("abbonamenti");
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abbonamenti');
    }
};
