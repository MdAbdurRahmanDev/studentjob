<div>
    <div class="min-h-[calc(100vh-200px)] bg-[#faf9f6] flex items-center justify-center py-12 px-6">
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 overflow-hidden w-full max-w-4xl flex flex-col md:flex-row">
            
            <!-- Left Side Image/Branding -->
            <div class="w-full md:w-1/2 bg-black relative p-12 text-white flex flex-col justify-between hidden md:flex">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/20 to-black/80 z-0"></div>
                <!-- Abstract glowing orb -->
                <div class="absolute -top-12 -left-12 w-64 h-64 bg-yellow-500 rounded-full mix-blend-screen filter blur-3xl opacity-30"></div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold mb-4">পাসওয়ার্ড রিকভার করুন</h2>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        আপনার স্টুডেন্ট একাউন্টের পাসওয়ার্ড ভুলে গেলে আপনার রেজিস্টার্ড ফোন নম্বরের মাধ্যমে সহজেই নতুন পাসওয়ার্ড সেট করে নিতে পারেন।
                    </p>
                </div>
                
                <div class="relative z-10 mt-12">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center border border-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <span class="text-sm text-gray-300">নিরাপদ রিকভারি পদ্ধতি</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center border border-white/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-sm text-gray-300">দ্রুত SMS ভেরিফিকেশন</span>
                    </div>
                </div>
            </div>

            <!-- Right Side Form -->
            <div class="w-full md:w-1/2 p-10 md:p-14 relative overflow-hidden">
                @if(session('status'))
                    <div class="mb-4 text-center text-sm font-medium text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="relative w-full h-full">
                    
                    <!-- Step 1: Phone Number -->
                    @if($step === 1)
                    <div class="w-full transition-opacity duration-300">
                        <div class="mb-10 text-center md:text-left">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">পাসওয়ার্ড ভুলে গেছেন?</h3>
                            <p class="text-gray-500 text-sm">আপনার স্টুডেন্ট একাউন্টের ফোন নম্বর দিন</p>
                        </div>
                        
                        <form wire:submit="sendOtp" class="space-y-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">ফোন নম্বর</label>
                                <input wire:model="phone" id="phone" type="text" placeholder="01XXXXXXXXX" required autofocus class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                                @error('phone') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="w-full text-black bg-yellow-500 hover:bg-yellow-600 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all shadow-lg shadow-yellow-500/30 hover:-translate-y-0.5 flex justify-center items-center">
                                <span wire:loading.remove wire:target="sendOtp">OTP পাঠান</span>
                                <svg wire:loading wire:target="sendOtp" class="animate-spin -ml-1 mr-3 h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endif

                    <!-- Step 2: OTP Verification -->
                    @if($step === 2)
                    <div class="w-full transition-opacity duration-300">
                        <div class="mb-10 text-center md:text-left">
                            <button wire:click="$set('step', 1)" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 mb-6 transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                পিছনে যান
                            </button>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">OTP ভেরিফাই করুন</h3>
                            <p class="text-gray-500 text-sm">আপনার <strong>{{ $phone }}</strong> নম্বরে ৪ ডিজিটের একটি কোড পাঠানো হয়েছে।</p>
                        </div>
                        
                        <form wire:submit="verifyOtp" class="space-y-6">
                            <div>
                                <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">OTP কোড</label>
                                <input wire:model="otp" id="otp" type="text" placeholder="XXXX" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-center text-2xl tracking-[0.5em] rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors">
                                @error('otp') <span class="mt-2 text-sm text-red-600 block text-center">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="w-full text-black bg-yellow-500 hover:bg-yellow-600 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all shadow-lg shadow-yellow-500/30 hover:-translate-y-0.5 flex justify-center items-center">
                                <span wire:loading.remove wire:target="verifyOtp">ভেরিফাই করুন</span>
                                <svg wire:loading wire:target="verifyOtp" class="animate-spin -ml-1 mr-3 h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endif

                    <!-- Step 3: New Password -->
                    @if($step === 3)
                    <div class="w-full transition-opacity duration-300">
                        <div class="mb-10 text-center md:text-left">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">নতুন পাসওয়ার্ড সেট করুন</h3>
                            <p class="text-gray-500 text-sm">আপনার একাউন্টের জন্য নতুন পাসওয়ার্ড দিন।</p>
                        </div>
                        
                        <form wire:submit="changePassword" class="space-y-6">
                            <div x-data="{ show: false }">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">নতুন পাসওয়ার্ড</label>
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
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">কনফার্ম পাসওয়ার্ড</label>
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
                            </div>

                            <button type="submit" class="w-full text-black bg-yellow-500 hover:bg-yellow-600 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all shadow-lg shadow-yellow-500/30 hover:-translate-y-0.5 flex justify-center items-center">
                                <span wire:loading.remove wire:target="changePassword">পাসওয়ার্ড পরিবর্তন করুন</span>
                                <svg wire:loading wire:target="changePassword" class="animate-spin -ml-1 mr-3 h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endif

                </div>

                <!-- Footer Links -->
                @if($step === 1)
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        মনে পড়েছে? <a href="{{ route('login') }}" class="font-bold text-yellow-600 hover:text-yellow-700 transition-colors">লগ ইন করুন</a>
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
