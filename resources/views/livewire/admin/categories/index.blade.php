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
                        {{ $isEditing ? 'Edit Category' : 'Add New Category' }}
                    </h2>
                </div>
                
                <div class="p-6">
                    <form wire:submit="{{ $isEditing ? 'updateCategory' : 'saveCategory' }}" class="space-y-6">
                        
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Category Name</label>
                            <input type="text" wire:model="{{ $isEditing ? 'edit_name' : 'name' }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 hover:bg-white dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm" placeholder="e.g. Graphic Design">
                            @error($isEditing ? 'edit_name' : 'name') <span class="text-red-500 text-xs font-medium mt-2">{{ $message }}</span> @enderror
                        </div>

                        <!-- Icon -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Category Icon</label>
                            
                            @if($isEditing && $existing_icon && !$edit_icon)
                                <div class="mb-4">
                                    <span class="text-xs text-gray-500 mb-1 block">Current Icon:</span>
                                    <img src="{{ Storage::url($existing_icon) }}" class="h-16 w-16 object-contain bg-gray-50 p-2 rounded border border-gray-200">
                                </div>
                            @endif

                            @if($icon && !$isEditing)
                                <div class="mb-4">
                                    <span class="text-xs text-gray-500 mb-1 block">Preview:</span>
                                    <img src="{{ $icon->temporaryUrl() }}" class="h-16 w-16 object-contain bg-gray-50 p-2 rounded border border-gray-200">
                                </div>
                            @elseif($isEditing && $edit_icon)
                                <div class="mb-4">
                                    <span class="text-xs text-gray-500 mb-1 block">Preview:</span>
                                    <img src="{{ $edit_icon->temporaryUrl() }}" class="h-16 w-16 object-contain bg-gray-50 p-2 rounded border border-gray-200">
                                </div>
                            @endif

                            <div class="relative flex flex-col items-center justify-center w-full py-4 border-2 border-gray-200 dark:border-gray-600 border-dashed rounded-xl cursor-pointer bg-gray-50 dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-500 rounded-full group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300 text-center px-4">
                                        {{ ($isEditing ? $edit_icon : $icon) ? 'File selected - click to change' : 'Click to upload icon' }}
                                    </span>
                                </div>
                                <input type="file" wire:model="{{ $isEditing ? 'edit_icon' : 'icon' }}" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            </div>
                            @error($isEditing ? 'edit_icon' : 'icon') <span class="text-red-500 text-xs font-medium mt-2">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-2 flex flex-col space-y-3">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-xl transition-all shadow-md focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center justify-center disabled:opacity-50" wire:loading.attr="disabled">
                                <svg wire:loading wire:target="{{ $isEditing ? 'updateCategory' : 'saveCategory' }}, icon, edit_icon" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                {{ $isEditing ? 'Update Category' : 'Save Category' }}
                            </button>
                            
                            @if($isEditing)
                                <button type="button" wire:click="cancelEdit" class="w-full bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold py-3 px-4 rounded-xl transition-colors">
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
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/50">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">All Categories</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                                <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Icon</th>
                                <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="p-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($categories as $category)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="p-4">
                                        @if($category->icon)
                                            <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center p-2 border border-gray-200">
                                                <img src="{{ Storage::url($category->icon) }}" class="max-w-full max-h-full object-contain" alt="{{ $category->name }}">
                                            </div>
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 border border-gray-200">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-4 font-medium text-gray-900 dark:text-gray-100">
                                        {{ $category->name }}
                                        <div class="text-xs text-gray-500 font-normal mt-1">{{ $category->jobs()->count() }} jobs associated</div>
                                    </td>
                                    <td class="p-4 text-right">
                                        <button wire:click="edit({{ $category->id }})" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm mr-4 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors">
                                            Edit
                                        </button>
                                        <button wire:click="delete({{ $category->id }})" wire:confirm="Are you sure you want to delete this category?" class="text-red-600 hover:text-red-900 font-medium text-sm bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-8 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            <p>No categories found.</p>
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
