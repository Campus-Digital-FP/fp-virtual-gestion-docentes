<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    protected $table = 'ciclos';
    protected $primaryKey = 'id_ciclo';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_ciclo', 'nombre'];

    public function centros()
    {
        return $this->belongsToMany(Centro::class, 'centro_ciclo', 'id_ciclo', 'id_centro');
    }

    public function modulos()
    {
        return $this->belongsToMany(Modulo::class, 'ciclo_modulo', 'id_ciclo', 'id_modulo');
    }
}

