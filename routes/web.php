<?php

use App\Http\Controllers\InterestController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\PeopleController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'OK'
    ]);
});

Route::get('/somar', function(Request $request) {

    // Não está chegando nada pela request
    if (count($request->all()) < 1) {
        return response()->json([
            'message' => 'Não há valores para somar.'
        ], 406);
    }

    $soma = array_sum($request->all());
    return response()->json([
        'message' => 'OK',
        'sum' => $soma, 
    ],200);
});

Route::prefix('/people')->middleware([JwtMiddleware::class])->group(function() {
    Route::get('/list', [PeopleController::class, 'list']);

    Route::post('/store', [PeopleController::class, 'store']);

});

Route::prefix('/interest')->group(function() {
    Route::get('/list', [InterestController::class, 'list']);

    Route::post('/store', [InterestController::class, 'store']);
});

Route::prefix('/user')->group(function() {
    Route::post('register', [JWTAuthController::class, 'register']);
    Route::post('/login', [JWTAuthController::class, 'login']);
    Route::middleware([JwtMiddleware::class])->get('/logout', [JWTAuthController::class, 'logout']);
});

