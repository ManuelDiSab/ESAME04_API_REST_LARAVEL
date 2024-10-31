<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Crediti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
        /**
     * Create a new AuthController instance
     * 
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * GEt JWT via given credentials
     * 
     * @return Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if(! $token = Auth::attempt($validator->validated())) {
            return response()->json(['error'=>'Non autorizzato'], 401);
        }
        
        return $this->createNewToken($token);
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
            ['password'=>bcrypt($request->password)]
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
     * Refreshare un token
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(Auth::refresh());
    }

        /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(Auth::user());
    }

    /**
     * Get the token array structure 
     * 
     * @param string $token 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => Auth::user()
        ]);
    }



}


