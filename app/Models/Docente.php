<?php

// app/Models/Docente.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    // Especificamos qué campos son asignables masivamente
    protected $fillable = ['dni', 'nombre', 'apellido'];


    public function centros()
    {
        return $this->belongsToMany(Centro::class, 'centro_docente', 'dni', 'id_centro')
                    ->withPivot('email');
    }

}

