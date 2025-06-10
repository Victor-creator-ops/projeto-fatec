@extends('layouts.app')

@section('title', 'Cadastrar Novo Cliente')

@section('content')
    <div class="w-full max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Cadastrar Novo Cliente</h1>
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('clients.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700">Nome do Cliente</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-700">Senha</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none">
            </div>
            <div>
                <label class="block text-gray-700">Confirmar Senha</label>
                <input type="password" name="password_confirmation" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none">
            </div>
            <div>
                <button type="submit"
                    class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition">Cadastrar
                    Cliente</button>
            </div>
        </form>
    </div>
@endsection