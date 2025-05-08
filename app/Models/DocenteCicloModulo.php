<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocenteCicloModulo extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'docente_modulo_ciclo';

    // Definir los campos que se pueden llenar
    protected $fillable = [
        'dni',
        'id_ciclo',
        'id_modulo',
        'id_centro'
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'dni', 'dni'); // Ajustado a 'dni'
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'id_ciclo', 'id_ciclo');
    }

    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'id_modulo', 'id_modulo');
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class, 'id_centro', 'id_centro');
    }
}
