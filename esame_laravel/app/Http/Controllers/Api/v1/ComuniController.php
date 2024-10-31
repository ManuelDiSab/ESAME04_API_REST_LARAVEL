<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ComuniCompletoCollection;
use App\Models\Comuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ComuniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                return response()->json(Comuni::limit(100)->get(
                ["nome","regione","cap","siglaAuto"]),200);
            }
        }
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($comune)
    {
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                $comune = Comuni::where('nome',$comune)
                ->get()
                ->first();

                if($comune) {
                    return response()->json($comune, 200);
                }else{
                    return response()->json(['message' => 'Comune non trovato'], 404);
                }
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$idComune)
    {
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $comune = Comuni::findOrFail($idComune);

                if($comune)
                {
                    $request->validate([
                        'nome'=> 'required|string|max:45',
                        'regione' => 'required|string|max:45',
                        'metropolitana' => '|string|max:45',
                        'provincia'=> 'required|string|max:45',
                        'siglaAuto'=>'required|string|max:2',
                        'codCat'=>'required|string|max:4',
                        'capoluogo'=>'|string|max:45',
                        'multicap'=>'|string|max:3',
                        'cap'=>'required|string|max:10',
                        'capFine'=>'|string|max:10',
                        'capInizio'=> '|string|max:10'
                    ]);

                    $comune->update($request->only(['nome']));
                    return response()->json($comune,200);
                }else{
                    return response()->json(['message' => 'Comune non trovato '], 404);
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idComune)
    {
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $comune = Comuni::find($idComune);

                if($comune){
                    $comune->delete();
                    return response()->json(["message"=> 'Comune cancellato correttamente'],200);
                }else{
                    return response()->json(['message' => 'Comune non trovato'], 404);
                }
            }
        }
    }
}

