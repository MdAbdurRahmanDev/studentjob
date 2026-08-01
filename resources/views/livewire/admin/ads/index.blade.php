<div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
    
    @if (session()->has('success'))
        <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Form Section -->
        <div class="md:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                        {{ $isEditing ? 'Edit Ad' : 'Add New Ad' }}
                    </h2>
                </div>

                <div class="p-6">
                    <form wire:submit="{{ $isEditing ? 'updateAd' : 'saveAd' }}" class="space-y-4">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                            <input type="text" wire:model="{{ $isEditing ? 'edit_title' : 'title' }}" 
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                placeholder="e.g. Special Offers">
                            @error($isEditing ? 'edit_title' : 'title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description (Optional)</label>
                            <textarea wire:model="{{ $isEditing ? 'edit_description' : 'description' }}" rows="2"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                placeholder="Short description"></textarea>
                            @error($isEditing ? 'edit_description' : 'description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Link URL (Optional)</label>
                            <input type="text" wire:model="{{ $isEditing ? 'edit_link' : 'link' }}" 
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                placeholder="https://example.com">
                            @error($isEditing ? 'edit_link' : 'link') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tag/Badge (Optional)</label>
                            <input type="text" wire:model="{{ $isEditing ? 'edit_tag' : 'tag' }}" 
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 px-4 py-2.5 text-sm dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                                placeholder="e.g. Featured Ad">
                            @error($isEditing ? 'edit_tag' : 'tag') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ad Image (Ideal: 360x450px)</label>
                            
                            @if($isEditing && $existing_image)
                                <div class="mb-2">
                                    <img src="{{ Storage::disk('uploads')->url($existing_image) }}" alt="Current Image" class="h-20 rounded object-cover">
                                </div>
                            @endif
                            
                            <input type="file" wire:model="{{ $isEditing ? 'edit_image' : 'image' }}" 
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:text-gray-400 dark:file:bg-gray-700 dark:file:text-gray-300">
                            @error($isEditing ? 'edit_image' : 'image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror

                            <div wire:loading wire:target="{{ $isEditing ? 'edit_image' : 'image' }}" class="text-sm text-indigo-500 mt-1">Uploading...</div>
                        </div>

                        <div class="flex items-center gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex-1" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="{{ $isEditing ? 'updateAd' : 'saveAd' }}">
                                    {{ $isEditing ? 'Update Ad' : 'Save Ad' }}
                                </span>
                                <span wire:loading wire:target="{{ $isEditing ? 'updateAd' : 'saveAd' }}">Saving...</span>
                            </button>
                            
                            @if($isEditing)
                                <button type="button" wire:click="cancelEdit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                    Cancel
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- List Section -->
        <div class="md:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">All Ads</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-50 dark:bg-gray-700/50 text-xs uppercase text-gray-700 dark:text-gray-300 border-b border-gray-100 dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-4 font-medium">Image</th>
                                <th class="px-6 py-4 font-medium">Title</th>
                                <th class="px-6 py-4 font-medium">Status</th>
                                <th class="px-6 py-4 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($ads as $ad)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="h-12 w-12 rounded overflow-hidden shadow-sm border border-gray-200 dark:border-gray-600 bg-gray-100">
                                            @if($ad->image)
                                                <img src="{{ Storage::disk('uploads')->url($ad->image) }}" class="h-full w-full object-cover" alt="{{ $ad->title }}">
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $ad->title }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $ad->tag }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button wire:click="toggleStatus({{ $ad->id }})" class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $ad->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $ad->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button wire:click="edit({{ $ad->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">Edit</button>
                                        <button wire:click="delete({{ $ad->id }})" wire:confirm="Are you sure you want to delete this ad?" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            <p>No ads found. Add your first ad using the form.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
