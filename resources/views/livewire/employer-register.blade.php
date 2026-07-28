<div>
    <div class="min-h-[calc(100vh-200px)] bg-[#faf9f6] flex items-center justify-center py-12 px-6">
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 overflow-hidden w-full max-w-4xl flex flex-col md:flex-row">
            
            <!-- Left Side Form -->
            <div class="w-full md:w-1/2 p-10 md:p-14">
                <div class="mb-10 text-center md:text-left">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">কোম্পানি অ্যাকাউন্ট খুলুন</h3>
                    <p class="text-gray-500 text-sm">সম্পূর্ণ ফ্রিতে শিফট পোস্ট করতে যুক্ত হোন</p>
                </div>
                
                <form wire:submit="register" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">আপনার নাম / কোম্পানির নাম</label>
                        <input wire:model="name" id="name" type="text" required autofocus placeholder="XYZ Company" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                        @error('name') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">ইমেইল অ্যাড্রেস</label>
                        <input wire:model="email" id="email" type="email" required placeholder="email@company.com" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                        @error('email') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">পাসওয়ার্ড</label>
                        <input wire:model="password" id="password" type="password" required placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                        @error('password') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">পাসওয়ার্ড নিশ্চিত করুন</label>
                        <input wire:model="password_confirmation" id="password_confirmation" type="password" required placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                        @error('password_confirmation') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full text-black bg-yellow-500 hover:bg-yellow-600 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all shadow-lg shadow-yellow-500/30 hover:-translate-y-0.5" wire:loading.attr="disabled">
                        <span wire:loading.remove>কোম্পানি একাউন্ট খুলুন</span>
                        <span wire:loading>অপেক্ষা করুন...</span>
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
                
                <!-- Student Switch Button -->
                <div class="relative z-10 flex justify-end">
                    <a href="{{ route('register') }}" wire:navigate class="inline-flex items-center px-4 py-2 border border-yellow-500/50 rounded-full text-sm font-medium text-yellow-500 hover:bg-yellow-500 hover:text-black transition-all duration-300">
                        শিক্ষার্থী হিসেবে যুক্ত হোন
                        <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <div class="relative z-10 mt-auto">
                    <h2 class="text-3xl font-bold mb-4">সেরা শিক্ষার্থীদের হায়ার করুন</h2>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        ক্যাটারিং, ডেলিভারি, প্যাকেজিং সহ যে কোনো কাজের জন্য দ্রুত নির্ভরযোগ্য কর্মী খুঁজে পান। সম্পূর্ণ বিনামূল্যে শিফট পোস্ট করুন।
                    </p>
                </div>
            </div>
            
        </div>
    </div>
</div>
