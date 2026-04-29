<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BaseSystemSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear rol admin
        $rolId = DB::table('roles')->insertGetId([
            'nombre' => 'admin',
            'descripcion' => 'admin'
        ]);

        // 2. Crear permiso admin
        $permisoId = DB::table('permisos')->insertGetId([
            'nombre' => 'admin',
            'descripcion' => 'admin'
        ]);

        // 3. Relación permiso_rol
        DB::table('permiso_rol')->insert([
            'rol_id' => $rolId,
            'permiso_id' => $permisoId
        ]);

        // 4. Crear usuario admin
        $userId = DB::table('users')->insertGetId([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'rol_id' => $rolId,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 5. Crear cliente (ESTO ES LO QUE TE FALTABA)
        DB::table('clientes')->insert([
            'nombre' => 'Admin',
            'apellido_paterno' => 'Sistema',
            'apellido_materno' => 'Principal',
            'curp' => 'ADMIN123456',
            'telefono' => '0000000000',
            'correo' => 'admin@admin.com',
            'direccion' => 'Sistema',
            'fecha_nacimiento' => '2000-01-01',
            'estatus' => 1,
            'user_id' => $userId,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}