<?php

namespace Database\Seeders;

use App\Models\Cuenta;
use Illuminate\Database\Seeder;

class CuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cuenta = new Cuenta();
        $cuenta->idUsuario = 1;
        $cuenta->idMultimedia = null;
        $cuenta->nombre = 'Alfredo';
        $cuenta->apellidos = 'Delgado Santiago';
        $cuenta->email = 'dltunasd@gmail.com';
        $cuenta->info = 'Info prueba Alfredo';
        $cuenta->save();

        $cuenta = new Cuenta();
        $cuenta->idUsuario = 2;
        $cuenta->idMultimedia = null;
        $cuenta->nombre = 'Asael';
        $cuenta->apellidos = 'Marcial';
        $cuenta->email = 'asael@gmail.com';
        $cuenta->info = 'Info prueba Asael';
        $cuenta->save();

        $cuenta = new Cuenta();
        $cuenta->idUsuario = 3;
        $cuenta->idMultimedia = null;
        $cuenta->nombre = 'Jose Israel';
        $cuenta->apellidos = 'Zavaleta';
        $cuenta->email = 'israel@admin.com';
        $cuenta->info = 'Info prueba Israel';
        $cuenta->save();

        $cuenta = new Cuenta();
        $cuenta->idUsuario = 4;
        $cuenta->idMultimedia = null;
        $cuenta->nombre = 'Leslie';
        $cuenta->apellidos = 'Loaiza';
        $cuenta->email = 'leslie@admin.com';
        $cuenta->info = 'Info prueba Leslie';
        $cuenta->save();
    }
}
