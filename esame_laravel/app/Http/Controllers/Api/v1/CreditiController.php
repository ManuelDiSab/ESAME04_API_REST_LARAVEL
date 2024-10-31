<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Crediti;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CreditiController extends Controller
{
    /**
     * Visualizzare il credito disponibile
     */
    public function portafoglio()
    {
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){

                $user = Auth::user();
                $id = $user->idUser;

                $portafoglio =DB::table('crediti')
                ->where('idUser',$id)
                ->firstOrFail('credito');
                return response()->json($portafoglio, 200);
            }
        }
    }

    /**
     * VIsualizzare il credito dello user desiderato (solo admin)
     */
    public function portafoglioAdmin( $idUser)
    {
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $portafoglio =DB::table('crediti')
                ->where('idUser',$idUser)
                ->firstOrFail('credito');
                return response()->json($portafoglio, 200);
            }
        }
    }
    public function AggiungiFondi($int){
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                $user = Auth::user();
                $id = $user->idUser;

                $portafoglio =DB::table('crediti')
                ->where('idUser',$id)
                ->firstOrFail();

                $residuo = $portafoglio->credito;
                $newCredit = $residuo + $int;
                
                return ["message" => "Sul tuo portafoglio sono disponibili ora
                 " . $newCredit . "crediti"];
            }
        }
    }

    // public function AggiungiFondiAdmin($idUser, Request $request)
    // {
    //     $portafoglio =DB::table('crediti')
    //             ->where('idUser',$idUser)
    //             ->firstOrFail();
        
    //     $request->validate([
    //         'credito' => 'required|integer',
    //     ]);


    //     $fondi = $portafoglio->credito;
    //     $newCredit = $fondi + $request;

    //     return ["message" => "Sul portafoglio dell'utente con id:" .$idUser ."ora
    //     ci sono" . $newCredit . "crediti"];
    // }

    public function negozio($idAbbonamento)
    {
        $user = Auth::user();
        $id = $user->idUser;

        $portafoglio =DB::table('crediti')
        ->where('idUser',$id)
        ->firstOrFail();

        $C_residuo = $portafoglio->credito;

        $abb = DB::table('abbonamenti')
        ->where('idAbbonamento',$idAbbonamento)
        ->firstOrFail();
        $costo = $abb->costo;
        if($user->idAbbonamento == $idAbbonamento){
            return ["message" => "abbonamento già acquisito"];
        }else{
            if($C_residuo < $costo){
                return "Credito non sufficente";
            }else{
            $NuovoResiduo = $C_residuo - $costo;
            DB::table('users')
            ->where('idUSer',$id)
            ->update(["idAbbonamento"=>$idAbbonamento]);

            DB::table('crediti')
            ->where('idUser',$id)
            ->update(["credito"=>$NuovoResiduo]);
            return [
                "message" => "Abbonamento acquistato con successo",
                "credito" => "Il tuo credito residuo ammonta a " .$NuovoResiduo
            ];
            }
        }
    }
}
