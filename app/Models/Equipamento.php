<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    protected $fillable = [
        'id',
        'id_hospital',
        'id_sistema',
        'nome'
    ];

    public $timestamps = false;

    public static function listEquipment($hospitalId, $sistemaId){
        return Equipamento::select(
            'equipamentos.id',
            'equipamentos.nome',
        )
        ->where('equipamentos.id_sistema', $sistemaId)
        ->where('equipamentos.id_hospital', $hospitalId)
        ->orderBy('id', 'DESC')
        ->get();
    }

}
