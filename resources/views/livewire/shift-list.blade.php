<div>
    <!-- Header Area -->
    <div class="bg-black py-16">
        <div class="container mx-auto px-6 lg:px-12 text-center">
            <h1 class="text-4xl font-bold text-white mb-4">সকল এভেইলেবল <span class="text-yellow-500">শিফট</span></h1>
            <p class="text-gray-400">আপনার পছন্দ এবং লোকেশন অনুযায়ী সেরা শিফটটি খুঁজে নিন</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-[#faf9f6] py-12 min-h-screen" x-data="{ openFilter: false }">
        <div class="container mx-auto px-6 lg:px-12 flex flex-col lg:flex-row gap-10">
            
            <!-- Mobile Filter Toggle -->
            <div class="lg:hidden flex items-center justify-between bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900">ফিল্টার করুন</h3>
                <button @click="openFilter = true" class="text-gray-600 hover:text-yellow-600 focus:outline-none bg-gray-50 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Overlay -->
            <div 
                x-show="openFilter" 
                @click="openFilter = false"
                class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                style="display: none;">
            </div>

            <!-- Filters Sidebar -->
            <div 
                class="fixed inset-y-0 right-0 z-50 w-[280px] bg-white shadow-2xl transform transition-transform duration-300 overflow-y-auto lg:relative lg:transform-none lg:w-1/4 lg:shadow-none lg:z-auto lg:h-auto lg:overflow-visible lg:block"
                :class="openFilter ? 'translate-x-0' : 'translate-x-full lg:translate-x-0'"
                style="display: block;"
            >
                <!-- Mobile Close Header -->
                <div class="lg:hidden p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50 sticky top-0 z-10">
                    <h3 class="text-lg font-bold text-gray-900">ফিল্টার</h3>
                    <button @click="openFilter = false" class="text-gray-500 hover:text-red-500 bg-white p-1.5 rounded-lg shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6 lg:p-6 lg:bg-white lg:rounded-2xl lg:shadow-sm lg:border lg:border-gray-100 lg:sticky lg:top-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 hidden lg:block">ফিল্টার করুন</h3>
                        <button wire:click="$set('location', ''); $set('category', '')" @click="openFilter = false" class="text-xs text-yellow-600 hover:text-yellow-700 font-semibold bg-yellow-50 px-3 py-1.5 rounded-lg lg:bg-transparent lg:p-0">
                            রিসেট করুন
                        </button>
                    </div>

                    <!-- Location Filter -->
                    <div class="mb-8">
                        <h4 class="font-semibold text-gray-700 mb-3 text-sm">লোকেশন</h4>
                        <select wire:model.live="location" class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block p-2.5 text-sm">
                            <option value="">সব এলাকা</option>
                            @foreach($locations as $loc)
                            <option value="{{ $loc }}">{{ $loc }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-3 text-sm">কাজের ধরন</h4>
                        <div class="space-y-2">
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="radio" wire:model.live="category" value="" class="form-radio text-yellow-500 focus:ring-yellow-500 h-4 w-4">
                                <span class="text-gray-600 text-sm">সবগুলো</span>
                            </label>
                            @foreach($categories as $cat)
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="radio" wire:model.live="category" value="{{ $cat->id }}" class="form-radio text-yellow-500 focus:ring-yellow-500 h-4 w-4">
                                <span class="text-gray-600 text-sm">{{ $cat->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Cards Grid -->
            <div class="w-full lg:w-3/4">
                
                <div class="mb-6 flex justify-between items-center">
                    <p class="text-gray-500 text-sm">সর্বমোট <span class="font-bold text-gray-900">{{ $shifts->total() }}</span> টি শিফট পাওয়া গেছে</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative" wire:loading.class="opacity-50">
                    
                    <!-- Loading Spinner Overlay -->
                    <div wire:loading.flex class="absolute inset-0 z-10 hidden justify-center items-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-4 border-yellow-500 border-t-transparent"></div>
                    </div>

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
                                @if($shift->start_datetime && $shift->end_datetime)
                                    {{ \Carbon\Carbon::parse($shift->start_datetime)->format('M d, g:i A') }} - {{ \Carbon\Carbon::parse($shift->end_datetime)->format('M d, g:i A') }}
                                @else
                                    {{ $shift->time }}
                                @endif
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
                    <div class="col-span-1 md:col-span-2 text-center py-16 bg-white rounded-2xl border border-dashed border-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">কোনো শিফট পাওয়া যায়নি</h3>
                        <p class="text-gray-500 text-sm">আপনার সার্চ করা ফিল্টারের সাথে মিল রেখে কোনো শিফট পাওয়া যায়নি। অন্য কিছু দিয়ে চেষ্টা করুন।</p>
                        <button wire:click="$set('location', ''); $set('category', '')" class="mt-4 px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors text-sm font-medium">
                            ফিল্টার রিসেট করুন
                        </button>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $shifts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
