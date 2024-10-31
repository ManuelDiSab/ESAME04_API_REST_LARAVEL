<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Nazione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class nazioniController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                return response()->json(Nazione::limit(100)->get(
                ["nome","continente","iso","prefissoTelefonico"]),200);
            }
        }
        return response()->json(Nazione::limit(100)->get(
            ["nome","continente","iso","prefissoTelefonico"]
        ),200);
    }

    public function show($nazione){
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                $resource = Nazione::where('nome',$nazione)
                ->get()
                ->first();

                if($resource) {
                    return response()->json($resource, 200);
                }else{
                    return response()->json(['message' => 'Nazione non trovato'], 404);
                }
            }
        }
    }
}
