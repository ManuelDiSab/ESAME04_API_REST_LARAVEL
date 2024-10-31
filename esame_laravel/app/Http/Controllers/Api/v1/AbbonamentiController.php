<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\abbonamenti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\Events\GateEvaluated;

class AbbonamentiController extends Controller
{
    //Funzione per visualizzare tutti gli abbonamenti
    public function index()
    {
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                return abbonamenti::all(['idAbbonamento', 'nome', 'costo']);
            }
        }
    }   


    public function show($id)
    {
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                $abbonamento =  abbonamenti::findOrFail($id);
                return response()->json([
                    "nome"=> $abbonamento->nome,
                    "costo"=> $abbonamento->costo
                ], 200);
            }
        }
    }  
    public function store(Request $request){
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $request->validate([
                    'nome'=> 'required|string|max:45',
                    'costo' => 'required|integer'
                ]);
        
                $abb = abbonamenti::create([
                    'nome' => $request->nome,
                    'costo' => $request->costo
                ]);
        
                return response()->json([
                    'messaggio'=>'Nuovo abbonamento creato',
                    'abbonamento' => $abb
                ], 201);
            }
        }
    } 

    /**
     * 
     * Funzione per modificare la risorsa
     */
    public function update(Request $request, $id){
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                
            $abb = abbonamenti::find($id);

            if($abb)
            {
                $request->validate([
                    'nome'=> 'required|string|max:45',
                    'costo' => 'required|integer'
                ]);

                $abb->update($request->only(['nome','costo']));
                return response()->json($abb,200);
            }else{
                return response()->json(['message' => 'abbonamento non trovato'], 404);
            }
            }
        }
    }
    
    /**
     * Funzione per eliminare la risorsa
     * 
     */
    public function destroy($id){
        if(Gate::allows("admin")){
            if(Gate::allows("attivo")){

                $resource = abbonamenti::findOrFail($id);
                $resource->delete();

                return response()->json(["messagge" => "Abbonamento eliminato correttamente"], 204);
            }
        }
    }
}
