<x-layouts.front>
    <div class="bg-[#faf9f6] min-h-[calc(100vh-200px)] py-12">
        <div class="container mx-auto px-6 lg:px-12">
            
            @if (session('error'))
                <div class="mb-8 p-4 bg-red-100 border border-red-200 text-red-600 rounded-xl flex items-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Welcome Header -->
            <div class="bg-black text-white rounded-3xl p-10 md:p-14 relative overflow-hidden mb-10 shadow-xl shadow-black/10">
                <div class="absolute -right-24 -top-24 w-96 h-96 bg-yellow-500 rounded-full mix-blend-screen filter blur-[80px] opacity-30"></div>
                
                <div class="relative z-10">
                    <h1 class="text-3xl md:text-4xl font-bold mb-3">স্বাগতম, {{ auth()->user()->name }}!</h1>
                    <p class="text-gray-300 text-lg">আপনার ড্যাশবোর্ডে আপনাকে স্বাগতম। এখান থেকে আপনি আপনার প্রোফাইল এবং শিফট পরিচালনা করতে পারবেন।</p>
                </div>
            </div>

            <!-- Stats/Actions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Card 1 -->
                <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-lg transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">এপ্লাইকৃত শিফট</h3>
                    <p class="text-gray-500 mb-4">আপনি এখনো কোনো শিফটে এপ্লাই করেননি।</p>
                    <a href="{{ route('shifts.index') }}" class="text-yellow-600 font-semibold hover:text-yellow-700 flex items-center">
                        শিফট খুঁজুন 
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-lg transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">প্রোফাইল</h3>
                    <p class="text-gray-500 mb-4">আপনার অ্যাকাউন্ট তথ্য আপডেট করুন।</p>
                    <a href="{{ route('profile.edit') }}" class="text-blue-600 font-semibold hover:text-blue-700 flex items-center">
                        প্রোফাইল দেখুন
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm hover:shadow-lg transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">অপেক্ষারত কাজ</h3>
                    <p class="text-gray-500 mb-4">আপনার কোনো শিফট বর্তমানে অপেক্ষমান নেই।</p>
                </div>
            </div>

            <!-- Notice Section -->
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    গুরুত্বপূর্ণ নোটিশ
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    অনুগ্রহ করে আপনার প্রোফাইল সম্পূর্ণ করুন যাতে নিয়োগদাতারা আপনার সম্পর্কে আরও জানতে পারে। প্রোফাইল সম্পূর্ণ থাকলে আপনার কাজ পাওয়ার সম্ভাবনা বেড়ে যায়।
                </p>
            </div>

        </div>
    </div>
</x-layouts.front>
