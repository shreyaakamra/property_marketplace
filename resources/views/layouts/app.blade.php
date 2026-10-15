<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Property Registry')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400..700&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
@include('partials.welcome-modal')
<body>
    <nav class="nav">
        <div class="nav-inner">
           <a href="{{ route('home') }}" class="brand">
    <img src="{{ asset('images/logo.png') }}" alt="" class="brand-logo">
    Registry<span class="code-dot">.</span>Home
</a>
           <div class="nav-links">
    <a href="{{ route('properties.index') }}">Browse</a>
    <a href="{{ route('shared-spaces.index') }}">Requirements</a>
    <a href="{{ route('about') }}">About</a>
    <a href="{{ route('why-us') }}">Why Us</a>
    <a href="{{ route('contact') }}">Contact</a>
    <a href="{{ route('home') }}#post" class="btn btn-brass" style="margin-left:24px;">Post free</a>
</div>
        </div>
    </nav>

    @if (session('status'))
        <div class="wrap" style="margin-top:16px;">
            <div class="chip" style="background:#eef4ee;border-color:var(--verified);color:var(--verified);">
                {{ session('status') }}
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>
<div class="footer-ticker">
    <div class="footer-ticker-track">
        @php
            $footerTags = ['DIRECT OWNER DEALS', 'REGISTRY.HOME', 'FREE LISTINGS', 'ZERO COMMISSION'];
        @endphp
        @foreach (array_merge($footerTags, $footerTags, $footerTags) as $tag)
            <span>{{ $tag }}</span><span class="footer-ticker-dot">•</span>
        @endforeach
    </div>
</div>
    <footer class="site-footer">
        <div class="wrap">
            &copy; {{ date('Y') }} Registry.Home — an original starter kit, not affiliated with any third-party listing site.
        </div>
    </footer>
</body>
</html>
