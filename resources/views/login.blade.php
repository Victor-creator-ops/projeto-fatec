<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-800 min-h-screen flex items-center justify-center text-white">
    <div class="w-full max-w-md bg-gray-900 bg-opacity-50 p-8 rounded-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Acesse sua Conta</h2>
        @if ($errors->any())
        <div class="bg-red-500 text-white p-3 rounded mb-4">{{ $errors->first('email') }}</div> @endif
        <form method="POST" action="{{ route('login') }}" class="space-y-6"> @csrf
            <input type="email" name="email" placeholder="Email" required
                class="w-full px-4 py-2 bg-transparent border-b-2 focus:outline-none">
            <input type="password" name="password" placeholder="Senha" required
                class="w-full px-4 py-2 bg-transparent border-b-2 focus:outline-none">
            <button type="submit" class="w-full bg-blue-600 py-2 rounded-lg hover:bg-blue-700">Entrar</button>
        </form>
    </div>
</body>

</html>