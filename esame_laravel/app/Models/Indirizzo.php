<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Indirizzo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "indirizzi";
    protected $primaryKey = "idIndirizzo";

    protected $fillable = [
        "idUser",
        "idTipologiaIndirizzo",
        "idNazione",
        'idComune',
        "indirizzo",
        "civico",
        "cap",
        "località"
    ];
}
