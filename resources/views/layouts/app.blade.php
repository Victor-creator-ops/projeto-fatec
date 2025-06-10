<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Meu App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100">
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center font-bold">Meu Sistema</div>
                <div class="flex items-center">
                    <a href="{{ route('tasks') }}"
                        class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Projetos</a>

                    {{-- Bloco de links visível apenas para o admin --}}
                    @if(Auth::user()->role == 'admin')
                        <a href="{{ route('clients.create') }}"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                            Cadastrar Cliente
                        </a>
                        <a href="{{ route('projects.create') }}"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                            Cadastrar Projeto
                        </a>
                    @endif

                    {{-- Formulário de Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <main class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">@yield('content')</div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

</html>