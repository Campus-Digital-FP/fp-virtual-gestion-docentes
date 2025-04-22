<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imparte extends Model
{
    protected $table = 'imparte';
    public $timestamps = false;

    protected $fillable = ['dni', 'id_modulo', 'id_centro'];
}

