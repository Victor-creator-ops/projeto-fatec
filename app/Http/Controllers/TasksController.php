<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Projeto;

class TasksController extends Controller
{
    // Exibe o quadro Kanban
    public function index()
    {
        // --- LÓGICA DO KANBAN (JÁ EXISTENTE) ---
        $allProjects = Projeto::with('client')->get();
        $projects = $allProjects->groupBy('status');
        $statuses = ['Planejado', 'Em Análise', 'Em Andamento', 'Aguardando Aprovação', 'Finalizado'];
        $groupedProjects = [];
        foreach ($statuses as $status) {
            $groupedProjects[$status] = $projects->get($status, collect());
        }

        // --- LÓGICA DO NOVO DASHBOARD ---
        // 1. Filtra apenas os projetos que não estão finalizados.
        $openProjects = $allProjects->where('status', '!=', 'Finalizado');

        // 2. Conta quantos projetos estão em aberto.
        $openProjectsCount = $openProjects->count();

        // 3. Soma o custo total desses projetos.
        $totalCost = $openProjects->sum('total_cost');

        // 4. Calcula o lucro total (soma de todos os preços - soma de todos os custos).
        $totalProfit = $openProjects->sum('final_price') - $totalCost;

        // --- ENVIO DOS DADOS PARA A VIEW ---
        return view('tasks', [
            'projectsByStatus' => $groupedProjects, // Para o Kanban
            'statuses' => $statuses,               // Para o Kanban
            'openProjectsCount' => $openProjectsCount, // Para o Dashboard
            'totalCost' => $totalCost,             // Para o Dashboard
            'totalProfit' => $totalProfit,         // Para o Dashboard
        ]);
    }

    // Salva uma nova tarefa
    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);

        Auth::user()->tasks()->create([
            'title' => $request->title,
            'status' => 'pedido' // Status inicial
        ]);

        return redirect()->route('tasks');
    }

    // Atualiza o status de uma tarefa (via AJAX)
    public function update(Request $request, Task $task)
    {
        // Garante que o usuário só pode atualizar suas próprias tarefas
        if ($task->user_id !== Auth::id()) {
            return response()->json(['message' => 'Não autorizado.'], 403);
        }

        $request->validate(['status' => 'required|string']);

        $task->update(['status' => $request->status]);

        return response()->json(['message' => 'Status atualizado com sucesso!']);
    }

    public function destroy(Task $task)
    {
        // Autorização: Garante que o usuário só pode excluir suas próprias tarefas
        if ($task->user_id !== Auth::id()) {
            return response()->json(['message' => 'Não autorizado.'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Tarefa excluída com sucesso!']);
    }
}