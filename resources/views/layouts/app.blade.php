<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-[#0A2540]">
            <nav class="bg-[#1B4965] border-b border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 items-center">
                        <div class="flex items-center">
                            <a href="{{ route('dashboard') }}" class="text-white text-lg font-semibold">Dashboard</a>
                            <a href="{{ route('loyalty') }}" class="ml-6 text-white text-sm hover:underline">Loyalty Reward</a>
                            <a href="{{ route('contact') }}" class="ml-4 text-white text-sm hover:underline">Contact Center</a>
                        </div>
                        <div class="flex items-center">
                            @auth
                                <div class="ml-3 relative">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="inline-flex items-center gap-1 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-100 bg-transparent hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                            <img 
    src="{{ Auth::user()->profile_picture 
        ? asset('storage/' . Auth::user()->profile_picture) 
        : asset('images/default-avatar.png') }}" 
    alt="Profile Photo" 
    class="w-11 h-11 rounded-full object-cover border border-white"
/>


                                    <span>{{ Auth::user()->name }}</span>


                                                {{-- Arrow Down Icon --}}
                                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('profile.edit')">
                                                {{ __('Profile') }}
                                            </x-dropdown-link>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                                    {{ __('Log Out') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-[#1B4965] shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            @stack('scripts')
        </div>
    </body>
</html>
