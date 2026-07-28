<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">General Settings</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage website name, logo, and favicon.</p>
            </div>

            <div class="p-6">
                @if (session()->has('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form wire:submit="saveSettings" class="space-y-8 max-w-3xl">
                    <!-- Site Name -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Website Name</label>
                        <input type="text" wire:model="site_name" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 hover:bg-white dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm">
                        @error('site_name') <span class="text-red-500 text-xs font-medium mt-2 flex items-center"><svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>{{ $message }}</span> @enderror
                    </div>

                    <!-- Site Logo -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Website Logo</label>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-6">
                            @if ($site_logo || $existing_logo)
                                <div class="shrink-0 relative group">
                                    @if ($site_logo)
                                        <img src="{{ $site_logo->temporaryUrl() }}" alt="New Logo" class="h-20 w-auto rounded-xl object-contain bg-gray-50 dark:bg-gray-900 p-3 border-2 border-indigo-100 dark:border-indigo-900 shadow-inner">
                                    @elseif ($existing_logo)
                                        <img src="{{ Storage::url($existing_logo) }}" alt="Current Logo" class="h-20 w-auto rounded-xl object-contain bg-gray-50 dark:bg-gray-900 p-3 border border-gray-200 dark:border-gray-700 shadow-sm group-hover:border-indigo-300 transition-colors">
                                    @endif
                                </div>
                            @endif
                            <div class="flex-1 w-full">
                                <label class="relative flex flex-col items-center justify-center w-full py-4 border-2 border-gray-200 dark:border-gray-600 border-dashed rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-500 rounded-full group-hover:scale-110 transition-transform">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Click to upload <span class="font-normal text-gray-400">or drag and drop</span></span>
                                    </div>
                                    <input type="file" wire:model="site_logo" accept="image/*" class="hidden">
                                </label>
                                <p class="text-xs text-gray-500 mt-2 ml-1">Recommended: 200x50px transparent PNG. Max 2MB.</p>
                                @error('site_logo') <span class="text-red-500 text-xs font-medium mt-2 flex items-center"><svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Site Favicon -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Website Favicon</label>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-6">
                            @if ($site_favicon || $existing_favicon)
                                <div class="shrink-0 relative group">
                                    @if ($site_favicon)
                                        <img src="{{ $site_favicon->temporaryUrl() }}" alt="New Favicon" class="h-14 w-14 rounded-xl object-contain bg-gray-50 dark:bg-gray-900 p-2 border-2 border-indigo-100 dark:border-indigo-900 shadow-inner">
                                    @elseif ($existing_favicon)
                                        <img src="{{ Storage::url($existing_favicon) }}" alt="Current Favicon" class="h-14 w-14 rounded-xl object-contain bg-gray-50 dark:bg-gray-900 p-2 border border-gray-200 dark:border-gray-700 shadow-sm group-hover:border-indigo-300 transition-colors">
                                    @endif
                                </div>
                            @endif
                            <div class="flex-1 w-full">
                                <label class="relative flex flex-col items-center justify-center w-full py-4 border-2 border-gray-200 dark:border-gray-600 border-dashed rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group">
                                    <div class="flex flex-col items-center justify-center space-y-2">
                                        <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-500 rounded-full group-hover:scale-110 transition-transform">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Click to upload <span class="font-normal text-gray-400">or drag and drop</span></span>
                                    </div>
                                    <input type="file" wire:model="site_favicon" accept="image/x-icon,image/png,image/jpeg,image/svg+xml" class="hidden">
                                </label>
                                <p class="text-xs text-gray-500 mt-2 ml-1">Recommended: 32x32px .ico or .png. Max 1MB.</p>
                                @error('site_favicon') <span class="text-red-500 text-xs font-medium mt-2 flex items-center"><svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Footer Copyright -->
                    <div class="mb-8 mt-8">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Footer Copyright Text</label>
                        <input type="text" wire:model="footer_copyright" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 hover:bg-white dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm" placeholder="e.g. © 2026 StudentJob. সর্বস্বত্ব সংরক্ষিত।">
                        @error('footer_copyright') <span class="text-red-500 text-xs font-medium mt-2 flex items-center">{{ $message }}</span> @enderror
                    </div>

                    <!-- Footer Text -->
                    <div class="mb-8 mt-8">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Footer Additional Text</label>
                        <input type="text" wire:model="footer_text" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 hover:bg-white dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm" placeholder="e.g. শিক্ষার্থীদের জন্য, শিক্ষার্থীদের দ্বারা তৈরি।">
                        @error('footer_text') <span class="text-red-500 text-xs font-medium mt-2 flex items-center">{{ $message }}</span> @enderror
                    </div>

                    <!-- WhatsApp Number -->
                    <div class="mb-8 mt-8">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">WhatsApp Number</label>
                        <input type="text" wire:model="whatsapp_number" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 hover:bg-white dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm" placeholder="e.g. +8801700000000">
                        @error('whatsapp_number') <span class="text-red-500 text-xs font-medium mt-2 flex items-center">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-xl transition-all shadow-md hover:shadow-lg focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center disabled:opacity-50" wire:loading.attr="disabled">
                            <svg wire:loading wire:target="saveSettings, site_logo, site_favicon" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
