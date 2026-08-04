<div>
    <div class="min-h-[calc(100vh-200px)] bg-[#faf9f6] flex items-center justify-center py-12 px-6">
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 overflow-hidden w-full max-w-4xl flex flex-col md:flex-row">
            
            <!-- Left Side Form -->
            <div class="w-full md:w-1/2 p-10 md:p-14">
                <div class="mb-10 text-center md:text-left">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">কোম্পানি অ্যাকাউন্ট খুলুন</h3>
                    <p class="text-gray-500 text-sm">সম্পূর্ণ ফ্রিতে শিফট পোস্ট করতে যুক্ত হোন</p>
                </div>
                
                @if($step === 1)
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
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">ফোন নম্বর <span class="text-red-500">*</span></label>
                        <input wire:model="phone" id="phone" type="tel" required placeholder="01XXXXXXXXX" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                        @error('phone') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div x-data="{ show: false }">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">পাসওয়ার্ড</label>
                        <div class="relative">
                            <input wire:model="password" id="password" :type="show ? 'text' : 'password'" required placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 pr-12 transition-colors">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-gray-700">
                                <!-- Eye Open -->
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <!-- Eye Closed -->
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div x-data="{ show: false }">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">পাসওয়ার্ড নিশ্চিত করুন</label>
                        <div class="relative">
                            <input wire:model="password_confirmation" id="password_confirmation" :type="show ? 'text' : 'password'" required placeholder="••••••••" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 pr-12 transition-colors">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-gray-700">
                                <!-- Eye Open -->
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <!-- Eye Closed -->
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full text-black bg-yellow-500 hover:bg-yellow-600 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all shadow-lg shadow-yellow-500/30 hover:-translate-y-0.5 flex justify-center items-center" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="register">পরবর্তী ধাপ</span>
                        <svg wire:loading wire:target="register" class="animate-spin -ml-1 mr-3 h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>
                @endif

                <!-- Step 2: OTP Verification -->
                @if($step === 2)
                <div class="w-full transition-opacity duration-300">
                    <div class="mb-10 text-center md:text-left">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">ওটিপি (OTP) ভেরিফিকেশন</h3>
                        <p class="text-gray-500 text-sm">আপনার ফোন নম্বরে পাঠানো ৪-ডিজিটের কোডটি দিন।</p>
                    </div>
                    
                    <form wire:submit="verifyOtp" class="space-y-6">
                        <div>
                            <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">৪-ডিজিটের কোড</label>
                            <input wire:model="otp" id="otp" type="text" maxlength="4" required placeholder="1234" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-center text-2xl tracking-[1em] font-mono rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                            @error('otp') <span class="mt-2 text-sm text-red-600 block text-center">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full text-black bg-yellow-500 hover:bg-yellow-600 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all shadow-lg shadow-yellow-500/30 hover:-translate-y-0.5 flex justify-center items-center">
                            <span wire:loading.remove wire:target="verifyOtp">একাউন্ট তৈরি করুন</span>
                            <svg wire:loading wire:target="verifyOtp" class="animate-spin -ml-1 mr-3 h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
                @endif

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
