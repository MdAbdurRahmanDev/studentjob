<x-layouts.front>
    <div class="min-h-[calc(100vh-200px)] bg-[#faf9f6] flex items-center justify-center py-12 px-6">
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 overflow-hidden w-full max-w-4xl flex flex-col md:flex-row">
            
            <!-- Left Side Form -->
            <div class="w-full md:w-1/2 p-10 md:p-14">
                <div class="mb-10 text-center md:text-left">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">অ্যাকাউন্ট খুলুন</h3>
                    <p class="text-gray-500 text-sm">নতুন শিফট খুঁজে পেতে আজই যুক্ত হোন</p>
                </div>
                
                <form method="POST" action="{{ route('register.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">পূর্ণ নাম</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                        @error('name') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">ইমেইল অ্যাড্রেস</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="email@example.com" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                        @error('email') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">পাসওয়ার্ড</label>
                        <input id="password" type="password" name="password" required placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                        @error('password') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">পাসওয়ার্ড নিশ্চিত করুন</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                        @error('password_confirmation') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full text-black bg-yellow-500 hover:bg-yellow-600 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all shadow-lg shadow-yellow-500/30 hover:-translate-y-0.5">
                        রেজিস্টার করুন
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        আগে থেকেই অ্যাকাউন্ট আছে? <a href="{{ route('login') }}" class="font-bold text-yellow-600 hover:text-yellow-700 transition-colors">লগ ইন করুন</a>
                    </p>
                </div>
            </div>

            <!-- Right Side Image/Branding -->
            <div class="w-full md:w-1/2 bg-black relative p-12 text-white flex flex-col justify-between hidden md:flex">
                <div class="absolute inset-0 bg-gradient-to-bl from-yellow-500/20 to-black/80 z-0"></div>
                <!-- Abstract glowing orb -->
                <div class="absolute -bottom-12 -right-12 w-64 h-64 bg-yellow-500 rounded-full mix-blend-screen filter blur-3xl opacity-30"></div>
                
                <div class="relative z-10 mt-auto">
                    <h2 class="text-3xl font-bold mb-4">আপনার ক্যারিয়ার শুরু হোক এখান থেকে</h2>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        অ্যাকাউন্ট তৈরি করুন এবং হাজারো সুযোগের দরজা খুলে দিন। আপনার পছন্দের সময় অনুযায়ী কাজ করে আয় করুন।
                    </p>
                </div>
            </div>
            
        </div>
    </div>
</x-layouts.front>
