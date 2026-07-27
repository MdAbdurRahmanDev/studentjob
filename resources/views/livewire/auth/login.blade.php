<x-layouts.front>
    <div class="min-h-[calc(100vh-200px)] bg-[#faf9f6] flex items-center justify-center py-12 px-6">
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 overflow-hidden w-full max-w-4xl flex flex-col md:flex-row">
            
            <!-- Left Side Image/Branding -->
            <div class="w-full md:w-1/2 bg-black relative p-12 text-white flex flex-col justify-between hidden md:flex">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/20 to-black/80 z-0"></div>
                <!-- Abstract glowing orb -->
                <div class="absolute -top-12 -left-12 w-64 h-64 bg-yellow-500 rounded-full mix-blend-screen filter blur-3xl opacity-30"></div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold mb-4">স্বাগতম!</h2>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Lans Student Service এ লগ ইন করে আপনার পরবর্তী শিফট খুঁজুন। হাজারো শিক্ষার্থী প্রতিদিন তাদের পছন্দমতো কাজ করছে।
                    </p>
                </div>
                
                <div class="relative z-10 mt-12">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center border border-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-sm text-gray-300">১০০% ভেরিফাইড শিফট</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center border border-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-sm text-gray-300">দ্রুত পেমেন্ট ব্যবস্থা</span>
                    </div>
                </div>
            </div>

            <!-- Right Side Form -->
            <div class="w-full md:w-1/2 p-10 md:p-14">
                <div class="mb-10 text-center md:text-left">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">লগ ইন করুন</h3>
                    <p class="text-gray-500 text-sm">আপনার ইমেইল এবং পাসওয়ার্ড দিন</p>
                </div>
                
                @if(session('status'))
                    <div class="mb-4 text-center text-sm font-medium text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">ইমেইল অ্যাড্রেস</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="email@example.com" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                        @error('email') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">পাসওয়ার্ড</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-yellow-600 hover:text-yellow-700 font-semibold transition-colors">
                                    পাসওয়ার্ড ভুলে গেছেন?
                                </a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                        @error('password') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center">
                        <input id="remember" type="checkbox" name="remember" class="w-4 h-4 text-yellow-500 bg-gray-100 border-gray-300 rounded focus:ring-yellow-500 focus:ring-2 cursor-pointer">
                        <label for="remember" class="ml-2 text-sm font-medium text-gray-600 cursor-pointer">আমাকে মনে রাখুন</label>
                    </div>

                    <button type="submit" class="w-full text-black bg-yellow-500 hover:bg-yellow-600 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all shadow-lg shadow-yellow-500/30 hover:-translate-y-0.5">
                        লগ ইন
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        অ্যাকাউন্ট নেই? <a href="{{ route('register') }}" class="font-bold text-yellow-600 hover:text-yellow-700 transition-colors">নতুন অ্যাকাউন্ট খুলুন</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.front>
