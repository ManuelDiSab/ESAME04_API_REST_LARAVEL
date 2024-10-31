<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\generi;
use Illuminate\Support\Facades\Gate;

class GeneriController extends Controller
{
    /**
     * Funzione per prendere tutte le risorse
     * 
     */
    public function index(){
    if(Gate::allows('user')){
            return response()->json(generi::all(),200);
        }
    }

    /**
     * 
     * 
     */
    public function show($idGenere){
        $genere = generi::find($idGenere);

        if($genere) {
            return response()->json($genere, 200);
        }else{
            return response()->json(['message' => 'Genere non trovato'], 404);
        }

    }


    /**
     * 
     * 
     */
    public function store(Request $request){
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $request->validate([
                    'nome'=> 'required|string|max:45'
                ]);
        
                $genere = generi::create([
                    'nome' => $request->nome
                ]);
        
                return response()->json($genere, 201);
            }
        }
    }


    /**
     * 
     * 
     */
    public function update(Request $request, $idGenere){

        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $genere = generi::find($idGenere);

                if($genere)
                {
                    $request->validate([
                        'nome'=> 'required|string|max:45'
                    ]);
        
                    $genere->update($request->only(['nome']));
                    return response()->json($genere,200);
                }else{
                    return response()->json(['message' => 'Genere non trovato'], 404);
                }
        
            }
        }
    }


    /**
     * 
     * 
     */
    public function destroy($idGenere){
     
        $genere = generi::find($idGenere);

        if($genere){
            $genere->delete();
            return response()->json(["message"=> 'genere cancellato correttamente'],200);
        }else{
            return response()->json(['message' => 'Genere non trovato'], 404);
        }
    }

}

