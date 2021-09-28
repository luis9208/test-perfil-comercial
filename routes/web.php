<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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

Route::get('/user/nuevo', function(){
    User::create([
        'nombres' => 'admin',
        'apellido_1' => 'admin',
        'apellido_2' => 'admin',
        'cedula' => 'admin',
        'fecha_nacimiento' => '02/08/1998',
        'genero' => 'M',
        'fecha_ingreso' => '02/08/1998',
        'numero_empleado' => 0,
        'cargo' => 'admin',
        'jefe' => null,
        'zona' => 'admin',
        'municipio' => 'admin',
        'departamento' => 'admin',
        'email' => 'admin@admin.com',
        'imagen' => 'admin',
        'password' => Hash::make('admin'),
        'celular' => 'admin',
        'admin' => true,
    ]);
    return redirect('/');
});