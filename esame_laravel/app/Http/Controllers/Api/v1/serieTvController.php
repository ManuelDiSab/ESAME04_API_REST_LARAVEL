<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\serieTv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class serieTvController extends Controller
{
 /**
     * Display a listing of the resource.
     * 
     * @return JsonResource
     */
    public function index(){
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                return serieTv::all();
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function show($idSerie)
    {
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $film = serieTv::findOrFail($idSerie);
                return response()->json($film, 200);
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
                    'idGenere'=>'required|integer',
                    'titolo'=>'required|string|max:45',
                    'trama'=>'string|max:255',
                    'n_stagioni'=>'required|integer',
                    'anno_inizio'=>'required|string|max:4',
                    'anno_fine'=>'string|max:10'
                ]);
                $resource = serieTv::create([
                    'idGenere'=>$request->idGenere,
                    'titolo'=>$request->titolo,
                    'trama'=>$request->trama,
                    'n_stagioni'=>$request->n_stagioni,
                    'anno_inizio'=>$request->anno_inizio,
                    'anno_fine'=>$request->anno_fine
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
    public function update(Request $request, $idSerie){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $request->validate([
                    'idGenere'=>'required|integer',
                    'titolo'=>'required|string|max:45',
                    'trama'=>'string|max:255',
                    'n_stagioni'=>'required|integer',
                    'anno_inizio'=>'required|string|max:4',
                    'anno_fine'=>'string|max:10'
                ]);
                $serie = serieTv::findOrFail($idSerie);
                $serie->update($request->all());
                return response()->json([
                    "message"=>"Serie modificata correttamente",
                    "indirizzo"=> $serie],200);     
            }
        }
    }

    /**
     * Elimina una risorsa
     * 
     * @param integer $idSerie 
     * @return 
     */
    public function destroy($idSerie){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $serie = serieTv::findOrFail($idSerie);
                $serie->delete();

                return response()->json(['message'=>'serie eliminata con successo'],204);
            }
        }
    }

}
