<?php

use App\Http\Controllers\Api\v1\AbbonamentiController;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ComuniController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\CreditiController;
use App\Http\Controllers\api\v1\episodiController;
use App\Http\Controllers\Api\v1\FilmController;
use App\Http\Controllers\Api\v1\GeneriController;
use App\Http\Controllers\Api\v1\IndirizziController;
use App\Http\Controllers\Api\v1\LingueController;
use App\Http\Controllers\api\v1\nazioniController;
use App\Http\Controllers\api\v1\serieTvController;
use App\Http\Controllers\Api\v1\TipologiaIndirizziController;
use App\Http\Controllers\Api\v1\TraduzioniController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Definire una costante per le versione delle api
if(!defined("_VERS")){
    define('_VERS', 'v1');
}

//Api protette dall'autenticazione 
Route::group(['auth:api'], function ($router){

    Route::post(_VERS . '/logout', [AuthController::class, 'logout']);// log-out
    Route::post(_VERS . '/refresh', [AuthController::class, 'refresh']);// refresh del token
    Route::post(_VERS . '/login', [AuthController::class, 'login']);
    Route::post(_VERS . '/register', [AuthController::class, 'register']);


    //---------------------------------------------  SOLO ADMIN  -------------------------------------------------------
    #################################################################################################################################
        //Route per la gestione utenti
        Route::get(_VERS . '/profili', [UserController::class, 'indexAdmin']);
        Route::get(_VERS . '/profili/{idUser}', [UserController::class, 'showAdmin']);
        Route::put(_VERS . '/profili', [UserController::class, 'updateAdmin']);
        Route::delete(_VERS . '/profili/{idUser}', [UserController::class, 'destroyAdmin']);

        //Route per abbonamenti e crediti
        route::post(_VERS . '/abbonamenti', [AbbonamentiController::class, 'store']);
        route::put(_VERS . '/abbonamenti/{id}', [AbbonamentiController::class, 'update']);
        route::delete(_VERS . '/abbonamenti/{id}', [AbbonamentiController::class, 'destroy']);
        Route::get(_VERS . '/portafoglio/{id}', [CreditiController::class, 'portafoglioAdmin']);

        //Route per indirizzi e tipologie indirizzi
        Route::post(_VERS . '/Tipo-inidirizzo', [TipologiaIndirizziController::class, 'store']);
        Route::put(_VERS . '/Tipo-inidirizzo/{idTipo}', [TipologiaIndirizziController::class, 'update']);
        Route::delete(_VERS . '/Tipo-inidirizzo/{idTipo}', [TipologiaIndirizziController::class, 'destroy']);
        Route::get(_VERS . '/indirizzi',[IndirizziController::class, 'index']);
        Route::get(_VERS . '/indirizzi/{idIndirizzo}',[IndirizziController::class, 'show']);


        //Route per i comuni
        Route::put(_VERS . '/comuni/{idComune}', [ComuniController::class, 'update']);
        Route::delete(_VERS . '/comuni/{idComune}', [ComuniController::class, 'destroy']);

        //Route Api per le lingue e le traduzioni
        Route::put(_VERS . '/lingue/{idLingua}', [LingueController::class, 'update']);
        Route::post(_VERS . '/lingue', [LingueController::class, 'store']);
        Route::delete(_VERS . '/lingue/{idLingua}', [LingueController::class, 'destroy']);
        Route::put(_VERS . '/traduzioni/{idTrad}', [TraduzioniController::class. 'update']);
        Route::post(_VERS . '/traduzioni/{idTrad}', [TraduzioniController::class. 'store']);
        Route::delete(_VERS . '/traduzioni/{idTrad}', [TraduzioniController::class. 'destroy']);

        // Route per la gestione dei film e delle serie tv
        Route::post(_VERS . '/genere',[GeneriController::class, 'store']);
        Route::post(_VERS . '/film', [FilmController::class, 'store']);
        Route::put(_VERS . '/film/{idFilm}', [FilmController::class, 'update']);
        Route::delete(_VERS . '/film/{idFilm}', [FilmController::class, 'destroy']);
        Route::post(_VERS . '/serie', [serieTvController::class, 'store']);
        Route::put(_VERS . '/serie/{idSerie}', [serieTvController::class, 'update']);
        Route::delete(_VERS . '/serie/{idSerie}', [serieTvController::class, 'destroy']);
        Route::post(_VERS . '/episodi',[episodiController::class, 'store']);
        Route::put(_VERS . '/episodi/{idEpisodio}',[episodiController::class, 'update']);
        Route::delete(_VERS . '/episodi/{idEpisodio}',[episodiController::class, 'destroy']);

        




    //---------------------------------------------  USERS & ADMIN  -------------------------------------------------------
    #################################################################################################################################

    // Route accessibili da user e amministratori
        //Route per i profili
        Route::put(_VERS . '/mio-profilo', [UserController::class, 'update']);
        Route::delete(_VERS . '/mio-profilo', [UserController::class, 'destroy']);
        Route::get(_VERS . '/mio-profilo', [AuthController::class, 'userProfile']);

        //Route per crediti e abbonamenti
        Route::get(_VERS . '/abbonamenti', [AbbonamentiController::class, 'index']);
        Route::get(_VERS . '/abbonamenti/{id}', [AbbonamentiController::class, 'show']);
        Route::get(_VERS . '/portafoglio', [CreditiController::class, 'portafoglio']);
        Route::post(_VERS . '/aggiungi-crediti/{int}',[CreditiController::class, 'AggiungiFondi']);
        Route::post(_VERS . '/negozio/{idAbbonamento}', [CreditiController::class, 'negozio']);

        //Api per indirizzi e tipologia indirizzi
        Route::get(_VERS . '/Tipo-inidirizzo', [TipologiaIndirizziController::class, 'index']);
        Route::get(_VERS . '/Tipo-inidirizzo/{idTipo}', [TipologiaIndirizziController::class, 'show']);
        Route::put(_VERS . '/indirizzi/{idIndirizzo}',[IndirizziController::class, 'update']);
        Route::post(_VERS . '/indirizzi',[IndirizziController::class, 'store']);
        Route::delete(_VERS . '/indirizzi/{idIndirizzo}', [IndirizziController::class, 'destroy']);

        //Route per i comuni e le nazioni
        Route::get(_VERS . '/comuni', [ComuniController::class, 'index']);
        Route::get(_VERS . '/comuni/{comune}', [ComuniController::class, 'show']);
        Route::get(_VERS . '/nazioni',[nazioniController::class, 'index']);
        Route::get(_VERS . '/nazioni/{id}',[nazioniController::class, 'show']);

        //Route Api per le lingue e le traduzioni
        Route::get(_VERS . '/lingue', [LingueController::class, 'index']);
        Route::get(_VERS . '/lingue/{idLingua}', [LingueController::class, 'show']);
        Route::get(_VERS . '/traduzioni', [TraduzioniController::class. 'index']);
        Route::get(_VERS . '/traduzioni/{idTrad}', [TraduzioniController::class. 'show']);


        //Route per la gestione dei film e serie tv
        Route::get(_VERS . '/film', [FilmController::class, 'index']);
        Route::get(_VERS . '/film/{idFilm}', [FilmController::class, 'show']);
        Route::get(_VERS . '/serie', [serieTvController::class, 'index']);
        Route::get(_VERS . '/serie/{idSerie}', [serieTvController::class, 'show']);
        Route::get(_VERS . '/episodi',[episodiController::class, 'index']);
        Route::get(_VERS . '/episodi/{idEpisodio}',[episodiController::class, 'show']);


});

