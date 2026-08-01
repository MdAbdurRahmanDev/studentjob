<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">SEO Settings</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage global SEO title, keywords, and description.</p>
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
                    <!-- SEO Title -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Global SEO Title</label>
                        <input type="text" wire:model="seo_title" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 hover:bg-white dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm" placeholder="Default Site Title">
                        <p class="text-xs text-gray-500 mt-2 ml-1">This title will be used as a suffix for page titles or as the main title if none is provided.</p>
                        @error('seo_title') <span class="text-red-500 text-xs font-medium mt-2 flex items-center">{{ $message }}</span> @enderror
                    </div>

                    <!-- SEO Keywords -->
                    <div class="mb-8 mt-8">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Global SEO Keywords</label>
                        <input type="text" wire:model="seo_keywords" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 hover:bg-white dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm" placeholder="job, student job, part time job">
                        <p class="text-xs text-gray-500 mt-2 ml-1">Separate keywords with commas.</p>
                        @error('seo_keywords') <span class="text-red-500 text-xs font-medium mt-2 flex items-center">{{ $message }}</span> @enderror
                    </div>

                    <!-- SEO Description -->
                    <div class="mb-8 mt-8">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Global SEO Description</label>
                        <textarea wire:model="seo_description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 hover:bg-white dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm" placeholder="A platform for student jobs..."></textarea>
                        @error('seo_description') <span class="text-red-500 text-xs font-medium mt-2 flex items-center">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-xl transition-all shadow-md hover:shadow-lg focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center disabled:opacity-50" wire:loading.attr="disabled">
                            <svg wire:loading wire:target="saveSettings" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
