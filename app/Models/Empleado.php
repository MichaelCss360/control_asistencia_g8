<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    /**
     * Modelo Generado para gestionar registros en la base de datos
     */

    /**
     * Tabla Asociada al Modelo
     *
     * @var string
     */
    protected $table = 'empleados';

    /**
     * Campos de la tabla Empleados.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'edad',
        'cargo_id',
        'cedula',
        'nocelular',
    ];

    public function Cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }
}
