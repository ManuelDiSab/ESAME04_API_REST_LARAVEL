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
        Schema::create('contatti_accessi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("idUser")->unsigned();
            $table->unsignedBigInteger("autenticato")->unsigned();
            $table->string("ip", 15);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("idUser")->references("idUser")->on("users");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contatti_accessi');
    }
};
