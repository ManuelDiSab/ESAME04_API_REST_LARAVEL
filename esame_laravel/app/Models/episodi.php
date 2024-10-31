<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class episodi extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'episodi';
    protected $primaryKey = 'idEpisodio';

    protected $fillable =[
        'idSerie',
        'durata',
        'numero',
        'stagione',
        'titolo'
    ];
}
