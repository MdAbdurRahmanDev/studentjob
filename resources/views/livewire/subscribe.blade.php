<div>
    <div class="min-h-[calc(100vh-200px)] bg-[#faf9f6] flex items-center justify-center py-12 px-6">
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 overflow-hidden w-full max-w-4xl flex flex-col md:flex-row">
            
            <!-- Left Side Info -->
            <div class="w-full md:w-1/2 bg-black relative p-12 text-white flex flex-col">
                @if (session('error'))
                    <div class="absolute top-4 left-4 right-4 bg-red-500 text-white px-4 py-3 rounded-xl shadow-lg z-50 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-bl from-yellow-500/20 to-black/80 z-0"></div>
                <!-- Abstract glowing orb -->
                <div class="absolute -bottom-12 -right-12 w-64 h-64 bg-yellow-500 rounded-full mix-blend-screen filter blur-3xl opacity-30"></div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold mb-4">সাবস্ক্রাইব করুন</h2>
                    <p class="text-gray-300 text-sm leading-relaxed mb-8">
                        মাত্র ৳২০০/মাস সাবস্ক্রিপশনে আনলিমিটেড শিফটে এপ্লাই করার সুযোগ নিন। পেমেন্ট সম্পন্ন করে নিচের ফর্মটি পূরণ করুন।
                    </p>

                    <div class="space-y-6">
                        @foreach($paymentMethods as $method)
                        <div class="bg-white/10 border border-white/20 p-4 rounded-xl backdrop-blur-sm">
                            <div class="flex items-center space-x-3 mb-2">
                                @if($method->logo)
                                    <div class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center bg-white p-1">
                                        <img src="{{ Storage::disk('uploads')->url($method->logo) }}" alt="{{ $method->name }}" class="w-full h-full object-contain">
                                    </div>
                                @else
                                    <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <h3 class="font-bold">{{ $method->name }} সেন্ড মানি</h3>
                            </div>
                            <p class="text-xl font-mono text-yellow-500 font-bold tracking-wider">{{ $method->number }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Side Form -->
            <div class="w-full md:w-1/2 p-10 md:p-14">
                <div class="mb-10 text-center md:text-left">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">পেমেন্ট ভেরিফাই করুন</h3>
                    <p class="text-gray-500 text-sm">পেমেন্ট করার পর ট্রানজেকশন আইডি দিন</p>
                </div>
                
                <form wire:submit="submit" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">পেমেন্ট মেথড নির্বাচন করুন</label>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($paymentMethods as $method)
                            <label class="cursor-pointer">
                                <input type="radio" wire:model="payment_method" value="{{ $method->name }}" class="peer sr-only">
                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4 hover:bg-gray-100 peer-checked:border-pink-500 peer-checked:bg-pink-50 peer-checked:ring-1 peer-checked:ring-pink-500 transition-all text-center">
                                    <span class="font-bold text-gray-800">{{ $method->name }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('payment_method') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="transaction_id" class="block text-sm font-medium text-gray-700 mb-2">ট্রানজেকশন আইডি (TrxID)</label>
                        <input wire:model="transaction_id" id="transaction_id" type="text" required placeholder="যেমন: 8N4MN5..." class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block p-3.5 transition-colors uppercase">
                        @error('transaction_id') <span class="mt-2 text-sm text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full text-black bg-yellow-500 hover:bg-yellow-600 font-bold rounded-xl text-sm px-5 py-4 text-center transition-all shadow-lg shadow-yellow-500/30 hover:-translate-y-0.5" wire:loading.attr="disabled">
                        <span wire:loading.remove>সাবমিট করুন</span>
                        <span wire:loading>অপেক্ষা করুন...</span>
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</div>
