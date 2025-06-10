@extends('layouts.app')

@section('title', 'Quadro de Projetos')

@section('content')
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Resumo Geral</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-100 p-6 rounded-lg shadow">
                <h3 class="text-gray-600 font-semibold">Projetos em Aberto</h3>
                <p class="text-3xl font-bold text-blue-800 mt-2">{{ $openProjectsCount }}</p>
            </div>

            <div class="bg-red-100 p-6 rounded-lg shadow">
                <h3 class="text-gray-600 font-semibold">Custo Total (Abertos)</h3>
                <p class="text-3xl font-bold text-red-800 mt-2">
                    {{ 'R$ ' . number_format($totalCost, 2, ',', '.') }}
                </p>
            </div>

            <div class="bg-green-100 p-6 rounded-lg shadow">
                <h3 class="text-gray-600 font-semibold">Lucro Estimado (Abertos)</h3>
                <p class="text-3xl font-bold text-green-800 mt-2">
                    {{ 'R$ ' . number_format($totalProfit, 2, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
    <div class="p-8 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Quadro de Projetos (Kanban)</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @php
                $statusLabels = [
                    'Planejado' => 'Planejado',
                    'Em Análise' => 'Em Análise',
                    'Em Andamento' => 'Em Andamento',
                    'Aguardando Aprovação' => 'Aguardando Aprovação',
                    'Finalizado' => 'Finalizado'
                ];
            @endphp

            @foreach ($statuses as $status)
                <div class="bg-gray-100 p-3 rounded-lg">
                    <h3 class="font-bold mb-3 text-center text-gray-700">{{ $statusLabels[$status] }}</h3>

                    <div class="project-column space-y-3 min-h-[200px]" data-status="{{ $status }}">
                        @foreach ($projectsByStatus[$status] as $project)
                            <div class="project-card p-3 bg-white rounded-lg shadow-sm flex justify-between items-center"
                                data-project-id="{{ $project->id }}">
                                <div class="project-info flex-grow cursor-grab">
                                    <p class="font-semibold">{{ $project->name }}</p>
                                    <p class="text-sm text-gray-600">Cliente: {{ $project->client->name }}</p>
                                    <p class="text-xs text-green-700 font-bold">Valor:
                                        {{ 'R$ ' . number_format($project->final_price, 2, ',', '.') }}
                                    </p>
                                </div>
                                <button class="delete-project-btn text-red-500 hover:text-red-700 font-bold ml-2 px-2"
                                    data-project-id="{{ $project->id }}">
                                    &times;
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Função para configurar os botões de exclusão
            function setupDeleteButtons() {
                document.querySelectorAll('.delete-project-btn').forEach(button => {
                    // Remove eventuais listeners antigos para evitar duplicação
                    button.replaceWith(button.cloneNode(true));
                });

                document.querySelectorAll('.delete-project-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const projectId = this.dataset.projectId;

                        if (confirm('Tem certeza que deseja excluir este projeto?')) {
                            fetch(`/projects/${projectId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                }
                            })
                                .then(response => {
                                    if (response.ok) {
                                        this.closest('.project-card').remove();
                                    } else {
                                        alert('Ocorreu um erro ao excluir o projeto.');
                                    }
                                })
                                .catch(error => console.error('Erro:', error));
                        }
                    });
                });
            }

            // Lógica do Drag and Drop (Kanban)
            const columns = document.querySelectorAll('.project-column');
            columns.forEach(column => {
                new Sortable(column, {
                    group: 'kanban',
                    animation: 150,
                    handle: '.project-info', // Área de arrastar é a div com as informações
                    onEnd: function (evt) {
                        const itemEl = evt.item;
                        const newStatus = evt.to.dataset.status;
                        const projectId = itemEl.dataset.projectId;

                        fetch(`/projects/${projectId}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ status: newStatus })
                        })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data.message);
                                // Reconfigura os botões de exclusão após a reordenação do DOM pelo SortableJS
                                setupDeleteButtons();
                            })
                            .catch(error => console.error('Erro:', error));
                    }
                });
            });

            // Configura os botões de exclusão quando a página carrega
            setupDeleteButtons();
        });
    </script>
@endsection