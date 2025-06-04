<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroCiclo extends Model
{
    use HasFactory;

    protected $table = 'centro_ciclo';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_centro',
        'id_ciclo'
    ];

    /**
     * Relación con el modelo Centro
     */
    public function centro()
    {
        return $this->belongsTo(Centro::class, 'id_centro');
    }

    /**
     * Relación con el modelo Ciclo
     */
    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class, 'id_ciclo');
    }

    /**
     * Relación con las docencias (módulos impartidos en este centro-ciclo)
     */
    public function docencias()
    {
        return $this->hasMany(Docencia::class, 'id_centro_ciclo');
    }
}