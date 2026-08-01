<div>
    <!-- Hero Section -->
    <div class="relative bg-black min-h-[340px] sm:min-h-[450px] lg:min-h-[600px] flex items-start lg:items-center">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
                alt="Waiter" class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-transparent"></div>
        </div>

        <!-- Content -->
        <div class="container mx-auto px-6 lg:px-12 relative z-10 grid grid-cols-1 lg:[grid-template-columns:1fr_380px] gap-10">
            <!-- Left Side -->
            <div
                class="text-white pt-16 md:pt-10 lg:pt-[15px] pb-10 md:pb-16 lg:pb-[15px] text-center lg:text-left flex flex-col items-center lg:items-start">
                <style>
                    @media (max-width: 1024px) {
                        .hero-title br {
                            display: none;
                        }
                    }
                </style>
                <!-- Badge -->


                <!-- Headline -->
                <h1
                    class="hero-title text-3xl sm:text-4xl lg:text-5xl font-bold leading-snug lg:leading-tight mb-4 lg:mb-6">
                    {!! \App\Models\Setting::get(
                        'home_hero_title',
                        'শিক্ষার্থীদের পার্ট-টাইম <br> কর্মসংস্থান আর <br> <span class="text-yellow-500">বেকারত্ব দূরীকরণে</span> <br> আমরা নিয়মিত কাজ করে <br> যাচ্ছি।',
                    ) !!}
                </h1>


                <!-- Subtitle -->
                <p class="hidden lg:block text-gray-300 text-base lg:text-lg leading-relaxed mb-6 max-w-lg">
                    {!! \App\Models\Setting::get('home_hero_subtitle', 'ক্যাটারিং, প্যাকেজিং, ডেলিভারি এবং অফিস সাপোর্ট শিফট — ঢাকার ভেরিফায়েড এমপ্লয়াররা পোস্ট করেন, আপনি এক ক্লিকে অ্যাপ্লাই করুন মাত্র ৳২০০/মাস সাবস্ক্রিপশনে।') !!}
                </p>

                <!-- Actions -->
                <div class="flex flex-row items-center w-full lg:w-auto gap-2 sm:gap-3 mb-6">
                    <a href="{{ route('employer.register') }}" wire:navigate
                        class="flex-1 lg:flex-none text-center bg-yellow-500 hover:bg-yellow-600 text-black font-semibold rounded-full px-3 py-2.5 lg:px-5 lg:py-2 text-sm transition-colors">
                        কর্মী নিয়োগ করুন
                    </a>
                    <a href="{{ route('register') }}" wire:navigate
                        class="flex-1 lg:flex-none text-center bg-transparent hover:bg-white/10 border border-white/50 text-white font-medium rounded-full px-3 py-2.5 lg:px-5 lg:py-2 text-sm transition-colors">
                        আমি একজন শিক্ষার্থী
                    </a>
                </div>

                <!-- Footer Text -->
                <div
                    class="text-gray-400 text-xs sm:text-sm flex items-center justify-center lg:justify-start space-x-2 sm:space-x-3">
                    <span>৳২০০/মাস</span>
                    <span class="text-gray-500">|</span>
                    <span>৩-মাসের টাকা একসাথে দিলে ২০% ছাড়</span>
                </div>
            </div>

            <!-- Right Side (Ads Slider) -->
            <div
                class="hidden lg:flex items-center justify-center w-full mt-10 lg:mt-0">
                <div class="relative w-full overflow-hidden shadow-2xl group border border-white/10 bg-[#1a1b26]"
                    id="ad-slider" style="height: 450px; border-radius: 1.5rem;">
                    @forelse ($ads as $index => $ad)
                        <!-- Dynamic Slide {{ $index + 1 }} -->
                        <div
                            class="ad-slide absolute inset-0 w-full h-full transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}">
                            @if ($ad->image)
                                <img src="{{ Storage::disk('uploads')->url($ad->image) }}"
                                    class="absolute inset-0 w-full h-full object-cover" alt="{{ $ad->title }}">
                            @else
                                <div class="absolute inset-0 w-full h-full bg-gray-800"></div>
                            @endif
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/70 to-transparent opacity-90">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 right-0 p-6 transform transition-transform duration-700">
                                @if ($ad->tag)
                                    <span
                                        class="inline-block px-3 py-1 bg-yellow-500 text-black text-[10px] font-bold uppercase tracking-widest rounded-full mb-3"
                                        style="box-shadow: 0 0 10px rgba(234,179,8,0.4);">{{ $ad->tag }}</span>
                                @endif
                                <h3 class="text-2xl font-bold text-white mb-2 leading-tight">{{ $ad->title }}</h3>
                                @if ($ad->description)
                                    <p class="text-gray-300 text-xs mb-5 line-clamp-2 leading-relaxed">
                                        {{ $ad->description }}</p>
                                @endif
                                @if ($ad->link)
                                    <a href="{{ $ad->link }}"
                                        class="group flex items-center justify-center w-full py-3 bg-yellow-500 text-black text-sm font-bold rounded-xl hover:bg-yellow-400 transition-all duration-300 shadow-[0_0_15px_rgba(234,179,8,0.3)] hover:shadow-[0_0_20px_rgba(234,179,8,0.5)] transform hover:-translate-y-0.5">
                                        Visit Now
                                        <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform duration-300"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <!-- Default Slide -->
                        <div
                            class="ad-slide absolute inset-0 w-full h-full transition-opacity duration-1000 opacity-100 z-10">
                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                class="absolute inset-0 w-full h-full object-cover" alt="Premium Employers">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-[#0f172a]/70 to-transparent opacity-90">
                            </div>
                            <div
                                class="absolute bottom-0 left-0 right-0 p-6 transform transition-transform duration-700">
                                <span
                                    class="inline-block px-3 py-1 bg-yellow-500 text-black text-[10px] font-bold uppercase tracking-widest rounded-full mb-3"
                                    style="box-shadow: 0 0 10px rgba(234,179,8,0.4);">Featured Ad</span>
                                <h3 class="text-2xl font-bold text-white mb-2 leading-tight">Premium Employers</h3>
                                <p class="text-gray-300 text-xs mb-5 line-clamp-2 leading-relaxed">Get access to
                                    top-tier companies offering the best hourly rates in Dhaka.</p>
                                <a href="{{ route('register') }}" wire:navigate
                                    class="group flex items-center justify-center w-full py-3 bg-yellow-500 text-black text-sm font-bold rounded-xl hover:bg-yellow-400 transition-all duration-300 shadow-[0_0_15px_rgba(234,179,8,0.3)] hover:shadow-[0_0_20px_rgba(234,179,8,0.5)] transform hover:-translate-y-0.5">
                                    Visit Now
                                    <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform duration-300"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforelse

                </div>

                <script>
                    (function() {
                        let sliderInterval;

                        function initSlider() {
                            if (sliderInterval) clearInterval(sliderInterval);
                            let slides = document.querySelectorAll('.ad-slide');
                            let currentSlide = 0;
                            if (slides.length > 0) {
                                sliderInterval = setInterval(() => {
                                    slides[currentSlide].classList.remove('opacity-100', 'z-10');
                                    slides[currentSlide].classList.add('opacity-0', 'z-0');
                                    currentSlide = (currentSlide + 1) % slides.length;
                                    slides[currentSlide].classList.remove('opacity-0', 'z-0');
                                    slides[currentSlide].classList.add('opacity-100', 'z-10');
                                }, 4000);
                            }
                        }

                        document.addEventListener('livewire:navigated', initSlider);
                        initSlider();
                    })();
                </script>
            </div>
        </div>
    </div>

    {{-- Categories Section --}}
    <div class="bg-gray-50 py-16 border-t border-gray-100">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mb-10 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">ক্যাটাগরি অনুযায়ী খুঁজুন</h2>
                <p class="text-gray-500">আপনার পছন্দের ক্যাটাগরি থেকে জব বেছে নিন</p>
            </div>

            {{-- Desktop: সব দেখাবে --}}
            <div class="hidden sm:grid sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6 md:gap-8 lg:gap-y-10">
                <a href="{{ route('shifts.index') }}" wire:navigate
                    class="bg-white rounded-2xl p-6 flex flex-col items-center justify-center text-center border-2 border-transparent hover:border-yellow-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm mb-1.5 whitespace-normal leading-tight">সব ক্যাটাগরি</h3>
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('shifts.index', ['category' => $category->id]) }}" wire:navigate
                        class="bg-white rounded-2xl p-6 flex flex-col items-center justify-center text-center border-2 border-transparent hover:border-yellow-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="w-14 h-14 bg-gray-50 rounded-full flex items-center justify-center mb-4 overflow-hidden transition-colors">
                            @if ($category->icon)
                                <img src="{{ Storage::url($category->icon) }}" class="w-8 h-8 object-contain" alt="{{ $category->name }}">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            @endif
                        </div>
                        <h3 class="font-bold text-gray-900 text-sm mb-1.5 whitespace-normal leading-tight w-full">{{ $category->name }}</h3>
                        <span class="text-[11px] font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full mt-auto">{{ $category->jobs_count }} টি জব</span>
                    </a>
                @endforeach
            </div>

            {{-- Mobile: প্রথম ৪টা দেখাবে --}}
            <div class="grid grid-cols-2 gap-4 sm:hidden">
                @php $mobileCategories = $categories->take(3); @endphp

                {{-- সব ক্যাটাগরি card --}}
                <a href="{{ route('shifts.index') }}" wire:navigate
                    class="bg-white rounded-2xl p-4 flex flex-col items-center justify-center text-center border-2 border-transparent hover:border-yellow-300 transition-all duration-300">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3 text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-xs leading-tight">সব ক্যাটাগরি</h3>
                </a>

                @foreach ($mobileCategories as $category)
                    <a href="{{ route('shifts.index', ['category' => $category->id]) }}" wire:navigate
                        class="bg-white rounded-2xl p-4 flex flex-col items-center justify-center text-center border-2 border-transparent hover:border-yellow-300 transition-all duration-300">
                        <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-3 overflow-hidden">
                            @if ($category->icon)
                                <img src="{{ Storage::url($category->icon) }}" class="w-7 h-7 object-contain" alt="{{ $category->name }}">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            @endif
                        </div>
                        <h3 class="font-bold text-gray-900 text-xs leading-tight w-full">{{ $category->name }}</h3>
                        <span class="text-[10px] font-medium text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full mt-1">{{ $category->jobs_count }} টি জব</span>
                    </a>
                @endforeach

                {{-- আরো ক্যাটাগরি দেখুন বাটন --}}
                @if ($categories->count() > 3)
                    <button onclick="document.getElementById('category-bottom-sheet').classList.remove('translate-y-full'); document.getElementById('category-sheet-backdrop').classList.remove('hidden');"
                        class="bg-white rounded-2xl p-4 flex flex-col items-center justify-center text-center border-2 border-dashed border-yellow-300 transition-all duration-300 col-span-2">
                        <div class="w-12 h-12 bg-yellow-50 rounded-full flex items-center justify-center mb-2 text-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </div>
                        <span class="font-bold text-yellow-600 text-sm">আরো ক্যাটাগরি দেখুন</span>
                        <span class="text-[10px] text-gray-400 mt-0.5">{{ $categories->count() - 3 }}টি আরো আছে</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- How it Works Section -->
    <div class="bg-[#faf9f6] py-24 relative overflow-hidden">
        <!-- Subtle Pattern Background -->
        <div class="absolute inset-0 opacity-[0.04]"
            style="background-image: radial-gradient(#000 1.5px, transparent 1.5px); background-size: 24px 24px;"></div>

        <div class="container mx-auto px-6 lg:px-12 relative z-10">
            <div class="text-center max-w-4xl mx-auto mb-20">
                <span
                    class="inline-block px-4 py-1.5 bg-yellow-100 text-yellow-700 font-bold tracking-wider uppercase rounded-full text-xs mb-5 shadow-sm">কিভাবে
                    কাজ করে?</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 leading-snug">
                    {!! \App\Models\Setting::get(
                        'home_middle_title',
                        'যে শিক্ষার্থীর এই সপ্তাহেই টাকা দরকার, বছরের পর বছরের ক্যারিয়ার নয়।',
                    ) !!}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 lg:gap-12 relative pt-6">
                <!-- Connecting Line (Desktop) -->
                <div
                    class="hidden md:block absolute top-12 left-[15%] right-[15%] h-[2px] bg-transparent border-t-2 border-dashed border-yellow-300 z-0">
                </div>

                <!-- Step 1 -->
                <div
                    class="bg-white rounded-3xl p-8 shadow-[0_10px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(234,179,8,0.12)] border border-gray-100 transform hover:-translate-y-2 transition-all duration-300 relative group z-10">
                    <div
                        class="w-16 h-16 bg-yellow-500 text-black text-2xl font-extrabold rounded-full flex items-center justify-center shadow-lg mx-auto -mt-16 mb-6 border-4 border-white group-hover:scale-110 group-hover:rotate-6 transition-transform">
                        ১</div>
                    <h3
                        class="text-xl font-bold text-gray-900 mb-4 text-center group-hover:text-yellow-600 transition-colors">
                        প্রোফাইল তৈরি করুন</h3>
                    <p class="text-gray-500 leading-relaxed text-sm text-center">
                        আপনার বিশ্ববিদ্যালয়, স্টুডেন্ট আইডি এবং পছন্দের কাজের ধরন যোগ করুন।
                    </p>
                </div>

                <!-- Step 2 -->
                <div
                    class="bg-white rounded-3xl p-8 shadow-[0_10px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(234,179,8,0.12)] border border-gray-100 transform hover:-translate-y-2 transition-all duration-300 relative group z-10 mt-10 md:mt-0">
                    <div
                        class="w-16 h-16 bg-yellow-500 text-black text-2xl font-extrabold rounded-full flex items-center justify-center shadow-lg mx-auto -mt-16 mb-6 border-4 border-white group-hover:scale-110 group-hover:-rotate-6 transition-transform">
                        ২</div>
                    <h3
                        class="text-xl font-bold text-gray-900 mb-4 text-center group-hover:text-yellow-600 transition-colors">
                        সাবস্ক্রাইব করুন — ৳২০০/মাস</h3>
                    <p class="text-gray-500 leading-relaxed text-sm text-center">
                        বিকাশ বা নগদের মাধ্যমে পে করুন এবং ট্রানজেকশন আইডি জমা দিন। কয়েক ঘণ্টার মধ্যেই ভেরিফাই হয়ে যাবে।
                    </p>
                </div>

                <!-- Step 3 -->
                <div
                    class="bg-white rounded-3xl p-8 shadow-[0_10px_30px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(234,179,8,0.12)] border border-gray-100 transform hover:-translate-y-2 transition-all duration-300 relative group z-10 mt-10 md:mt-0">
                    <div
                        class="w-16 h-16 bg-yellow-500 text-black text-2xl font-extrabold rounded-full flex items-center justify-center shadow-lg mx-auto -mt-16 mb-6 border-4 border-white group-hover:scale-110 group-hover:rotate-6 transition-transform">
                        ৩</div>
                    <h3
                        class="text-xl font-bold text-gray-900 mb-4 text-center group-hover:text-yellow-600 transition-colors">
                        এপ্লাই করুন ও কাজ করুন</h3>
                    <p class="text-gray-500 leading-relaxed text-sm text-center">
                        আপনার কাছের লাইভ শিফট ব্রাউজ করুন, এক ট্যাপে এপ্লাই করুন, আর কাজে হাজির হয়ে যান।
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Sheet Backdrop --}}
    <div id="category-sheet-backdrop"
        class="hidden fixed inset-0 bg-black/50 z-40 sm:hidden"
        onclick="document.getElementById('category-bottom-sheet').classList.add('translate-y-full'); this.classList.add('hidden');">
    </div>

    {{-- Bottom Sheet --}}
    <div id="category-bottom-sheet"
        class="fixed bottom-0 left-0 right-0 z-50 bg-white rounded-t-3xl shadow-2xl translate-y-full transition-transform duration-300 ease-out sm:hidden"
        style="max-height: 80vh; overflow-y: auto;">
        {{-- Handle Bar --}}
        <div class="flex justify-center pt-3 pb-2">
            <div class="w-10 h-1 bg-gray-300 rounded-full"></div>
        </div>
        {{-- Header --}}
        <div class="flex items-center justify-between px-5 pb-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900">সব ক্যাটাগরি</h3>
            <button onclick="document.getElementById('category-bottom-sheet').classList.add('translate-y-full'); document.getElementById('category-sheet-backdrop').classList.add('hidden');"
                class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        {{-- All Categories Grid --}}
        <div class="grid grid-cols-3 gap-3 p-4">
            <a href="{{ route('shifts.index') }}" wire:navigate
                class="bg-gray-50 rounded-2xl p-3 flex flex-col items-center justify-center text-center border-2 border-transparent hover:border-yellow-300 transition-all duration-300">
                <div class="w-11 h-11 bg-gray-100 rounded-full flex items-center justify-center mb-2 text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-[11px] leading-tight">সব</h3>
            </a>
            @foreach ($categories as $category)
                <a href="{{ route('shifts.index', ['category' => $category->id]) }}" wire:navigate
                    class="bg-gray-50 rounded-2xl p-3 flex flex-col items-center justify-center text-center border-2 border-transparent hover:border-yellow-300 transition-all duration-300">
                    <div class="w-11 h-11 bg-white rounded-full flex items-center justify-center mb-2 overflow-hidden">
                        @if ($category->icon)
                            <img src="{{ Storage::url($category->icon) }}" class="w-6 h-6 object-contain" alt="{{ $category->name }}">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        @endif
                    </div>
                    <h3 class="font-bold text-gray-900 text-[11px] leading-tight w-full">{{ $category->name }}</h3>
                    <span class="text-[9px] font-medium text-gray-500 bg-gray-200 px-1.5 py-0.5 rounded-full mt-1">{{ $category->jobs_count }} টি</span>
                </a>
            @endforeach
        </div>
        <div class="h-6"></div>
    </div>


    <!-- Available Shifts Section -->
    <div class="bg-white py-24 border-t border-gray-100" id="jobs-section">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">এভেইলেবল শিফটসমূহ</h2>
                    <p class="text-gray-500">আপনার আশেপাশের লেটেস্ট শিফটগুলোতে আজই এপ্লাই করুন</p>
                </div>
                <a href="{{ route('shifts.index') }}" wire:navigate
                    class="hidden md:inline-flex items-center text-yellow-600 font-semibold hover:text-yellow-700 transition-colors">
                    সবগুলো দেখুন
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($shifts as $shift)
                    <a href="{{ route('shifts.show', $shift->id) }}" wire:navigate
                        class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative group block">
                        <!-- Status Badge -->
                        <div class="absolute top-6 right-6 flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-green-600 text-xs font-bold tracking-wider">{{ $shift->status }}</span>
                        </div>

                        <!-- Icon & Title -->
                        <div class="flex items-start mb-4">
                            <div
                                class="w-12 h-12 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3
                                    class="text-xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">
                                    {{ $shift->title }}</h3>
                                <p class="text-gray-400 text-sm mt-1 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $shift->location }}
                                </p>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="flex items-center justify-between py-4 border-y border-gray-100 mt-4 mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @if ($shift->start_datetime && $shift->end_datetime)
                                    {{ \Carbon\Carbon::parse($shift->start_datetime)->format('M d, g:i A') }} -
                                    {{ \Carbon\Carbon::parse($shift->end_datetime)->format('M d, g:i A') }}
                                @else
                                    {{ $shift->time }}
                                @endif
                            </div>
                            <div class="flex items-center text-sm font-semibold text-gray-700">
                                ৳২০০/ঘণ্টা
                            </div>
                        </div>

                        <!-- Action -->
                        <button
                            class="w-full py-3 bg-gray-50 hover:bg-yellow-500 hover:text-black text-gray-700 font-semibold rounded-xl transition-colors duration-300">
                            এপ্লাই করুন
                        </button>
                    </a>
                @empty
                    <div
                        class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                        <p class="text-gray-500">এই মুহূর্তে কোনো শিফট এভেইলেবল নেই।</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 text-center md:hidden">
                <a href="{{ route('shifts.index') }}" wire:navigate
                    class="inline-flex items-center text-yellow-600 font-semibold hover:text-yellow-700 transition-colors">
                    সবগুলো দেখুন
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
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
                <a href="{{ route('employer.register') }}" wire:navigate
                    class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold rounded-full px-8 py-3 transition-colors shadow-lg">
                    কর্মী নিয়োগ করুন — সম্পূর্ণ ফ্রি
                </a>
            </div>
        </div>
    </div>

    <!-- Information Cards Section -->
    <div class="bg-[#faf9f6] py-24 border-t border-gray-100">
        <div class="container mx-auto px-6 lg:px-12">
            <div class="mb-14 text-center max-w-2xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    {{ \App\Models\Setting::get('home_cards_title', 'কেন আমাদের প্ল্যাটফর্ম বেছে নেবেন?') }}</h2>
                <p class="text-gray-500 text-lg">
                    {{ \App\Models\Setting::get('home_cards_subtitle', 'আপনার ব্যবসার প্রয়োজনে সঠিক লোকবল খুঁজে পাওয়ার সবচেয়ে বিশ্বস্ত মাধ্যম') }}
                </p>
            </div>

            @php
                $defaultCards = [
                    [
                        'title' => 'মেধাবী ও পরিশ্রমী শিক্ষার্থী',
                        'description' =>
                            'আমাদের প্ল্যাটফর্মে রয়েছেন দেশের বিভিন্ন স্বনামধন্য বিশ্ববিদ্যালয়ের হাজারো মেধাবী শিক্ষার্থী। তারা যেমন পড়াশোনায় ভালো, তেমনি যেকোনো পার্ট-টাইম কাজেও অত্যন্ত দায়িত্বশীল ও পরিশ্রমী।',
                        'image_url' =>
                            'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'tag' => 'Quality',
                        'link_text' => 'বিস্তারিত জানুন',
                        'link' => '/employer/register',
                    ],
                    [
                        'title' => 'দ্রুত ও সহজ নিয়োগ প্রক্রিয়া',
                        'description' =>
                            'কোনো ঝামেলা ছাড়াই মাত্র কয়েক মিনিটে জব পোস্ট করুন। আপনার প্রয়োজন অনুযায়ী সঠিক স্কিলের শিক্ষার্থী খুঁজে পেতে আমাদের স্মার্ট সিস্টেম আপনাকে সাহায্য করবে।',
                        'image_url' =>
                            'https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'tag' => 'Speed',
                        'link_text' => 'এখনই শুরু করুন',
                        'link' => '/employer/register',
                    ],
                ];
                $cardsJson = \App\Models\Setting::get('home_cards');
                $cards = $cardsJson ? json_decode($cardsJson, true) : $defaultCards;
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                @foreach ($cards as $card)
                    <!-- Card -->
                    <div
                        class="group bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100">
                        <div class="relative h-72 overflow-hidden">
                            <img src="{{ $card['image_url'] }}" alt="{{ $card['title'] }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent">
                            </div>
                            <div class="absolute bottom-6 left-8 right-8">
                                <span
                                    class="bg-yellow-500 text-black text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">{{ $card['tag'] }}</span>
                                <h3 class="text-2xl font-bold text-white leading-snug">{{ $card['title'] }}</h3>
                            </div>
                        </div>
                        <div class="p-8">
                            <p class="text-gray-600 leading-relaxed mb-6">
                                {{ $card['description'] }}
                            </p>
                            <a href="{{ url($card['link']) }}"
                                class="inline-flex items-center text-yellow-600 font-bold hover:text-yellow-700 transition-colors group-hover:translate-x-2 duration-300">
                                {{ $card['link_text'] }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
