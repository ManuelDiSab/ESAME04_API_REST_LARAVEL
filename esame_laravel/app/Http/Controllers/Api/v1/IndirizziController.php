<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Indirizzo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class IndirizziController extends Controller
{
    /**
     * Display a listing of the resource.
     *  
     * @return JsonResource
     */
    public function index()
    {
        if(Gate::allows('admin')){
            if(Gate::allows('attivo'))
            {
                return Indirizzo::all();
            }
        }
    }

    public function show($idIndirizzo){
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $resource = Indirizzo::findOrFail($idIndirizzo);

                    return response()->json([ 
                    "idUser"=>$resource->idUser,
                    "idTipologiaIndirizzo"=>$resource->idTipologiaIndirizzo,
                    "idNazione"=>$resource->idNazione,
                    "idComune"=>$resource->idComune,
                    "indirizzo"=>$resource->indirizzo,
                    "civico"=>$resource->civico,
                    "cap"=>$resource->cap,
                    "località"=>$resource->località
                        ], 200);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return JsonResource
     */
    public function store(Request $request){
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                $user = Auth::user();
                $id = $user->idUser;

                $request->validate([
                    "idTipologiaIndirizzo"=>'required|integer',
                    "idNazione"=>'required|integer',
                    'idComune'=>'required|integer',
                    "indirizzo"=>'required|string|max:45',
                    "civico"=>'required|string|max:10',
                    "cap"=>'string|max:10',
                    "località"=>'string|max:10'
                ]); 
                $indirizzo = Indirizzo::create([
                    "idUser"=>$id,
                    "idTipologiaIndirizzo"=>$request->idTipologiaIndirizzo,
                    "idNazione"=>$request->idNazione,
                    "idComune"=>$request->idComune,
                    "indirizzo"=>$request->indirizzo,
                    "civico"=>$request->civico,
                    "cap"=>$request->cap,
                    "località"=>$request->località
                ]);

                return response()->json($indirizzo, 201);
            }
        }
    }
    /**
     * Update the specified resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @param $idIndirizzo 
     * @return JsonResource
     */
    public function update(Request $request, $idIndirizzo){
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $user = Auth::user();
                $id = $user->idUser;

                $request->validate([
                    "idTipologiaIndirizzo"=>'|integer',
                    "idNazione"=>'|integer',
                    'idComune'=>'|integer',
                    "indirizzo"=>'|string|max:45',
                    "civico"=>'|string|max:10',
                    "cap"=>'|string|max:10',
                    "località"=>'|string|max:10'
                ]);
                $indirizzo = Indirizzo::findOrFail($idIndirizzo);
                $verifica = $indirizzo->idUser;
                if($id === $verifica){
                    $indirizzo->update($request->all());
                    return response()->json([
                        "message"=>"Indirizzo modificato correttamente",
                        "indirizzo"=> $indirizzo
                    ],200);
                }                
            }
        }
    }


    /**
     * 
     * 
     */
    public function destroy($idIndirizzo)
    {
        if(Gate::allows('user')){
            if(Gate::allows('admin')){
                $user = Auth::user();
                $id = $user->idUser;
                $indirizzo = Indirizzo::findOrFail($idIndirizzo);
                $verifica = $indirizzo->idUser;

                if($id === $verifica){
                    $indirizzo->delete();
                    return response()->json(["messagge"=>"Indirizzo eliminato con successso"], 204);
                }{
                    return "Non puoi effettuare questa azione";
                }
            }
        }
    }
}
