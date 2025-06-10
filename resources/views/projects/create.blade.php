@extends('layouts.app')

@section('title', 'Cadastrar Novo Projeto')

@section('content')
    <div class="w-full max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Cadastrar Novo Projeto</h1>
        <form method="POST" action="{{ route('projects.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700">Nome do Projeto</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-gray-700">Descrição</label>
                <textarea name="description" class="w-full px-4 py-2 border rounded-lg"></textarea>
            </div>
            <div>
                <label class="block text-gray-700">Atribuir ao Cliente</label>
                <select name="client_id" required class="w-full px-4 py-2 border rounded-lg">
                    <option value="">Selecione um cliente</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700">Estimativa de Tempo (em horas)</label>
                <input type="number" id="estimated_hours" name="estimated_hours" required
                    class="w-full px-4 py-2 border rounded-lg" min="1">
            </div>

            <div class="bg-gray-100 p-4 rounded-lg space-y-2">
                <p>Custo Estimado: <strong id="display_cost">R$ 0,00</strong></p>
                <p>Preço Final (com lucro): <strong id="display_price" class="text-green-600">R$ 0,00</strong></p>
            </div>

            <div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Salvar
                    Projeto</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hoursInput = document.getElementById('estimated_hours');
            const costDisplay = document.getElementById('display_cost');
            const priceDisplay = document.getElementById('display_price');

            // Estes valores DEVEM ser os mesmos do seu Controller
            const costPerHour = 50.00;
            const profitMargin = 0.30; // 30%

            hoursInput.addEventListener('input', function () {
                const hours = parseInt(this.value) || 0;

                if (hours > 0) {
                    const totalCost = hours * costPerHour;
                    const profit = totalCost * profitMargin;
                    const finalPrice = totalCost + profit;

                    // Formata para moeda brasileira
                    costDisplay.textContent = totalCost.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                    priceDisplay.textContent = finalPrice.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                } else {
                    costDisplay.textContent = 'R$ 0,00';
                    priceDisplay.textContent = 'R$ 0,00';
                }
            });
        });
    </script>
@endsection