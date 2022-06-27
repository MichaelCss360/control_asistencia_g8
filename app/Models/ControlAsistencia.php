<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlAsistencia extends Model
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
     * Campos de la tabla Control Asistencias.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'empleado_id',
        'fecha_ingreso',
        'hora_ingreso',
    ];

    public function Empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
