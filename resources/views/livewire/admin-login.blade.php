<div class="min-h-[calc(100vh-200px)] bg-[#111424] flex items-center justify-center py-12 px-6">
    <div class="bg-gray-900 border border-gray-800 rounded-3xl shadow-2xl shadow-black/50 overflow-hidden w-full max-w-4xl flex flex-col md:flex-row relative">
        
        <!-- Glowing background effect -->
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-yellow-500 rounded-full mix-blend-screen filter blur-[100px] opacity-10 pointer-events-none"></div>

        <!-- Left Side Form -->
        <div class="w-full md:w-1/2 p-10 md:p-14 relative z-10">
            <div class="mb-10 text-center md:text-left">
                <div class="inline-block px-3 py-1 mb-4 rounded-full bg-yellow-500/10 border border-yellow-500/20 text-yellow-500 text-xs font-bold tracking-widest uppercase">
                    অ্যাডমিন পোর্টাল
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">লগ ইন করুন</h3>
                <p class="text-gray-400 text-sm">শুধুমাত্র অনুমোদিত অ্যাডমিনদের জন্য</p>
            </div>
            
            @if (session('status'))
                <div class="mb-4 text-center text-sm font-medium text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            <form wire:submit="login" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">ইমেইল অ্যাড্রেস</label>
                    <input id="email" type="email" wire:model="email" required autofocus placeholder="admin@example.com" class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors placeholder-gray-600">
                    @error('email') <span class="mt-2 text-sm text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-medium text-gray-300">পাসওয়ার্ড</label>
                    </div>
                    <input id="password" type="password" wire:model="password" required placeholder="••••••••" class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors placeholder-gray-600">
                    @error('password') <span class="mt-2 text-sm text-red-400">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center">
                    <input id="remember" type="checkbox" wire:model="remember" class="w-4 h-4 text-yellow-500 bg-gray-800 border-gray-700 rounded focus:ring-yellow-500 focus:ring-2 cursor-pointer">
                    <label for="remember" class="ml-2 text-sm font-medium text-gray-400 cursor-pointer">আমাকে মনে রাখুন</label>
                </div>

                <button type="submit" class="w-full text-black bg-yellow-500 hover:bg-yellow-600 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all shadow-lg shadow-yellow-500/10 hover:-translate-y-0.5 mt-4" wire:loading.attr="disabled">
                    <span wire:loading.remove>অ্যাডমিন লগ ইন</span>
                    <span wire:loading>লগ ইন হচ্ছে...</span>
                </button>
            </form>
        </div>

        <!-- Right Side Brand -->
        <div class="w-full md:w-1/2 bg-black relative p-12 text-white flex flex-col justify-center items-center hidden md:flex border-l border-gray-800 z-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-yellow-500 mb-6 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <h2 class="text-3xl font-bold mb-3 text-center">নিরাপদ অ্যাক্সেস</h2>
            <p class="text-gray-400 text-sm text-center max-w-xs leading-relaxed">
                সিস্টেম অ্যাডমিনিস্ট্রেশন, ইউজার ম্যানেজমেন্ট এবং ডেটা এনালিটিক্সের জন্য লগ ইন করুন।
            </p>
        </div>
        
    </div>
</div>
