<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    // Mostra o formulário de cadastro de cliente
    public function create()
    {
        return view('clients.create');
    }

    // Salva o novo cliente no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cliente', // Define o papel como 'cliente'
        ]);

        // Redireciona de volta para o dashboard do admin com uma mensagem
        return redirect()->route('tasks')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function dashboard()
    {
        if (Auth::user()->role !== 'cliente') {
            abort(403, 'Acesso não autorizado.');
        }

        // Pega os projetos associados a este cliente
        $projects = Auth::user()->projetos()->get();

        return view('acompanhamento', ['projects' => $projects]);
    }
}