<div class="min-h-screen w-full flex flex-col gap-6 p-1">

    {{-- ===== SEARCH BAR ===== --}}
    <div class="relative">
        <form wire:submit.prevent="searchUser" class="group relative flex items-center gap-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl px-5 py-4 shadow-sm hover:shadow-md hover:border-yellow-400 dark:hover:border-yellow-500 transition-all duration-300">
            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-yellow-50 dark:bg-yellow-500/10 flex-shrink-0">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
            </div>
            <input
                type="text"
                wire:model="query"
                placeholder="নাম, ইমেইল বা User ID দিয়ে ইউজার খুঁজুন..."
                class="flex-1 bg-transparent outline-none text-sm font-medium text-zinc-800 dark:text-zinc-100 placeholder-zinc-400 dark:placeholder-zinc-600"
                autofocus
            >
            <button type="submit"
                class="flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 bg-yellow-500 hover:bg-yellow-400 active:scale-95 text-black text-sm font-bold rounded-xl shadow-sm shadow-yellow-500/30 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                খুঁজুন
            </button>
        </form>
    </div>

    @if(!$user && $query)
    {{-- ===== NOT FOUND ===== --}}
    <div class="flex flex-col items-center justify-center py-24 gap-4">
        <div class="w-20 h-20 rounded-3xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
            <svg class="w-10 h-10 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div class="text-center">
            <p class="text-base font-bold text-zinc-700 dark:text-zinc-300">"{{ $query }}" — পাওয়া যায়নি</p>
            <p class="text-sm text-zinc-400 mt-1">অন্য নাম, ইমেইল বা ID দিয়ে চেষ্টা করুন</p>
        </div>
    </div>

    @elseif($user)

    {{-- ===== HERO PROFILE CARD ===== --}}
    <div class="relative overflow-hidden rounded-3xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm">

        {{-- Gradient Banner — contains avatar + info --}}
        <div class="relative bg-gradient-to-br from-yellow-400 via-yellow-500 to-amber-500 overflow-hidden px-6 py-6 sm:px-8 sm:py-7">
            {{-- Decorative orbs --}}
            <div class="absolute -top-8 -right-8 w-40 h-40 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute -bottom-6 left-16 w-28 h-28 rounded-full bg-black/10 blur-xl"></div>
            <div class="absolute inset-0" style="background-image:radial-gradient(circle, rgba(255,255,255,0.15) 1px, transparent 1px); background-size:24px 24px;"></div>

            {{-- Profile row inside banner --}}
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center gap-4">
                {{-- Avatar --}}
                <div class="relative flex-shrink-0">
                    <div class="w-16 h-16 rounded-2xl bg-black/20 border-2 border-white/40 flex items-center justify-center text-2xl font-black text-white shadow-lg backdrop-blur-sm">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white {{ $user->email_verified_at ? 'bg-emerald-400' : 'bg-zinc-400' }}"></div>
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl font-black text-white tracking-tight mb-0.5 drop-shadow-sm">{{ $user->name }}</h1>
                    <p class="text-sm text-black/60 font-semibold mb-2">{{ $user->email }}</p>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center text-[11px] font-black px-2.5 py-1 rounded-full bg-black/20 text-white backdrop-blur-sm border border-white/20">
                            {{ ucfirst($user->role ?? 'user') }}
                        </span>
                        @if($user->email_verified_at)
                        <span class="inline-flex items-center gap-1 text-[11px] font-black px-2.5 py-1 rounded-full bg-white/20 text-white backdrop-blur-sm border border-white/20">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Verified
                        </span>
                        @endif
                    </div>
                </div>

                {{-- User ID --}}
                <div class="flex-shrink-0 text-left sm:text-right">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-black/40 mb-0.5">User ID</p>
                    <p class="text-2xl font-black font-mono text-white drop-shadow-sm">#{{ $user->id }}</p>
                </div>
            </div>
        </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 px-6 pt-5 pb-6 sm:px-8 sm:pb-8">
                {{-- Stat Card --}}
                <div class="group relative overflow-hidden rounded-2xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-100 dark:border-zinc-700/50 p-4 hover:border-yellow-300 dark:hover:border-yellow-500/40 transition-all duration-300">
                    <div class="absolute -top-3 -right-3 w-14 h-14 rounded-full bg-zinc-200/50 dark:bg-zinc-700/30 group-hover:bg-yellow-100 dark:group-hover:bg-yellow-500/10 transition-colors duration-300"></div>
                    <p class="text-3xl font-black text-zinc-800 dark:text-white mb-0.5">{{ $applications->count() }}</p>
                    <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wide">মোট আবেদন</p>
                </div>
                <div class="group relative overflow-hidden rounded-2xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-100 dark:border-zinc-700/50 p-4 hover:border-emerald-300 dark:hover:border-emerald-500/40 transition-all duration-300">
                    <div class="absolute -top-3 -right-3 w-14 h-14 rounded-full bg-zinc-200/50 dark:bg-zinc-700/30 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-500/10 transition-colors duration-300"></div>
                    <p class="text-3xl font-black text-emerald-600 dark:text-emerald-400 mb-0.5">{{ $applications->where('status', 'completed')->count() }}</p>
                    <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wide">সম্পন্ন শিফট</p>
                </div>
                <div class="group relative overflow-hidden rounded-2xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-100 dark:border-zinc-700/50 p-4 hover:border-yellow-300 dark:hover:border-yellow-500/40 transition-all duration-300">
                    <div class="absolute -top-3 -right-3 w-14 h-14 rounded-full bg-zinc-200/50 dark:bg-zinc-700/30 group-hover:bg-yellow-100 dark:group-hover:bg-yellow-500/10 transition-colors duration-300"></div>
                    <p class="text-3xl font-black text-yellow-600 dark:text-yellow-400 mb-0.5">৳{{ number_format($applications->sum('earnings'), 0) }}</p>
                    <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wide">মোট আয়</p>
                </div>
                <div class="group relative overflow-hidden rounded-2xl bg-zinc-50 dark:bg-zinc-800/60 border border-zinc-100 dark:border-zinc-700/50 p-4 hover:border-blue-300 dark:hover:border-blue-500/40 transition-all duration-300">
                    <div class="absolute -top-3 -right-3 w-14 h-14 rounded-full bg-zinc-200/50 dark:bg-zinc-700/30 group-hover:bg-blue-100 dark:group-hover:bg-blue-500/10 transition-colors duration-300"></div>
                    <p class="text-3xl font-black text-blue-600 dark:text-blue-400 mb-0.5">{{ $subscriptions->count() }}</p>
                    <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wide">সাবস্ক্রিপশন</p>
                </div>
            </div>
    </div>

    {{-- ===== TABS ===== --}}
    <div class="flex gap-1.5 bg-zinc-100 dark:bg-zinc-800/80 p-1.5 rounded-2xl w-fit">
        @foreach([
            ['overview', 'সংক্ষেপ', 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
            ['applications', 'আবেদন', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
            ['subscriptions', 'সাবস্ক্রিপশন', 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
        ] as [$tab, $label, $icon])
        <button
            wire:click="setTab('{{ $tab }}')"
            @class([
                'inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-xl transition-all duration-200',
                'bg-white dark:bg-zinc-900 text-yellow-600 dark:text-yellow-400 shadow-sm ring-1 ring-zinc-200 dark:ring-zinc-700' => $activeTab === $tab,
                'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200' => $activeTab !== $tab,
            ])
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
            </svg>
            {{ $label }}
            @if($tab === 'applications')
            <span @class([
                'text-[10px] font-black px-1.5 py-0.5 rounded-full',
                'bg-yellow-500 text-black' => $activeTab === $tab,
                'bg-zinc-200 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400' => $activeTab !== $tab,
            ])>{{ $applications->count() }}</span>
            @endif
        </button>
        @endforeach
    </div>

    {{-- ===== TAB: OVERVIEW ===== --}}
    @if($activeTab === 'overview')
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">

        {{-- Personal Info (wider) --}}
        <div class="lg:col-span-3 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-zinc-100 dark:border-zinc-800">
                <div class="w-8 h-8 rounded-xl bg-yellow-50 dark:bg-yellow-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200">ব্যক্তিগত তথ্য</h3>
            </div>
            <div class="divide-y divide-zinc-50 dark:divide-zinc-800/60">
                @foreach([
                    ['পূর্ণ নাম', $user->name, false],
                    ['ইমেইল', $user->email, false],
                    ['ফোন নম্বর', $user->phone ?? '—', false],
                    ['User ID', '#'.$user->id, 'mono'],
                    ['যোগদান', $user->created_at->format('d M Y, h:i A'), false],
                ] as [$label, $value, $style])
                <div class="flex items-center justify-between px-6 py-3.5 hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wide">{{ $label }}</span>
                    <span @class([
                        'text-sm font-semibold text-zinc-800 dark:text-zinc-200',
                        'font-mono' => $style === 'mono',
                    ])>{{ $value }}</span>
                </div>
                @endforeach
                <div class="flex items-center justify-between px-6 py-3.5">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wide">Role</span>
                    <span @class([
                        'text-xs font-bold px-3 py-1 rounded-full',
                        'bg-red-100 text-red-600 dark:bg-red-500/10 dark:text-red-400' => $user->role === 'admin',
                        'bg-blue-100 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400' => $user->role === 'employer',
                        'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' => !in_array($user->role, ['admin','employer']),
                    ])>{{ ucfirst($user->role ?? 'user') }}</span>
                </div>
                <div class="flex items-center justify-between px-6 py-3.5">
                    <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wide">ইমেইল ভেরিফাই</span>
                    @if($user->email_verified_at)
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 dark:text-emerald-400">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ $user->email_verified_at->format('d M Y') }}
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-red-500">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        হয়নি
                    </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right column --}}
        <div class="lg:col-span-2 flex flex-col gap-4">

            {{-- Subscription Card --}}
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm flex-1">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-zinc-100 dark:border-zinc-800">
                    <div class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200">সাবস্ক্রিপশন</h3>
                </div>
                @php $latestSub = $user->latestSubscription; @endphp
                @if($latestSub)
                <div class="p-5 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wide">স্ট্যাটাস</span>
                        <span @class([
                            'text-xs font-bold px-2.5 py-1 rounded-full',
                            'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' => $latestSub->status === 'approved',
                            'bg-yellow-100 text-yellow-600 dark:bg-yellow-500/10 dark:text-yellow-400' => $latestSub->status === 'pending',
                            'bg-red-100 text-red-500 dark:bg-red-500/10 dark:text-red-400' => !in_array($latestSub->status, ['approved','pending']),
                        ])>{{ ucfirst($latestSub->status) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wide">পেমেন্ট</span>
                        <span class="text-sm font-bold text-zinc-800 dark:text-zinc-200">{{ $latestSub->payment_method ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wide">Trx ID</span>
                        <span class="text-xs font-mono text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2 py-0.5 rounded-lg">{{ $latestSub->transaction_id ?? '—' }}</span>
                    </div>
                    @if($latestSub->expires_at)
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-zinc-400 uppercase tracking-wide">মেয়াদ</span>
                        <span class="text-sm font-bold {{ $latestSub->expires_at->isFuture() ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500' }}">
                            {{ $latestSub->expires_at->format('d M Y') }}
                        </span>
                    </div>
                    @endif
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-8 text-zinc-400">
                    <svg class="w-8 h-8 mb-2 text-zinc-300 dark:text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <p class="text-xs font-medium">কোনো সাবস্ক্রিপশন নেই</p>
                </div>
                @endif
            </div>

            {{-- ID Verification Card --}}
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-zinc-100 dark:border-zinc-800">
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200">পরিচয় যাচাই</h3>
                </div>
                @php $v = $user->verification; @endphp
                @if($v)
                <div class="p-5 flex items-center justify-between">
                    <span class="text-sm font-semibold text-zinc-600 dark:text-zinc-400">{{ $v->document_type ?? 'Document' }}</span>
                    <span @class([
                        'text-xs font-bold px-2.5 py-1 rounded-full',
                        'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' => $v->status === 'approved',
                        'bg-yellow-100 text-yellow-600 dark:bg-yellow-500/10 dark:text-yellow-400' => $v->status === 'pending',
                        'bg-red-100 text-red-500 dark:bg-red-500/10 dark:text-red-400' => !in_array($v->status, ['approved','pending']),
                    ])>{{ ucfirst($v->status) }}</span>
                </div>
                @else
                <div class="flex items-center justify-center py-6 text-zinc-400">
                    <p class="text-xs font-medium">কোনো ভেরিফিকেশন নেই</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- ===== TAB: APPLICATIONS ===== --}}
    @if($activeTab === 'applications')
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100 dark:border-zinc-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-yellow-50 dark:bg-yellow-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200">আবেদন ইতিহাস</h3>
            </div>
            <span class="text-xs font-bold px-2.5 py-1 bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 rounded-full">{{ $applications->count() }}টি</span>
        </div>
        @if($applications->count() > 0)
        <div class="divide-y divide-zinc-50 dark:divide-zinc-800/60">
            @foreach($applications as $app)
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-zinc-800 dark:text-zinc-200 truncate">{{ $app->job?->title ?? 'Deleted Job' }}</p>
                    <p class="text-xs text-zinc-400 font-medium mt-0.5">{{ $app->created_at->format('d M Y, h:i A') }}</p>
                </div>
                @if($app->earnings)
                <div class="flex-shrink-0 text-right">
                    <p class="text-sm font-black text-yellow-600 dark:text-yellow-400">৳{{ number_format($app->earnings, 0) }}</p>
                    <p class="text-[10px] text-zinc-400">আয়</p>
                </div>
                @endif
                <span @class([
                    'text-xs font-bold px-2.5 py-1 rounded-full flex-shrink-0',
                    'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' => $app->status === 'completed',
                    'bg-blue-100 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400' => $app->status === 'hired',
                    'bg-yellow-100 text-yellow-600 dark:bg-yellow-500/10 dark:text-yellow-400' => $app->status === 'pending',
                    'bg-red-100 text-red-500 dark:bg-red-500/10 dark:text-red-400' => $app->status === 'absent',
                    'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400' => !in_array($app->status, ['completed','hired','pending','absent']),
                ])>{{ ucfirst($app->status) }}</span>
            </div>
            @endforeach
        </div>
        @else
        <div class="flex flex-col items-center py-16 text-zinc-400 gap-3">
            <svg class="w-10 h-10 text-zinc-200 dark:text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <p class="text-sm font-medium">কোনো আবেদন নেই</p>
        </div>
        @endif
    </div>
    @endif

    {{-- ===== TAB: SUBSCRIPTIONS ===== --}}
    @if($activeTab === 'subscriptions')
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100 dark:border-zinc-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200">সাবস্ক্রিপশন ইতিহাস</h3>
            </div>
            <span class="text-xs font-bold px-2.5 py-1 bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 rounded-full">{{ $subscriptions->count() }}টি</span>
        </div>
        @if($subscriptions->count() > 0)
        <div class="divide-y divide-zinc-50 dark:divide-zinc-800/60">
            @foreach($subscriptions as $sub)
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-zinc-800 dark:text-zinc-200">{{ $sub->payment_method ?? 'Unknown' }}</p>
                    <p class="text-xs font-mono text-zinc-400 mt-0.5 bg-zinc-100 dark:bg-zinc-800 inline-block px-2 py-0.5 rounded-md">{{ $sub->transaction_id ?? '—' }}</p>
                </div>
                @if($sub->expires_at)
                <div class="flex-shrink-0 text-right">
                    <p class="text-[10px] text-zinc-400 mb-0.5">মেয়াদ</p>
                    <p class="text-xs font-bold {{ $sub->expires_at->isFuture() ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500' }}">
                        {{ $sub->expires_at->format('d M Y') }}
                    </p>
                </div>
                @endif
                <span @class([
                    'text-xs font-bold px-2.5 py-1 rounded-full flex-shrink-0',
                    'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' => $sub->status === 'approved',
                    'bg-yellow-100 text-yellow-600 dark:bg-yellow-500/10 dark:text-yellow-400' => $sub->status === 'pending',
                    'bg-red-100 text-red-500 dark:bg-red-500/10 dark:text-red-400' => !in_array($sub->status, ['approved','pending']),
                ])>{{ ucfirst($sub->status) }}</span>
            </div>
            @endforeach
        </div>
        @else
        <div class="flex flex-col items-center py-16 text-zinc-400 gap-3">
            <svg class="w-10 h-10 text-zinc-200 dark:text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            <p class="text-sm font-medium">কোনো সাবস্ক্রিপশন নেই</p>
        </div>
        @endif
    </div>
    @endif

    @else
    {{-- ===== EMPTY STATE ===== --}}
    <div class="flex flex-col items-center justify-center py-28 gap-5">
        <div class="relative">
            <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-yellow-400/20 to-amber-500/10 dark:from-yellow-500/10 dark:to-amber-500/5 border border-yellow-200 dark:border-yellow-500/20 flex items-center justify-center">
                <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
            </div>
            <div class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-yellow-500 border-2 border-white dark:border-zinc-900 flex items-center justify-center">
                <svg class="w-3 h-3 text-black" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
            </div>
        </div>
        <div class="text-center">
            <h3 class="text-lg font-black text-zinc-800 dark:text-zinc-200 mb-1">ইউজার খুঁজুন</h3>
            <p class="text-sm text-zinc-400 font-medium">নাম, ইমেইল বা User ID দিয়ে যেকোনো ইউজারের<br>সম্পূর্ণ প্রোফাইল ও ইতিহাস দেখুন</p>
        </div>
    </div>
    @endif

</div>
