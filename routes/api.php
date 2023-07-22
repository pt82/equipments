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

Route::post('/gi', [SwController::class, 'index']);
Route::get('/list-chars', [SwController::class, 'listChars']);//список персов
Route::post('/update-chars', [SwController::class, 'updateChars']);//обновить персов
Route::post('/update-members', [SwController::class, 'updateMembers']); //обновить членов гильдии
Route::post('/update-info-member/{member}', [SwController::class, 'updateInfoMember']); //

Route::get('/gi-members', [SwController::class, 'listMembers']); //члены гильдии
Route::post('/load-data', [SwController::class, 'loadData']); //загрузить все данные на всех членов
Route::post('/search-data', [SwController::class, 'searchData']); //загрузить все данные на всех членов

