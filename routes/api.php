<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
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
Route::post('/register', [Users::class, 'register']);
Route::post('/login', [Users::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [Users::class, 'logout']);

Route::get('/blog/rows/{rows}', [BlogController::class, 'index']);
Route::get('/blog/{user_id}/rows/{rows}', [BlogController::class, 'getUserIndex']);
Route::get('/blog/count', [BlogController::class, 'count']);
Route::get('/blog/count/{user_id}', [BlogController::class, 'getUserCount']);
Route::middleware('auth:sanctum')->post('/blog/store', [BlogController::class, 'store']);
Route::get('/blog/{blog}', [BlogController::class, 'show']);
Route::middleware('auth:sanctum')->get('/blog/edit/{blog}', [BlogController::class, 'edit']);
Route::middleware('auth:sanctum')->post('/blog/update/{blog}', [BlogController::class, 'update']);
Route::middleware('auth:sanctum')->get('/blog/destroy/{blog}', [BlogController::class, 'destroy']);

Route::get('/comment/{blog_id}/rows/{rows}', [CommentController::class, 'index']);
Route::get('/comment/count/{blog_id}', [CommentController::class, 'count']);
Route::middleware('auth:sanctum')->post('/comment/store', [CommentController::class, 'store']);
Route::middleware('auth:sanctum')->post('/comment/update/{comment}', [CommentController::class, 'update']);
Route::middleware('auth:sanctum')->get('/comment/destroy/{comment}', [CommentController::class, 'destroy']);

