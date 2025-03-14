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
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

<!-- Header -->
<header class="bg-primary p-4 flex justify-between items-center">
    <!-- Logo / Branding -->
    <div class="text-white font-bold text-lg">
        E-Learning
    </div>

    <!-- Navigation / Controls -->
    <div class="flex space-x-4 items-center">
        @auth
            <!-- User Menu with Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center space-x-1 text-white font-medium focus:outline-none">
                    <span>{{ auth()->user()->name }}</span>
                    <span>&#x25BC;</span> <!-- Down arrow -->
                </button>

                <!-- Dropdown Menu -->
                <div
                    x-show="open"
                    @click.outside="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md"
                    style="display: none;">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                        Profile
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
            <!-- Login/Register Button -->
            <a href="{{ route('login') }}" class="bg-white text-black px-4 py-2 rounded-full shadow-md">
                Login
            </a>
        @endauth

        <!-- Language Switcher -->
        <div class="flex space-x-1">
            <button class="bg-secondary text-white px-2 py-1 rounded-full">EN</button>
            <button class="bg-white text-black px-2 py-1 rounded-full shadow-md">NL</button>
        </div>
    </div>
</header>

<!-- Main Content Area -->
<main class="container mx-auto mt-4">
    {{ $slot }}
</main>

<!-- Footer -->
<footer class="bg-primary p-4 text-white text-center">
    &copy; {{ date('Y') }} E_learning
</footer>

<!-- JavaScript Files -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.2/cdn.min.js" integrity="sha512-FwRoHOUW/Yu7CcAMg4bH20XOn0uismYklB9wpfJureVul5q4ZAZYsV4AZMJkMkB7FwT0tMlZZEu86ItSO00CmQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
