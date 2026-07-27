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
            <header class="container mx-auto py-3 px-6 lg:px-12 flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold">Lans<span class="text-yellow-500">Student</span>Service</a>
                </div>

                <!-- Search Bar -->
                <div class="hidden lg:flex items-center border border-gray-300 rounded-full bg-white overflow-hidden w-[400px]">
                    <div class="px-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" placeholder="এখানে সার্চ করুন" class="flex-grow border-none focus:ring-0 text-sm py-2 px-1 text-gray-700 outline-none">
                    <div class="px-3 border-l border-gray-300 text-gray-400 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <button class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-6 py-2 transition-colors">
                        খুঁজুন
                    </button>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center space-x-6">
                    <div class="flex items-center space-x-2 text-sm">
                        <button class="text-yellow-500 font-medium">বাং</button>
                        <span class="text-gray-300">|</span>
                        <button class="text-gray-500 hover:text-gray-700 font-medium">EN</button>
                    </div>
                    <a href="{{ route('login') }}" class="text-gray-800 hover:text-yellow-600 font-medium text-sm transition-colors">লগ ইন</a>
                    <a href="{{ route('register') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold rounded-full px-5 py-2 text-sm transition-colors">
                        শুরু করুন
                    </a>
                </div>
            </header>
        </div>

        {{ $slot }}

        <!-- Footer Section -->
        <footer class="bg-[#f8f9fa] py-8 border-t border-gray-200 relative mt-auto">
            <div class="container mx-auto px-6 lg:px-12 flex flex-col md:flex-row items-center justify-between text-gray-500 text-xs md:text-sm">
                <div class="mb-4 md:mb-0">
                    &copy; {{ date('Y') }} LansStudentService
                </div>
                <div class="text-center md:text-right">
                    শিক্ষার্থীদের জন্য, শিক্ষার্থীদের দ্বারা তৈরি। (অ্যাডমিনের জন্য লোগোতে ৫x ট্যাপ করুন)
                </div>
            </div>

            <!-- Floating Action Button -->
            <div class="absolute right-6 bottom-6 md:right-12 md:bottom-1/2 md:translate-y-1/2">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-black p-3 rounded-full shadow-lg transition-transform hover:scale-105 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </button>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
