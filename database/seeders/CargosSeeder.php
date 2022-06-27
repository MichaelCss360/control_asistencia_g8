<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cargos')->insert([
            'cargo_nombre' => 'Administrador',
        ]);

        DB::table('cargos')->insert([
            'cargo_nombre' => 'Auxiliar',
        ]);

        DB::table('cargos')->insert([
            'cargo_nombre' => 'Empleado',
        ]);
    }
}
