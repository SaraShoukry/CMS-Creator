<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\CustomAttributeController;
use App\Http\Controllers\EntityCustomAttributeController;
use App\Http\Controllers\CRMController;
use App\Http\Controllers\TableController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
//    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});


Route::group(['prefix' => 'operators', 'middleware' => ['role:admin']], function ($router) {
    $router->get('/', [\App\Http\Controllers\OperatorController::class, 'index']);
    $router->get('/{id}', [\App\Http\Controllers\OperatorController::class, 'show']);
    $router->post('', [\App\Http\Controllers\OperatorController::class, 'store']);
    $router->post('/{id}/edit', [\App\Http\Controllers\OperatorController::class, 'update']);
    $router->delete('{id}', [\App\Http\Controllers\OperatorController::class, 'delete']);
});

Route::group(['prefix' => 'entities', 'middleware' => ['role:admin']], function ($router) {
    $router->get('/', [EntityController::class, 'index']);
    $router->get('/{id}', [EntityController::class, 'show']);
    $router->post('', [EntityController::class, 'store']);
    $router->post('/{id}/edit', [EntityController::class, 'update']);
    $router->delete('{id}', [EntityController::class, 'delete']);
});

Route::group(['prefix' => 'custom_attributes', 'middleware' => ['role:admin']], function ($router) {
    $router->get('/', [CustomAttributeController::class, 'index']);
    $router->get('/{id}', [CustomAttributeController::class, 'show']);
    $router->post('', [CustomAttributeController::class, 'store']);
    $router->post('/{id}/edit', [CustomAttributeController::class, 'update']);
    $router->delete('{id}', [CustomAttributeController::class, 'delete']);
});

Route::group(['prefix' => 'assign_custom_attributes', 'middleware' => ['role:admin']], function ($router) {
    $router->post('', [EntityCustomAttributeController::class, 'store']);
});

Route::group(['prefix' => 'tables', 'middleware' => ['role:admin']], function ($router) {
    $router->post('create', [TableController::class, 'createTable']);
});


Route::group(['prefix' => 'crm', 'middleware' => ['role:operator']], function ($router) {
    $router->get('/{entity_id}', [CRMController::class, 'index']);
    $router->get('/{entity_id}/{id}', [CRMController::class, 'show']);
    $router->post('{entity_id}', [CRMController::class, 'store']);
    $router->post('/{entity_id}/edit', [CRMController::class, 'update']);
});
