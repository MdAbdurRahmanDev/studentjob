<div class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-5 lg:px-12 max-w-4xl">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">প্রোফাইল আপডেট করুন</h1>
            <p class="text-gray-600">আপনার বিস্তারিত তথ্য দিন যাতে কোম্পানিগুলো আপনাকে সহজে খুঁজে পেতে পারে।</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <form wire:submit.prevent="updateProfile" class="space-y-6">
                
                <!-- Visibility Toggle -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">প্রোফাইল ভিজিবিলিটি</h3>
                        <p class="text-xs text-gray-500 mt-1">আপনার প্রোফাইল "শিক্ষার্থী খুঁজুন" পেইজে দেখাবেন কি না তা নির্ধারণ করুন।</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="is_profile_visible" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-500"></div>
                    </label>
                </div>

                <!-- Profile Image -->
                <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <h3 class="text-sm font-bold text-gray-900 mb-2">প্রোফাইল ছবি</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-yellow-200 bg-white flex items-center justify-center text-gray-400 shrink-0">
                            @if ($profile_image)
                                <img src="{{ $profile_image->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif ($existing_profile_image)
                                <img src="{{ asset('uploads/' . $existing_profile_image) }}" class="w-full h-full object-cover">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" wire:model="profile_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100 cursor-pointer">
                            <p class="text-xs text-gray-500 mt-2">সর্বোচ্চ 2MB সাইজের ছবি আপলোড করতে পারবেন।</p>
                            @error('profile_image') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">টাইটেল বা পেশা</label>
                        <input type="text" wire:model="title" placeholder="যেমন: Web Developer, Graphic Designer" class="w-full rounded-xl border border-gray-300 bg-white focus:border-yellow-500 focus:ring-4 focus:ring-yellow-500/20 text-sm py-3 px-4 shadow-sm transition-all outline-none">
                        @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">ক্যাটাগরি</label>
                        <select wire:model="category_id" class="w-full rounded-xl border border-gray-300 bg-white focus:border-yellow-500 focus:ring-4 focus:ring-yellow-500/20 text-sm py-3 px-4 shadow-sm transition-all cursor-pointer outline-none">
                            <option value="">ক্যাটাগরি নির্বাচন করুন</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        
                        <div class="mt-3 bg-gray-50/50 p-3.5 rounded-xl border border-gray-200/60">
                            <label class="block text-xs font-semibold text-gray-600 mb-2">অথবা, আপনার ক্যাটাগরি লিখে দিন (যদি লিস্টে না থাকে)</label>
                            <input type="text" wire:model="custom_category" placeholder="আপনার ক্যাটাগরি..." class="w-full rounded-lg border border-gray-300 bg-white focus:border-yellow-500 focus:ring-4 focus:ring-yellow-500/20 text-sm py-2.5 px-3 shadow-sm transition-all outline-none">
                            @error('custom_category') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Education -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">শিক্ষা (Education)</label>
                        <input type="text" wire:model="education" placeholder="যেমন: BSc in CS, Dhaka University" class="w-full rounded-xl border border-gray-300 bg-white focus:border-yellow-500 focus:ring-4 focus:ring-yellow-500/20 text-sm py-3 px-4 shadow-sm transition-all outline-none">
                        @error('education') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Availability -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">কাজের ধরন (Availability)</label>
                        <select wire:model="availability" class="w-full rounded-xl border border-gray-300 bg-white focus:border-yellow-500 focus:ring-4 focus:ring-yellow-500/20 text-sm py-3 px-4 shadow-sm transition-all cursor-pointer outline-none">
                            <option value="">নির্বাচন করুন</option>
                            <option value="Full Time">Full Time</option>
                            <option value="Part Time">Part Time</option>
                            <option value="Freelance">Freelance</option>
                        </select>
                        @error('availability') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Skills -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">দক্ষতা (Skills) - একাধিক নির্বাচন করতে পারবেন</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-white p-5 rounded-xl border border-gray-200 max-h-56 overflow-y-auto shadow-inner">
                        @php
                            $availableSkills = ['PHP', 'Laravel', 'React', 'Vue', 'Python', 'Django', 'Graphic Design', 'Photoshop', 'Illustrator', 'Figma', 'Digital Marketing', 'SEO', 'Facebook Ads', 'Content Writing', 'Video Editing', 'Premiere Pro'];
                        @endphp
                        @foreach($availableSkills as $skill)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative flex items-center justify-center">
                                    <input type="checkbox" wire:model="skills" value="{{ $skill }}" class="peer w-5 h-5 rounded-md border-gray-300 text-yellow-500 focus:ring-yellow-500 focus:ring-offset-1 transition-all cursor-pointer">
                                </div>
                                <span class="text-sm text-gray-700 group-hover:text-yellow-600 font-medium transition-colors">{{ $skill }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('skills') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Bio -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">আপনার সম্পর্কে (Bio)</label>
                    <textarea wire:model="bio" rows="4" placeholder="আপনার কাজের অভিজ্ঞতা এবং দক্ষতা সম্পর্কে সংক্ষেপে লিখুন..." class="w-full rounded-xl border border-gray-300 bg-white focus:border-yellow-500 focus:ring-4 focus:ring-yellow-500/20 text-sm py-3 px-4 shadow-sm transition-all outline-none"></textarea>
                    @error('bio') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-3 px-8 rounded-xl transition-colors shadow-sm">
                        সংরক্ষণ করুন
                    </button>
                    <a href="{{ route('dashboard') }}" wire:navigate class="text-gray-500 hover:text-gray-800 font-medium text-sm transition-colors">
                        বাতিল করুন
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
