<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cliente::create([
            'nombre' => 'Juan García',
            'email' => 'juan@example.com',
            'telefono' => '+34 912 345 678',
            'empresa' => 'Tech Solutions S.A.',
            'direccion' => 'Calle Principal 123, Madrid',
        ]);

        Cliente::create([
            'nombre' => 'María López',
            'email' => 'maria@example.com',
            'telefono' => '+34 923 456 789',
            'empresa' => 'Digital Innovations',
            'direccion' => 'Avenida Secundaria 456, Barcelona',
        ]);

        Cliente::create([
            'nombre' => 'Carlos Rodríguez',
            'email' => 'carlos@example.com',
            'telefono' => '+34 934 567 890',
            'empresa' => 'Cloud Services Ltd',
            'direccion' => 'Plaza Central 789, Valencia',
        ]);

        Cliente::create([
            'nombre' => 'Ana Martínez',
            'email' => 'ana@example.com',
            'telefono' => '+34 945 678 901',
            'empresa' => 'Software Development Corp',
            'direccion' => 'Calle Tecnológica 101, Bilbao',
        ]);

        Cliente::create([
            'nombre' => 'Pedro Sánchez',
            'email' => 'pedro@example.com',
            'telefono' => '+34 956 789 012',
            'empresa' => 'Data Analytics Inc',
            'direccion' => 'Avenida Moderna 202, Sevilla',
        ]);
    }
}
