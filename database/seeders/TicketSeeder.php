<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\Cliente;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = Cliente::all();

        $tickets = [
            [
                'titulo' => 'Error en login',
                'descripcion' => 'Los usuarios no pueden iniciar sesión en la aplicación',
                'prioridad' => 'alta',
                'estado' => 'abierto',
                'cliente_id' => $clientes->first()->id,
            ],
            [
                'titulo' => 'Solicitud de nueva funcionalidad',
                'descripcion' => 'Se requiere agregar exportación a PDF',
                'prioridad' => 'media',
                'estado' => 'abierto',
                'cliente_id' => $clientes->get(1)->id,
            ],
            [
                'titulo' => 'Mejorar rendimiento de reportes',
                'descripcion' => 'Los reportes se cargan muy lentamente',
                'prioridad' => 'media',
                'estado' => 'en_proceso',
                'cliente_id' => $clientes->get(2)->id,
            ],
            [
                'titulo' => 'Configurar backups automáticos',
                'descripcion' => 'Se necesitan backups diarios de la BD',
                'prioridad' => 'alta',
                'estado' => 'en_proceso',
                'cliente_id' => $clientes->get(3)->id,
            ],
            [
                'titulo' => 'Actualizar documentación',
                'descripcion' => 'Documentación de API obsoleta',
                'prioridad' => 'baja',
                'estado' => 'cerrado',
                'cliente_id' => $clientes->get(4)->id,
            ],
            [
                'titulo' => 'Bug en búsqueda avanzada',
                'descripcion' => 'La búsqueda no retorna resultados correctos',
                'prioridad' => 'alta',
                'estado' => 'abierto',
                'cliente_id' => $clientes->first()->id,
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::create($ticket);
        }
    }
}
