<?php

use App\Http\Controllers\API\SwController;
use App\Http\Controllers\API\TypeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\API\EquipmentController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/login', [AuthController::class, 'login'])->name('login.custom');
Route::post('/reg', [AuthController::class, 'reg']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('equipment', EquipmentController::class);
    Route::get('equipment-type', [TypeController::class, 'index']);
});

Route::get('/gi', [SwController::class, 'index']);
Route::get('/list-chars', [SwController::class, 'listChars']);
Route::post('/update-chars', [SwController::class, 'updateChars']);
Route::get('/gi-members', [SwController::class, 'listMembers']);

