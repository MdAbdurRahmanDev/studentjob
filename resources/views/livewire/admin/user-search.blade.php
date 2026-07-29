<div class="w-full" x-data="{ open: @entangle('showResults') }">

    {{-- Search Bar --}}
    <div class="relative">
        <div class="flex items-center gap-3 w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-2xl shadow-sm px-4 py-3 focus-within:ring-2 focus-within:ring-yellow-500 focus-within:border-yellow-500 transition-all">
            <svg class="w-5 h-5 text-zinc-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
            <input
                type="text"
                wire:model.live.debounce.300ms="query"
                placeholder="নাম, ইমেইল বা User ID দিয়ে ইউজার খুঁজুন..."
                class="flex-1 bg-transparent outline-none text-sm text-zinc-800 dark:text-zinc-200 placeholder-zinc-400"
                @focus="if($wire.query.length > 0) open = true"
                @click.outside="open = false"
            >
            @if($query)
            <button wire:click="clearSearch" class="text-zinc-400 hover:text-zinc-600 transition-colors flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            @endif
        </div>

        {{-- Dropdown Results --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-end="opacity-0"
            class="absolute top-full left-0 right-0 mt-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-2xl shadow-xl z-50 overflow-hidden"
            style="display:none;"
        >
            @if($results->count() > 0)
                <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @foreach($results as $user)
                    <button
                        wire:click="selectUser({{ $user->id }})"
                        class="w-full flex items-center gap-4 px-5 py-3.5 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors text-left"
                    >
                        <div class="w-9 h-9 rounded-full bg-yellow-500 flex items-center justify-center font-bold text-black text-sm flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-zinc-800 dark:text-zinc-200 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-zinc-400 truncate">{{ $user->email }}</p>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full
                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-600' : ($user->role === 'employer' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600') }}">
                                {{ ucfirst($user->role ?? 'user') }}
                            </span>
                            <span class="text-xs font-mono text-zinc-400">#{{ $user->id }}</span>
                        </div>
                    </button>
                    @endforeach
                </div>
            @else
                <div class="px-5 py-6 text-center text-sm text-zinc-400">
                    <svg class="w-8 h-8 mx-auto mb-2 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    কোনো ইউজার পাওয়া যায়নি
                </div>
            @endif
        </div>
    </div>

    {{-- Selected User Profile Card --}}
    @if($selectedUser)
    <div class="mt-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-2xl shadow-sm overflow-hidden">
        {{-- Card Header --}}
        <div class="flex items-center gap-4 p-5 border-b border-zinc-100 dark:border-zinc-800">
            <div class="w-14 h-14 rounded-full bg-yellow-500 flex items-center justify-center font-bold text-black text-xl flex-shrink-0">
                {{ strtoupper(substr($selectedUser->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-base font-bold text-zinc-900 dark:text-white truncate">{{ $selectedUser->name }}</h3>
                <p class="text-sm text-zinc-500 truncate">{{ $selectedUser->email }}</p>
            </div>
            <span class="text-xs font-bold px-3 py-1 rounded-full flex-shrink-0
                {{ $selectedUser->role === 'admin' ? 'bg-red-100 text-red-600' : ($selectedUser->role === 'employer' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600') }}">
                {{ ucfirst($selectedUser->role ?? 'user') }}
            </span>
        </div>

        {{-- Card Details --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-zinc-100 dark:divide-zinc-800">
            <div class="px-5 py-4">
                <p class="text-xs text-zinc-400 mb-1">User ID</p>
                <p class="text-sm font-mono font-semibold text-zinc-700 dark:text-zinc-300">#{{ $selectedUser->id }}</p>
            </div>
            <div class="px-5 py-4">
                <p class="text-xs text-zinc-400 mb-1">ফোন নম্বর</p>
                <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">{{ $selectedUser->phone ?? '—' }}</p>
            </div>
            <div class="px-5 py-4">
                <p class="text-xs text-zinc-400 mb-1">যোগ দিয়েছেন</p>
                <p class="text-sm font-semibold text-zinc-700 dark:text-zinc-300">{{ $selectedUser->created_at->format('d M Y') }}</p>
            </div>
            <div class="px-5 py-4">
                <p class="text-xs text-zinc-400 mb-1">ইমেইল ভেরিফাই</p>
                <p class="text-sm font-semibold {{ $selectedUser->email_verified_at ? 'text-green-600' : 'text-red-500' }}">
                    {{ $selectedUser->email_verified_at ? '✓ হয়েছে' : '✗ হয়নি' }}
                </p>
            </div>
        </div>
    </div>
    @endif

</div>
