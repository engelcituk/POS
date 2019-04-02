<?php

use Illuminate\Database\Seeder;
use  Caffeinated\Shinobi\Models\Permission; /* use Proveedor\Paquete\Carpeta\Entidad */

class PermisosTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permisos para los usuarios
        Permission::Create([
            'name'              =>'Navegar Usuarios',
            'slug'              =>'usuarios.index',
            'description'       =>'Lista y navega todos los usuarios del sistema'
        ]);
        Permission::Create([
            'name'              =>'Ver detalle de usuario',
            'slug'              =>'usuarios.show',
            'description'       =>'Ver en detalle cualquier usuario del sistema'
        ]);
        Permission::Create([
            'name'              =>'Edición de usuarios',
            'slug'              =>'usuarios.edit',
            'description'       =>'Editar cualquier usuario del sistema'
        ]);
        Permission::Create([
            'name'              =>'Eliminar usuario',
            'slug'              =>'usuarios.destroy',
            'description'       =>'Eliminar cualquier usuario del sistema'
         ]);

        //Permisos para roles
        Permission::Create([
            'name'              =>'Navegar roles',
            'slug'              =>'roles.index',
            'description'       =>'Lista y navega todos los roles del sistema'
        ]);
        
        Permission::Create([
            'name'              =>'Ver detalle de rol',
            'slug'              =>'roles.show',
            'description'       =>'Ver en detalle cualquier rol del sistema' 
        ]);
        Permission::Create([
            'name'              =>'Creacion de roles',
            'slug'              =>'roles.create',
            'description'       =>'Lista y    navega todos los categorias del sistema'
        ]);
        Permission::Create([
            'name'              =>'Edición de roles',
            'slug'              =>'roles.edit',
            'description'       =>'Editar cualquier rol del sistema'
          ]);
        Permission::Create([
            'name'              =>'Eliminar rol',
            'slug'              =>'roles.destroy',
            'description'       =>'Eliminar cualquier rol del sistema'
          ]);

        //Permisos para Productos
        Permission::Create([
            'name'              =>'Navegar productos',
            'slug'              =>'productos.index',
            'description'       =>'Lista y navega todos los productos del sistema'
        ]);
        Permission::Create([
            'name'              =>'Creacion de productos',
            'slug'              =>'productos.create',
            'description'       =>'Lista y   navega todos los categorias del sistema'
        ]);
        Permission::Create([
            'name'              =>'Ver detalle de producto',
            'slug'              =>'productos.show',
            'description'       =>'Ver en detalle cualquier producto del sistema' 
        ]);
        Permission::Create([
            'name'              =>'Edición de productos',
            'slug'              =>'productos.edit',
            'description'       =>'Editar cualquier producto del sistema'
          ]);
        Permission::Create([
            'name'              =>'Eliminar producto',
            'slug'              =>'productos.destroy',
            'description'       =>'Eliminar cualquier producto del sistema'
         ]);

        //Permisos para categorias
        Permission::Create([
            'name'              =>'Navegar categorias',
            'slug'              =>'categorias.index',
            'description'       =>'Lista y navega todos los categorias del sistema'
        ]);
        Permission::Create([
            'name'              =>'Creacion de categorias',
            'slug'              =>'categorias.create',
            'description'       =>'Lista y  navega todos los categorias del sistema'
        ]);
        Permission::Create([
            'name'              =>'Ver detalle de categoria',
            'slug'              =>'categorias.show',
            'description'       =>'Ver en detalle cualquier categoria del sistema'
        ]);
        Permission::Create([
            'name'              =>'Edición de categorias',
            'slug'              =>'categorias.edit',
            'description'       =>'Editar cualquier categoria del sistema'
         ]);
        Permission::Create([
            'name'              =>'Eliminar categoria',
            'slug'              =>'categorias.destroy',
            'description'       =>'Eliminar cualquier categoria del sistema'
           ]);
    }
}
