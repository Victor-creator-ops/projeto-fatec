@extends('layouts.app')

@section('title', 'Editar Projeto')

@section('content')
    <div class="w-full max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Editar Projeto: {{ $project->name }}</h1>

        <form method="POST" action="{{ route('projects.update', $project->id) }}" class="space-y-4">
            @csrf
            @method('PATCH') {{-- Informa ao Laravel que esta é uma requisição de atualização --}}

            <div>
                <label class="block text-gray-700">Nome do Projeto</label>
                <input type="text" name="name" value="{{ old('name', $project->name) }}" required
                    class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">Descrição</label>
                <textarea name="description"
                    class="w-full px-4 py-2 border rounded-lg">{{ old('description', $project->description) }}</textarea>
            </div>
            <div>
                <label class="block text-gray-700">Atribuir ao Cliente</label>
                <select name="client_id" required class="w-full px-4 py-2 border rounded-lg">
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" @if($client->id == old('client_id', $project->client_id)) selected
                        @endif>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700">Estimativa de Tempo (em horas)</label>
                <input type="number" id="estimated_hours" name="estimated_hours"
                    value="{{ old('estimated_hours', $project->estimated_hours) }}" required
                    class="w-full px-4 py-2 border rounded-lg" min="1">
            </div>

            <div class="bg-gray-100 p-4 rounded-lg space-y-2">
                <p>Custo Estimado: <strong id="display_cost">R$ 0,00</strong></p>
                <p>Preço Final (com lucro): <strong id="display_price" class="text-green-600">R$ 0,00</strong></p>
            </div>

            <div>
                <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600">Salvar
                    Alterações</button>
            </div>
        </form>
    </div>

    {{-- O mesmo script da página de criação para o cálculo em tempo real --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hoursInput = document.getElementById('estimated_hours');
            const costDisplay = document.getElementById('display_cost');
            const priceDisplay = document.getElementById('display_price');
            const costPerHour = 50.00;
            const profitMargin = 0.30;

            function calculatePrice() {
                const hours = parseInt(hoursInput.value) || 0;
                if (hours > 0) {
                    const totalCost = hours * costPerHour;
                    const finalPrice = totalCost * (1 + profitMargin);
                    costDisplay.textContent = totalCost.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                    priceDisplay.textContent = finalPrice.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                } else {
                    costDisplay.textContent = 'R$ 0,00';
                    priceDisplay.textContent = 'R$ 0,00';
                }
            }

            hoursInput.addEventListener('input', calculatePrice);

            // Calcula o preço inicial ao carregar a página
            calculatePrice();
        });
    </script>
@endsection