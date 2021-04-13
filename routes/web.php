<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

//Auth::routes();

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'EmpresaController@index')->name('dashboard');

    // Empresa
    Route::get('/empresas', 'EmpresaController@index');//->middleware('auth');
    Route::post('/empresas/store', 'EmpresaController@store');
    Route::put('/empresas/edit', 'EmpresaController@update');
    Route::delete('/empresas/destroy', 'EmpresaController@destroy');
    // Empleado
    Route::get('/empleados', 'EmpleadoController@index')->middleware('auth');
    Route::post('/empleados/create', 'EmpleadoController@create');
    Route::put('/empleados/edit', 'EmpleadoController@update');
    Route::delete('/empleados/destroy', 'EmpleadoController@destroy');

    Route::get('index', 'LocalizationController@index');
    Route::get('change/lang', 'LocalizationController@lang_change')->name('LangChange');
});

Route::get('locale/{locale}', function($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});