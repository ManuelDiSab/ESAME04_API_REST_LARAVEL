<?php

namespace App\Helpers;

use App\Models\Contatti;
use App\Models\User;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\Contracts\Providers\JWT as ProvidersJWT;
use Tymon\JWTAuth\Facades\JWTAuth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AppHelpers{

    public static function isAdmin($idRuolo)
    {
        return ($idRuolo === 2) ? true : false;
    }

    public static function AggiornaRegoleHelper($rules)
    {
        $newRules =array();
        foreach($rules as $key=>$value)
        {
            $newRules[$key] = str_replace('required|', "", $value);
        }
        return $newRules;
    }

    /**
     * ciframento
     * @param string $testo da cifrare
     * @param string $chiave usata per cifrare
     */
    public static function cifra($testo, $chiave)
    {
        $testoCifrato = AesCtr::encrypt($testo, $chiave, 256);
        return base64_encode($testoCifrato);
    }

    /**
     * 
     * deciframento
     * 
     * @param string $testoDecifrato testo da decifrare
     * @param string $chiave chiave usata per la decifrazione
     * 
     * @return string  
     * 
     */
    public static function decifra($testoCifrato, $chiave)
    {
        $testoCifrato= base64_decode($testoCifrato);
        return AesCtr::decrypt($testoCifrato, $chiave, 256);    
    }
        


    /**
     * Funzione per unire password e salt per fare un HASH
     * 
     *@param string $password
     *@param string $salt
     *
     *@return string
     */
    public static function nascondiPassword($password, $salt)
    {
        return hash('sha512', $salt . $password);
    }


    /**
     * Toglie il required alle rules di aggiornamento 
     * 
     * @param string $secretJWT chiave di cifratura
     * @param integer $idContatto
     * @param integer $usaDa unixtime abilotazione utilizzo token
     * @param integer $scadenza unixtime scadenza utilizzo token 
     * 
     * @return string 
     */
    public static function creaTokenSessione($idUser, $secretJWT, $usaDa = null, $scadenza = null)
    {
        $maxTime = 15 * 24 * 60 * 60; // Scadenza del token dopo un massimo di 15 giorni
        $recordContatto = User::where('idUser', $idUser)->first();
        $t = time();
        $nbf = ($usaDa == null) ? $t:$usaDa;
        $exp = ($scadenza == null) ? $nbf + $maxTime : $scadenza;
        $idRuolo = $recordContatto->idRuolo;
        $arr = array(
            'iss'=>'',
            'aud'=>null,
            'iat'=>$t,
            'nbf'=>$nbf,
            'exp'=>$exp,
            'data'=>array(
                'idUser'=>$idUser,
                'status'=>$recordContatto->status,
                'idRuolo'=>$idRuolo,
                'nome_completo'=>trim($recordContatto->name . " " . $recordContatto->cognome)
            )
            );
            $token = JWT::encode($arr, $secretJWT,'HS256');
            return $token;
    }


    /**
     * Controlla se esiste l'utente passato 
     * 
     * @param boolean $successo TRUE  se la richiesta è andata a buon fine 
     * @param integer $codice STATUS CODE della richiesta 
     * @param array $dati Dati richiesti
     * @param string $messaggio 
     * @param array $errori 
     *
     * @return array
     */
    public static function rispostaCustom($dati, $messaggio= null, $errori = null)
    {
        $respoonse = array();
        $response["data"] = $dati;
        if ( $messaggio != null) $response["message"] = $messaggio;
        if ( $errori != null) $response["error"] = $errori;
        return $response;
    }

    /**
     * 
     */
    public static function validaToken($token, $jwt, $sessione){
        $rit = null;
        $payload = JWT::decode($token,new Key($jwt, 'HS256')); // Per fare il decode devl creare una nuova istanza key e passargli la secretJWT e l'algoritmo
        if($payload->iat <=$sessione->inizioSessione) {
            if($payload->data->idUser == $sessione->idUser) {
                $rit = $payload;
            }
        }
        return $rit;
    }
}