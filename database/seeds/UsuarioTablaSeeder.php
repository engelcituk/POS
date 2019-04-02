<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Role; /* use Proveedor\Paquete\Carpeta\Entidad */

class UsuarioTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 20)->create();
        
        Role::create([
            'name'             =>'admin',
            'slug'             =>'admin',
            'description'      =>'Todos los accesos',
            'special'         => 'all-access' /*no-access */
        ]);
    }
}
