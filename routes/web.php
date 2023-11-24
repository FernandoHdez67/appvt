<?php

use App\Http\Controllers\ModulosController;
use App\Http\Controllers\Productos as ControllersProductos;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CuentasController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\ProductoDetalle;
use App\Http\Controllers\CarrucelController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\UsuariosContoller;
use App\Models\Usuarios;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RespaldoController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\CarrucelController::class, 'carrucel'])->name('inicio');

Route::post('/logoute', [App\Http\Controllers\AuthController::class, 'logout'])->name('logoute');



Route::get('/agregar-pregunta', function () {
    return view('admin.insertar_ayuda');
})->name('agregar-pregunta');

Route::get('/ayudaa', [App\Http\Controllers\AyudaController::class, 'adminayuda'])
    ->middleware('auth')
    ->name('ayudaa');

Route::post('/agregar-pregunta', [App\Http\Controllers\AyudaController::class, 'store'])->name('insertar.pregunta');
Route::put('/ayudaa/{idpregunta}', [App\Http\Controllers\AyudaController::class, 'update'])->name('ayuda.update');
Route::get('/ayudaa/{idpregunta}/edit', [App\Http\Controllers\AyudaController::class, 'edit'])->name('ayuda.edit');
Route::delete('/ayudaa/{idpregunta}', [App\Http\Controllers\AyudaController::class, 'destroy'])->name('destroy.ayuda');
Route::get('/ayuda', [App\Http\Controllers\AyudaController::class, 'ayudamostrar'])->name('ayuda');


Route::get('/registro-usuario', [App\Http\Controllers\UsuariosContoller::class, 'pregunta'])->name('registro');






Route::get('/iniciar', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('iniciar');

Route::post('/iniciar', [App\Http\Controllers\AuthController::class, 'login'])->name('iniciar.sesion');


Route::post('/registrar-usuario', [App\Http\Controllers\UsuariosContoller::class, 'store'])->name('registrar.usuario');


// Ruta para cargar el formulario de nueva cita
Route::get('/citas', [App\Http\Controllers\CitasController::class, 'horario'])->name('citas');


// Ruta para procesar los datos del formulario y almacenar la nueva cita
Route::post('/citas', [App\Http\Controllers\CitasController::class, 'store'])->name('registro.citas');
//Route::post('/citas', [App\Http\Controllers\CitasController::class, 'store'])->name('registro.citas')->middleware('auth');





Route::get('/marcas', [App\Http\Controllers\MarcaController::class, 'marcas'])
    ->middleware('auth', 'verified')
    ->name('marcas');

Route::post('/marcas', [App\Http\Controllers\MarcaController::class, 'store'])->name('insertar.marca');
Route::put('/marcas/{idmarca}', [App\Http\Controllers\MarcaController::class, 'update'])->name('marca.update');
Route::get('/marcas/{idmarca}/edit', [App\Http\Controllers\MarcaController::class, 'edit'])->name('marca.edit');
Route::delete('/marcas/{idmarca}', [App\Http\Controllers\MarcaController::class, 'destroy'])->name('destroy.marca');

Route::get('/categorias', [App\Http\Controllers\CategoriaController::class, 'categorias'])
    ->middleware('auth', 'verified')
    ->name('categorias');

Route::post('/categorias', [App\Http\Controllers\CategoriaController::class, 'store'])->name('insertar.categoria');
Route::put('/categorias/{idcategoria}', [App\Http\Controllers\CategoriaController::class, 'update'])->name('categoria.update');
Route::get('/categorias/{idcategoria}/edit', [App\Http\Controllers\CategoriaController::class, 'edit'])->name('categoria.edit');
Route::delete('/categorias/{idcategoria}', [App\Http\Controllers\CategoriaController::class, 'destroy'])->name('destroy.categoria');




// Ruta para procesar los datos del formulario y almacenar el nuevo producto

Route::get('/nuevo-servicio', function () {
    return view('admin.insertar_servicio');
})->name('nuevo-servicio');

// Ruta para procesar los datos del formulario y almacenar el nuevo producto
Route::post('/insertar-servicio', [App\Http\Controllers\ServiciosController::class, 'store'])->name('insertar.servicio');



Route::post('/contacto', [App\Http\Controllers\ContactoController::class, 'enviarCorreo'])->name('enviar');
//TERMINA RUTAS SOLO PARA RETORNAR VISTAR DE LOS MODULOS

//INICIA RUTAS SOLO PARA RETORNAR VISTAR DE LOS MODULOS METODO GET
Route::get('/productos', [App\Http\Controllers\ProductoController::class, 'productos'])->name('productos');
Route::get('/producto', [App\Http\Controllers\ProductoController::class, 'buscar'])->name('productos.buscar');

Route::get('/product', [App\Http\Controllers\ProductoController::class, 'buscardos'])->name('prod.buscar');


Route::get('/servicios', [App\Http\Controllers\ServiciosController::class, 'servicios'])->name('servicios');
Route::get('/productos/detalles/{idproducto}', [ProductoDetalle::class, 'detalles'])->name('detalles');

//TERMINA RUTAS SOLO PARA RETORNAR VISTAR DE LOS MODULOS METODO GET



// INICIA RUTAS PARA LA ADMINISTRACION
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/editarperfil', [App\Http\Controllers\PerfilController::class, 'perfil'])
    ->middleware('auth', 'verified')
    ->name('perfil');

Route::put('/editarperfil/update', [App\Http\Controllers\PerfilController::class, 'update'])->name('perfiluser.update');
Route::get('/editarperfil/edit', [App\Http\Controllers\PerfilController::class, 'edit'])->name('perfiluser.edit');

Route::get('/configuracion', [App\Http\Controllers\ConfiguracionController::class, 'adminsomos'])
    ->middleware('auth', 'verified')
    ->name('configuracion');


Route::put('/configuracion/{idconfiguracion}', [App\Http\Controllers\ConfiguracionController::class, 'update'])->name('somos.update');
Route::get('/configuracion/{idconfiguracion}/edit', [App\Http\Controllers\ConfiguracionController::class, 'edit'])->name('somos.edit');

Route::get('/somos', [App\Http\Controllers\ConfiguracionController::class, 'somos'])->name('somos');



Route::get('/products', [App\Http\Controllers\ProductoControllerAdmin::class, 'productos'])
    ->middleware('auth', 'verified')
    ->name('products');

Route::delete('/products', [App\Http\Controllers\ProductoControllerAdmin::class, 'eliminarVarios'])->name('eliminar-varios.productos');

Route::get('/citass', [App\Http\Controllers\CitasController::class, 'citas'])
    ->middleware('auth', 'verified')
    ->name('citass');

Route::delete('/citass/{id}', [App\Http\Controllers\CitasController::class, 'destroy'])->name('destroy.cita');
Route::put('/citass/{id}', [App\Http\Controllers\CitasController::class, 'update'])->name('update.cita');
Route::get('/citass/{id}/edit', [App\Http\Controllers\CitasController::class, 'edit'])->name('edit.cita');


Route::get('/services', [App\Http\Controllers\ServiciosController::class, 'adminservicios'])
    ->middleware('auth', 'verified')
    ->name('services');

Route::put('/services/{idservicio}', [App\Http\Controllers\ServiciosController::class, 'update'])->name('servicios.update');

Route::get('/services/{idservicio}/edit', [App\Http\Controllers\ServiciosController::class, 'edit'])->name('servicios.edit');

Route::delete('/services/{idservicio}', [App\Http\Controllers\ServiciosController::class, 'destroy'])->name('destroy.servicios');

Route::get('/users', [App\Http\Controllers\UsuariosControllerAdmin::class, 'usuarios'])
    ->middleware('auth', 'verified')
    ->name('users');


Route::delete('/products/{idproducto}', [App\Http\Controllers\ProductoControllerAdmin::class, 'destroy'])->name('destroy.producto');
Route::get('/nuevo-producto', [App\Http\Controllers\ProductoControllerAdmin::class, 'marcacategoria'])->name('nuevo-producto');
Route::post('/products', [App\Http\Controllers\ProductoControllerAdmin::class, 'store'])->name('insertar.producto');
Route::put('/products/{idproducto}', [App\Http\Controllers\ProductoControllerAdmin::class, 'update'])->name('productos.update');
Route::get('/products/{idproducto}/edit', [App\Http\Controllers\ProductoControllerAdmin::class, 'edit'])->name('productos.edit');


use App\Http\Controllers\RecuperarContrasenaController;

Route::get('/recuperarcontrasena', [RecuperarContrasenaController::class, 'recuperar'])->name('recuperar.contrasena');

Route::post('/recuperarcontrasena', [RecuperarContrasenaController::class, 'enviarLink'])->name('recuperar-contrasena.enviarLink');
Route::get('/recuperarcontrasena/nueva-contrasena/{token}', [RecuperarContrasenaController::class, 'nuevaContrasena'])->name('recuperar-contrasena.nuevaContrasena');
Route::post('/recuperarcontrasena/actualizar-contrasena', [RecuperarContrasenaController::class, 'actualizarContrasena'])->name('recuperar-contrasena.actualizarContrasena');



Route::get('/eventos', [App\Http\Controllers\CitasController::class, 'obtener_citas'])->name('eventos');


Route::get('/agregar-imagen', function () {
    return view('admin.insertar_carrucel');
})->name('agregar-imagen');

Route::get('/politicas', function () {
    return view('modulos.politicas');
})->name('politicas');

Route::get('/contacto', function () {
    return view('modulos.contacto');
})->name('contacto');



Route::get('/carruseladmin', [App\Http\Controllers\CarrucelController::class, 'admincarrucel'])
    ->middleware('auth', 'verified')
    ->name('carruseladmin');

Route::post('/agregar-imagen', [App\Http\Controllers\CarrucelController::class, 'store'])->name('nueva-imagen');
Route::delete('/carruseladmin/{idimagen}', [App\Http\Controllers\CarrucelController::class, 'destroy'])->name('destroy.imagen');
Route::delete('/carruseladmin', [App\Http\Controllers\CarrucelController::class, 'eliminarVarios'])->name('eliminar-varios.imagen');
Route::put('/carruseladmin/{idimagen}', [App\Http\Controllers\CarrucelController::class, 'update'])->name('imagen.update');
Route::get('/carruseladmin/{idimagen}/edit', [App\Http\Controllers\CarrucelController::class, 'edit'])->name('imagen.edit');

// TERMINA RUTAS PARA LA ADMINISTRACION




//RUTAS DE PROYECTO DE COMPAÑIAS (OMITIR)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';



Route::get('/iniciarsesion', ['App\Http\Controllers\Auth\LoginController', 'showLoginForm'])->name('iniciarsesion');

Route::post('/iniciarsesion', ['App\Http\Controllers\Auth\LoginController', 'login']);


Route::resource('companies', CompanyController::class);

Route::get('/registerrr', 'RegisterController@showRegistrationForm');
Route::post('/registerrr', 'RegisterController@register')->name('registerrr');


//Respaldo de la base de datos
Route::get('/respaldo', [RespaldoController::class, 'index'])->name('respaldo');
Route::get('backup', [RespaldoController::class, 'backup'])->name('respaldo.backup');
Route::post('/restore-db', [RespaldoController::class, 'restore'])->name('restore-db');
Route::post('/eliminar-bd', [RespaldoController::class, 'eliminarBD'])->name('eliminar-bd');




use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Route::get('/admin', [App\Http\Controllers\Auth\AdminController::class, 'index'])->middleware(['auth', 'admin']);
// Route::get('/veterinario', [App\Http\Controllers\Auth\VeterinarioController::class, 'index'])->middleware(['auth', 'veterinario']);
// Route::get('/enfermero', [App\Http\Controllers\Auth\EnfermeroController::class, 'index'])->middleware(['auth', 'enfermero']);

// Muestra el formulario de correo electrónico para enviar el enlace de restablecimiento de contraseña
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Enviar el correo electrónico con el enlace de restablecimiento de contraseña
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Muestra el formulario para restablecer la contraseña
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

// Restablecer la contraseña
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

//INICIAR SESION CON GOOGLE
Route::get('/login-google', function () {
    return Socialite::driver('google')->redirect();
});


Route::get('/google-callback', function () {
    $user_google = Socialite::driver('google')->user();

    $user = User::updateOrCreate([
        'external_id' => $user_google->id,

    ], [
        'name' => $user_google->name,
        'email' => $user_google->email,
    ]);

    Auth::login($user);

    return redirect('/dashboard');
});



//CARRITO DE COMPRAS

Route::get('/carrito', [App\Http\Controllers\CarritoController::class,'index'])->name('carrito.index');
Route::post('/carrito/agregar', [App\Http\Controllers\CarritoController::class,'agregarProducto'])->name('carrito.agregar');
Route::delete('/carrito/eliminar/{idcarrito}', [App\Http\Controllers\CarritoController::class, 'eliminarProducto'])->name('carrito.eliminar');
Route::delete('/carrito/limpiar', [App\Http\Controllers\CarritoController::class, 'limpiarCarrito'])->name('carrito.limpiar');


//PREDICCIONES
Route::get('/prediccion', function () {
    return view('prediccion.prediction_form');
});

Route::post('/pred', [App\Http\Controllers\PredictionController::class,'getP rediction'])->name('prediccion');


Route::get('/offline', function () {
    return view('vendor.laravelpwa.offline');
});

// routes/web.php

// Route::get('/', function () {
//     return view('splashscreen');
// })->name('splash');

//Route::get('/encuesta', [App\Http\Controllers\CitasController::class, 'encuesta'])->name('encuesta');



Route::get('/perfil/editar', [App\Http\Controllers\PerfilUsuario::class,'editar'])->name('perfilusuario.editar');
Route::put('/perfil/actualizar', [App\Http\Controllers\PerfilUsuario::class,'actualizar'])->name('perfilusuario.actualizar');

Route::get('/perfil/editar', [App\Http\Controllers\PerfilUsuario::class,'editar'])->name('perfilusuario.editar');

Route::get('/miscitas', [App\Http\Controllers\CitasController::class,'citasUsuario'])->name('miscitas');


//Pagos

Route::post('/session', [App\Http\Controllers\CarritoController::class,'session'])->name('session');
Route::get('/success', [App\Http\Controllers\CarritoController::class,'success'])->name('success');

Route::post('/sessionproduct', [App\Http\Controllers\CarritoController::class,'sessionproduct'])->name('sessionproduct');

Route::get('/usocamara', [App\Http\Controllers\CamaraController::class,'usocamara'])->name('usocamara');
