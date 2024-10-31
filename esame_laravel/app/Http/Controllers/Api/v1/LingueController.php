<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lingue;
use Illuminate\Support\Facades\Gate;

class LingueController extends Controller
{

    /**
     * Funzione per prendere tutte le risorse
     * 
     */
    public function index()
    {
        if (Gate::allows('attivo')) {
            if (Gate::allows('user')) {
                return response()->json(Lingue::all([
                    'idLingua',
                    'nome',
                    'abbreviazione'
                ]));
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function show($idLingua){
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $lingua = Lingue::findOrFail($idLingua);
                return response()->json($lingua);
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
                    'abbreviazione' => 'required|max:3'
                ]);
        
                $lingua = Lingue::create([
                    'nome' => $request->nome,
                    'abbreviazione' => $request->abbreviazione
                ]);
                
                return response()->json($lingua, 201);
            }
        }
    }

    /**
     * 
     * 
     */
    public function update(Request $request, $idLingua){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $lingua = Lingue::find($idLingua);

                if($lingua)
                {
                    $request->validate([
                        'nome'=> 'required|string|max:45',
                         'abbreviazione' => 'required|max:3'
                    ]);
        
                    $lingua->update($request->only(['nome','abbreviazione']));
                    return response()->json($lingua,200);
                }else{
                    return response()->json(['message' => 'Genere non trovato'], 404);
                }
        
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function destroy($idLingua){
        if(Gate::allows('attivo')) {
            if(Gate::allows('admin')){
                $lingua = Lingue::findOrFail($idLingua);
                $lingua->delete();

                return response()->json(204, "Lingua eliminata con successo ");     
            }
        }
    }
}
