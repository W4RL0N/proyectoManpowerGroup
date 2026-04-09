<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_creation_requires_validation(): void
    {
        $response = $this->postJson('/api/tickets', []);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Validación fallida',
            ])
            ->assertJsonStructure(['errors' => ['titulo', 'descripcion', 'prioridad', 'cliente_id']]);
    }

    public function test_ticket_creation_is_successful(): void
    {
        $cliente = Cliente::create([
            'nombre' => 'Cliente Prueba',
            'email' => 'cliente@example.com',
        ]);

        $payload = [
            'titulo' => 'Incidente de prueba',
            'descripcion' => 'El usuario no puede iniciar sesión.',
            'prioridad' => 'alta',
            'cliente_id' => $cliente->id,
        ];

        $response = $this->postJson('/api/tickets', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Ticket creado exitosamente',
                'data' => [
                    'titulo' => 'Incidente de prueba',
                    'descripcion' => 'El usuario no puede iniciar sesión.',
                    'prioridad' => 'alta',
                    'cliente_id' => $cliente->id,
                ],
            ]);

        $this->assertDatabaseHas('tickets', [
            'titulo' => 'Incidente de prueba',
            'cliente_id' => $cliente->id,
            'prioridad' => 'alta',
        ]);
    }

    public function test_ticket_listing_can_filter_by_priority_and_title(): void
    {
        $cliente = Cliente::create([
            'nombre' => 'Cliente Prueba',
            'email' => 'cliente@example.com',
        ]);

        Ticket::create([
            'titulo' => 'Error en pago',
            'descripcion' => 'El pago no se procesa correctamente.',
            'prioridad' => 'alta',
            'cliente_id' => $cliente->id,
        ]);

        Ticket::create([
            'titulo' => 'Solicitud de mejora',
            'descripcion' => 'Agregar reporte mensual.',
            'prioridad' => 'media',
            'cliente_id' => $cliente->id,
        ]);

        Ticket::create([
            'titulo' => 'Consulta sobre facturación',
            'descripcion' => 'Verificar precio del plan.',
            'prioridad' => 'baja',
            'cliente_id' => $cliente->id,
        ]);

        $response = $this->getJson('/api/tickets?prioridad=alta&titulo=Error');

        $response->assertStatus(200)
            ->assertJson([ 'success' => true ])
            ->assertJsonCount(1, 'data');

        $this->assertEquals('Error en pago', $response->json('data.0.titulo'));
    }
}
