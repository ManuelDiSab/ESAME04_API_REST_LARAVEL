<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Crediti extends Model
{
    use HasFactory, SoftDeletes;

        protected $table = 'crediti';
        protected $primaryKey = 'idCredito';
    
        protected $fillable = [
            'credito',
            'idUser'
        ];


}
