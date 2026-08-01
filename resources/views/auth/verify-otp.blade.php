<x-layouts.front>
    <div class="min-h-[calc(100vh-200px)] bg-[#faf9f6] flex items-center justify-center py-12 px-6">
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 overflow-hidden w-full max-w-md p-10">
            
            <div class="mb-8 text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">ভেরিফিকেশন কোড</h3>
                <p class="text-gray-500 text-sm">আপনার ফোন নম্বরে একটি ৪ ডিজিটের কোড পাঠানো হয়েছে। দয়া করে কোডটি নিচে দিন।</p>
            </div>
            
            @if(session('status'))
                <div class="mb-4 text-center text-sm font-medium text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.verify.post') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="otp" class="block text-sm font-medium text-gray-700 mb-2 text-center">OTP কোড</label>
                    <input id="otp" type="text" name="otp" required autofocus placeholder="----" maxlength="4" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-3xl tracking-[1em] text-center rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-4 transition-colors font-mono">
                    @error('otp') <span class="mt-2 text-sm text-red-600 block text-center">{{ $message }}</span> @enderror
                    @error('login') <span class="mt-2 text-sm text-red-600 block text-center">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full text-black bg-yellow-500 hover:bg-yellow-600 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all shadow-lg shadow-yellow-500/30 hover:-translate-y-0.5">
                    যাচাই করুন
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">
                    লগইন পেজে ফিরে যান
                </a>
            </div>
        </div>
    </div>
</x-layouts.front>
