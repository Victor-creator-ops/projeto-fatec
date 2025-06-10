<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Registrar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-800 min-h-screen flex items-center justify-center text-white">
    <div class="w-full max-w-md bg-gray-900 bg-opacity-50 p-8 rounded-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Crie sua Conta</h2>
        @if ($errors->any())
            <div class="bg-red-500 p-3 rounded">
                <ul class="list-disc list-inside">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div> @endif
        <form method="POST" action="{{ route('register') }}" class="space-y-4"> @csrf
            <input type="text" name="name" placeholder="Nome" required
                class="w-full px-4 py-2 bg-transparent border-b-2 focus:outline-none">
            <input type="email" name="email" placeholder="Email" required
                class="w-full px-4 py-2 bg-transparent border-b-2 focus:outline-none">
            <input type="password" name="password" placeholder="Senha" required
                class="w-full px-4 py-2 bg-transparent border-b-2 focus:outline-none">
            <input type="password" name="password_confirmation" placeholder="Confirmar Senha" required
                class="w-full px-4 py-2 bg-transparent border-b-2 focus:outline-none">
            <button type="submit" class="w-full bg-green-600 py-2 rounded-lg hover:bg-green-700">Registrar</button>
        </form>
    </div>
</body>

</html>