<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;

// --- ROTAS PÚBLICAS ---
Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// A rota de registro principal é para o primeiro admin
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


// --- ROTAS PROTEGIDAS APENAS PARA O CLIENTE ---
Route::middleware('auth')->group(function () {
    Route::get('/acompanhamento', [ClientController::class, 'dashboard'])->name('acompanhamento');
});


// --- ROTAS PROTEGIDAS APENAS PARA O ADMIN ---
Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard do Admin (Kanban)
    Route::get('/tasks', [TasksController::class, 'index'])->name('tasks');

    // Gerenciamento de Clientes
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

    // Gerenciamento de Projetos
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::patch('/projects/{project}/status', [ProjectController::class, 'updateStatus'])->name('projects.updateStatus');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
});