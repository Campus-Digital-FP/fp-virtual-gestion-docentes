<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CicloModulo extends Model
{
    protected $table = 'ciclo_modulo'; 

    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'id_modulo', 'id_modulo');
    }

    public function docencias()
    {
        return $this->hasMany(Docencia::class, 'id_modulo', 'id_modulo');
    }


}

