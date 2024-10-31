<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Traduzioni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TraduzioniController extends Controller
{
    
    /**
     * Funzione per prendere tutte le risorse
     * 
     */
    public function index()
    {
        if (Gate::allows('attivo')) {
            if (Gate::allows('user')) {
                return response()->json(Traduzioni::all([
                    'idLingua',
                    'chiave',
                    'valore'
                ]));
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function show($idTrad){
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $traduzione = Traduzioni::findOrFail($idTrad);
                return response()->json($traduzione);
            }
        }
    }

     /**
     * 
     * 
     */
    public function store(Request $request)
    {
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $request->validate([
                    'nome'=> 'required|string|max:45',
                    'chiave' => 'required|max:45',
                    'valore' => 'required|max:45',
                ]);
        
                $traduzione = Traduzioni::create([
                    'nome' => $request->nome,
                    'chiave' => $request->chiave,
                    'valore'=> $request->valore
                ]);
        
                return response()->json($traduzione, 201);
            }
        }
    }

     /**
     * 
     * 
     */
    public function update(Request $request, $idTrad){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $traduzione = Traduzioni::find($idTrad);

                if($traduzione)
                {
                    $request->validate([
                    'nome'=> 'required|string|max:45',
                    'chiave' => 'required|max:45',
                    'valore' => 'required|max:45',
                    ]);
        
                    $traduzione->update($request->only(['nome','chiave','valore']));
                    return response()->json($traduzione,200);
                }else{
                    return response()->json(['message' => 'traduzione non trovata'], 404);
                }
            }
        }
    }

        /**
     * 
     * 
     * 
     */
    public function destroy($idTrad){
        if(Gate::allows('attivo')) {
            if(Gate::allows('admin')){
                $Traduzione = Traduzioni::findOrFail($idTrad);
                $Traduzione->delete();

                return response()->json(204, "Traduzione eliminata con successo ");     
            }
        }
    }

}
