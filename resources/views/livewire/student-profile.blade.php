<div class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-5 lg:px-12 max-w-5xl">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm text-gray-500">
            <a href="{{ route('students.index') }}" wire:navigate class="hover:text-yellow-600 transition-colors">শিক্ষার্থী খুঁজুন</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium">{{ $student->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Basic Info & Actions -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 text-center relative overflow-hidden">
                    <!-- Top decoration -->
                    <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-yellow-400 to-yellow-500"></div>
                    
                    <!-- Avatar -->
                    <div class="w-32 h-32 mx-auto rounded-full bg-yellow-50 border-4 border-white shadow-lg flex items-center justify-center text-4xl font-bold text-yellow-600 mb-6 mt-4 overflow-hidden">
                        @if($student->profileImageUrl())
                            <img src="{{ $student->profileImageUrl() }}" alt="{{ $student->name }}" class="w-full h-full object-cover">
                        @else
                            {{ $student->initials() }}
                        @endif
                    </div>

                    <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $student->name }}</h1>
                    <p class="text-yellow-600 font-medium mb-4">{{ $student->title ?? 'শিক্ষার্থী' }}</p>

                    @if($student->isVerified())
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 text-xs font-semibold rounded-full mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            ভেরিফাইড প্রোফাইল
                        </div>
                    @endif

                    <!-- Hire Button -->
                    @if(auth()->id() !== $student->id)
                        <button wire:click="openHireModal" class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3.5 px-6 rounded-xl transition-all shadow-md shadow-yellow-500/20 flex items-center justify-center gap-2 hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            হায়ার করুন (Hire Now)
                        </button>
                    @endif

                    <hr class="border-gray-100 my-6">

                    <!-- Quick Details -->
                    <div class="space-y-4 text-left">
                        @if($student->availability)
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">কাজের ধরন</p>
                            <p class="text-sm font-medium text-gray-900">{{ $student->availability }}</p>
                        </div>
                        @endif
                        
                        @if($student->category)
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">ক্যাটাগরি</p>
                            <p class="text-sm font-medium text-gray-900">{{ $student->category->name }}</p>
                        </div>
                        @elseif($student->custom_category)
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">ক্যাটাগরি</p>
                            <p class="text-sm font-medium text-gray-900">{{ $student->custom_category }}</p>
                        </div>
                        @endif

                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">যোগদান করেছেন</p>
                            <p class="text-sm font-medium text-gray-900">{{ $student->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Detailed Info -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- About -->
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        বিস্তারিত (About)
                    </h2>
                    
                    @if($student->bio)
                        <div class="prose prose-sm md:prose-base text-gray-600 max-w-none leading-relaxed">
                            {!! nl2br(e($student->bio)) !!}
                        </div>
                    @else
                        <p class="text-gray-400 italic">কোনো বিস্তারিত তথ্য দেওয়া নেই।</p>
                    @endif
                </div>

                <!-- Skills -->
                @if(!empty($student->skills))
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        দক্ষতা সমূহ (Skills)
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($student->skills as $skill)
                            <span class="px-4 py-2 bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl font-medium hover:border-yellow-300 hover:bg-yellow-50 transition-colors">
                                {{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Education -->
                @if($student->education)
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                        শিক্ষাগত যোগ্যতা (Education)
                    </h2>
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <div class="p-3 bg-white rounded-xl shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-gray-900">{{ $student->education }}</h4>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Hire Modal -->
    @if($showHireModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <!-- Backdrop -->
        <div wire:click="closeHireModal" class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h3 class="text-xl font-bold text-gray-900">হায়ার রিকোয়েস্ট পাঠান</h3>
                <button wire:click="closeHireModal" class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-white">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form wire:submit.prevent="submitHireRequest" class="p-6 overflow-y-auto">
                <p class="text-sm text-gray-600 mb-6">আপনি <strong>{{ $student->name }}</strong> কে হায়ার করতে চাচ্ছেন। দয়া করে কাজের বিস্তারিত নিচে প্রদান করুন।</p>
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">কাজের শিরোনাম (কী কাজের জন্য)</label>
                        <input type="text" wire:model="work_title" placeholder="যেমন: ওয়েবসাইট ডেভেলপমেন্ট প্রজেক্ট" class="w-full rounded-xl border border-gray-300 bg-white focus:border-yellow-500 focus:ring-4 focus:ring-yellow-500/20 text-sm py-3 px-4 shadow-sm transition-all outline-none">
                        @error('work_title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">যোগাযোগ নম্বর (ঐচ্ছিক)</label>
                        <input type="text" wire:model="contact_number" placeholder="আপনার ফোন বা হোয়াটসঅ্যাপ নম্বর দিন..." class="w-full rounded-xl border border-gray-300 bg-white focus:border-yellow-500 focus:ring-4 focus:ring-yellow-500/20 text-sm py-3 px-4 shadow-sm transition-all outline-none">
                        @error('contact_number') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">বিস্তারিত বিবরণ (কেন হায়ার করছেন)</label>
                        <textarea wire:model="description" rows="4" placeholder="কাজের বিস্তারিত বিবরণ এবং আপনি কী চাচ্ছেন তা বিস্তারিত লিখুন..." class="w-full rounded-xl border border-gray-300 bg-white focus:border-yellow-500 focus:ring-4 focus:ring-yellow-500/20 text-sm py-3 px-4 shadow-sm transition-all outline-none"></textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-8 flex gap-3">
                    <button type="submit" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 px-4 rounded-xl transition-all shadow-md shadow-yellow-500/20">
                        রিকোয়েস্ট পাঠান
                    </button>
                    <button type="button" wire:click="closeHireModal" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors">
                        বাতিল
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
