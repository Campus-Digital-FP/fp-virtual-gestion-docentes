<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentroDocente extends Model
{
    protected $table = 'centro_docente'; 
    public $timestamps = false; 

    protected $fillable = [
        'dni',
        'id_centro',
        'email',
    ];

    // Relación con el Docente
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'dni', 'dni');
    }

    // Relación con el Centro
    public function centro()
    {
        return $this->belongsTo(Centro::class, 'id_centro', 'id_centro');
    }
}
