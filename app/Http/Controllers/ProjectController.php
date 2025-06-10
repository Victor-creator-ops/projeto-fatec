<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // Mostra o formulário para criar um novo projeto
    public function create()
    {
        // Pega todos os usuários com o papel 'cliente' para listar no formulário
        $clients = User::where('role', 'cliente')->get();
        return view('projects.create', ['clients' => $clients]);
    }

    // Salva o novo projeto no banco de dados
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'client_id' => 'required|exists:users,id',
            'estimated_hours' => 'required|integer|min:1', // Valida as horas
        ]);

        // --- LÓGICA DE CÁLCULO ---
        $costPerHour = 50.00;    // Seu custo por hora (ex: R$ 50)
        $profitMargin = 0.30; // Sua margem de lucro (ex: 30%)

        $estimatedHours = $request->estimated_hours;
        $totalCost = $estimatedHours * $costPerHour;
        $profit = $totalCost * $profitMargin;
        $finalPrice = $totalCost + $profit;
        // --- FIM DA LÓGICA ---

        Projeto::create([
            'name' => $request->name,
            'description' => $request->description,
            'client_id' => $request->client_id,
            'estimated_hours' => $estimatedHours,
            'total_cost' => $totalCost,
            'final_price' => $finalPrice,
        ]);

        return redirect()->route('tasks')->with('success', 'Projeto cadastrado com sucesso!');
    }

    public function updateStatus(Request $request, Projeto $project)
    {
        // Validação básica
        $request->validate(['status' => 'required|string']);

        $project->update(['status' => $request->status]);

        return response()->json(['message' => 'Status do projeto atualizado!']);
    }

    public function destroy(Projeto $project)
    {
        // Garante que apenas o admin pode excluir projetos
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Não autorizado.'], 403);
        }

        $project->delete();

        return response()->json(['message' => 'Projeto excluído com sucesso!']);
    }
}