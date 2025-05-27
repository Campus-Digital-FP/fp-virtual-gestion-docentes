<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    protected $table = 'coordinadores';

    // No es necesario establecer una clave primaria si la clave es compuesta
    public $incrementing = false;
    protected $keyType = 'string';
    
    public $timestamps = false;
    protected $fillable = ['id_ciclo', 'id_centro', 'dni'];

    //Relación con Ciclo
    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'id_ciclo', 'id_ciclo');
    }
   
    //Relación con Centro  
    public function centro()
    {
        return $this->belongsTo(Centro::class, 'id_centro', 'id_centro');
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'dni', 'dni');
    }


}
