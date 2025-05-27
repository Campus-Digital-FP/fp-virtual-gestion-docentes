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

    // En Docente.php

    public function tutor()
    {
        return $this->hasOne(Tutor::class, 'dni', 'dni');
    }

    public function coordinador()
    {
        return $this->hasOne(Coordinador::class, 'dni', 'dni');
    }

    public function docencias()
    {
        return $this->hasMany(Docencia::class, 'dni', 'dni');
    }

}

