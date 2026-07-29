<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <!-- Navbar -->
        <div class="bg-white border-b border-gray-100 z-50 relative shadow-sm">
            @php
                $siteName = \App\Models\Setting::get('site_name', config('app.name', 'StudentJob'));
                $siteLogo = \App\Models\Setting::get('site_logo', '');
            @endphp
            <header class="container mx-auto py-3 px-5 lg:px-12 relative"
                    x-data="{ mobileSearchOpen: false, mobileMenuOpen: false }">

                <!-- ── MOBILE HEADER (hidden on lg+) ── -->
                <div class="flex items-center justify-between lg:hidden">

                    <!-- Left: Logo -->
                    <a href="{{ route('home') }}" wire:navigate
                       class="text-lg font-bold flex items-center gap-1.5 whitespace-nowrap">
                        @if($siteLogo)
                            <img src="{{ Storage::url($siteLogo) }}" alt="{{ $siteName }}" class="h-7 w-auto">
                        @endif
                        {{ $siteName }}
                    </a>

                    <!-- Right: Search + Hamburger -->
                    <div class="flex items-center gap-1">

                        <!-- Search icon -->
                        <button @click="$dispatch('open-nav-search')"
                                class="w-10 h-10 flex items-center justify-center rounded-full text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 transition-colors focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>

                        <!-- Hamburger -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen"
                                class="w-10 h-10 flex items-center justify-center rounded-full text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 transition-colors focus:outline-none"
                                :aria-expanded="mobileMenuOpen">
                            <span x-show="!mobileMenuOpen">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </span>
                            <span x-show="mobileMenuOpen" style="display:none;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </span>
                        </button>

                    </div>
                </div>

                <!-- Mobile Hamburger Dropdown Menu -->
                <div x-show="mobileMenuOpen"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="lg:hidden absolute top-full left-0 right-0 bg-white border-t border-gray-100 shadow-lg z-50 py-2"
                     style="display:none;" @click.outside="mobileMenuOpen = false">
                    <div class="px-5 py-2 flex flex-col gap-1">
                        @auth
                            <a href="{{ route('dashboard') }}" wire:navigate @click="mobileMenuOpen = false"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 font-medium text-sm transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                ড্যাশবোর্ড
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-500 hover:bg-red-50 font-medium text-sm transition-colors text-left">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    লগআউট
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" wire:navigate @click="mobileMenuOpen = false"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 font-medium text-sm transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                লগ ইন
                            </a>
                            <a href="{{ route('register') }}" wire:navigate @click="mobileMenuOpen = false"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-yellow-500 hover:bg-yellow-600 text-black font-semibold text-sm transition-colors justify-center mt-1">
                                শুরু করুন
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Mobile search handled by bottom sheet (open-nav-search event) -->

                <!-- ── DESKTOP HEADER (hidden on mobile) ── -->
                <div class="hidden lg:flex items-center justify-between w-full">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" wire:navigate class="text-xl font-bold flex items-center">
                            @if($siteLogo)
                                <img src="{{ Storage::url($siteLogo) }}" alt="{{ $siteName }}" class="h-8 w-auto mr-2">
                            @endif
                            {{ $siteName }}
                        </a>
                    </div>

                    <!-- Search Bar (Desktop) -->
                    <form action="{{ route('shifts.index') }}" method="GET" class="flex items-center border border-gray-300 rounded-full bg-white overflow-hidden w-[550px] shadow-sm focus-within:ring-2 focus-within:ring-yellow-500/50 focus-within:border-yellow-400 transition-all">
                        <div class="px-4 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="এখানে সার্চ করুন" class="flex-grow border-none focus:ring-0 text-sm py-2.5 px-2 text-gray-700 outline-none w-full">
                        <div class="px-3 border-l border-gray-300 bg-gray-50/80 flex items-center relative h-full">
                            <div class="absolute left-3 text-gray-400 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            @php
                                $availableLocations = \App\Models\Job::select('location')->whereNotNull('location')->where('location', '!=', '')->distinct()->pluck('location');
                            @endphp
                            <select name="location" class="bg-transparent border-none focus:ring-0 text-sm py-2.5 pl-8 pr-6 text-gray-700 outline-none appearance-none cursor-pointer w-36 h-full font-medium">
                                <option value="">সব লোকেশন</option>
                                @foreach($availableLocations as $loc)
                                    <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-3 text-gray-400 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold px-8 py-2.5 transition-colors h-full">
                            খুঁজুন
                        </button>
                    </form>

                    <!-- Right Actions -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-800 hover:text-yellow-600 font-medium text-sm transition-colors flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                ড্যাশবোর্ড
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-full px-5 py-2 text-sm transition-colors border border-gray-200">
                                    লগআউট
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-800 hover:text-yellow-600 font-medium text-sm transition-colors">লগ ইন</a>
                            <a href="{{ route('register') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold rounded-full px-5 py-2 text-sm transition-colors">
                                শুরু করুন
                            </a>
                        @endauth
                    </div>
                </div>

            </header>
        </div>


        {{ $slot }}

        <!-- Footer Section -->
        <footer class="bg-[#f8f9fa] py-8 border-t border-gray-200 mt-auto pb-20 lg:pb-8">
            <div class="container mx-auto px-6 lg:px-12 flex flex-col md:flex-row items-center justify-between text-gray-500 text-xs md:text-sm">
                <div class="mb-4 md:mb-0">
                    {{ \App\Models\Setting::get('footer_copyright', '© ' . date('Y') . ' ' . \App\Models\Setting::get('site_name', config('app.name', 'StudentJob')) . '. সর্বস্বত্ব সংরক্ষিত।') }}
                </div>
                <div class="text-center md:text-right">
                    {{ \App\Models\Setting::get('footer_text', 'শিক্ষার্থীদের জন্য, শিক্ষার্থীদের দ্বারা তৈরি। (অ্যাডমিনের জন্য লোগোতে ৫x ট্যাপ করুন)') }}
                </div>
            </div>
        </footer>

        <!-- Floating Action Button (Fixed to viewport) -->
        @php $waNumber = \App\Models\Setting::get('whatsapp_number', ''); @endphp
        @if($waNumber)
        <div class="fixed right-6 bottom-6 md:right-8 md:bottom-8 z-50">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $waNumber) }}" target="_blank" class="bg-yellow-500 hover:bg-yellow-600 text-black w-14 h-14 rounded-full shadow-lg shadow-yellow-500/30 transition-transform hover:scale-110 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11.99 2C6.47 2 2 6.48 2 12c0 1.76.46 3.42 1.25 4.89L2 22l5.34-1.18c1.42.73 3.03 1.15 4.65 1.15 5.52 0 10-4.48 10-10S17.51 2 11.99 2zm5.72 14.28c-.24.67-1.39 1.26-1.95 1.32-.48.06-1.1.18-3.13-.67-2.45-1.02-4.04-3.52-4.16-3.69-.13-.17-1-1.32-1-2.52 0-1.2.62-1.79.84-2.02.22-.24.48-.3.64-.3h.45c.16 0 .38-.06.59.44.22.51.68 1.66.74 1.79.06.13.11.28.02.46-.08.18-.13.3-.25.44-.13.14-.26.3-.37.4-.13.13-.26.27-.11.52.14.25.64 1.07 1.38 1.72.96.85 1.76 1.11 2 1.24.24.13.38.11.52-.06.14-.17.61-.71.77-.95.16-.24.32-.2.54-.12.22.08 1.41.67 1.65.79.24.12.4.18.45.28.06.1.06.58-.18 1.25z"/>
                </svg>
            </a>
        </div>
        @else
        <div class="fixed right-6 bottom-6 md:right-8 md:bottom-8 z-50">
            <button class="bg-yellow-500 hover:bg-yellow-600 text-black w-14 h-14 rounded-full shadow-lg shadow-yellow-500/30 transition-transform hover:scale-110 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
            </button>
        </div>
        @endif
        
        <!-- Mobile Bottom Navbar -->
        @php $navCategories = \App\Models\Category::withCount('jobs')->get(); @endphp
        <div x-data="{ categoryOpen: false, searchOpen: false }"
             @keydown.escape.window="categoryOpen = false; searchOpen = false"
             @open-nav-search.window="searchOpen = true; $nextTick(() => $refs.mobileNavSearch.focus())">

            <nav class="lg:hidden fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-gray-200 shadow-[0_-4px_20px_rgba(0,0,0,0.08)]">
                <div class="flex items-stretch h-16">

                    <!-- Home -->
                    <a href="{{ route('home') }}" wire:navigate
                       class="flex-1 flex flex-col items-center justify-center gap-0.5 group transition-colors {{ request()->routeIs('home') ? 'text-yellow-500' : 'text-gray-500 hover:text-yellow-500' }}">
                        <span class="relative flex items-center justify-center w-9 h-9 rounded-full transition-all {{ request()->routeIs('home') ? 'bg-yellow-50' : 'group-hover:bg-yellow-50' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="{{ request()->routeIs('home') ? '0' : '2' }}">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12L5 10M5 10L12 3L19 10M5 10V20C5 20.5523 5.44772 21 6 21H9M19 10L21 12M19 10V20C19 20.5523 18.5523 21 18 21H15M9 21V15C9 14.4477 9.44772 14 10 14H14C14.5523 14 15 14.4477 15 15V21M9 21H15" />
                            </svg>
                            @if(request()->routeIs('home'))
                                <span class="absolute -bottom-0.5 left-1/2 -translate-x-1/2 w-1 h-1 bg-yellow-500 rounded-full"></span>
                            @endif
                        </span>
                        <span class="text-[10px] font-medium leading-none {{ request()->routeIs('home') ? 'text-yellow-500' : '' }}">হোম</span>
                    </a>

                    <!-- Search Button -->
                    <button @click="searchOpen = true; $nextTick(() => $refs.mobileNavSearch.focus())"
                            :class="searchOpen ? 'text-yellow-500' : '{{ request()->routeIs('shifts.index') ? 'text-yellow-500' : 'text-gray-500' }}'"
                            class="flex-1 flex flex-col items-center justify-center gap-0.5 group transition-colors hover:text-yellow-500 focus:outline-none">
                        <span class="relative flex items-center justify-center w-9 h-9 rounded-full transition-all"
                              :class="searchOpen ? 'bg-yellow-50' : '{{ request()->routeIs('shifts.index') ? 'bg-yellow-50' : 'group-hover:bg-yellow-50' }}'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            @if(request()->routeIs('shifts.index'))
                                <span x-show="!searchOpen" class="absolute -bottom-0.5 left-1/2 -translate-x-1/2 w-1 h-1 bg-yellow-500 rounded-full"></span>
                            @endif
                            <span x-show="searchOpen" class="absolute -bottom-0.5 left-1/2 -translate-x-1/2 w-1 h-1 bg-yellow-500 rounded-full"></span>
                        </span>
                        <span class="text-[10px] font-medium leading-none {{ request()->routeIs('shifts.index') ? 'text-yellow-500' : '' }}">সার্চ</span>
                    </button>

                    <!-- Category Button -->
                    <button @click="categoryOpen = true"
                            :class="categoryOpen ? 'text-yellow-500' : 'text-gray-500'"
                            class="flex-1 flex flex-col items-center justify-center gap-0.5 group transition-colors hover:text-yellow-500 focus:outline-none">
                        <span class="relative flex items-center justify-center w-9 h-9 rounded-full transition-all"
                              :class="categoryOpen ? 'bg-yellow-50' : 'group-hover:bg-yellow-50'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span x-show="categoryOpen" class="absolute -bottom-0.5 left-1/2 -translate-x-1/2 w-1 h-1 bg-yellow-500 rounded-full"></span>
                        </span>
                        <span class="text-[10px] font-medium leading-none">ক্যাটাগরি</span>
                    </button>

                    <!-- My Account -->
                    @auth
                    <a href="{{ route('dashboard') }}" wire:navigate
                       class="flex-1 flex flex-col items-center justify-center gap-0.5 group transition-colors {{ request()->routeIs('dashboard') ? 'text-yellow-500' : 'text-gray-500 hover:text-yellow-500' }}">
                        <span class="relative flex items-center justify-center w-9 h-9 rounded-full transition-all {{ request()->routeIs('dashboard') ? 'bg-yellow-50' : 'group-hover:bg-yellow-50' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="{{ request()->routeIs('dashboard') ? 'currentColor' : 'none' }}" stroke="{{ request()->routeIs('dashboard') ? 'none' : 'currentColor' }}" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            @if(request()->routeIs('dashboard'))
                                <span class="absolute -bottom-0.5 left-1/2 -translate-x-1/2 w-1 h-1 bg-yellow-500 rounded-full"></span>
                            @endif
                        </span>
                        <span class="text-[10px] font-medium leading-none {{ request()->routeIs('dashboard') ? 'text-yellow-500' : '' }}">আমার অ্যাকাউন্ট</span>
                    </a>
                    @else
                    <a href="{{ route('login') }}" wire:navigate
                       class="flex-1 flex flex-col items-center justify-center gap-0.5 group transition-colors text-gray-500 hover:text-yellow-500">
                        <span class="flex items-center justify-center w-9 h-9 rounded-full transition-all group-hover:bg-yellow-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <span class="text-[10px] font-medium leading-none">আমার অ্যাকাউন্ট</span>
                    </a>
                    @endauth

                </div>
            </nav>

            <!-- Search Slide-Up Modal -->
            <!-- Backdrop -->
            <div x-show="searchOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="searchOpen = false"
                 class="lg:hidden fixed inset-0 bg-black/50 z-[60]"
                 style="display:none;"></div>

            <!-- Sheet -->
            <div x-show="searchOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="translate-y-full"
                 x-transition:enter-end="translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-y-0"
                 x-transition:leave-end="translate-y-full"
                 class="lg:hidden fixed bottom-0 left-0 right-0 z-[70] bg-white rounded-t-3xl shadow-2xl flex flex-col"
                 style="display:none;">

                <!-- Handle -->
                <div class="flex justify-center pt-3 pb-1 flex-shrink-0">
                    <div class="w-10 h-1 bg-gray-300 rounded-full"></div>
                </div>

                <!-- Header -->
                <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 flex-shrink-0">
                    <h2 class="text-base font-bold text-gray-900">শিফট খুঁজুন</h2>
                    <button @click="searchOpen = false"
                            class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Search Form -->
                <form action="{{ route('shifts.index') }}" method="GET"
                      class="px-5 py-5 pb-10 flex flex-col gap-3">

                    <!-- Keyword Input -->
                    <div class="flex items-center border-2 border-gray-200 focus-within:border-yellow-400 rounded-2xl bg-gray-50 overflow-hidden transition-all px-4 gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            x-ref="mobileNavSearch"
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="শিফট বা কোম্পানির নাম..."
                            class="flex-grow bg-transparent border-none focus:ring-0 text-sm py-3.5 text-gray-700 outline-none w-full placeholder-gray-400"
                        >
                    </div>

                    <!-- Location Select -->
                    <div class="flex items-center border-2 border-gray-200 focus-within:border-yellow-400 rounded-2xl bg-gray-50 overflow-hidden transition-all px-4 gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <select name="location" class="flex-grow bg-transparent border-none focus:ring-0 text-sm py-3.5 text-gray-700 outline-none appearance-none cursor-pointer w-full font-medium">
                            <option value="">সব লোকেশন</option>
                            @foreach(\App\Models\Job::select('location')->whereNotNull('location')->where('location','!=','')->distinct()->pluck('location') as $loc)
                                <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                            @endforeach
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 flex-shrink-0 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                            @click="searchOpen = false"
                            class="w-full bg-yellow-500 hover:bg-yellow-600 active:bg-yellow-700 text-black font-bold rounded-2xl py-3.5 text-sm transition-colors flex items-center justify-center gap-2 shadow-sm shadow-yellow-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        শিফট খুঁজুন
                    </button>
                </form>
            </div>
            <!-- End Search Slide-Up Modal -->

            <!-- Category Slide-Up Modal -->
            <!-- Backdrop -->
            <div x-show="categoryOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="categoryOpen = false"
                 class="lg:hidden fixed inset-0 bg-black/50 z-[60]"
                 style="display:none;"></div>

            <!-- Sheet -->
            <div x-show="categoryOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="translate-y-full"
                 x-transition:enter-end="translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-y-0"
                 x-transition:leave-end="translate-y-full"
                 class="lg:hidden fixed bottom-0 left-0 right-0 z-[70] bg-white rounded-t-3xl shadow-2xl max-h-[80vh] flex flex-col"
                 style="display:none;">

                <!-- Handle -->
                <div class="flex justify-center pt-3 pb-1 flex-shrink-0">
                    <div class="w-10 h-1 bg-gray-300 rounded-full"></div>
                </div>

                <!-- Header -->
                <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 flex-shrink-0">
                    <h2 class="text-base font-bold text-gray-900">সকল ক্যাটাগরি</h2>
                    <button @click="categoryOpen = false"
                            class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Categories Grid (scrollable) -->
                <div class="overflow-y-auto flex-1 px-4 py-4 pb-20">
                    <div class="grid grid-cols-3 gap-3">

                        <!-- All Categories -->
                        <a href="{{ route('shifts.index') }}" wire:navigate @click="categoryOpen = false"
                           class="flex flex-col items-center justify-center bg-gray-50 hover:bg-yellow-50 border-2 border-transparent hover:border-yellow-300 rounded-2xl p-3 transition-all duration-200 text-center">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mb-2 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-800 leading-tight">সব ক্যাটাগরি</span>
                        </a>

                        @foreach($navCategories as $cat)
                        <a href="{{ route('shifts.index', ['category' => $cat->id]) }}" wire:navigate @click="categoryOpen = false"
                           class="flex flex-col items-center justify-center bg-gray-50 hover:bg-yellow-50 border-2 border-transparent hover:border-yellow-300 rounded-2xl p-3 transition-all duration-200 text-center">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mb-2 shadow-sm overflow-hidden">
                                @if($cat->icon)
                                    <img src="{{ Storage::url($cat->icon) }}" class="w-7 h-7 object-contain" alt="{{ $cat->name }}">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                @endif
                            </div>
                            <span class="text-xs font-semibold text-gray-800 leading-tight line-clamp-2">{{ $cat->name }}</span>
                            <span class="text-[10px] text-gray-400 mt-1">{{ $cat->jobs_count }} টি জব</span>
                        </a>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
        <!-- End Mobile Bottom Navbar -->

        @livewireScripts
    </body>
</html>
