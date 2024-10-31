<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return JsonResource
     */
    public function index(){
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                return Film::all(
                    "idFilm",
                    "idGenere",
                    "titolo",
                    "regista",
                    "durata",
                    "anno",
                );
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function show($idFilm)
    {
        if(Gate::allows('attivo')){
            if(Gate::allows('user')){
                $film = Film::findOrFail($idFilm);
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
                    'regista'=>'required|max:45|string',
                    'durata'=>'required|string|max:10',
                    'anno'=>'required|string'
                ]);
                $resource = Film::create([
                    'idGenere'=>$request->idGenere,
                    'titolo'=>$request->titolo,
                    'trama'=>$request->trama,
                    'regista'=>$request->regista,
                    'durata'=>$request->durata,
                    'anno'=>$request->anno
                ]);

                return response()->json($resource, 201);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @param $idFilm 
     * @return JsonResource
     */
    public function update(Request $request, $idFilm){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $request->validate([
                    "idGenere"=>"required|integer",
                    "titolo"=>"required|string|max:45",
                    "trama"=>"string|max:255",
                    "regista"=>"required|max:45|string",
                    "durata"=>"required|string|max:10",
                    "anno"=>"required|string"
                ]);
                $Film = Film::findOrFail($idFilm);
                $Film->update($request->all());
                return response()->json([
                    "message"=>"Indirizzo modificato correttamente",
                    "indirizzo"=> $Film],200);     
            }
        }
    }

    /**
     * Elimina una risorsa
     * 
     * @param integer $idFilm 
     * @return 
     */
    public function destroy($idFilm){
        if(Gate::allows('attivo')){
            if(Gate::allows('admin')){
                $film = Film::findOrFail($idFilm);
                $film->delete();

                return response()->json("Film eliminato",204);
            }
        }
    }

}
