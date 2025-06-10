@extends('layouts.app')

@section('title', 'Acompanhamento de Projeto')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Acompanhamento de Projetos</h1>
        <p class="mb-6">Olá, {{ Auth::user()->name }}! Aqui está o andamento dos seus projetos.</p>

        <div class="space-y-4">
            @forelse ($projects as $project)
                <div class="border p-4 rounded-lg">
                    <h3 class="font-bold text-lg">{{ $project->name }}</h3>
                    <p class="text-gray-600">{{ $project->description }}</p>
                    <p class="mt-2"><span class="font-semibold">Status:</span> {{ $project->status }}</p>
                </div>
            @empty
                <p>Você ainda não tem nenhum projeto associado.</p>
            @endforelse
        </div>
    </div>
@endsection