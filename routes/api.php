<?php

use App\Models\Equipamento;
use App\Models\TipoInstalacao;
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

Route::group(
    [
        'prefix' => 'customers',
    ],
    function () {
        Route::post(
            '/',
            App\Http\Controllers\Customers\NewCustomerController::class
        )->name('customers.store');

        Route::get(
            '/',
            App\Http\Controllers\Customers\GetAllCustomersController::class
        )->name('customers.all');

        Route::get(
            '/{id}',
            App\Http\Controllers\Customers\GetCustomerController::class
        )->name('customers.get');

        Route::put(
            '/{id}',
            App\Http\Controllers\Customers\UpdateCustomerController::class
        )->name('customers.update');

        Route::delete(
            '/{id}',
            App\Http\Controllers\Customers\DestroyCustomerController::class
        )->name('customers.destroy');
    }
);

Route::get(
    'tipos-instalacao',
    App\Http\Controllers\InstallTypes\GetAllInstallTypesController::class
);

Route::get(
    'equipamentos',
    App\Http\Controllers\Equipment\GetAllEquipmentsController::class
);

Route::group(
    [
        'prefix' => 'projects',
    ],
    function () {
        Route::post(
            '/',
            App\Http\Controllers\Projects\NewProjectController::class
        )->name('projects.store');

        Route::get(
            '/',
            App\Http\Controllers\Projects\GetAllProjectsController::class
        )->name('projects.all');

        Route::get(
            '/{id}',
            App\Http\Controllers\Projects\GetProjectController::class
        )->name('projects.get');

        Route::put(
            '/{id}',
            App\Http\Controllers\Projects\UpdateProjectController::class
        )->name('projects.update');

        Route::delete(
            '/{id}',
            App\Http\Controllers\Projects\DestroyProjectController::class
        )->name('projects.destroy');
    }
);
