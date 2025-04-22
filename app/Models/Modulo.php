<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'modulos';
    protected $primaryKey = 'id_modulo';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_modulo', 'nombre'];

    public function ciclos()
    {
        return $this->belongsToMany(Ciclo::class, 'ciclo_modulo', 'id_modulo', 'id_ciclo');
    }
}

