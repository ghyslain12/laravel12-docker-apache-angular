<?php

use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\UtilisateurController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/utilisateur/ping', [UtilisateurController::class, 'ping']);
Route::get('/material/ping', [MaterialController::class, 'ping']);
Route::post('/utilisateur', [UtilisateurController::class, 'store']);

Route::get('/config/jwt', function () {
    return response()->json([
        'jwt_enabled' => env('JWT_ENABLE', false)
    ]);
});

Route::middleware(env('JWT_ENABLE', false) ? 'jwt' : [])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('client', ClientController::class)->parameters(['client' => 'customer']);
    Route::apiResource('material', MaterialController::class)->parameters(['material' => 'material']);
    Route::apiResource('sale', SaleController::class)->parameters(['sale' => 'sale']);
    Route::apiResource('ticket', TicketController::class)->parameters(['ticket' => 'ticket']);
    Route::apiResource('utilisateur', UtilisateurController::class)
        ->parameters(['utilisateur' => 'user'])
        ->except(['store']);
});
