<div class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-5 lg:px-12">
        
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">শিক্ষার্থী খুঁজুন</h1>
            <p class="text-gray-600">আপনার প্রজেক্ট বা কোম্পানির জন্য দক্ষ শিক্ষার্থী খুঁজে বের করুন।</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar: Filters -->
            <div class="w-full lg:w-1/4">
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-7 sticky top-24">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2.5">
                            <div class="p-2 bg-yellow-50 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                            </div>
                            ফিল্টার
                        </h2>
                        @if($search || $category_id || $selectedSkills || $availability)
                            <button wire:click="resetFilters" class="text-xs font-semibold text-red-500 hover:text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                রিসেট
                            </button>
                        @endif
                    </div>
                    
                    <!-- Search by Name -->
                    <div class="mb-7">
                        <label class="block text-sm font-semibold text-gray-800 mb-3">নাম বা পেশা</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="খুঁজুন..." class="w-full pl-10 pr-4 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/10 text-sm py-3 transition-all outline-none shadow-sm">
                        </div>
                    </div>

                    <div class="w-full h-px bg-gray-100 mb-7"></div>

                    <!-- Category Filter -->
                    <div class="mb-7">
                        <label class="block text-sm font-semibold text-gray-800 mb-3">ক্যাটাগরি</label>
                        <div class="relative">
                            <select wire:model.live="category_id" class="w-full pl-4 pr-10 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-yellow-400 focus:ring-4 focus:ring-yellow-400/10 text-sm py-3 cursor-pointer appearance-none transition-all outline-none shadow-sm font-medium text-gray-700">
                                <option value="">সব ক্যাটাগরি</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="w-full h-px bg-gray-100 mb-7"></div>

                    <!-- Skills Filter -->
                    <div class="mb-7">
                        <label class="block text-sm font-semibold text-gray-800 mb-3">দক্ষতা (Skills)</label>
                        <div class="space-y-3 max-h-56 overflow-y-auto pr-3 custom-scrollbar">
                            @php
                                $availableSkills = ['PHP', 'Laravel', 'React', 'Vue', 'Python', 'Django', 'Graphic Design', 'Photoshop', 'Illustrator', 'Figma', 'Digital Marketing', 'SEO', 'Facebook Ads', 'Content Writing', 'Video Editing', 'Premiere Pro'];
                            @endphp
                            @foreach($availableSkills as $skill)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <div class="relative flex items-center justify-center">
                                        <input type="checkbox" wire:model.live="selectedSkills" value="{{ $skill }}" class="peer w-5 h-5 rounded-md border-gray-300 bg-gray-50 text-yellow-500 focus:ring-yellow-500 focus:ring-offset-0 transition-all cursor-pointer shadow-sm">
                                    </div>
                                    <span class="text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">{{ $skill }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="w-full h-px bg-gray-100 mb-7"></div>

                    <!-- Availability Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-3">কাজের ধরন</label>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative flex items-center justify-center">
                                    <input type="checkbox" wire:model.live="availability" value="Part Time" class="peer w-5 h-5 rounded-md border-gray-300 bg-gray-50 text-yellow-500 focus:ring-yellow-500 focus:ring-offset-0 transition-all cursor-pointer shadow-sm">
                                </div>
                                <span class="text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">পার্ট-টাইম (Part Time)</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative flex items-center justify-center">
                                    <input type="checkbox" wire:model.live="availability" value="Full Time" class="peer w-5 h-5 rounded-md border-gray-300 bg-gray-50 text-yellow-500 focus:ring-yellow-500 focus:ring-offset-0 transition-all cursor-pointer shadow-sm">
                                </div>
                                <span class="text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">ফুল-টাইম (Full Time)</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative flex items-center justify-center">
                                    <input type="checkbox" wire:model.live="availability" value="Freelance" class="peer w-5 h-5 rounded-md border-gray-300 bg-gray-50 text-yellow-500 focus:ring-yellow-500 focus:ring-offset-0 transition-all cursor-pointer shadow-sm">
                                </div>
                                <span class="text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">ফ্রিল্যান্স (Freelance)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content: Student List -->
            <div class="w-full lg:w-3/4">
                
                <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
                    <p class="text-gray-600 font-medium">সর্বমোট <span class="text-gray-900 font-bold">{{ $students->total() }}</span> জন শিক্ষার্থী পাওয়া গেছে</p>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">সাজান:</span>
                        <select wire:model.live="sort" class="rounded-lg border-gray-200 text-sm focus:border-yellow-400 focus:ring-0 py-1.5 pl-3 pr-8 cursor-pointer bg-white">
                            <option value="newest">নতুন যুক্ত</option>
                            <option value="name_asc">নাম (A-Z)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-6 relative" wire:loading.class="opacity-50 pointer-events-none transition-opacity duration-200">
                    
                    <!-- Loading Spinner -->
                    <div wire:loading class="absolute inset-0 z-10 flex items-center justify-center">
                        <div class="w-10 h-10 border-4 border-yellow-200 border-t-yellow-500 rounded-full animate-spin"></div>
                    </div>

                    @forelse($students as $student)
                        <!-- Student Profile Card -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300 group flex flex-col h-full relative overflow-hidden">
                            <!-- Top Banner / Decoration -->
                            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-400 to-yellow-500"></div>
                            
                            <div class="flex gap-4 mb-4">
                                <!-- Avatar -->
                                <div class="relative w-16 h-16 rounded-full overflow-hidden border-2 border-yellow-100 flex-shrink-0 bg-yellow-50 flex items-center justify-center text-yellow-600 text-xl font-bold">
                                    @if($student->profileImageUrl())
                                        <img src="{{ $student->profileImageUrl() }}" alt="{{ $student->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ $student->initials() }}
                                    @endif
                                </div>
                                <!-- Basic Info -->
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">{{ $student->name }}</h3>
                                    <p class="text-sm text-yellow-600 font-medium mb-1">{{ $student->title ?? 'শিক্ষার্থী' }}</p>
                                    @if($student->education)
                                    <p class="text-xs text-gray-500 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        </svg>
                                        {{ $student->education }}
                                    </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Bio -->
                            @if($student->bio)
                                <p class="text-sm text-gray-600 mb-5 line-clamp-2">{{ $student->bio }}</p>
                            @else
                                <p class="text-sm text-gray-400 italic mb-5 line-clamp-2">কোনো বায়ো দেওয়া নেই।</p>
                            @endif
                            
                            <!-- Skills -->
                            <div class="flex flex-wrap gap-2 mb-6 mt-auto">
                                @if($student->skills && is_array($student->skills))
                                    @foreach(array_slice($student->skills, 0, 4) as $skill)
                                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-lg font-medium">{{ $skill }}</span>
                                    @endforeach
                                    @if(count($student->skills) > 4)
                                        <span class="px-3 py-1 bg-gray-50 text-gray-400 text-xs rounded-lg font-medium">+{{ count($student->skills) - 4 }}</span>
                                    @endif
                                @endif
                                
                                @if($student->availability)
                                    <span class="px-3 py-1 bg-yellow-50 text-yellow-700 text-xs rounded-lg font-medium border border-yellow-100">{{ $student->availability }}</span>
                                @endif
                            </div>

                            <!-- Action -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                @if($student->isVerified())
                                    <div class="flex items-center text-xs text-gray-500 gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        ভেরিফাইড প্রোফাইল
                                    </div>
                                @else
                                    <div class="flex items-center text-xs text-gray-400 gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        আনভেরিফাইড
                                    </div>
                                @endif
                                <a href="{{ route('students.show', $student->id) }}" wire:navigate class="bg-yellow-50 hover:bg-yellow-500 text-yellow-700 hover:text-black font-semibold py-2 px-4 rounded-xl text-sm transition-colors">
                                    প্রোফাইল দেখুন
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 py-12 text-center bg-white rounded-2xl border border-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">কোনো শিক্ষার্থী পাওয়া যায়নি</h3>
                            <p class="text-gray-500">আপনার দেওয়া ফিল্টার অনুযায়ী কাউকে পাওয়া যায়নি। ফিল্টার পরিবর্তন করে আবার চেষ্টা করুন।</p>
                            <button wire:click="resetFilters" class="mt-4 text-yellow-600 font-medium hover:text-yellow-700">রিসেট করুন</button>
                        </div>
                    @endforelse

                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    {{ $students->links(data: ['scrollTo' => false]) }}
                </div>

            </div>
        </div>
    </div>
</div>
