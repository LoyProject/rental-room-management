<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Room Rental Management</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
        <aside 
            class="fixed inset-y-0 left-0 z-30 w-64 bg-gray-800 text-white transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0"
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
            <div class="p-4 border-b border-gray-700 items-center flex justify-start space-x-4">
                <a href="{{ route('dashboard') }}"><x-application-logo class="h-10 w-auto" /></a>
                <div>
                    @auth
                        <div class="font-bold text-lg text-white">{{ auth()->user()->name }}</div>
                        <div class="text-sm text-gray-400">{{ ucfirst(auth()->user()->role) }}</div>
                    @endauth
                </div>
            </div>
            
            <nav class="flex-grow p-4">
                <a href="{{ route('dashboard') }}" 
                    class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700
                        {{ Route::is('dashboard') ? 'bg-purple-700' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 10l9-7 9 7v8a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1v-8z"/>
                    </svg>
                    <span>ទំព័រដើម</span>
                </a>

                <a href="{{ route('sites.index') }}" 
                    class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700
                        {{ Route::is('sites.*') ? 'bg-purple-700' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 6l7-3 7 3 7-3v14l-7 3-7-3-7 3V6z"/>
                    </svg>
                    <span>តំបន់</span>
                </a>

                <a href="{{ route('blocks.index') }}" 
                    class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700
                        {{ Route::is('blocks.*') ? 'bg-purple-700' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="3" width="8" height="8"/>
                        <rect x="13" y="3" width="8" height="8"/>
                        <rect x="3" y="13" width="8" height="8"/>
                        <rect x="13" y="13" width="8" height="8"/>
                    </svg>
                    <span>ប្លុក</span>
                </a>

                <a href="{{ route('customers.index') }}" 
                    class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700
                        {{ Route::is('customers.*') ? 'bg-purple-700' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="9" cy="8" r="3"/>
                        <path d="M2 20c1.5-4 5.5-6 7-6s5.5 2 7 6"/>
                        <path d="M17 11a3 3 0 110-6 3 3 0 010 6z"/>
                    </svg>
                    <span>អតិថិជន</span>
                </a>
                <a href="{{ route('users.index') }}" 
                    class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700
                        {{ Route::is('users.*') ? 'bg-purple-700' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="8" r="3"/>
                        <path d="M6 20c0-3 3-5 6-5s6 2 6 5"/>
                    </svg>
                    <span>អ្នកប្រើប្រាស់</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block py-2.5 px-4 rounded transition duration-200 hover:bg-red-700">
                        ចាកចេញ
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col w-full">
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h1 class="text-xl font-semibold">@yield('title', 'ទំព័រដើម')</h1>
                </div>

                <div class="md:hidden w-6"></div>
            </header>

            <main class="flex-grow p-6 overflow-y-auto">
                @yield('content')
            </main>

            <footer class="bg-white shadow p-4 text-center text-sm text-gray-500">
                <div class="container flex items-center justify-between">
                    <span>&copy; {{ date('Y') }} Room Rental Management. All rights reserved.</span>
                    <span>Developed by: <b>Loy Team</b></span>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
