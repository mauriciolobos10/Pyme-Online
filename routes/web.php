<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TiendaController;
use \App\Http\Controllers\PreguntaController;
use \App\Http\Controllers\RespuestaController;
use \App\Http\Controllers\CategoriaController;

use App\Http\Controllers\ClienteController;

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

Route::get('/', function () {
    return view('home');
});
/*


*/

Route::resource('categorias', '\App\Http\Controllers\CategoriaController');

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
    NO BORRAR LOS COMENTARIOS Route::group!!!
    Agregar dentro de los grupos las vistas que correspondan a cada rol.

    Dscomentar los grupos cuando se terminen de hacer pruebas o se suba todo a la main branch!
*/

Route::resource('vistacliente', '\App\Http\Controllers\VistaClientesController');




Route::middleware(['CheckBan','auth'])->group(function () {
    
    Route::group(['middleware' => 'CheckRole:admin'], function () {
        Route::get('admin/banear/{id}','\App\Http\Controllers\AdminController@banear');
        Route::get('admin/desbanear/{id}','\App\Http\Controllers\AdminController@desbanear');
        Route::get('admin/verificari','\App\Http\Controllers\AdminController@verificari');
        Route::get('admin/verificare/{id}','\App\Http\Controllers\AdminController@verificare');
        Route::get('admin/verificarb/{id}','\App\Http\Controllers\AdminController@verificarb');
        Route::get('admin/verificarb2/{id}','\App\Http\Controllers\AdminController@verificarb2');
        Route::get('admin/desverificarb/{id}','\App\Http\Controllers\AdminController@deverificarb');
        Route::resource('admin', '\App\Http\Controllers\AdminController');


    });

    Route::group(['middleware' => 'CheckRole:cliente'], function () {

        Route::get('/perfil', [App\Http\Controllers\ClienteController::class, 'verPerfil']);

        Route::resource('clientes',ClienteController::class);
    });

    Route::group(['middleware' => 'CheckRole:tienda'], function () {
        Route::resource('producto', '\App\Http\Controllers\ProductoController');
        Route::resource( 'tags', TagController::class );
        Route::resource('publicacion', '\App\Http\Controllers\PublicacionController');

        Route::resource( 'tienda', TiendaController::class );

        Route::get('publicacion/res/{id}','\App\Http\Controllers\ResenaController@getList')->name('PubliGetRes');
        Route::get('publicacion/score/{id}','\App\Http\Controllers\ResenaController@getScore')->name('PubliGetScore');
        Route::get('/tienda', [App\Http\Controllers\PaginaTiendaController::class, 'index']);
        //Route::get('tienda/{id}', 'App\Http\Controllers\PaginaTiendaController@index');
        //no va aqui, provisional

        Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
        Route::post('/add', [CartController::class, 'add'])->name('cart.store');
        Route::post('/update', [CartController::class, 'update'])->name('cart.update');
        Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');
        Route::post('pregunta', [PreguntaController::class, 'store'])->name('pregunta.store');
        Route::post('respuesta',[RespuestaController::class, 'store'])->name('respuesta.store');
    });

});




