<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    protected $table = 'centros';
    protected $primaryKey = 'id_centro';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_centro', 'nombre'];

    public function ciclos()
    {
        return $this->belongsToMany(Ciclo::class, 'centro_ciclo', 'id_centro', 'id_ciclo');
    }

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_centro');
    }
}
