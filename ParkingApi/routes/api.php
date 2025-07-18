<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\TipoVehiculoController;
use App\Http\Controllers\TarifaController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\ClienteController; // 🔧 <- ESTO FALTABA
use App\Http\Controllers\MovimientoCajaController;
use App\Http\Controllers\PlanAbonadoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UserController;

// Rutas de vehículos
Route::prefix("vehiculo")->middleware('jwt.cookie')->group(function () {
    Route::post("/", [VehiculoController::class, "save"]);
    Route::post("/addrange", [VehiculoController::class, "AddRange"]);

    Route::get("/with-cliente", [VehiculoController::class, "GetWithCliente"]);
    Route::get("/grouped", [VehiculoController::class, "GetGroupVehiculos"]);
    Route::get("/report", [VehiculoController::class, "GetReport"]);

    Route::get("/", [VehiculoController::class, "GetPaginate"]);
    Route::get("/{id}", [VehiculoController::class, "GetById"]);

    Route::delete("/{id}", [VehiculoController::class, "Delete"]);
    Route::delete("/", [VehiculoController::class, "DeleteRange"]);

    Route::put("/{id}", [VehiculoController::class, "Update"]);
});

// ✅ Buscar vehículo por placa
Route::get('/vehiculo/by-placa', [VehiculoController::class, 'GetByPlaca'])->middleware('jwt.cookie');

// ✅ Buscar transacción activa por placa
Route::get('/transaccion/placa/{placa}', [TransaccionController::class, 'GetByPlaca'])->middleware('jwt.cookie');

// Rutas para tipos de vehículos y tarifas
Route::get('/tipos-vehiculo', [TipoVehiculoController::class, 'GetAll']);
Route::get('/tarifa-all', [TarifaController::class, 'GetAll']);

Route::middleware(['jwt.cookie', 'is.admin'])->group(function () {
    Route::post('/tarifa-all', [TarifaController::class, 'Save']);
    Route::put('/tarifa-all/{id}', [TarifaController::class, 'Update']);
    Route::delete('/tarifa-all/{id}', [TarifaController::class, 'Delete']);
});

// Rutas de transacciones
Route::prefix("transaccion")->middleware('jwt.cookie')->group(function () {
    Route::post("/", [TransaccionController::class, "Save"]);
    Route::put("/{id}/cerrar", [TransaccionController::class, "CerrarTransaccion"]);

    Route::get("/", [TransaccionController::class, "GetPaginate"]);
    Route::get("/{id}", [TransaccionController::class, "GetById"]);
    Route::get("/between/fechas", [TransaccionController::class, "GetBetween"]);

    Route::put("/{id}", [TransaccionController::class, "Update"]);
    Route::delete("/{id}", [TransaccionController::class, "Delete"]);
    Route::delete("/", [TransaccionController::class, "DeleteRange"]);
});

// Autenticación de usuarios
Route::post('/user/authenticate', [UserController::class, 'authenticate']);
Route::post('/user/register', [UserController::class, 'register']);

// Crear vehículo desde React si no existe
Route::post('/vehiculo/first-or-create', [VehiculoController::class, 'firstOrCreateByPlaca']);

// ✅ Rutas de búsqueda de cliente
Route::prefix("cliente")->middleware('jwt.cookie')->group(function () {
    Route::get("/by-placa/{placa}", [ClienteController::class, "getByPlaca"]);
    Route::get("/by-documento/{cedula}", [ClienteController::class, "getByDocumento"]);
    Route::get("/by-nombre-apellido", [ClienteController::class, "getByNombreApellido"]);
});

Route::post("/cliente/abonado", [ClienteController::class, "SaveAbonado"]);

Route::post("/cliente/abonado-plan", [ClienteController::class, "SavePlanAbonado"]);

Route::get('/cliente/{id}/plan-activo', [ClienteController::class, 'tienePlanActivo']);

Route::get('/planes-abonado/{clienteId}', [PlanAbonadoController::class, 'getByCliente']);
Route::delete('/planes-abonado/{id}', [PlanAbonadoController::class, 'destroy']);

Route::put('/planes-abonado/{id}', [PlanAbonadoController::class, 'update']);

Route::post('/caja', [MovimientoCajaController::class, 'store']);
Route::get('/caja', [MovimientoCajaController::class, 'index']);

Route::get('/planes-abonado', [PlanAbonadoController::class, 'getByCliente']);

Route::get('/cliente/plan-abonado/buscar', [ClienteController::class, 'buscarPlanPorCodigo']);

Route::get('/cliente/pagos-abonado/buscar', [ClienteController::class, 'buscarPagos']);

Route::get('/cliente/pagos-buscar', [ClienteController::class, 'buscarPagos']);

Route::prefix("pagos")->group(function () {
    Route::post("/buscar", [ClienteController::class, "buscarPagos"]);
});

Route::post('/reportes', [ReporteController::class, 'generar'])->middleware('jwt.cookie');

Route::get('/reportes/tickets', [ReporteController::class, 'listarTickets']);
Route::get('/reportes/salidas', [ReporteController::class, 'salidasVehiculos']);
Route::get('/reportes/estacionados', [ReporteController::class, 'vehiculosEstacionados']);
Route::get('/reportes/pagos', [ReporteController::class, 'pagosTickets']);

Route::middleware('jwt.cookie')->group(function () {
    Route::get('/usuarios', [UserController::class, 'index']);
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy']);
});

Route::middleware(['jwt.cookie'])->prefix('usuarios')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::post('/reportes/pdf', [ReporteController::class, 'generarPDF'])->middleware('jwt.cookie');

Route::middleware(['auth:api', 'jwt.cookie'])->group(function () {
    Route::get('/configuracion', [ConfiguracionController::class, 'index']);
    Route::put('/configuracion', [ConfiguracionController::class, 'update']);
});

Route::get('/ticket/pdf/{ticketId}', [TicketController::class, 'generarPDF']);

