<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'prioridad' => 'nullable|in:baja,media,alta',
                'fecha_inicio' => 'nullable|date_format:Y-m-d',
                'fecha_fin' => 'nullable|date_format:Y-m-d|after_or_equal:fecha_inicio',
                'titulo' => 'nullable|string|max:255',
                'per_page' => 'nullable|integer|min:1|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validación fallida',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $query = Ticket::query();

            // Filtro por prioridad
            if ($request->has('prioridad') && $request->prioridad) {
                $query->where('prioridad', $request->prioridad);
            }

            // Filtro por rango de fechas
            if ($request->has('fecha_inicio') && $request->fecha_inicio) {
                $query->whereDate('created_at', '>=', $request->fecha_inicio);
            }
            if ($request->has('fecha_fin') && $request->fecha_fin) {
                $query->whereDate('created_at', '<=', $request->fecha_fin);
            }

            // Búsqueda por título (búsqueda parcial)
            if ($request->has('titulo') && $request->titulo) {
                $query->where('titulo', 'like', '%' . $request->titulo . '%');
            }

            $perPage = $request->input('per_page', 15);
            $tickets = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Tickets obtenidos correctamente',
                'data' => $tickets->items(),
                'pagination' => [
                    'total' => $tickets->total(),
                    'per_page' => $tickets->perPage(),
                    'current_page' => $tickets->currentPage(),
                    'last_page' => $tickets->lastPage(),
                    'from' => $tickets->firstItem(),
                    'to' => $tickets->lastItem(),
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener tickets',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'titulo' => 'required|max:120',
                'descripcion' => 'required',
                'prioridad' => 'required|in:baja,media,alta',
                'cliente_id' => 'required|exists:clientes,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validación fallida',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $ticket = Ticket::create([
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'prioridad' => $request->prioridad,
                'cliente_id' => $request->cliente_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ticket creado exitosamente',
                'data' => $ticket,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear ticket',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}