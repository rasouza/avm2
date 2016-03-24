<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['middleware' => 'auth','uses' => 'HomeController@index'])->name('home');

// Authentication
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@authenticate');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Administração
Route::group(['prefix' => 'administracao', 'middleware' => 'auth'], function() {
    Route::resource('filiais', 'FiliaisController');
    Route::resource('precos', 'PrecosController');
    Route::resource('funcionarios', 'FuncionariosController');
    Route::resource('cargos', 'CargosController');
    Route::resource('vendedores', 'VendedoresController');
});

// Comercial
Route::group(['prefix' => 'comercial', 'middleware' => 'auth'], function() {
    Route::resource('clientes', 'ClientesController');
    Route::resource('fichas', 'FichasController');
});

// Operacional
Route::group(['prefix' => 'operacional', 'middleware' => 'auth'], function() {
    Route::resource('agenda', 'AgendaController');
    Route::resource('os', 'OsController');
    Route::resource('ambientes', 'AmbientesController');
    Route::resource('processos', 'ProcessosController');
    Route::get('relatorios', 'RelatoriosController@index');

    Route::group(['prefix' => 'processo', 'middleware' => 'auth'], function() {

        Route::post('{os}/parse', 'ProcessoController@parse');

        Route::get('{os}', 'ProcessoController@principal');
        Route::match(['get', 'post'], '{os}/detalhe', 'ProcessoController@detalhe');
        Route::get('{os}/duplicidades', 'ProcessoController@duplicidades');
        Route::get('{os}/restantes', 'ProcessoController@restantes');
        Route::match(['get', 'post'], '{os}/auditoria', 'ProcessoController@auditoria');
        Route::get('{os}/operadores', 'ProcessoController@operadores');
        Route::get('{os}/divergencia', 'ProcessoController@divergencia');
        Route::get('{os}/finalizar', 'ProcessoController@finalizar');
        Route::get('{os}/excluir/{setor}', 'ProcessoController@destroy');
    });
});


