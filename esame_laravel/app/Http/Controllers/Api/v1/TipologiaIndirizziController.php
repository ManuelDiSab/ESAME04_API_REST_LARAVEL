<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TipologiaIndirizzi;
use Illuminate\Support\Facades\Gate;

class TipologiaIndirizziController extends Controller
{
    public function index()
    {
        return TipologiaIndirizzi::all([
            'nome', 'idTipologiaIndirizzo'
        ]);
    }

    public function show($idTipo){
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                $tipo = TipologiaIndirizzi::find($idTipo);

                if($tipo) {
                    return response()->json($tipo, 200);
                }else{
                    return response()->json(['message' => 'Tipologia indirizzo non trovato non trovato'], 404);
                }
            }
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('admin')) {
            if (Gate::allows('attivo')) {
                $request->validate([
                    'nome' => 'required|string|max:45'
                ]);

                $tipo = TipologiaIndirizzi::create([
                    'nome' => $request->nome
                ]);

                return response()->json($tipo, 201);
            }
        }
    }

    public function update(Request $request, $idTipo)
    {
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $tipo = TipologiaIndirizzi::findOrFail($idTipo);

                if($tipo)
                {
                    $request->validate([
                        'nome'=> 'required|string|max:45',
                        
                    ]);

                    $tipo->update($request->only(['nome']));
                    return response()->json($tipo,200);
                }else{
                    return response()->json(['message' => 'Tipologia indirizzo non trovato '], 404);
                }
            }
        }
    }

    /** Funzione per eliminare la risorsa
     * 
     */
    public function destroy($idTipo)
    {
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $tipo = TipologiaIndirizzi::find($idTipo);

                if($tipo){
                    $tipo->delete();
                    return response()->json(["message"=> 'tipologia indirizzo cancellato correttamente'],200);
                }else{
                    return response()->json(['message' => 'tipologia indirizzo non trovato'], 404);
                }
            }
        }
    }
}
