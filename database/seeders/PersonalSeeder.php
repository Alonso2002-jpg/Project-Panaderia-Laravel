<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PersonalSeeder extends Seeder
{
    public function run()
    {

        DB::table('staff')->insert([

            [
                'id' => (string)Str::uuid(),
                'name' => 'Juan',
                'dni' => '12345678',
                'lastname' => 'Perez',
                'email' => 'juan@gmail.com',
                'startDate' => '2024-02-20',
                'role' => 'baker',
                'image' => 'https://via.placeholder.com/150',
                'isDelete' => 'false',
            ],
            // Personal que se encarga de manejar las transacciones en caja
            [
                'id' => (string)Str::uuid(),
                'name' => 'Ana',
                'dni' => '87654321',
                'lastname' => 'Lopez',
                'email' => 'ana@gmail.com',
                'startDate' => '2024-02-20',
                'role' => 'cashier',
                'image' => 'https://via.placeholder.com/150',
                'isDelete' => 'false',

            ],
            // Personal que se encarga de la gestión y administración de la panadería
            [
                'id' => (string)Str::uuid(),
                'name' => 'Carlos',
                'dni' => '23456789',
                'lastname' => 'Garcia',
                'email' => 'carlos@gmail.com',
                'startDate' => '2024-02-20',
                'role' => 'manager',
                'image' => 'https://via.placeholder.com/150',
                'isDelete' => 'false',


            ],
            // Personal que se encarga de la atención y el servicio al cliente
            [
                'id' => (string)Str::uuid(),
                'name' => 'Luis',
                'dni' => '34567890',
                'lastname' => 'Martinez',
                'email' => 'luis@gmail.com',
                'startDate' => '2024-02-20',
                'role' => 'steward',
                'image' => 'https://via.placeholder.com/150',
                'isDelete' => 'false',

            ],
            // Personal encargado de la limpieza y mantenimiento del establecimiento
            [
                'id' => (string)Str::uuid(),
                'name' => 'Sofia',
                'dni' => '45678901',
                'lastname' => 'Vega',
                'email' => 'sofia@gmail.com',
                'startDate' => '2024-02-20',
                'role' => 'cleaner',
                'image' => 'https://via.placeholder.com/150',
                'isDelete' => 'false',

            ],
            // Especialista en la preparación de pasteles y dulces
            [
                'id' => (string)Str::uuid(),
                'name' => 'Elena',
                'dni' => '56789012',
                'lastname' => 'Hernandez',
                'email' => 'elena@gmail.com',
                'startDate' => '2024-02-20',
                'role' => 'pastry_chef',
                'image' => 'https://via.placeholder.com/150',
                'isDelete' => 'false',

            ],
            // Responsable de la gestión del inventario y el abastecimiento
            [
                'id' => (string)Str::uuid(),
                'name' => 'Marco',
                'dni' => '67890123',
                'lastname' => 'Ruiz',
                'email' => 'marco@gmail.com',
                'startDate' => '2024-02-20',
                'role' => 'inventory_manager',
                'image' => 'https://via.placeholder.com/150',
                'isDelete' => 'false',

            ],
        ]);

    }
}
