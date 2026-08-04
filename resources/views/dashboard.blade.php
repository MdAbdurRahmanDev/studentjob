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

            @if (auth()->user()->role === 'company')
                <!-- Employer Dashboard -->
                <div class="hidden md:block bg-black text-white rounded-3xl p-10 md:p-14 relative overflow-hidden mb-10 shadow-xl shadow-black/10">
                    <div class="absolute -right-24 -top-24 w-96 h-96 bg-yellow-500 rounded-full mix-blend-screen filter blur-[80px] opacity-30"></div>
                    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold mb-3">স্বাগতম, {{ auth()->user()->name }}!</h1>
                            <p class="text-gray-300 text-lg">আপনার কোম্পানি ড্যাশবোর্ডে আপনাকে স্বাগতম। এখান থেকে আপনি নতুন শিফট পোস্ট করতে পারবেন।</p>
                        </div>
                        <div class="mt-6 md:mt-0 flex space-x-4">
                            <a href="{{ route('employer.post-shift') }}" wire:navigate class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold rounded-xl px-8 py-4 transition-colors shadow-lg flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                নতুন শিফট পোস্ট করুন
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl px-6 py-4 transition-colors border border-white/20 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    লগআউট
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @php
                    $companyId = auth()->id();
                    $totalJobsPosted = \App\Models\Job::where('user_id', $companyId)->count();
                    $totalHiredStudents = \App\Models\Application::whereHas('job', function($q) use ($companyId) {
                        $q->where('user_id', $companyId);
                    })->whereIn('status', ['hired', 'completed'])->count();
                    
                    $pendingApplications = \App\Models\Application::whereHas('job', function($q) use ($companyId) {
                        $q->where('user_id', $companyId);
                    })->where('status', 'pending')->count();
                    
                    $totalSpent = \App\Models\Application::whereHas('job', function($q) use ($companyId) {
                        $q->where('user_id', $companyId);
                    })->where('status', 'completed')->sum('earnings');
                @endphp

                <!-- Company Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-shadow">
                        <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mr-5 shrink-0">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Total Jobs Posted</p>
                            <h3 class="text-3xl font-bold text-gray-900">{{ $totalJobsPosted }}</h3>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-shadow">
                        <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mr-5 shrink-0">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Total Hired</p>
                            <h3 class="text-3xl font-bold text-gray-900">{{ $totalHiredStudents }}</h3>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-shadow">
                        <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mr-5 shrink-0">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Pending Request</p>
                            <h3 class="text-3xl font-bold text-gray-900">{{ $pendingApplications }}</h3>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-shadow">
                        <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mr-5 shrink-0">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium mb-1">Total Spent (BDT)</p>
                            <h3 class="text-3xl font-bold text-gray-900">৳{{ number_format($totalSpent) }}</h3>
                        </div>
                    </div>
                </div>

                <livewire:employer.my-shifts />
            @else
                <!-- Student Dashboard -->
                <div class="hidden md:block bg-black text-white rounded-3xl p-10 md:p-14 relative overflow-hidden mb-10 shadow-xl shadow-black/10">
                    <div class="absolute -right-24 -top-24 w-96 h-96 bg-yellow-500 rounded-full mix-blend-screen filter blur-[80px] opacity-30"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold mb-3">স্বাগতম, {{ auth()->user()->name }}!</h1>
                            <p class="text-gray-300 text-lg">আপনার ড্যাশবোর্ডে আপনাকে স্বাগতম। এখান থেকে আপনি আপনার প্রোফাইল এবং শিফট পরিচালনা করতে পারবেন।</p>
                            
                            @if(auth()->user()->role === 'user')
                                <livewire:student.availability-toggle />
                            @endif
                        </div>
                        <div class="mt-6 md:mt-0 flex space-x-4">
                            <a href="{{ route('student.profile.update') }}" wire:navigate class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold rounded-xl px-6 py-4 transition-colors shadow-lg flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                প্রোফাইল আপডেট
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl px-6 py-4 transition-colors border border-white/20 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    লগআউট
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Student dashboard: flex-col, reorder on mobile -->
                <div class="flex flex-col">

                <!-- Verification Status (bottom on mobile, top on md+) -->
                <div class="mb-8 order-3 md:order-1">
                    @if(auth()->user()->isVerified())
                        <div class="bg-indigo-50 border border-indigo-200 rounded-3xl p-8 flex items-center shadow-sm">
                            <div class="w-14 h-14 bg-indigo-500 text-white rounded-2xl flex items-center justify-center mr-5 shadow-lg shadow-indigo-500/30">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-indigo-900 mb-1">ভেরিফাইড একাউন্ট</h3>
                                <p class="text-indigo-700">আপনার একাউন্টটি সফলভাবে ভেরিফাই করা হয়েছে।</p>
                            </div>
                        </div>
                    @elseif(auth()->user()->verification && auth()->user()->verification->status === 'pending')
                        <div class="bg-blue-50 border border-blue-200 rounded-3xl p-8 flex items-center shadow-sm">
                            <div class="w-14 h-14 bg-blue-500 text-white rounded-2xl flex items-center justify-center mr-5 shadow-lg shadow-blue-500/30 animate-pulse">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-blue-900 mb-1">ভেরিফিকেশন পেন্ডিং</h3>
                                <p class="text-blue-700">আপনার জমা দেওয়া তথ্যগুলো রিভিউ করা হচ্ছে।</p>
                            </div>
                        </div>
                    @else
                        <div class="bg-red-50 border border-red-200 rounded-3xl p-8 flex flex-col md:flex-row items-center justify-between shadow-sm">
                            <div class="flex items-center mb-6 md:mb-0">
                                <div class="w-14 h-14 bg-red-500 text-white rounded-2xl flex items-center justify-center mr-5 shadow-lg shadow-red-500/30">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-red-900 mb-1">একাউন্ট ভেরিফাই করুন</h3>
                                    <p class="text-red-700 text-lg">
                                        @if(auth()->user()->verification && auth()->user()->verification->status === 'rejected')
                                            আপনার আগের রিকোয়েস্ট বাতিল হয়েছে। পুনরায় আবেদন করুন।
                                        @else
                                            ন্যাশনাল আইডি বা স্টুডেন্ট আইডি দিয়ে আপনার পরিচয় নিশ্চিত করুন।
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('verify-identity') }}" wire:navigate class="bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-8 rounded-2xl transition-transform hover:-translate-y-1 shadow-lg shadow-red-500/40 text-lg whitespace-nowrap">
                                এখনই ভেরিফাই করুন
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Subscription Status (bottom on mobile, top on md+) -->
                <div class="mb-8 order-4 md:order-2">
                    @if (auth()->user()->hasActiveSubscription())
                        <div class="bg-white border-2 border-green-400 rounded-3xl p-8 md:p-10 flex flex-col md:flex-row items-center justify-between shadow-xl shadow-green-500/10 relative overflow-hidden">
                            <div class="absolute right-0 top-0 w-64 h-64 bg-green-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>
                            <div class="relative z-10 mb-6 md:mb-0 max-w-2xl">
                                <div class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 font-bold text-xs mb-4">অ্যাক্টিভ মেম্বারশিপ</div>
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">আপনার সাবস্ক্রিপশন অ্যাক্টিভ আছে!</h3>
                                <p class="text-gray-600 text-lg">
                                    আপনি এখন যেকোনো শিফটে এপ্লাই করতে পারবেন। 
                                    @if(auth()->user()->latestSubscription->expires_at)
                                        (মেয়াদ শেষ হবে: {{ auth()->user()->latestSubscription->expires_at->format('d M, Y') }})
                                    @endif
                                </p>
                            </div>
                            <div class="relative z-10 w-full md:w-auto text-center md:text-right bg-green-50 rounded-2xl p-4 border border-green-100">
                                <div class="text-3xl md:text-4xl font-bold text-green-600 mb-1">
                                    @if(auth()->user()->latestSubscription->expires_at)
                                        {{ max(0, (int) round(now()->diffInDays(auth()->user()->latestSubscription->expires_at))) }} দিন
                                    @else
                                        ∞
                                    @endif
                                </div>
                                <div class="text-sm text-green-800 font-medium">বাকি আছে</div>
                            </div>
                        </div>
                    @elseif (auth()->user()->hasPendingSubscription())
                        <div class="bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-3xl p-8 flex flex-col md:flex-row items-center justify-between shadow-sm">
                            <div class="flex items-center mb-4 md:mb-0">
                                <div class="w-16 h-16 bg-yellow-500 text-white rounded-full flex items-center justify-center mr-6 shadow-md shadow-yellow-500/30 animate-pulse">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-yellow-800 mb-1">আপনার সাবস্ক্রিপশন পেন্ডিং!</h3>
                                    <p class="text-yellow-700">আপনার পেমেন্ট ভেরিফাই করা হচ্ছে। কয়েক ঘণ্টার মধ্যেই আপডেট হয়ে যাবে।</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-white border-2 border-yellow-400 rounded-3xl p-8 md:p-10 flex flex-col md:flex-row items-center justify-between shadow-xl shadow-yellow-500/10 relative overflow-hidden">
                            <div class="absolute right-0 top-0 w-64 h-64 bg-yellow-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>
                            <div class="relative z-10 mb-6 md:mb-0 max-w-2xl">
                                <div class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 font-bold text-xs mb-4">অ্যাকশন প্রয়োজন</div>
                                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">সাবস্ক্রাইব করুন — ৳২০০/মাস</h3>
                                <p class="text-gray-600 text-lg">
                                    মাত্র ২০০ টাকা পেমেন্ট করে একটিভ মেম্বারশিপ গ্রহণ করুন এবং প্রতিদিন শত শত লাইভ শিফটে এপ্লাই করার সুযোগ পান।
                                </p>
                            </div>
                            <div class="relative z-10 w-full md:w-auto">
                                <a href="{{ route('subscribe') }}" wire:navigate class="block text-center w-full md:w-auto bg-yellow-500 hover:bg-yellow-600 text-black font-bold rounded-2xl px-8 py-5 transition-transform hover:-translate-y-1 shadow-lg shadow-yellow-500/40 text-lg">
                                    এখনই সাবস্ক্রাইব করুন
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                @php
                    $myApplications = \App\Models\Application::with('job')->where('user_id', auth()->id())->latest()->get();
                    $totalEarnings = $myApplications->where('status', 'completed')->sum('earnings');
                    $completedCount = $myApplications->where('status', 'completed')->count();
                    $hiredCount = $myApplications->where('status', 'hired')->count();
                    $appliedCount = $myApplications->count();
                @endphp

                <!-- Stats/Actions Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8 order-1 md:order-3">
                    <!-- Total Earnings -->
                    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl p-6 shadow-lg shadow-green-500/30 text-white flex flex-col justify-between">
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-green-100 font-medium mb-1">মোট আয়</p>
                            <h3 class="text-3xl font-bold">৳{{ number_format($totalEarnings) }}</h3>
                        </div>
                    </div>

                    <!-- Completed Jobs -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 font-medium mb-1">সম্পন্ন কাজ</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $completedCount }}</h3>
                        </div>
                    </div>

                    <!-- Hired Jobs -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-yellow-50 text-yellow-600 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 font-medium mb-1">হায়ারড (বর্তমান)</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $hiredCount }}</h3>
                        </div>
                    </div>

                    <!-- Total Applied -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500 font-medium mb-1">মোট এপ্লাই</p>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $appliedCount }}</h3>
                        </div>
                    </div>
                </div>

                @php
                    $myHireRequests = auth()->user()->hireRequests;
                @endphp

                <!-- Hire Requests List -->
                <div class="mb-8 order-2 md:order-4">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            নতুন হায়ার রিকোয়েস্ট (Hire Requests)
                        </h2>
                    </div>

                    @if($myHireRequests->count() > 0)
                        <div class="space-y-4">
                            @foreach($myHireRequests as $request)
                            <div class="bg-white p-6 border border-gray-100 rounded-2xl flex flex-col hover:shadow-md transition-shadow relative overflow-hidden">
                                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-yellow-400"></div>
                                
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="font-bold text-xl text-gray-900 mb-1">{{ $request->work_title }}</h3>
                                        <p class="text-gray-500 text-sm">
                                            <span class="font-medium text-gray-700">{{ $request->employer->name ?? 'Unknown' }}</span> 
                                            @if($request->employer && $request->employer->email)
                                                ({{ $request->employer->email }})
                                            @endif
                                            • রিকোয়েস্ট এসেছে: {{ $request->created_at->format('d M, Y h:i A') }}
                                        </p>
                                    </div>
                                    <span class="px-4 py-1.5 bg-yellow-100 text-yellow-800 text-xs font-bold uppercase tracking-wider rounded-full">
                                        {{ $request->status }}
                                    </span>
                                </div>
                                
                                <div class="bg-gray-50 p-4 rounded-xl text-gray-700 text-sm border border-gray-100">
                                    <p class="font-semibold text-gray-900 mb-1">বিস্তারিত:</p>
                                    <p class="whitespace-pre-wrap">{{ $request->description }}</p>
                                    
                                    @if($request->contact_number)
                                        <div class="mt-3 pt-3 border-t border-gray-200">
                                            <p class="font-semibold text-gray-900 mb-1">যোগাযোগ নম্বর:</p>
                                            <p>{{ $request->contact_number }}</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="mt-4 flex gap-3">
                                    <a href="mailto:{{ $request->employer->email ?? '' }}" class="bg-black hover:bg-gray-800 text-white font-semibold py-2 px-6 rounded-xl text-sm transition-colors flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        ইমেইল করুন
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10 bg-white rounded-3xl border border-dashed border-gray-300 shadow-sm">
                            <p class="text-gray-500">আপনার কোনো হায়ার রিকোয়েস্ট নেই।</p>
                        </div>
                    @endif
                </div>

                <!-- Applications List -->
                <div class="mb-8 order-2 md:order-4">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">আপনার এপ্লাইকৃত শিফটসমূহ</h2>
                    </div>

                    @if($myApplications->count() > 0)
                        <div class="space-y-4">
                            @foreach($myApplications as $application)
                            <div class="bg-white p-6 border border-gray-100 rounded-2xl flex flex-col md:flex-row justify-between items-start md:items-center hover:shadow-md transition-shadow relative overflow-hidden">
                                @if($application->status === 'hired')
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-500"></div>
                                @elseif($application->status === 'completed')
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-green-500"></div>
                                @elseif($application->status === 'rejected')
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-400"></div>
                                @elseif($application->status === 'absent')
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-gray-400"></div>
                                @else
                                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-yellow-400"></div>
                                @endif
                                
                                <div>
                                    <h3 class="font-bold text-xl text-gray-900 mb-1">{{ $application->job->title ?? 'Deleted Job' }}</h3>
                                    <p class="text-gray-500 text-sm mb-3">
                                        <span class="font-medium text-gray-700">{{ $application->job->employer_name ?? '' }}</span> 
                                        @if($application->job)
                                            • {{ $application->job->location }} • 
                                            @if($application->job->start_datetime && $application->job->end_datetime)
                                                {{ \Carbon\Carbon::parse($application->job->start_datetime)->format('M d, g:i A') }} - {{ \Carbon\Carbon::parse($application->job->end_datetime)->format('M d, g:i A') }}
                                            @else
                                                {{ $application->job->time }}
                                            @endif
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-400">এপ্লাই করেছেন: {{ $application->created_at->format('d M, Y') }}</p>
                                </div>
                                <div class="mt-4 md:mt-0 flex flex-col md:items-end space-y-3">
                                    @if($application->status === 'pending')
                                        <span class="px-4 py-1.5 bg-yellow-100 text-yellow-800 text-xs font-bold uppercase tracking-wider rounded-full flex items-center">
                                            <svg class="w-3 h-3 mr-1.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                            Pending
                                        </span>
                                    @elseif($application->status === 'hired')
                                        <span class="px-4 py-1.5 bg-blue-100 text-blue-800 text-xs font-bold uppercase tracking-wider rounded-full flex items-center shadow-sm">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            Hired (Upcoming)
                                        </span>
                                    @elseif($application->status === 'completed')
                                        <div class="flex flex-col items-end">
                                            <span class="px-4 py-1.5 bg-green-100 text-green-800 text-xs font-bold uppercase tracking-wider rounded-full flex items-center shadow-sm mb-2">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Completed
                                            </span>
                                            <span class="text-sm font-bold text-green-600">আয়: ৳{{ number_format($application->earnings) }}</span>
                                        </div>
                                    @elseif($application->status === 'rejected')
                                        <span class="px-4 py-1.5 bg-red-100 text-red-800 text-xs font-bold uppercase tracking-wider rounded-full">
                                            Not Selected
                                        </span>
                                    @elseif($application->status === 'absent')
                                        <span class="px-4 py-1.5 bg-gray-100 text-gray-800 text-xs font-bold uppercase tracking-wider rounded-full">
                                            Did Not Attend
                                        </span>
                                    @endif
                                    
                                    @if($application->job)
                                        <a href="{{ route('shifts.show', $application->job->id) }}" wire:navigate class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm flex items-center transition-colors">
                                            কাজের বিস্তারিত দেখুন
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10 bg-white rounded-3xl border border-dashed border-gray-300 shadow-sm">
                            <p class="text-gray-500">আপনি এখনও কোনো শিফটে এপ্লাই করেননি।</p>
                        </div>
                    @endif
                </div>
                <!-- end student dashboard flex container -->
                </div>
            @endif

        </div>
    </div>
</x-layouts.front>
