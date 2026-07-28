@props([
    'sidebar' => false,
])

@php
    $siteName = \App\Models\Setting::get('site_name', config('app.name', 'StudentJob'));
    $siteLogo = \App\Models\Setting::get('site_logo', '');
@endphp

@if($sidebar)
    <flux:sidebar.brand :name="$siteName" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground p-0.5 bg-white">
            @if($siteLogo)
                <img src="{{ Storage::url($siteLogo) }}" alt="Logo" class="size-full object-contain" />
            @else
                <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
            @endif
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand :name="$siteName" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground p-0.5 bg-white">
            @if($siteLogo)
                <img src="{{ Storage::url($siteLogo) }}" alt="Logo" class="size-full object-contain" />
            @else
                <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
            @endif
        </x-slot>
    </flux:brand>
@endif
