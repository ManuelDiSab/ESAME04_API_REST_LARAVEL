<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class serieTv extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "serie_tv";
    protected $primaryKey = "idSerie";

    protected $fillable = [
        'idGenere',
        'titolo',
        'trama',
        'n_stagioni',
        'anno_inizio',
        'anno_fine'
    ];
}
