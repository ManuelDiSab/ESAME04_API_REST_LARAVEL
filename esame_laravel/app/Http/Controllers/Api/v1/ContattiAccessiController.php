<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\contattiAccessi;
use Illuminate\Http\Request;

class ContattiAccessiController extends Controller
{
    protected static function newRecord($idUser, $autenticato)
    {
        $new = contattiAccessi::create([
            "idUser"=>$idUser,
            "autenticato" => $autenticato,
            "ip"=>request()->ip()
        ]);
        return $new;
    }
}
