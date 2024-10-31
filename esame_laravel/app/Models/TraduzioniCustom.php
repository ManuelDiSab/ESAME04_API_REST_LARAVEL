<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TraduzioniCustom extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'traduzioni_custom';
    protected $primaryKey = 'idCustom';

    protected $fillable = [
        'chiave',
        'valore',
        'idLingua'
    ];
}
