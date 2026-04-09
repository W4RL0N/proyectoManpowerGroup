<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/generate-token', function () {
    $user = User::first();
    
    if (!$user) {
        return response()->json(['error' => 'No users found'], 404);
    }
    
    $token = $user->createToken('api-token')->plainTextToken;
    
    return response()->json([
        'message' => 'Token generado exitosamente',
        'user_id' => $user->id,
        'user_email' => $user->email,
        'token' => $token,
        'usage' => 'Usa este token en el header: Authorization: Bearer ' . $token,
    ]);
});
