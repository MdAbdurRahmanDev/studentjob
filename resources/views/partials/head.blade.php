<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    @php
        $siteName = \App\Models\Setting::get('site_name', config('app.name', 'StudentJob'));
        $siteFavicon = \App\Models\Setting::get('site_favicon', '');
    @endphp
    {{ filled($title ?? null) ? $title.' - '.$siteName : $siteName }}
</title>

@if ($siteFavicon)
    <link rel="icon" href="{{ Storage::url($siteFavicon) }}">
@else
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
@endif

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
