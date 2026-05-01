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
    <body class="font-sans antialiased text-slate-900" x-data="{ sidebarOpen: false, openMenus: { data: {{ request()->routeIs('users.*', 'guests.*') ? 'true' : 'false' }}, ops: {{ request()->routeIs('tasks.*', 'member.*') ? 'true' : 'false' }} } }">
        <div class="flex h-screen bg-slate-50 dark:bg-gray-950 overflow-hidden">
            <!-- Off-canvas menu for mobile -->
            <div x-show="sidebarOpen" class="fixed inset-0 flex z-40 lg:hidden" role="dialog" aria-modal="true">
                <div x-show="sidebarOpen" 
                     x-transition:enter="transition-opacity ease-linear duration-300" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="transition-opacity ease-linear duration-300" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0" 
                     @click="sidebarOpen = false"
                     class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm" aria-hidden="true"></div>

                <div x-show="sidebarOpen" 
                     x-transition:enter="transition ease-in-out duration-300 transform" 
                     x-transition:enter-start="-translate-x-full" 
                     x-transition:enter-end="translate-x-0" 
                     x-transition:leave="transition ease-in-out duration-300 transform" 
                     x-transition:leave-start="translate-x-0" 
                     x-transition:leave-end="-translate-x-full" 
                     class="relative flex-1 flex flex-col max-w-xs w-full bg-slate-900 focus:outline-none">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button type="button" @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                        <div class="flex-shrink-0 flex items-center px-6">
                            <x-application-logo class="h-9 w-auto fill-current text-blue-400" />
                            <span class="ml-3 text-2xl font-black tracking-tight text-white">SIMPROTO</span>
                        </div>
                        <nav class="mt-8 px-3 space-y-4">
                            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate class="rounded-xl">
                                {{ __('Dashboard') }}
                            </x-responsive-nav-link>
                            
                            <!-- Mobile Group: Manajemen -->
                            <div>
                                <button @click="openMenus.data = !openMenus.data" class="w-full flex items-center justify-between px-4 py-2 text-xs font-black text-slate-500 uppercase tracking-widest hover:text-white transition-colors">
                                    <span>Manajemen Data</span>
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="openMenus.data ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="openMenus.data" x-collapse class="mt-2 space-y-1">
                                    <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" wire:navigate class="rounded-xl pl-8">
                                        {{ __('Pengguna') }}
                                    </x-responsive-nav-link>
                                    <x-responsive-nav-link :href="route('guests.index')" :active="request()->routeIs('guests.*')" wire:navigate class="rounded-xl pl-8">
                                        {{ __('Tamu VIP') }}
                                    </x-responsive-nav-link>
                                </div>
                            </div>

                            <!-- Mobile Group: Operasional -->
                            <div>
                                <button @click="openMenus.ops = !openMenus.ops" class="w-full flex items-center justify-between px-4 py-2 text-xs font-black text-slate-500 uppercase tracking-widest hover:text-white transition-colors">
                                    <span>Operasional</span>
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="openMenus.ops ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="openMenus.ops" x-collapse class="mt-2 space-y-1">
                                    <x-responsive-nav-link :href="route('tasks.dispatch')" :active="request()->routeIs('tasks.dispatch')" wire:navigate class="rounded-xl pl-8">
                                        {{ __('Dispatching') }}
                                    </x-responsive-nav-link>
                                    <x-responsive-nav-link :href="route('member.dashboard')" :active="request()->routeIs('member.dashboard')" wire:navigate class="rounded-xl pl-8">
                                        {{ __('Tugas Saya') }}
                                    </x-responsive-nav-link>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div class="flex-shrink-0 flex border-t border-slate-800 p-4 bg-slate-900/50">
                        <livewire:layout.navigation />
                    </div>
                </div>
                <div class="flex-shrink-0 w-14"></div>
            </div>

            <!-- Static sidebar for desktop -->
            <div class="hidden lg:flex lg:flex-shrink-0">
                <div class="flex flex-col w-72">
                    <div class="flex flex-col h-0 flex-1 bg-slate-900 border-r border-slate-800">
                        <div class="flex-1 flex flex-col pt-8 pb-4 overflow-y-auto">
                            <div class="flex items-center flex-shrink-0 px-8 mb-10">
                                <x-application-logo class="h-10 w-auto fill-current text-blue-500" />
                                <span class="ml-3 text-2xl font-black tracking-tighter text-white">SIMPROTO</span>
                            </div>
                            <nav class="flex-1 px-4 space-y-6">
                                <div>
                                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate class="group flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 bg-slate-800/30 text-slate-300 hover:text-white">
                                        <svg class="w-5 h-5 mr-3 text-slate-500 group-hover:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                                        <span class="flex-1">{{ __('Dashboard') }}</span>
                                    </x-nav-link>
                                </div>

                                <!-- Desktop Group: Manajemen -->
                                <div class="space-y-1">
                                    <button @click="openMenus.data = !openMenus.data" class="w-full group flex items-center justify-between px-4 py-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] hover:text-slate-300 transition-colors">
                                        <span>Manajemen Data</span>
                                        <svg class="w-3 h-3 transition-transform duration-300" :class="openMenus.data ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                                    </button>
                                    <div x-show="openMenus.data" x-collapse class="space-y-1 mt-2">
                                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" wire:navigate class="group flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 hover:bg-slate-800/40">
                                            <div class="w-1.5 h-1.5 rounded-full mr-4 bg-slate-700 group-hover:bg-blue-500 transition-colors"></div>
                                            <span class="flex-1">{{ __('Pengguna') }}</span>
                                        </x-nav-link>
                                        <x-nav-link :href="route('guests.index')" :active="request()->routeIs('guests.*')" wire:navigate class="group flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 hover:bg-slate-800/40">
                                            <div class="w-1.5 h-1.5 rounded-full mr-4 bg-slate-700 group-hover:bg-blue-500 transition-colors"></div>
                                            <span class="flex-1">{{ __('Tamu VIP') }}</span>
                                        </x-nav-link>
                                    </div>
                                </div>

                                <!-- Desktop Group: Operasional -->
                                <div class="space-y-1">
                                    <button @click="openMenus.ops = !openMenus.ops" class="w-full group flex items-center justify-between px-4 py-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] hover:text-slate-300 transition-colors">
                                        <span>Operasional</span>
                                        <svg class="w-3 h-3 transition-transform duration-300" :class="openMenus.ops ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                                    </button>
                                    <div x-show="openMenus.ops" x-collapse class="space-y-1 mt-2">
                                        <x-nav-link :href="route('tasks.dispatch')" :active="request()->routeIs('tasks.dispatch')" wire:navigate class="group flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 hover:bg-slate-800/40">
                                            <div class="w-1.5 h-1.5 rounded-full mr-4 bg-slate-700 group-hover:bg-blue-500 transition-colors"></div>
                                            <span class="flex-1">{{ __('Dispatching') }}</span>
                                        </x-nav-link>
                                        <x-nav-link :href="route('member.dashboard')" :active="request()->routeIs('member.dashboard')" wire:navigate class="group flex items-center px-4 py-3 text-sm font-bold rounded-xl transition-all duration-200 hover:bg-slate-800/40">
                                            <div class="w-1.5 h-1.5 rounded-full mr-4 bg-slate-700 group-hover:bg-blue-500 transition-colors"></div>
                                            <span class="flex-1">{{ __('Tugas Saya') }}</span>
                                        </x-nav-link>
                                    </div>
                                </div>
                            </nav>
                        </div>
                        <div class="flex-shrink-0 flex border-t border-slate-800 p-6 bg-slate-900/20 backdrop-blur-md">
                            <livewire:layout.navigation />
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col w-0 flex-1 overflow-hidden">
                <div class="relative z-10 flex-shrink-0 flex h-16 bg-white dark:bg-gray-900 shadow-sm border-b border-slate-200 dark:border-slate-800 lg:hidden">
                    <button type="button" @click="sidebarOpen = true" class="px-4 border-r border-slate-200 dark:border-slate-800 text-slate-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    <div class="flex-1 px-4 flex justify-between">
                        <div class="flex-1 flex items-center">
                            <span class="text-xl font-bold text-slate-900 dark:text-white">SIMPROTO</span>
                        </div>
                    </div>
                </div>

                <main class="flex-1 relative overflow-y-auto focus:outline-none scroll-smooth">
                    <div class="py-10">
                        @if (isset($header))
                            <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
                                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">{{ $header }}</h1>
                            </div>
                        @endif
                        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
                            <div class="py-6">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
