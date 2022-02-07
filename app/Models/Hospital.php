<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $table = 'hospitais'; // indica a tabela fazendo o laravel entender o plural de hospitais
    protected $fillable = [
        'id',
        'nome'
    ];

    public $timestamps = false;
}
