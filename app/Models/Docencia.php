<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docencia extends Model
{
    protected $table = 'docente_modulo_ciclo';

    protected $fillable = ['dni', 'id_modulo', 'id_ciclo', 'id_centro'];

    public function docente() {
        return $this->belongsTo(Docente::class, 'dni', 'dni');
    }

    public function modulo() {
        return $this->belongsTo(Modulo::class, 'id_modulo');
    }

    public function ciclo() {
        return $this->belongsTo(Ciclo::class, 'id_ciclo');
    }

    public function centroDocente()
    {
        return $this->hasOne(CentroDocente::class, 'dni', 'dni');
    }

}

