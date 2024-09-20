<?php

use App\Events\EmailNotification;
use App\Http\Controllers\AuthController;
use App\Models\MailingList;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\MailingListController;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;




Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::apiResource('topics', TopicController::class)->middleware('auth:sanctum');
Route::apiResource('mailinglists', MailingListController::class)->middleware('auth:sanctum');
Route::post('mailinglists/{id}/subscribe', [MailingListController::class, 'subscribe'])->middleware('auth:sanctum');

//Rota de notificação
Route::post('mailinglists/{id}/notify', function ($id, Request $request) {
    $mailingList = MailingList::find($id);
    $message = $request->input('message');

    if (!$mailingList) {
        return response()->json(['message' => 'Lista de e-mail não encontrada.'], 404);
    }

    event(new EmailNotification($mailingList, $message));

    return response()->json(['message' => 'Notificações enviadas com sucesso.']);
})->middleware('auth:sanctum');

//Rotas de Usuários
Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::post('users', [UserController::class, 'store']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
});
