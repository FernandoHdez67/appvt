<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/productos', [App\Http\Controllers\ProductosController::class,'index']); //muestra todos los registros
Route::get('/productos-all', [App\Http\Controllers\ProductosController::class,'productos']); //muestra todos los registros
Route::get('productos/{idproducto}',[App\Http\Controllers\ProductosController::class,'getCategoriaxid']);//Buscar por id
Route::post('/productos', [App\Http\Controllers\ProductosController::class,'store']); // crea un registro
Route::put('/productos/{idproducto}', [App\Http\Controllers\ProductosController::class,'update']); // actualiza un registro
Route::delete('/productos/{idproducto}', [App\Http\Controllers\ProductosController::class,'destroy']); //elimina un registro

Route::get('/citas', [App\Http\Controllers\CitassController::class,'citas']); //muestra todos los registros
Route::get('/citasss', [App\Http\Controllers\CitassController::class,'index']); //muestra todos los registros pero con la hora con ID
Route::get('citas/{id}',[App\Http\Controllers\CitassController::class,'getCategoriaxid']);//Buscar por id
Route::get('citas/fecha/{fecha}',[App\Http\Controllers\CitassController::class,'getCitasPorFecha']);//Buscar por fecha
Route::post('/citas', [App\Http\Controllers\CitassController::class,'store']); // crea un registro
Route::put('/citas/{id}', [App\Http\Controllers\CitassController::class,'update']); // actualiza un registro
Route::delete('/citas/{id}', [App\Http\Controllers\CitassController::class,'destroy']); //elimina un registro por id

Route::get('/fechas', [App\Http\Controllers\CitassController::class,'buscarFechas']); //Buscar por rango de fechas
Route::get('/buscar-fechas', [App\Http\Controllers\CitassController::class,'buscaFechaEspecifica']); //Buscar por fecha especifica
Route::get('/cita', [App\Http\Controllers\CitassController::class,'buscaFechaPorId']); //Buscar por Id
Route::get('/citas-del-dia', [App\Http\Controllers\CitassController::class,'citasDeHoy']); //Mostrar citas del dia de hoy
Route::get('/citas-de-manana', [App\Http\Controllers\CitassController::class,'citasDeManana']); //Mostrar citas del dia de mañana
Route::get('/cita-mes', [App\Http\Controllers\CitassController::class,'citasPorMesNumero']); //Mostrar citas por numero de mes
Route::get('/cita-del-mes', [App\Http\Controllers\CitassController::class,'citasPorMesNombre']); //Mostrar citas por nombre del mes
Route::get('/citas-dia', [App\Http\Controllers\CitassController::class,'citasPorDiaDelMes']); //Mostrar citas por dia de la semana
Route::delete('/eliminar-cita', [App\Http\Controllers\CitassController::class,'eliminarCitaPorFechaHora']); //elimina un registro por fecha y hora

Route::get('/horarios', [App\Http\Controllers\CitassController::class,'horariosDisponibles']); //Mostrar citas por dia de la semana

Route::get('/servicios', [App\Http\Controllers\ServiciossController::class,'index']); //muestra todos los registros
Route::get('servicios/{idservicios}',[App\Http\Controllers\ServiciossController::class,'getServicioxid']);//Buscar por id
Route::post('/servicios', [App\Http\Controllers\ServiciossController::class,'store']); // crea un registro
Route::put('/servicios/{idservicios}', [App\Http\Controllers\ServiciossController::class,'update']); // actualiza un registro
Route::delete('/servicios/{idservicios}', [App\Http\Controllers\ServiciossController::class,'destroy']); //elimina un registro

Route::get('/servicio-campos', [App\Http\Controllers\ServiciossController::class,'buscarServiciotodosloscampos']); //muestra todos los campos de un servicio
Route::get('/servicio-ccampo', [App\Http\Controllers\ServiciossController::class,'buscarServicioconcampo']); //muestra el nombre del servico con su campo
Route::get('/servicio-scampo', [App\Http\Controllers\ServiciossController::class,'buscarServiciosincampo']); //muestra el nombre del servico sin su campo
Route::get('/servicios-all', [App\Http\Controllers\ServiciossController::class,'servicios']); //muestra el nombre del servico sin su campo


Route::get('/carrusel', [App\Http\Controllers\CarruselController::class,'index']); //muestra todos los registros
Route::get('/ayuda', [App\Http\Controllers\AyudaController::class,'apipregunta']); //muestra todos los registros

Route::get('/categorias', [App\Http\Controllers\CategoriaController::class,'listacategorias']); //muestra todos los registros

Route::post('/crearusuario', [App\Http\Controllers\UsuariosContoller::class,'crearusuario']);

Route::get('/usuariosapi', [App\Http\Controllers\UsuariosContoller::class,'usuariosapi']);


// Rutas de autenticación
Route::post('/loginusuario', [App\Http\Controllers\LoginApiController::class,'login']);

use App\Http\Controllers\CarritoController;


Route::post('/carrito/agregar', [CarritoController::class, 'agregarProducto']);
Route::delete('/carrito/eliminar/{idcarrito}', [CarritoController::class, 'eliminarProducto']);
Route::get('/carrito/limpiar', [CarritoController::class, 'limpiarCarrito']);
Route::get('/carrito', [CarritoController::class, 'getCarrito']);
Route::get('/carrito/comprarahora', [CarritoController::class, 'comprarahora']);
Route::post('/carrito/session', [CarritoController::class, 'session']);
Route::get('/carrito/success', [CarritoController::class, 'success']);




