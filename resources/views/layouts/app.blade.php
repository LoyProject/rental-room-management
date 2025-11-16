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

                    <a href="{{ route('profile.edit') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md hover:bg-gray-100 {{ request()->routeIs('profile.edit') ? 'bg-purple-100 text-purple-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg class="mr-4 h-6 w-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Profile
                    </a>

                    <!-- Site dropdown -->
                    <div class="mt-4">
                        <button @click="openSite = !openSite" type="button" class="w-full flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('sites.*') ? 'bg-purple-50 text-purple-800' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <div class="flex items-center">
                                <svg class="mr-4 h-5 w-5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a1 1 0 001 1h16a1 1 0 001-1V7M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2" />
                                </svg>
                                <span>Site</span>
                            </div>
                            <svg :class="openSite ? 'transform rotate-180' : ''" class="h-4 w-4 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="openSite" x-cloak class="mt-1 space-y-1 px-2">
                            <a href="{{ route('sites.index') }}" class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('sites.index') ? 'bg-purple-50 text-purple-800' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}"></a>
                                Site List
                            </a>
                            <a href="{{ route('create') }}" class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('sites.create') ? 'bg-purple-50 text-purple-800' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Add Site
                            </a>
                        </div>
                    </div>

                    <!-- Block dropdown -->
                    <div class="mt-4">
                        <button @click="openBlock = !openBlock" type="button" class="w-full flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('blocks.*') ? 'bg-purple-50 text-purple-800' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <div class="flex items-center">
                                <svg class="mr-4 h-5 w-5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7v10a1 1 0 01-1 1H5a1 1 0 01-1-1V7m16 0L12 3 4 7" />
                                </svg>
                                <span>Block</span>
                            </div>
                            <svg :class="openBlock ? 'transform rotate-180' : ''" class="h-4 w-4 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="openBlock" x-cloak class="mt-1 space-y-1 px-2">
                            <a href="{{ route('blocks.index') }}" class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('blocks.index') ? 'bg-purple-50 text-purple-800' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Block List
                            </a>
                            <a href="{{ route('blocks.create') }}" class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('blocks.create') ? 'bg-purple-50 text-purple-800' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Add Block
                            </a>
                        </div>
                    </div>

                    <!-- Customer dropdown -->
                    <div class="mt-4">
                        <button @click="openCustomer = !openCustomer" type="button" class="w-full flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('customers.*') ? 'bg-purple-50 text-purple-800' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <div class="flex items-center">
                                <svg class="mr-4 h-5 w-5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11c1.657 0 3-1.343 3-3S17.657 5 16 5s-3 1.343-3 3 1.343 3 3 3zM6 21v-1a4 4 0 014-4h4a4 4 0 014 4v1" />
                                </svg>
                                <span>Customer</span>
                            </div>
                            <svg :class="openCustomer ? 'transform rotate-180' : ''" class="h-4 w-4 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="openCustomer" x-cloak class="mt-1 space-y-1 px-2">
                            <a href="{{ route('customers.index') }}" class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('customers.index') ? 'bg-purple-50 text-purple-800' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Customer List
                            </a>
                            <a href="{{ route('customers.create') }}" class="block px-3 py-2 rounded-md text-sm {{ request()->routeIs('customers.create') ? 'bg-purple-50 text-purple-800' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                Add Customer
                            </a>
                        </div>
                    </div>
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
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
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
