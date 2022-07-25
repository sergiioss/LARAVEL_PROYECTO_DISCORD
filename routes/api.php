<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function(){
    return 'Bienvenido a mi app de chats';
});

/* -------------------- AUTH CONTROLLER -------------------------- */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Asi estan agrupados por los que tienen jwt.
Route::group(["middleware" => "jwt.auth"] , function() {
    Route::get('/info', [AuthController::class, 'info']);
    Route::post('/logout', [AuthController::class, 'logout']); 
});

/* Route::get('/me', [AuthController::class, 'me'])->middleware('jwt.auth');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt.auth'); */
/* ------------------------ USER CONTROLLER -------------------------- */

Route::group(["middleware" => ["jwt.auth", "isSuperAdmin"]] , function() {
    /* ------------------------- ADMIN ----------------------------- */
        Route::post('/user/add_admin/{id}', [UserController::class, 'rolAdmin']);
        Route::post('/user/delete_admin/{id}', [UserController::class, 'deleteRolAdmin']);
    /* ----------------------- SUPER ADMIN ------------------------- */
        Route::post('/user/super_admin/{id}', [UserController::class, 'rolSuperAdmin']);
        Route::post('/user/delete_super_admin/{id}', [UserController::class, 'deleteRolSuperAdmin']);
    });