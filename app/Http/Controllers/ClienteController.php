<?php

namespace App\Http\Controllers;

use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index()
    {
        try {
            $clientes = Cliente::all();

            return response()->json([
                'success' => true,
                'message' => 'Clientes obtenidos correctamente',
                'data' => $clientes,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener clientes',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
