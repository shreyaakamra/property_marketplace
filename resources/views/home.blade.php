@extends('layouts.app')

@section('title', 'Registry.Home — Direct-owner property, no brokers, no guessing')

@section('content')
<div class="ticker-bar">
    <span class="ticker-badge">📰 Latest</span>
     <span class="ticker-badge ticker-badge-weather">📍 {{ $currentCity ?? 'DELHI' }} ☀️ {{ $currentTemp ?? '31' }}°C</span>
    <div class="ticker-track-wrap">
        <div class="ticker-track">
            @php
                $headlines = [
                    'Indore records highest rental demand growth in Central India this quarter',
                    'RERA tightens disclosure norms for under-construction projects',
                    'Direct-owner listings up 40% as buyers skip broker commissions',
                    'Bhopal ring-road expansion set to boost nearby property values',
                ];
            @endphp
            {{-- Duplicate the list once so the scroll loops seamlessly --}}
            @foreach (array_merge($headlines, $headlines) as $headline)
                <span class="ticker-item">{{ $headline }} <span class="ticker-dot">◆</span></span>
            @endforeach
        </div>
    </div>
</div>
<style>
    .footer-ticker {
    overflow: hidden;
    background: var(--navy, #0a1929);
    padding: 10px 0;
}
.footer-ticker-track {
    display: flex;
    width: max-content;
    gap: 8px;
    animation: ticker-scroll 25s linear infinite;
    font-family: var(--font-mono, 'IBM Plex Mono', monospace);
    font-size: 0.7rem;
    letter-spacing: 0.08em;
    color: rgba(255,255,255,0.5);
}
.footer-ticker-dot {
    color: var(--brass);
    margin: 0 8px;
}
    .city-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
    margin-top: 8px;
}

.city-card {
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    min-height: 160px;
    padding: 18px;
    border-radius: 10px;
    text-decoration: none;
    background-size: cover;
    background-position: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.city-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.25);
}

.city-card h3 {
    margin: 0;
    color: #fff;
    font-size: 1.15rem;
    text-shadow: 0 1px 3px rgba(0,0,0,0.5);
}

.city-card p {
    margin: 2px 0 0;
    color: rgba(255,255,255,0.85);
    font-size: 0.8rem;
}
.ticker-badge-weather {
    background: transparent;
    color: rgba(255,255,255,0.7);
    border-right: 1px solid rgba(255,255,255,0.1);
}
/* New classes for Browse-by-Category + Active Requirements.
   Colors reuse var(--brass) which your carousel already confirms exists.
   --ink / --muted / --border are GUESSED fallbacks — replace with your
   real app.css values if these differ. */
.ticker-bar {
    display: flex;
    align-items: center;
    background: #1a2c42; /* slightly lighter than your --navy for separation */
    border-bottom: 1px solid rgba(255,255,255,0.08);
    overflow: hidden;
}

.ticker-badge {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 8px 16px;
    background: var(--brass);
    color: #1a1a1a;
    font-family: var(--font-mono, 'IBM Plex Mono', monospace);
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.04em;
    white-space: nowrap;
}
.ticker-badge-weather {
    background: transparent;
    color: rgba(255,255,255,0.7);
    border-right: 1px solid rgba(255,255,255,0.1);
}

.ticker-track-wrap {
    overflow: hidden;
    flex: 1;
}

.ticker-track {
    display: flex;
    width: max-content;
    animation: ticker-scroll 40s linear infinite;
}

.ticker-item {
    flex-shrink: 0;
    padding: 8px 32px 8px 0;
    color: rgba(255,255,255,0.75);
    font-size: 0.82rem;
    white-space: nowrap;
}

.ticker-dot {
    margin-left: 24px;
    color: var(--brass);
    opacity: 0.6;
}

@keyframes ticker-scroll {
    from { transform: translateX(0); }
    to   { transform: translateX(-50%); }
}

/* pause on hover so it's readable if someone actually wants to read one */
.ticker-bar:hover .ticker-track {
    animation-play-state: paused;
}

@media (prefers-reduced-motion: reduce) {
    .ticker-track {
        animation: none;
    }
}
.section-subtitle {
    color: var(--muted, #6b7280);
    margin-top: -8px;
    margin-bottom: 24px;
    font-size: 0.95rem;
}

.section-header-row {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
}

.section-link {
    font-size: 0.9rem;
    color: var(--brass);
    text-decoration: none;
    font-weight: 500;
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
    margin-top: 8px;
}

.category-card {
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    min-height: 160px;
    padding: 20px;
    border-radius: 10px;
    text-decoration: none;
    background-size: cover;
    background-position: center;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.category-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.25);
}

.category-icon {
    font-size: 1.6rem;
    line-height: 1;
}

.category-card h3 {
    margin: 2px 0 0;
    font-size: 1.05rem;
    color: #fff;
    text-shadow: 0 1px 3px rgba(0,0,0,0.5);
}

.category-card p {
    margin: 0;
    font-size: 0.85rem;
    color: rgba(255,255,255,0.85);
}

.requirement-card {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.requirement-desc {
    font-size: 0.85rem;
    color: var(--muted, #6b7280);
    margin: 4px 0 0;
}

.requirement-contact {
    font-family: var(--font-mono, 'IBM Plex Mono', monospace);
    font-size: 0.8rem;
    color: var(--ink, #1f2937);
    margin-top: 4px;
}

.empty-state {
    color: var(--muted, #6b7280);
    font-size: 0.9rem;
}
.property-card-photo {
    min-height: 220px;
    background-size: cover;
    background-position: center;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    color: #fff;
}
.property-card-photo h3,
.property-card-photo .price {
    color: #fff;
}
.property-card-photo .meta {
    color: rgba(255,255,255,0.8);
}
.category-tag {
    display: inline-block;
    align-self: flex-start;
    padding: 3px 8px;
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.35);
    border-radius: 4px;
    font-family: var(--font-mono, 'IBM Plex Mono', monospace);
    font-size: 0.7rem;
    letter-spacing: 0.03em;
    color: #fff;
    backdrop-filter: blur(2px);
    position: relative;
    z-index: 2;
    margin-bottom: 6px;
}
.search-field {
    position: relative;
}
.search-field label {
    display: flex;
    align-items: center;
    gap: 6px;
}
.search-field label::before {
    content: '';
    width: 14px;
    height: 14px;
    background-size: contain;
    opacity: 0.6;
}
.search-field:nth-child(1) label::before {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23145C40'%3E%3Cpath d='M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z'/%3E%3C/svg%3E");
}
.search-field:nth-child(2) label::before {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23145C40'%3E%3Cpath d='M3 21V8l9-5 9 5v13h-6v-7H9v7z'/%3E%3C/svg%3E");
}
.hero {
    padding-top: 32px !important;
}
.hero-main {
    padding-top: 0 !important;
}
.hero-tag {
    margin-top: 0 !important;
}
.hero {
    background:
        linear-gradient(180deg, rgba(10,25,41,0.55) 0%, rgba(10,25,41,0.88) 65%, rgba(10,25,41,0.97) 100%),
        radial-gradient(circle at 85% 20%, rgba(242,169,59,0.10), transparent 40%),
        url('{{ asset('images/hero-skyline.jpeg') }}') center/cover no-repeat;
}
.hero {
    background-attachment: fixed;
}
.dot {
    animation: pulse 2s ease-in-out infinite;
}
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

/* ============================================= */
/* HERO CHAT-BUBBLE VISUAL                        */
/* Replaces the stock-photo carousel. Signals the */
/* "direct to owner, no broker" pitch visually.    */
/* ============================================= */
.hero-visual {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 14px;
}

.chat-window {
    width: 100%;
    max-width: 400px;
    border-radius: 16px;
    overflow: hidden;
    background: #0f2338;
    box-shadow:
        0 24px 60px rgba(0,0,0,0.45),
        0 2px 0 rgba(255,255,255,0.03) inset;
    border: 1px solid rgba(255,255,255,0.06);
}

.chat-window__header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 16px;
    background: #142c46;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}

.chat-window__dot {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    flex-shrink: 0;
    background: linear-gradient(135deg, var(--brass, #d99a3f), #b97a1f);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-mono, 'IBM Plex Mono', monospace);
    font-size: 0.75rem;
    font-weight: 700;
    color: #1a1a1a;
}

.chat-window__dot::after {
    content: 'RM';
}

.chat-window__title {
    display: flex;
    flex-direction: column;
    line-height: 1.25;
}

.chat-window__title strong {
    color: #fff;
    font-size: 0.9rem;
}

.chat-window__title span {
    color: rgba(255,255,255,0.55);
    font-size: 0.72rem;
}

.chat-window__badge {
    margin-left: auto;
    font-family: var(--font-mono, 'IBM Plex Mono', monospace);
    font-size: 0.65rem;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    color: var(--brass, #d99a3f);
    border: 1px solid rgba(217,154,63,0.4);
    padding: 3px 8px;
    border-radius: 999px;
    white-space: nowrap;
}

.chat-window__body {
    padding: 18px 16px 22px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    background:
        radial-gradient(circle at 20% 10%, rgba(255,255,255,0.02), transparent 40%),
        #0f2338;
    min-height: 260px;
}

.chat-bubble {
    max-width: 78%;
    padding: 10px 13px;
    border-radius: 14px;
    font-size: 0.85rem;
    line-height: 1.4;
    opacity: 0;
    transform: translateY(10px);
    animation: bubble-in 0.5s ease forwards;
    animation-delay: var(--d, 0s);
}

.chat-bubble p {
    margin: 0;
    color: inherit;
}

.chat-bubble__time {
    display: block;
    margin-top: 4px;
    font-size: 0.65rem;
    opacity: 0.55;
}

.chat-bubble--in {
    align-self: flex-start;
    background: #1c3a58;
    color: #eef3f8;
    border-bottom-left-radius: 4px;
}

.chat-bubble--out {
    align-self: flex-end;
    background: var(--brass, #d99a3f);
    color: #1a1a1a;
    border-bottom-right-radius: 4px;
}

.chat-bubble--typing {
    align-self: flex-start;
    background: #1c3a58;
    display: flex;
    gap: 4px;
    padding: 12px 14px;
    border-bottom-left-radius: 4px;
}

.chat-bubble--typing .typing-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(255,255,255,0.6);
    animation: typing-bounce 1.1s ease-in-out infinite;
}

.chat-bubble--typing .typing-dot:nth-child(2) { animation-delay: 0.15s; }
.chat-bubble--typing .typing-dot:nth-child(3) { animation-delay: 0.3s; }

.hero-visual__tag {
    font-family: var(--font-mono, 'IBM Plex Mono', monospace);
    font-size: 0.68rem;
    letter-spacing: 0.06em;
    color: rgba(255,255,255,0.4);
    text-transform: uppercase;
}

@keyframes bubble-in {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

@keyframes typing-bounce {
    0%, 60%, 100% { transform: translateY(0); opacity: 0.5; }
    30% { transform: translateY(-4px); opacity: 1; }
}

@media (prefers-reduced-motion: reduce) {
    .chat-bubble {
        animation: none;
        opacity: 1;
        transform: none;
    }
    .chat-bubble--typing .typing-dot {
        animation: none;
    }
}

@media (max-width: 720px) {
    .hero-visual {
        align-items: stretch;
    }
    .chat-window {
        max-width: 100%;
    }
    .listing-card-link {
    text-decoration: none;
    display: block;
}

/* Bring property-card-photo in line with .city-card / .category-card */
.property-card-photo {
    position: relative;
    border-radius: 10px;          /* was likely different before — now matches city/category cards */
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
    overflow: hidden;
}

.property-card-photo:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.25);
}

.property-card-body {
    padding: 16px 18px 18px;
}

.property-card-body h3 {
    margin: 0 0 4px;
    font-size: 1.05rem;
    text-shadow: 0 1px 3px rgba(0,0,0,0.5);
}

.property-card-body .meta {
    font-size: 0.8rem;
    margin-bottom: 6px;
}

.property-card-body .price {
    font-family: var(--font-mono, 'IBM Plex Mono', monospace);
    font-size: 1.05rem;
    font-weight: 600;
}

.property-card-body .price span {
    font-family: inherit;
    font-size: 0.72rem;
    font-weight: 400;
    opacity: 0.75;
    margin-left: 4px;
}

/* Replaces the old circular .seal badge — same visual language as .category-tag */
.card-badge {
    position: absolute;
    top: 14px;
    right: 14px;
    z-index: 2;
    padding: 4px 10px;
    background: rgba(255,255,255,0.92);
    color: #0f172a;
    font-family: var(--font-mono, 'IBM Plex Mono', monospace);
    font-size: 0.68rem;
    font-weight: 600;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    border-radius: 999px;
}
}
</style>
<div class="status-strip">
    <div class="wrap">
        <span class="dot">●</span> Popular right now:
        @foreach (['Indore', 'Bhopal', 'Mumbai', 'Bangalore', 'Pune'] as $city)
            <a href="{{ route('properties.index', ['city' => $city]) }}">{{ $city }}</a>
        @endforeach
    </div>
</div>

<section class="hero">
    <div class="wrap hero-grid">
        <div class="hero-main">
            <span class="hero-tag">◆ Direct-owner marketplace, zero commission</span>
            <h1>Find your next home, straight from the person who owns it.</h1>
            <p class="lede">
                No brokers, no markup. Search by location and type below, or just
                describe what you're after in your own words — either way, every
                listing connects you directly to the owner on WhatsApp.
            </p>

            <div class="search-panel">
                <form action="{{ route('properties.index') }}" method="GET">
                    <div class="search-grid">
                        <div class="search-field">
                            <label for="city">Location</label>
                            <select name="city" id="city">
                                <option value="">Any city</option>
                                @foreach (['Indore','Bhopal','Mumbai','Bangalore','Pune','Delhi'] as $c)
                                    <option value="{{ $c }}" @selected(request('city') === $c)>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="search-field">
                            <label for="property_type">Property type</label>
                            <select name="property_type" id="property_type">
                                <option value="">All types</option>
                                <option value="apartment">Apartment</option>
                                <option value="villa">Villa</option>
                                <option value="plot">Plot</option>
                                <option value="office">Office</option>
                                <option value="pg_hostel">PG / Hostel</option>
                                <option value="farm_land">Farm Land</option>
                                <option value="home">Independent Home</option>
                            </select>
                        </div>
                        <button type="submit">Search</button>
                    </div>
                </form>

                <div class="or-divider">or describe it in plain words</div>

                <form action="{{ route('search') }}" method="GET">
                    <div class="nl-search-row">
                        <input type="text" name="q" placeholder="e.g. 2bhk near Vijay Nagar Indore under 25k, furnished">
                        <button type="submit" class="btn btn-brass">Ask</button>
                    </div>
                </form>
            </div>

            <div class="tap-row">
                <span class="tap-row-label">Browse by type</span>
                @php
                    $types = [
                        'apartment' => 'Apartment',
                        'villa' => 'Villa',
                        'pg_hostel' => 'PG / Hostel',
                        'plot' => 'Plot',
                        'farm_land' => 'Farm Land',
                        'office' => 'Office',
                    ];
                @endphp
                @foreach ($types as $value => $label)
                    <a class="tap-chip" href="{{ route('properties.index', ['property_type' => $value]) }}">{{ $label }}</a>
                @endforeach
            </div>

            <div class="dual-cta">
                <a href="{{ route('properties.index') }}#post" class="btn btn-brass">Post a Property</a>
                <a href="{{ route('properties.index') }}#post-requirement" class="btn btn-outline" style="border-color:rgba(255,255,255,0.4); color:#fff;">Post a Requirement</a>
            </div>
        </div>

        {{-- ============================================= --}}
        {{-- HERO VISUAL — chat bubble mock, replaces the   --}}
        {{-- old stock-photo carousel. Loops via JS below.  --}}
        {{-- ============================================= --}}
        <div class="hero-visual">
            <div class="chat-window" id="heroChat">
                <div class="chat-window__header">
                    <span class="chat-window__dot"></span>
                    <div class="chat-window__title">
                        <strong>Rohan Mehta</strong>
                        <span>Owner · Vijay Nagar, Indore</span>
                    </div>
                    <span class="chat-window__badge">Verified</span>
                </div>
                <div class="chat-window__body" id="heroChatBody">
                    <div class="chat-bubble chat-bubble--in" style="--d:0.2s">
                        <p>Hi! Saw you're looking for a 2BHK near Vijay Nagar.</p>
                        <span class="chat-bubble__time">10:14 AM</span>
                    </div>
                    <div class="chat-bubble chat-bubble--out" style="--d:1.1s">
                        <p>Yes — is it still available? No brokers involved, right?</p>
                        <span class="chat-bubble__time">10:15 AM</span>
                    </div>
                    <div class="chat-bubble chat-bubble--in" style="--d:2s">
                        <p>Direct from me, zero commission. Free Tuesday evening for a visit?</p>
                        <span class="chat-bubble__time">10:16 AM</span>
                    </div>
                    <div class="chat-bubble chat-bubble--out" style="--d:2.9s">
                        <p>Works for me. Sending my number now 🙂</p>
                        <span class="chat-bubble__time">10:16 AM</span>
                    </div>
                </div>
            </div>
            <span class="hero-visual__tag">FILE-01 — DIRECT CONTACT, NO MIDDLEMAN</span>
        </div>
    </div>
</section>

<section class="wrap" style="padding-top:8px;">
    <div class="ledger-strip" style="margin-top:24px;">
        @forelse ($properties ?? [] as $p)
            <span><span class="code">{{ $p->code }}</span> · {{ $p->bhk ? $p->bhk.' BHK' : ucfirst($p->property_type) }}, {{ $p->locality ?? $p->city }}, {{ $p->city }}</span>
        @empty
            <span>No listings logged yet.</span>
        @endforelse
    </div>
</section>
{{-- ============================================= --}}
{{-- TRENDING CITIES --}}
{{-- ============================================= --}}
<section class="wrap">
    <h2 class="section-title">Trending cities</h2>
    <p class="section-subtitle">Explore listings across India's most searched property destinations.</p>

    <div class="city-grid">
        @php
            $trendingCities = [
                ['name' => 'Mumbai', 'tagline' => 'The City of Dreams', 'img' => 'https://images.unsplash.com/photo-1529253355930-ddbe423a2ac7?w=400'],
                ['name' => 'Bangalore', 'tagline' => 'The Silicon Valley of India', 'img' => 'https://images.unsplash.com/photo-1596176530529-78163a4f7af2?w=400'],
                ['name' => 'Indore', 'tagline' => 'The Cleanest City of India', 'img' => 'https://images.unsplash.com/photo-1587474260584-136574528ed5?w=400'],
                ['name' => 'Bhopal', 'tagline' => 'The City of Lakes', 'img' => 'https://images.unsplash.com/photo-1602216056096-3b40cc0c9944?w=400'],
                ['name' => 'Pune', 'tagline' => 'The Oxford of the East', 'img' => 'https://images.unsplash.com/photo-1560179707-f14e90ef3623?w=400'],
            ];
        @endphp

        @foreach ($trendingCities as $city)
            <a href="{{ route('properties.index', ['city' => $city['name']]) }}"
               class="city-card"
               style="background-image: linear-gradient(180deg, rgba(10,25,41,0.2) 0%, rgba(10,25,41,0.9) 75%), url('{{ $city['img'] }}');">
                <h3>{{ $city['name'] }}</h3>
                <p>{{ $city['tagline'] }}</p>
            </a>
        @endforeach
    </div>
</section>
<section class="wrap" style="padding-top:8px;">
    <h2 class="section-title">Browse by category</h2>
    <p class="section-subtitle">
        Every listing type on Registry.Home, one tap away.
    </p>

    @php
        $categories = [
            ['type' => 'apartment',  'label' => 'Apartments',        'blurb' => '1–4 BHK flats, ready to move', 'img' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=500'],
            ['type' => 'villa',      'label' => 'Villas',            'blurb' => 'Independent houses, private outdoor space', 'img' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=500'],
            ['type' => 'home',       'label' => 'Independent Homes', 'blurb' => 'Standalone houses, full ownership', 'img' => 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=500'],
            ['type' => 'pg_hostel',  'label' => 'PG / Hostel',       'blurb' => 'Shared living, meals & wifi included', 'img' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=500'],
            ['type' => 'plot',       'label' => 'Plots',             'blurb' => 'Approved residential land, road-touch', 'img' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=500'],
            ['type' => 'farm_land',  'label' => 'Farm Land',         'blurb' => 'Agricultural & weekend-farm parcels', 'img' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=500'],
            ['type' => 'office',     'label' => 'Office Space',      'blurb' => 'Commercial units, co-working ready', 'img' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=500'],
        ];
    @endphp

    <div class="category-grid">
        @foreach ($categories as $cat)
            <a href="{{ route('properties.index', ['property_type' => $cat['type']]) }}"
               class="category-card"
               style="background-image: linear-gradient(180deg, rgba(10,25,41,0.05) 0%, rgba(10,25,41,0.88) 70%), url('{{ $cat['img'] }}');">
                <h3>{{ $cat['label'] }}</h3>
                <p>{{ $cat['blurb'] }}</p>
            </a>
        @endforeach
    </div>
</section>

{{-- ============================================= --}}
{{-- ACTIVE REQUIREMENTS --}}
{{-- Insert right after Browse by Category --}}
{{-- Requires 'requirements' passed from the home() route — see note above --}}
{{-- ============================================= --}}
<section class="wrap">
    <div class="section-header-row">
        <h2 class="section-title">People looking right now</h2>
        <a href="{{ route('shared-spaces.index') }}" class="section-link">View all →</a>
    </div>
    <p class="section-subtitle">
        Real requirements posted by people searching for a place. If you're an owner, reach out directly.
    </p>

    <div class="grid">
        @forelse ($requirements ?? [] as $req)
            <a href="{{ route('shared-spaces.show', $req) }}" style="text-decoration:none;">
                <div class="card requirement-card">
                    <span class="code-tab">{{ $req->code }}</span>
                    <h3>{{ ucfirst(str_replace('_', ' ', $req->property_type)) }} in {{ $req->city }}</h3>
                    <div class="meta">
                        {{ $req->state ? $req->state . ' · ' : '' }}
                        Budget: &#8377;{{ number_format($req->budget) }}
                    </div>
                    <p class="requirement-desc">{{ \Illuminate\Support\Str::limit($req->description, 90) }}</p>
                    <div class="requirement-contact">
                        Posted by {{ $req->contact_name }}
                    </div>
                </div>
            </a>
        @empty
            <p class="empty-state">No active requirements right now — check back soon.</p>
        @endforelse
    </div>
</section>
<section class="wrap">
    <div class="section-header-row">
        <h2 class="section-title">Recently logged</h2>
        <a href="{{ route('properties.index') }}" class="section-link">View more properties →</a>
    </div>

    <div class="grid">
        @foreach ($properties ?? [] as $property)
            @include('partials.property-card', ['property' => $property])
        @endforeach
    </div>
</section>

<script>
(function () {
    // Replays the hero chat-bubble animation every 9s so the hero feels
    // "alive" for anyone lingering on the page, without needing a carousel.
    const chatBody = document.getElementById('heroChatBody');
    if (!chatBody) return;

    const bubbles = chatBody.querySelectorAll('.chat-bubble');
    const originalMarkup = chatBody.innerHTML;

    function replay() {
        chatBody.innerHTML = originalMarkup; // reset animations by re-inserting nodes
    }

    if (bubbles.length && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        setInterval(replay, 9000);
    }
})();
</script>
@endsection