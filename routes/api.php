<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;

use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('/login' , [AuthController::class , 'login']);
Route::post('/register' , [AuthController::class ,'register']);


Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user' , function (Request $request) {
        return response(['user'=>$request->user() , 'token' => request()->bearerToken()]);});
    Route::get('/allUser' , [AuthController::class , 'index']);
    Route::get('conversation' , [ConversationController::class , 'index']);
    Route::post('conversation' , [ConversationController::class , 'store']);
    Route::post('conversation/checkConversation' , [ConversationController::class , 'checkConversation']);
    Route::post('conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
    Route::post('/message' , [MessageController::class , 'store']);
    Route::post('/logout' , [AuthController::class ,'logout']);
});





