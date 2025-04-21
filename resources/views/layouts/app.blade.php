<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media (max-width: 768px) {
            .mobile-menu {
                display: none;
            }

            .mobile-menu.active {
                display: block;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-[#0A2540] text-white">
    <nav class="bg-[#1B4965] border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Left: Burger + Desktop Links -->
            <div class="flex items-center space-x-4">
    <!-- Animated Burger/X Button -->
    <button id="burgerBtn" onclick="toggleMobileMenu()" class="md:hidden relative w-8 h-8 z-50 group focus:outline-none">
        <span class="absolute top-1.5 left-0 w-8 h-0.5 bg-white transform transition duration-300 ease-in-out group-[.open]:rotate-45 group-[.open]:top-3.5"></span>
        <span class="absolute top-3.5 left-0 w-8 h-0.5 bg-white transform transition duration-300 ease-in-out group-[.open]:opacity-0"></span>
        <span class="absolute top-6 left-0 w-8 h-0.5 bg-white transform transition duration-300 ease-in-out group-[.open]:-rotate-45 group-[.open]:top-3.5"></span>
    </button>



                <!-- Desktop Links with Icons -->
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-1 text-sm text-white hover:underline">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v10m4-10v10m5-12l2 2m-2-2V4a1 1 0 00-1-1h-3M4 4v4" />
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('loyalty') }}" class="flex items-center space-x-1 text-sm text-white hover:underline">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.104 0-2 .896-2 2s.896 2 2 2m0-4a2 2 0 110 4m0 0v4m0 4h.01" />
                        </svg>
                        <span>Loyalty Rewards</span>
                    </a>
                    <a href="{{ route('contact') }}" class="flex items-center space-x-1 text-sm text-white hover:underline">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                        </svg>
                        <span>Contact Center</span>
                    </a>
                </div>
            </div>

            <!-- Right: Profile Dropdown -->
            @auth
                <div class="flex items-center space-x-2">
                    <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png') }}"
                         class="w-9 h-9 rounded-full border-2 border-white object-cover" alt="Avatar">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="text-sm text-white font-medium">
                                {{ Auth::user()->name }}
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth
        </div>
    </div>

    <!-- Mobile Links with Icons -->
    <div id="mobileLinks" class="mobile-menu hidden md:hidden px-6 py-3 space-y-2 bg-[#1B4965] border-t border-gray-700">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-white text-sm hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v10m4-10v10m5-12l2 2m-2-2V4a1 1 0 00-1-1h-3M4 4v4" />
            </svg>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('loyalty') }}" class="flex items-center space-x-2 text-white text-sm hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.104 0-2 .896-2 2s.896 2 2 2m0-4a2 2 0 110 4m0 0v4m0 4h.01" />
            </svg>
            <span>Loyalty Rewards</span>
        </a>
        <a href="{{ route('contact') }}" class="flex items-center space-x-2 text-white text-sm hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
            </svg>
            <span>Contact Center</span>
        </a>
    </div>
</nav>


        @isset($header)
            <header class="bg-[#1B4965] shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>

        @stack('scripts')
    </div>
    <script>
    function toggleMobileMenu() {
        const btn = document.getElementById('burgerBtn');
        const menu = document.getElementById('mobileLinks');

        // Toggle `open` class to animate lines
        btn.classList.toggle('open');

        // Toggle visibility of mobile menu
        if (menu) menu.classList.toggle('active');
    }
</script>


</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>
