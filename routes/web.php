<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;

// 1. Tela de Boas-Vindas
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 2. Telas de Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Telas de Registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// 4. Tela de Tarefas (Protegida)
Route::get('/tasks', [TasksController::class, 'index'])->middleware('auth')->name('tasks');

// No final do arquivo routes/web.php

// Rotas para Tasks
Route::get('/tasks', [TasksController::class, 'index'])->middleware('auth')->name('tasks');
Route::post('/tasks', [TasksController::class, 'store'])->middleware('auth')->name('tasks.store');
Route::patch('/tasks/{task}', [TasksController::class, 'update'])->middleware('auth')->name('tasks.update');
Route::delete('/tasks/{task}', [TasksController::class, 'destroy'])->middleware('auth')->name('tasks.destroy');



// Rotas para Clientes (acessível apenas por admin logado)
Route::get('/clients/create', [ClientController::class, 'create'])->middleware('auth')->name('clients.create');
Route::post('/clients', [ClientController::class, 'store'])->middleware('auth')->name('clients.store');
Route::get('/acompanhamento', [ClientController::class, 'dashboard'])->middleware('auth')->name('acompanhamento');


// Rotas para Projetos
Route::get('/projects/create', [ProjectController::class, 'create'])->middleware('auth')->name('projects.create');
Route::post('/projects', [ProjectController::class, 'store'])->middleware('auth')->name('projects.store');
Route::patch('/projects/{project}/status', [ProjectController::class, 'updateStatus'])->middleware('auth')->name('projects.updateStatus');
Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->middleware('auth')->name('projects.destroy');

