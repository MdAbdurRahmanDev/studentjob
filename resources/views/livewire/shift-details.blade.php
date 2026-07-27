<div>
    <!-- Header Section -->
    <div class="bg-black py-20 relative overflow-hidden">
        <!-- Abstract shapes -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>
        
        <div class="container mx-auto px-6 lg:px-12 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end">
                <div class="max-w-3xl">
                    <a href="{{ route('shifts.index') }}" class="text-gray-400 hover:text-white flex items-center text-sm mb-8 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        ফিরে যান
                    </a>
                    
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="px-3 py-1 bg-yellow-500/20 text-yellow-500 text-xs font-bold uppercase tracking-wider rounded-full border border-yellow-500/30">
                            {{ $shift->status }}
                        </span>
                        <span class="text-gray-400 text-sm flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $shift->time }}
                        </span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">{{ $shift->title }}</h1>
                    
                    <div class="flex items-center text-gray-300 space-x-6">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $shift->employer_name }}
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $shift->location }}
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 md:mt-0">
                    <button class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold px-10 py-4 rounded-xl shadow-lg shadow-yellow-500/20 transition-all hover:-translate-y-1 w-full md:w-auto">
                        এপ্লাই করুন
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Section -->
    <div class="bg-[#faf9f6] py-16">
        <div class="container mx-auto px-6 lg:px-12 flex flex-col lg:flex-row gap-12">
            
            <!-- Main Content -->
            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">কাজের বিবরণ</h2>
                    <div class="prose prose-gray max-w-none mb-10">
                        <p class="text-gray-600 leading-relaxed">{{ $shift->description }}</p>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-900 mb-6">দায়িত্ব ও যোগ্যতা</h2>
                    <div class="prose prose-gray max-w-none">
                        <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $shift->requirements }}</p>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 sticky top-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">শিফটের সারাংশ</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center text-yellow-600 mr-4 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">বেতন</p>
                                <p class="text-lg font-bold text-gray-900">{{ $shift->wage }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 mr-4 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">নিয়োগকারী</p>
                                <p class="text-lg font-bold text-gray-900">{{ $shift->employer_name }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center text-green-600 mr-4 shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">সময়</p>
                                <p class="text-lg font-bold text-gray-900">{{ $shift->time }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
