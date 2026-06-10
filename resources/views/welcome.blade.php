<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Mutirão no Bem - Bem-vindo</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 text-gray-900 flex flex-col min-h-screen">
        <header class="w-full bg-multirao-roxo text-white py-4 shadow-md">
            <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10 invert brightness-0">
                    <span class="font-bold text-xl tracking-tight">Mutirão no Bem</span>
                </div>
                @if (Route::has('login'))
                    <nav class="flex gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-white hover:text-multirao-amarelo font-medium">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-multirao-amarelo font-medium">Entrar</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-multirao-amarelo text-multirao-roxo px-4 py-1 rounded font-bold hover:bg-white transition">Registrar</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <main class="flex-grow flex items-center justify-center p-6 text-center md:text-left">
            <div class="max-w-4xl w-full bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
                <div class="bg-multirao-roxo md:w-1/3 p-8 flex flex-col justify-center items-center text-center text-white">
                    <img src="{{ asset('logo.png') }}" alt="Mutirão no Bem" class="w-32 mb-6 invert brightness-0">
                    <h2 class="text-2xl font-bold mb-2">Seja bem-vindo!</h2>
                    <p class="text-gray-200">Sistema de Gestão de Inscrições e Turmas.</p>
                </div>
                <div class="p-8 md:w-2/3 flex flex-col justify-center">
                    <h1 class="text-3xl font-bold text-multirao-roxo mb-4">Mutirão no Bem</h1>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Bem-vindo ao nosso sistema. Aqui você pode gerenciar as pré-inscrições, realizar a triagem das crianças e organizar as turmas.
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                        <a href="{{ route('pre-inscricao.index') }}" class="bg-multirao-roxo text-white px-6 py-3 rounded-lg font-bold hover:bg-opacity-90 transition shadow-lg">
                            Formulário de Pré-Inscrição
                        </a>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="border-2 border-multirao-roxo text-multirao-roxo px-6 py-3 rounded-lg font-bold hover:bg-multirao-roxo hover:text-white transition">
                                Acessar Painel
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </main>

        <footer class="py-6 text-center text-gray-500 text-sm border-t bg-white">
            <p>&copy; {{ date('Y') }} Mutirão no Bem - OSCIP | Cidade Dutra, São Paulo - SP</p>
            <p class="mt-1">v{{ app()->version() }}</p>
        </footer>
    </body>
</html>
