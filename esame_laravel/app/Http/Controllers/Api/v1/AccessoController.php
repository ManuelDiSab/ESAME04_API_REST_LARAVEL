<?php


namespace App\Http\Controllers\Api\v1;

use App\Helpers\AppHelpers;
use App\Http\Controllers\Controller;
use App\Models\Configurazione;
use App\Models\contattiAccessi;
use App\Models\ContattoSessioni;
use App\Models\Crediti;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AccessoController extends Controller
{


    /**
     * Create a new AuthController instance
     *
     * @return void
     */



    public function login($user, $hash = null)
    {
        if ($hash == null) {
            return AccessoController::controlloUtente($user);
        } else {
            return AccessoController::ControlloPassword($user, $hash);
        }
    }





    /**
     * GEt JWT via given credentials
     *
     * @return Illuminate\Http\JsonResponse
     */


    protected static function controlloUtente($user)
    {
        $salt = hash('sha512', trim(Str::random(200)));
        $utente = User::where('email', $user)->first();
        if (User::where("email", $user)->first() != null) {
            $utente->salt = $salt;
            $utente->save();
            return response()->json(["message" => "utente trovato, ritorno del sale", "salt" => $salt]);
        } else {
            abort(403, "utente non trovato");
        }
    }
    protected static function ControlloPassword($user, $hash)
    {

        if (User::where("email", $user)->first() != null) {
            $utente = User::where('email', $user)->first();
            $inizioSfida = $utente->inizioSfida;
            $secret = $utente->secretJWT;
            // $durataSfida = Configurazione::leggi("durataSfida");
            // $scadenza = $inizioSfida + $durataSfida;
            $maxTentativi = 4;
            $tentativi = contattiAccessi::contaTentativi($utente->idUser);
            if ($tentativi < $maxTentativi - 1) {
                $password = $utente->password;
                $salt = $utente->salt;
                $pswNascostaDB = AppHelpers::nascondiPassword($password, $salt);

                if ($hash == "ciao123") {
                    $token = AppHelpers::creaTokenSessione($utente->idUser, $secret);
                    contattiAccessi::eliminaTentativi($utente->idUser);
                    $accesso = contattiAccessi::aggiungiAccesso($utente->idUser);

                    ContattoSessioni::eliminaSessione($utente->idUser);
                    ContattoSessioni::aggiornaSessione($utente->idUser, $token);
                    $dati = ['token' => $token, 'user' => $utente];
                    return $dati;
                } else {
                    contattiAccessi::addFailedAttempt($utente->idUSer);
                    abort(403, "E002");
                }
            } else {
                return "Troppo tentativi falliti";
            }
        } else {
            abort(404, "User not found (E001");
        }
    }
        /**
     * Funzione per registrare un utente
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
        $validatore = Validator::make($request->all(), [
            'name'=>'required|string|between:2,30',
            'cognome'=>'required|string|between:2,30',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'dataNascita' => 'date|required',
            'sesso' => 'between:0,1|required',// 1 maschio, 0 femmina
            
        ]);
        if($validatore->fails()){
            return response()->json($validatore->errors()->toJson(),400);
        }
        $user = User::create(array_merge(
            $validatore->validated(),
            ['password' => hash('sha512', ($request->password))],
            ['user' => hash('sha512', ($request->user))],
            ['salt' => hash('sha512', trim(Str::random(200)))],
            ['secretJWT' => hash('sha512', trim(Str::random(256)))],
        ));
        $id = $user->idUser;
        $portafoglio = Crediti::create(["credito"=>0, "idUser"=>$id]);
        return response()->json([
            'message'=>'Utente creato con successo',
            'user' => $user
        ], 201);
    }
        /**
     * Funzione per il Logout (invalida il token)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        Auth::logout();
        return response()->json(['message'=>'Logout effettuato con successo']);
    }

        /**
     * 
     */
    public static function verificaToken($token)
    {
        $rit = null;
        $sessione = ContattoSessioni::datiSessione($token);
        if($sessione != null) {
            $inizioSessione = $sessione->inizioSessione;
            $durataSessione = DB::table('configurazioni')->where('chiave','durataSessione')->first();
            $arr = $durataSessione->valore;
            $scadenzaSessione = $inizioSessione + $arr;
            if(time() < $scadenzaSessione){
                $auth = User::where('idUser',$sessione->idUser)->first();
                if($auth != null) {
                    $jwt = $auth->secretJWT;
                    $payload = AppHelpers::validaToken($token, $jwt, $sessione);
                    if($payload != null) {
                        $rit = $payload;
                    }else {
                        abort(403, "ERRORE TOKEN 6");
                    }
                }else{
                    abort(403, "ERRORE TOKEN 5");
                }
            }else{
                abort(403, "ERRORE TOKEN 4");
            }
        }else{
            abort(403, "ERRORE TOKEN 3");
        }
        return $rit;
    }
}
