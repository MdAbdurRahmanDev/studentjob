<div>
    <!-- Hero Section -->
    <div class="relative bg-black min-h-[600px] flex items-center">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Waiter" class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-transparent"></div>
        </div>

        <style>
            @keyframes rowLight {
                0% { background-color: transparent; }
                15% { background-color: rgba(255, 255, 255, 0.15); }
                30%, 100% { background-color: transparent; }
            }
            .animate-row-light-1 { animation: rowLight 3s infinite 0s; }
            .animate-row-light-2 { animation: rowLight 3s infinite 1s; }
            .animate-row-light-3 { animation: rowLight 3s infinite 2s; }
        </style>

        <!-- Content -->
        <div class="container mx-auto px-6 lg:px-12 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Left Side -->
            <div class="text-white pt-10 pb-16">
                <!-- Badge -->
                <div class="inline-flex items-center border border-yellow-500/50 rounded-full px-3 py-1 mb-6">
                    <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2 animate-pulse"></span>
                    <span class="text-yellow-500 text-xs font-semibold tracking-wider">লাইভ লাইন</span>
                </div>

                <!-- Headline -->
                <h1 class="text-4xl lg:text-5xl font-bold leading-tight mb-6">
                    শিক্ষার্থীদের পার্ট-টাইম <br>
                    কর্মসংস্থান আর <br>
                    <span class="text-yellow-500">বেকারত্ব দূরীকরণে</span> <br>
                    আমরা নিয়মিত কাজ করে <br>
                    যাচ্ছি।
                </h1>

                <!-- Subtitle -->
                <p class="text-gray-300 text-lg mb-8 max-w-xl leading-relaxed">
                    ক্যাটারিং, প্যাকেজিং, ডেলিভারি এবং অফিস সাপোর্ট শিফট — ঢাকার ভেরিফায়েড এমপ্লয়াররা পোস্ট করেন, আপনি এক ক্লিকে অ্যাপ্লাই করুন মাত্র ৳২০০/মাস সাবস্ক্রিপশনে।
                </p>

                <!-- Actions -->
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <button class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold rounded-full px-8 py-3 transition-colors">
                        কর্মী নিয়োগ করুন
                    </button>
                    <button class="bg-transparent hover:bg-white/10 border border-white/50 text-white font-medium rounded-full px-8 py-3 transition-colors">
                        আমি একজন শিক্ষার্থী
                    </button>
                </div>

                <!-- Footer Text -->
                <div class="text-gray-400 text-sm flex items-center space-x-3">
                    <span>৳২০০/মাস</span>
                    <span>|</span>
                    <span>৩-মাসের টাকা একসাথে দিলে ২০% ছাড়</span>
                </div>
            </div>

            <!-- Right Side (Shifts Box) -->
            <div class="flex items-center justify-end">
                <div class="bg-[#1a1b26]/80 backdrop-blur-md border border-gray-700/50 rounded-xl w-full max-w-md overflow-hidden shadow-2xl">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-700/50">
                        <h3 class="text-gray-300 font-medium">আজকের খোলা শিফট</h3>
                        <div class="flex items-center space-x-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                            <span class="text-yellow-500 text-xs font-semibold tracking-wider">LIVE</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col">
                        @forelse($shifts as $index => $shift)
                        <!-- Shift Item -->
                        <div class="flex justify-between items-center px-6 py-4 hover:bg-white/5 transition-colors {{ $index > 0 ? 'border-t border-gray-700/30' : '' }} animate-row-light-{{ ($index % 3) + 1 }}">
                            <div class="w-1/3 text-white font-medium">{{ $shift->title }}</div>
                            <div class="w-1/3 text-gray-400 text-sm">{{ $shift->location }}</div>
                            <div class="w-1/6 text-gray-400 text-sm">{{ $shift->time }}</div>
                            <div class="w-1/6 text-right text-yellow-500 font-semibold text-sm">{{ $shift->status }}</div>
                        </div>
                        @empty
                        <div class="px-6 py-4 text-gray-400 text-sm text-center">
                            আজকের জন্য কোনো শিফট নেই।
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- How it Works Section -->
    <div class="bg-[#faf9f6] py-20">
        <div class="container mx-auto px-6 lg:px-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-16 max-w-2xl leading-snug">
                যে শিক্ষার্থীর এই সপ্তাহেই টাকা দরকার, বছরের পর বছরের ক্যারিয়ার নয়।
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Step 1 -->
                <div class="border-t-2 border-yellow-500 pt-6">
                    <p class="text-gray-400 text-sm mb-3">ধাপ ১</p>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">প্রোফাইল তৈরি করুন</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        আপনার বিশ্ববিদ্যালয়, স্টুডেন্ট আইডি এবং পছন্দের কাজের ধরন যোগ করুন।
                    </p>
                </div>
                
                <!-- Step 2 -->
                <div class="border-t-2 border-yellow-500 pt-6">
                    <p class="text-gray-400 text-sm mb-3">ধাপ ২</p>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">সাবস্ক্রাইব করুন — ৳২০০/মাস</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        বিকাশ বা নগদের মাধ্যমে পে করুন এবং ট্রানজেকশন আইডি জমা দিন। কয়েক ঘণ্টার মধ্যেই ভেরিফাই হয়ে যাবে।
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="border-t-2 border-yellow-500 pt-6">
                    <p class="text-gray-400 text-sm mb-3">ধাপ ৩</p>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">এপ্লাই করুন ও কাজ করুন</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">
                        আপনার কাছের লাইভ শিফট ব্রাউজ করুন, এক ট্যাপে এপ্লাই করুন, আর কাজে হাজির হয়ে যান।
                    </p>
                </div>
            </div>
        </div>
    </div>    <!-- Available Shifts Section -->
    <div class="bg-white py-24 border-t border-gray-100">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">এভেইলেবল শিফটসমূহ</h2>
                    <p class="text-gray-500">আপনার আশেপাশের লেটেস্ট শিফটগুলোতে আজই এপ্লাই করুন</p>
                </div>
                <a href="{{ route('shifts.index') }}" class="hidden md:inline-flex items-center text-yellow-600 font-semibold hover:text-yellow-700 transition-colors">
                    সবগুলো দেখুন 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($shifts as $shift)
                <a href="{{ route('shifts.show', $shift->id) }}" class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative group block">
                    <!-- Status Badge -->
                    <div class="absolute top-6 right-6 flex items-center space-x-1.5">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        <span class="text-green-600 text-xs font-bold tracking-wider">{{ $shift->status }}</span>
                    </div>

                    <!-- Icon & Title -->
                    <div class="flex items-start mb-4">
                        <div class="w-12 h-12 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">{{ $shift->title }}</h3>
                            <p class="text-gray-400 text-sm mt-1 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $shift->location }}
                            </p>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="flex items-center justify-between py-4 border-y border-gray-100 mt-4 mb-4">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $shift->time }}
                        </div>
                        <div class="flex items-center text-sm font-semibold text-gray-700">
                            ৳২০০/ঘণ্টা
                        </div>
                    </div>

                    <!-- Action -->
                    <button class="w-full py-3 bg-gray-50 hover:bg-yellow-500 hover:text-black text-gray-700 font-semibold rounded-xl transition-colors duration-300">
                        এপ্লাই করুন
                    </button>
                </a>
                @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                    <p class="text-gray-500">এই মুহূর্তে কোনো শিফট এভেইলেবল নেই।</p>
                </div>
                @endforelse
            </div>

            <div class="mt-8 text-center md:hidden">
                <a href="{{ route('shifts.index') }}" class="inline-flex items-center text-yellow-600 font-semibold hover:text-yellow-700 transition-colors">
                    সবগুলো দেখুন 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="bg-[#111424] py-16">
        <div class="container mx-auto px-6 lg:px-12 flex flex-col md:flex-row items-center justify-between">
            <div class="mb-8 md:mb-0 max-w-2xl">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">দ্রুত, নির্ভরযোগ্য শিক্ষার্থী দরকার?</h2>
                <p class="text-gray-400 text-sm md:text-base leading-relaxed">
                    দুই মিনিটের কম সময়ে একটি শিফট পোস্ট করুন, আবেদনকারীরা যেভাবে আসছেন, সেভাবেই দেখুন।
                </p>
            </div>
            <div>
                <button class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold rounded-full px-8 py-3 transition-colors shadow-lg">
                    কর্মী নিয়োগ করুন — সম্পূর্ণ ফ্রি
                </button>
            </div>
        </div>
    </div>

</div>
