<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Home Page Settings</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage texts and cards on the home page.</p>
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

            <form wire:submit="saveSettings" class="space-y-8 max-w-4xl">
                <!-- Hero Section Texts -->
                <div class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b pb-2 dark:border-gray-700">Hero Section</h3>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Hero Title (HTML allowed for styling)</label>
                        <textarea wire:model="home_hero_title" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm"></textarea>
                        @error('home_hero_title') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Hero Subtitle</label>
                        <textarea wire:model="home_hero_subtitle" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm"></textarea>
                        @error('home_hero_subtitle') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Middle Title Section -->
                <div class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b pb-2 dark:border-gray-700">Middle Section</h3>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Title</label>
                        <input type="text" wire:model="home_middle_title" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm">
                        @error('home_middle_title') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Cards Section -->
                <div class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-xl border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 border-b pb-2 dark:border-gray-700">Information Cards Section</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Section Title</label>
                            <input type="text" wire:model="home_cards_title" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm">
                            @error('home_cards_title') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Section Subtitle</label>
                            <input type="text" wire:model="home_cards_subtitle" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 dark:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm">
                            @error('home_cards_subtitle') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Repeater for Cards -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Cards Data</label>
                            <button type="button" wire:click="addCard" class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                                + Add Card
                            </button>
                        </div>

                        <div class="space-y-6">
                            @foreach($home_cards as $index => $card)
                                <div class="p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-600 relative shadow-sm">
                                    <button type="button" wire:click="removeCard({{ $index }})" class="absolute top-4 right-4 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-full transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Title</label>
                                            <input type="text" wire:model="home_cards.{{ $index }}.title" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Tag (e.g. Quality, Speed)</label>
                                            <input type="text" wire:model="home_cards.{{ $index }}.tag" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Description</label>
                                            <textarea wire:model="home_cards.{{ $index }}.description" rows="2" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm"></textarea>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Image URL</label>
                                            <input type="url" wire:model="home_cards.{{ $index }}.image_url" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Link Text & URL</label>
                                            <div class="flex space-x-2">
                                                <input type="text" wire:model="home_cards.{{ $index }}.link_text" placeholder="Text" class="w-1/2 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm">
                                                <input type="text" wire:model="home_cards.{{ $index }}.link" placeholder="URL" class="w-1/2 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-sm">
                                            </div>
                                        </div>
                                    </div>
                                    @error('home_cards.'.$index.'.*') <span class="text-red-500 text-xs mt-2 block">All fields in the card are required and must be valid.</span> @enderror
                                </div>
                            @endforeach
                            @if(empty($home_cards))
                                <div class="text-center py-8 text-gray-500 dark:text-gray-400 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl">
                                    No cards added yet. Click "+ Add Card" to create one.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-xl transition-all shadow-md hover:shadow-lg focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center disabled:opacity-50" wire:loading.attr="disabled">
                        <svg wire:loading wire:target="saveSettings" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Save Home Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
