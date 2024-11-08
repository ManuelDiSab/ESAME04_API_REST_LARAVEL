<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class contattiAccessi extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "contatti_accessi";
    protected $primaryKey = "idAccesso";

    protected $fillable = [
        "idUser",
        "autenticato",
        "ip"
    ];
    /**
     * Ritorno di appartenenza
     * 
     * @return \Illuminate\Http\Response
     * 
     */
    public function GetContatto(){
        return $this->belongsTo(User::class,"idUser", "idUser");
    }

    /**
     * 
     */
    public static function aggiungiAccesso($idUser)
    {
        contattiAccessi::eliminaTentativi($idUser);
        return contattiAccessi::nuovoRecord($idUser, 1);
    }

    /**
     * 
     */
    public static function addFailedAttempt($idUser)
    {
        return contattiAccessi::nuovoRecord($idUser, 0);
    }

    /**
     * 
     */
    public static function contaTentativi($idUser){
        $tmp = contattiAccessi::where('idUser',$idUser)->where('autenticato',0)->count();
        return $tmp;
    }

    //-------------PROTECTED-------------------------------
    /**
     * 
     */
    protected static function nuovoRecord($idUser, $autenticato)
    {
        $tmp = contattiAccessi::create([
            "idUser" => $idUser,
            "autenticato" => $autenticato,
            "ip" => request()->ip()
        ]);
        return $tmp;
    }

    protected static function eliminaTentativi($idUser)
    {
        return contattiAccessi::where('idUser',$idUser)
        ->where('autenticato',0)
        ->delete();
    }
}
