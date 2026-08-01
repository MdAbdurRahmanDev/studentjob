<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

@php
    $siteName = \App\Models\Setting::get('site_name', config('app.name', 'StudentJob'));
    $siteFavicon = \App\Models\Setting::get('site_favicon', '');
    $seoTitle = \App\Models\Setting::get('seo_title', $siteName);
    $seoKeywords = \App\Models\Setting::get('seo_keywords', '');
    $seoDescription = \App\Models\Setting::get('seo_description', '');
@endphp

<title>{{ filled($title ?? null) ? $title.' - '.$seoTitle : $seoTitle }}</title>

@if(filled($seoKeywords))
    <meta name="keywords" content="{{ $seoKeywords }}">
@endif

@if(filled($seoDescription))
    <meta name="description" content="{{ $seoDescription }}">
@endif

@if ($siteFavicon)
    <link rel="icon" href="{{ Storage::disk('uploads')->url($siteFavicon) }}">
@else
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
@endif

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
