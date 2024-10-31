<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\episodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class episodiController extends Controller
{
     /**
     * Display a listing of the resource.
     * 
     * @return JsonResource
     */
    public function index(){
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                return episodi::all();
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function show($idEpisodio)
    {
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $episodio = episodi::findOrFail($idEpisodio);
                return response()->json($episodio, 200);
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
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){

                $request->validate([
                    'idSerie'=>'required|integer',
                    'titolo'=>'required|string|max:45',
                    'durata'=>'string|max:255',
                    'numero'=>'required|integer',
                    'stagione'=>'required|integer'
                ]);
                $resource = episodi::create([
                    'idSerie'=>$request->idSerie,
                    'titolo'=>$request->titolo,
                    'durata'=>$request->durata,
                    'numero'=>$request->numero,
                    'stagione'=>$request->stagione
                ]);

                return response()->json($resource, 201);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @param $idSerie 
     * @return JsonResource
     */
    public function update(Request $request, $idEpisodio){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $request->validate([
                    'idSerie'=>'required|integer',
                    'titolo'=>'required|string|max:45',
                    'durata'=>'string|max:255',
                    'numero'=>'required|integer',
                    'stagione'=>'required|integer'
                ]);
                $episodio = episodi::findOrFail($idEpisodio);
                $episodio->update($request->all());
                return response()->json([
                    "message"=>"Episodio modificato correttamente",
                    "indirizzo"=> $episodio],200);     
            }
        }
    }

    /**
     * Elimina una risorsa
     * 
     * @param integer $idSerie 
     * @return 
     */
    public function destroy($idEpisodio){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $Episodio = episodi::findOrFail($idEpisodio);
                $Episodio->delete();

                return response()->json(['message'=>'Episodio eliminato con successo'],204);
            }
        }
    }
}
