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
            <header class="container mx-auto py-3 px-6 lg:px-12 relative" x-data="{ mobileSearchOpen: false }">
                <div class="flex items-center justify-between w-full">
                    <!-- Logo -->
                    <div class="flex items-center">
                        @php
                            $siteName = \App\Models\Setting::get('site_name', config('app.name', 'StudentJob'));
                            $siteLogo = \App\Models\Setting::get('site_logo', '');
                        @endphp
                        <a href="{{ route('home') }}" wire:navigate class="text-xl font-bold flex items-center">
                            @if($siteLogo)
                                <img src="{{ Storage::url($siteLogo) }}" alt="{{ $siteName }}" class="h-8 w-auto mr-2">
                            @endif
                            {{ $siteName }}
                        </a>
                    </div>

                    <!-- Search Bar (Desktop) -->
                    <form action="{{ route('shifts.index') }}" method="GET" class="hidden lg:flex items-center border border-gray-300 rounded-full bg-white overflow-hidden w-[550px] shadow-sm focus-within:ring-2 focus-within:ring-yellow-500/50 focus-within:border-yellow-400 transition-all">
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
                    <div class="flex items-center space-x-4 md:space-x-6">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-800 hover:text-yellow-600 font-medium text-sm transition-colors flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                ড্যাশবোর্ড
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-full px-4 sm:px-5 py-2 text-xs sm:text-sm transition-colors border border-gray-200">
                                    লগআউট
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-800 hover:text-yellow-600 font-medium text-sm transition-colors">লগ ইন</a>
                            <a href="{{ route('register') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold rounded-full px-5 py-2 text-sm transition-colors">
                                শুরু করুন
                            </a>
                        @endauth

                        <!-- Mobile Search Toggle -->
                        <button @click="mobileSearchOpen = true; $nextTick(() => $refs.mobileSearchInput.focus())" class="lg:hidden text-gray-600 hover:text-yellow-600 focus:outline-none bg-gray-50 hover:bg-gray-100 p-2 rounded-full transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Search Overlay (Animated) -->
                <div 
                    x-show="mobileSearchOpen"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-8"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-8"
                    class="absolute inset-0 bg-white z-50 flex items-center px-4 lg:hidden"
                    style="display: none;"
                >
                    <form action="{{ route('shifts.index') }}" method="GET" class="flex-grow flex items-center border border-gray-200 rounded-full bg-gray-50 focus-within:ring-2 focus-within:ring-yellow-500/50 focus-within:border-yellow-400 transition-all h-11 mr-3">
                        <div class="px-3 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input x-ref="mobileSearchInput" type="text" name="search" value="{{ request('search') }}" placeholder="শিফট বা কোম্পানির নাম খুঁজুন..." class="flex-grow bg-transparent border-none focus:ring-0 text-sm py-2 px-1 text-gray-700 outline-none w-full">
                    </form>
                    
                    <button @click="mobileSearchOpen = false" class="text-gray-500 hover:text-red-500 bg-gray-100 hover:bg-gray-200 p-2.5 rounded-full transition-colors flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </header>
        </div>

        {{ $slot }}

        <!-- Footer Section -->
        <footer class="bg-[#f8f9fa] py-8 border-t border-gray-200 mt-auto">
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
        
        @livewireScripts
    </body>
</html>
