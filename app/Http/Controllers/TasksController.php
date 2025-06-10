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

        // Pega todos os projetos e seus clientes associados, agrupados por status
        $projects = Projeto::with('client')->get()->groupBy('status');

        $statuses = ['Planejado', 'Em Análise', 'Em Andamento', 'Aguardando Aprovação', 'Finalizado'];

        $groupedProjects = [];
        foreach ($statuses as $status) {
            $groupedProjects[$status] = $projects->get($status, collect());
        }

        return view('tasks', ['projectsByStatus' => $groupedProjects, 'statuses' => $statuses]);
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