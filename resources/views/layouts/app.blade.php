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
        <div class="min-h-screen bg-gray-100 flex">
            <!-- Sidebar (left) -->
            <aside class="hidden sm:flex sm:flex-col w-64 bg-white border-r shadow-sm">
                <div class="m-4 shrink-0 flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}">
                            <x-application-logo class="block h-12 w-auto fill-current text-gray-800" />
                        </a>
                        <div class="ms-3 font-semibold text-lg text-gray-700">
                            {{ config('app.name', 'Laravel') }}
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 text-gray-600 hover:text-gray-900 focus:outline-none" title="Sign out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4M21 12H9" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7v-1a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2v-1" />
                            </svg>
                        </button>
                    </form>
                </div>

                <nav x-data="{ openSite: false, openBlock: false, openCustomer: false }" class="flex-1 px-2 pb-4 space-y-1 overflow-y-auto">
                    <a href="{{ route('dashboard') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-purple-100 text-purple-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-4 h-6 w-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 4v4m0 0h4m-4 0V9" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('sites.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md hover:bg-gray-100 {{ request()->routeIs('sites.index') ? 'bg-purple-100 text-purple-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-4 h-6 w-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2zm0 10c-4.418 0-8-1.79-8-4V6c0-2.21 3.582-4 8-4s8 1.79 8 4v8c0 2.21-3.582 4-8 4z" />
                        </svg>
                        Sites
                    </a>

                    <a href="{{ route('blocks.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md hover:bg-gray-100 {{ request()->routeIs('blocks.index') ? 'bg-purple-100 text-purple-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-4 h-6 w-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h3m10-14h3a2 2 0 012 2v10a2 2 0 01-2 2h-3m-10 0h4m-4-4h6m-6-4h6m2-4v.01M7 16v.01" />
                        </svg>
                        Blocks
                    </a>

                    <a href="{{ route('customers.index') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md hover:bg-gray-100 {{ request()->routeIs('customers.index') ? 'bg-purple-100 text-purple-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-4 h-6 w-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Customers
                    </a>

                    <a href="{{ route('profile.edit') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md hover:bg-gray-100 {{ request()->routeIs('profile.edit') ? 'bg-purple-100 text-purple-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-4 h-6 w-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Profile
                    </a>
                </nav>
            </aside>

            <!-- Mobile / small screens: show navigation at top -->
            <div class="sm:hidden w-full">
                @include('layouts.navigation')
            </div>

            <!-- Main content area -->
            <div class="flex-1 min-w-0">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow mx-2 sm:mx-4 lg:mx-6 mt-4 rounded-lg">
                        <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="mx-2 sm:mx-4 lg:mx-6 mt-4">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
