<?php

use Email\Messaging\Facades\Messaging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('a', function () {

    Messaging::consume(fn($a) => dd($a));
    dd(Messaging::publish(json_encode(['service' => 'send_email', 'config' => ['to' => 'test@email.com']]), 'sending_email'));
});
