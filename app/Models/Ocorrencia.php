<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ocorrencia extends Model
{
    protected $fillable = [
        'id_equipamento',
        'id_hospital',
        'id_sistema',
        'id_status',
        'descricao'
    ];

    public $timestamps = false;

}
