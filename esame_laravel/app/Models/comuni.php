<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comuni extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "comuni";
    protected $primaryKey = "idComune";

    protected $fillable = [
        'nome',
        'regione',
        'metropolitana',
        'provincia',
        'siglaAuto',
        'codCat',
        'capoluogo',
        'multicap',
        'cap',
        'capFine',
        'capInizio'
    ];
}