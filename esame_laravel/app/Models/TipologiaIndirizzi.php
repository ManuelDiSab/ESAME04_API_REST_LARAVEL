<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipologiaIndirizzi extends Model
{
    use HasFactory, SoftDeletes;

    
    protected $table ="tipologia_indirizzi";
    protected $primaryKey = "idTipologiaIndirizzo";

    protected $fillable = [
        'nome'
    ];
}
