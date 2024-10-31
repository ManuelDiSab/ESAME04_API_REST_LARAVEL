<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class UserController extends Controller
{

    /**
     * Funzione per mostrare la lista degli utenti
     */
    public function indexAdmin()
    {
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                return User::all([
                    'name',
                    'cognome',
                    'email',
                    'sesso',
                    'status',
                    'idRuolo',
                    'idUser'
                ]);
            }else{
                abort(403, "Il tuo account è disabilitato");
            }
        }else{
            abort(403, "Ops! Non sei autorizzato!");
        }
    }

    public function showAdmin(Request $request, $idUser)
    {
        if(Gate::allows('admin')) {
            if(Gate::allows('attivo')){
                $user = User::findOrFail($idUser);
                return  ([
                    'nome' => $user->name,
                    'cognome'=> $user->cognome,
                    'email'=>$user->email,
                    'sesso'=>$user->sesso,
                    'status'=>$user->status,
                    'idRuolo'=>$user->idRuolo,
                    'idUser'=>$user->idUser
                ]);
                if(! $user){
                    return ["message" => "L'utente non esiste"];
                }
            }else{
                abort(403, "Il tuo account è disabilitato");
            }
        }else{
            abort(403, "Ops! Non sei autorizzato!");
        }
    }
    /**
     * mostra i dati dell'utente loggato
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show() {
        return response()->json(Auth::user());
    }
    /**
     * 
     * 
     * 
     */
    public function update(Request $request){
        
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                $user = Auth::user();
                $id= $user->idUser;
    
                Validator::make($request->all(), [
                    'name'=>'required|string|between:2,30',
                    'cognome'=>'required|string|between:2,30',
                    'email' => 'required|string|email|max:255|unique:customers,email,' . $id,
                    'tel'=>'string|max:30',
                    'dataNascita' => 'date|required',
                    'sesso' => 'between:0,1|required',
                    'cittadinanza' => 'string|max:45',
                    'codFiscale'=> 'string|max:45',
                ]);
                $validazione = User::findOrFail($id);
                $validazione->update($request->all());
                return [
                    'messaggio' => 'Modifiche completate con successo',
                    'utente' => $validazione
                ];
                 
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function updateAdmin(Request $request, User $idUser)
    {
        if(Gate::allows('admin')){
            if(Gate::allows('attivo')){
                $user = User::find($idUser);

        if($user)
        {
            $request->validate([
                    'nome'=>'required|string|max:45',
                    'cognome'=>'required|string|max:45',
                    'tel'=>'string|max:30',
                    'cittadinanza'=>'required|string|max:45',
                    'sesso'=>'required|between:0,1',
                    'codFiscale'=>'required|string|max:45',
                    'dataNascita'=>'date',
                    'status'=>'required|between:0,1'
            ]);
            
            $user->update($request->only([
                'nome',
                'cognome',
                'email',
                'tel',
                'cittadinanza',
                'sesso',
                'codFiscale',
                'dataNascita',
                'status'
                
        ]));
            return response()->json($user,200);

        }else{
            return response()->json(['message' => 'Utente non trovato'], 404);
        }
            }   
        }
    }

    /**
     * 
     * 
     * 
     */
    public function destroy()
    {
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                $user = Auth::user();
                $id= $user->idUser;

                $utente = User::findOrFail($id);
                $utente->delete();

                return response()->json([
                    "messaggio"=> "Il tuo profilo è stato cancellato correttamente"
                ], 204);
                
            }
        }
    }
    /**
     * 
     * 
     * 
     */
    public function destroyAdmin(Request $request, $idUser)
    {
        if(Gate::allows('user')){
            if(Gate::allows('attivo')){
                $utente = User::findOrFail($idUser);
                $utente->delete();

                return response()->json([
                    "messaggio"=> "Utente cancellato correttamente"
                ], 204);
            }
        }
    }
}

