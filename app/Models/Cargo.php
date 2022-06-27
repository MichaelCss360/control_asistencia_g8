<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    /**
     * Modelo Generado para gestionar registros en la base de datos
     */

    /**
     * Tabla Asociada al Cargos
     *
     * @var string
     */
    protected $table = 'cargos';

    /**
     * Campos de la tabla Empleados.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cargo_nombre',
    ];
}
