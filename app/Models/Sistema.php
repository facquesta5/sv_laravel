<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sistema extends Model
{
    protected $fillable = [
        'id',
        'id_hospital',
        'nome'
    ];

    public $timestamps = false;

}
