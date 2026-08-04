<div class="mt-4 flex flex-col md:flex-row md:items-center gap-4">
    <div class="flex items-center gap-3 bg-white/10 border border-white/20 p-3 rounded-xl backdrop-blur-sm">
        <div class="flex items-center">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:model.live="is_profile_visible" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-500/50 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-500"></div>
            </label>
        </div>
        <div>
            <span class="text-sm font-semibold text-white {{ $is_profile_visible ? 'text-yellow-400' : 'text-gray-300' }}">
                {{ $is_profile_visible ? 'আমি কাজের জন্য এভেইলেবল (Public)' : 'আমি এভেইলেবল নই (Hidden)' }}
            </span>
            <p class="text-xs text-white/70">
                {{ $is_profile_visible ? 'ক্লায়েন্টরা আপনাকে সার্চে দেখতে পাবে এবং হায়ার করতে পারবে।' : 'আপনাকে সার্চে দেখা যাবে না।' }}
            </p>
        </div>
    </div>
    
    <!-- Flash message -->
    <div>
        @if (session()->has('status'))
            <div class="text-xs font-medium text-green-400 bg-green-900/40 border border-green-500/30 px-3 py-2 rounded-lg animate-fade-in-down">
                {{ session('status') }}
            </div>
        @endif
    </div>
</div>
