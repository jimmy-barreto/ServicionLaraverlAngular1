<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('inicio');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('Admin/users','Admin\UserController')->middleware('can:administrar-usuarios');

Route::resource('proyecto','ProyectoController');

Route::resource('desarrollador','DesarrolladorController');

Route::post('proyecto/guardar','ProyectoController@store');

Route::get('proyectos/','ProyectoController@listar');