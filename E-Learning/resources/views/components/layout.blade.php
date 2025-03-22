<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'E_Learning' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&family=Inter:wght@800&family=Lexend:wght@100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.2/cdn.min.js" integrity="sha512-FwRoHOUW/Yu7CcAMg4bH20XOn0uismYklB9wpfJureVul5q4ZAZYsV4AZMJkMkB7FwT0tMlZZEu86ItSO00CmQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal m-0 p-0">
<header class="bg-primary py-6 flex justify-between items-center px-20">
    <a href="/" class="text-white font-bold text-2xl">
        E-Learning
    </a>
    <div class="flex space-x-4 items-center">
        @auth
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center space-x-1 text-white font-medium focus:outline-none">
                    <span>{{ auth()->user()->name }}</span>
                    <span>&#x25BC;</span>
                </button>
                <div
                    x-show="open"
                    @click.outside="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md"
                    style="display: none;">
                    <a href="/lists" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                        My lists
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full shadow-md">
                Login
            </a>
        @endauth
        <div class="flex space-x-2">
            <button class="bg-secondary text-white px-3 py-2 rounded-full shadow-md">EN</button>
            <button class="bg-white text-black px-3 py-2 rounded-full shadow-md">NL</button>
        </div>
    </div>
</header>
<main class="m-0 bg-darker">
    {{ $slot }}
</main>
<footer class="bg-primary p-4 text-white text-center">
    &copy; {{ date('Y') }} E_learning
</footer>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.2/cdn.min.js" integrity="sha512-FwRoHOUW/Yu7CcAMg4bH20XOn0uismYklB9wpfJureVul5q4ZAZYsV4AZMJkMkB7FwT0tMlZZEu86ItSO00CmQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
