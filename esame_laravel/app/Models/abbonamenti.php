<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class abbonamenti extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'abbonamenti';
    protected $primaryKey = 'idAbbonamento';

    protected $fillable = [
        'nome',
        'costo'
    ];
    
}
