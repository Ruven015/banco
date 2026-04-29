<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\TipoCuentaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientePanelController;



// 🔐 RUTAS PÚBLICAS (LOGIN)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// 🔒 RUTAS PROTEGIDAS
Route::middleware(['auth'])->group(function () {
    Route::get('/cliente/comprobante/{id}', [ClientePanelController::class, 'comprobante'])
    ->name('cliente.comprobante');
    Route::get('/cliente/cuenta/{id}', [ClientePanelController::class, 'verCuenta'])
    ->name('cliente.cuenta');
    Route::post('/cliente/transferir', [ClientePanelController::class, 'transferir'])
    ->name('cliente.transferir');
    Route::post('/cliente/depositar', [ClientePanelController::class, 'depositar'])
    ->name('cliente.depositar');
Route::post('/cliente/retirar', [ClientePanelController::class, 'retirar'])
    ->name('cliente.retirar');
    Route::get('/', [DashboardController::class, 'index']);

    Route::resource('clientes', ClienteController::class);
    Route::resource('sucursales', SucursalController::class);
    Route::resource('tipo-cuentas', TipoCuentaController::class);
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('cuentas', CuentaController::class);
    Route::resource('usuarios', UserController::class);

    Route::get('transacciones', [TransaccionController::class, 'index']);
    Route::get('transacciones/create', [TransaccionController::class, 'create']);
    Route::post('transacciones/store', [TransaccionController::class, 'store']);

    Route::get('/notificaciones', [NotificacionController::class, 'index'])
        ->name('notificaciones.index');

    // 🔓 LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/cliente', [ClientePanelController::class, 'index'])
    
    
    ->name('cliente.dashboard');
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

