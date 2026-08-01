<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                @if(auth()->check() && auth()->user()->role === 'admin')
                <div class="px-2 pb-2 pt-1">
                    <form action="{{ route('admin.users.search') }}" method="GET">
                        <div class="flex items-center gap-2 bg-zinc-100 dark:bg-zinc-800 rounded-xl px-3 py-2 focus-within:ring-1 focus-within:ring-yellow-500 transition-all">
                            <svg class="w-3.5 h-3.5 text-zinc-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                            </svg>
                            <input
                                type="text"
                                name="q"
                                placeholder="ইউজার খুঁজুন..."
                                class="flex-1 bg-transparent outline-none text-xs text-zinc-700 dark:text-zinc-200 placeholder-zinc-400 min-w-0"
                            >
                            <button type="submit" class="flex-shrink-0 text-zinc-400 hover:text-yellow-500 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    @if(!auth()->check() || auth()->user()->role !== 'admin')
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    @endif

                    @if(auth()->check() && auth()->user()->role === 'admin')
                    <flux:sidebar.item icon="shield-check" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')" wire:navigate>
                        {{ __('Admin Dashboard') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="users" :href="route('admin.users')" :current="request()->routeIs('admin.users')" wire:navigate>
                        {{ __('All Users') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="check-badge" :href="route('admin.verifications')" :current="request()->routeIs('admin.verifications')" wire:navigate>
                        {{ __('User Verifications') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="briefcase" :href="route('admin.jobs')" :current="request()->routeIs('admin.jobs')" wire:navigate>
                        {{ __('Total Jobs') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="clipboard-document-check" :href="route('admin.applications')" :current="request()->routeIs('admin.applications')" wire:navigate>
                        {{ __('Job Applications') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="folder" :href="route('admin.categories')" :current="request()->routeIs('admin.categories')" wire:navigate>
                        {{ __('Categories') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="megaphone" :href="route('admin.ads')" :current="request()->routeIs('admin.ads')" wire:navigate>
                        {{ __('Ads Management') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="credit-card" :href="route('admin.payment-methods')" :current="request()->routeIs('admin.payment-methods')" wire:navigate>
                        {{ __('Payment Methods') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="banknotes" :href="route('admin.transactions')" :current="request()->routeIs('admin.transactions')" wire:navigate>
                        {{ __('Transactions') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="no-symbol" :href="route('admin.blocked-ips')" :current="request()->routeIs('admin.blocked-ips')" wire:navigate>
                        {{ __('Blocked IPs') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('Settings')" class="grid">
                    <flux:sidebar.item icon="cog-6-tooth" :href="route('admin.settings.general')" :current="request()->routeIs('admin.settings.general')" wire:navigate>
                        {{ __('General Settings') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="magnifying-glass-circle" :href="route('admin.settings.seo')" :current="request()->routeIs('admin.settings.seo')" wire:navigate>
                        {{ __('SEO Settings') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="window" :href="route('admin.settings.home-page')" :current="request()->routeIs('admin.settings.home-page')" wire:navigate>
                        {{ __('Home Page Settings') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="device-phone-mobile" :href="route('admin.settings.sms')" :current="request()->routeIs('admin.settings.sms')" wire:navigate>
                        {{ __('SMS Settings') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
                @endif
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="book-open-text" href="{{ route('admin.documentation') }}" wire:navigate>
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
