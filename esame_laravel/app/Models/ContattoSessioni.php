<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ContattoSessioni extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'contatto_sessioni';
    protected $primaryKey = 'idSessione';

    protected $fillable = [
        'idUser',
        'token',
        'inizioSessione'
    ];

    //--PUBLIC --------------------------

    /**
     * Aggiorna la sessione per il contatto ed il token passato
     * 
     * @param integer $idContatto
     * @param string $token 
     */
    public static function aggiornaSessione($idUser, $token)
    {
        $where = ["idUser" => $idUser, "token" => $token];
        $arr = ["inizioSessione" => time()];
        DB::table("contatto_sessioni")->updateOrInsert($where, $arr);
    }

    /**
     * Elimina la sessione per il contatto passato
     * 
     * @param integer $idContatto
     */
    public static function eliminaSessione($idUser)
    {
        DB::table("contatto_sessioni")->where("idUser", $idUser)->delete();
    }

    /**
     * Dati Sessione
     * 
     * @param string $token
     * @return App\Models\ContattoSessione
     */
    public static function datiSessione($token){
        if(ContattoSessioni::esisteSessione($token)){
            return ContattoSessioni::where("token",$token)->get()->first();
        }else {
            return null;
        }
    }


    /**
     * Controlla se esiste una sessione con il token passato
     * 
     * @param string $token 
     * @return boolean
     */
    public static function esisteSessione($token){
        return DB::table('contatto_sessioni')->where('token',$token)->exists(); 
    }
}   

