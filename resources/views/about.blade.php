@extends('layouts.app')

@section('title', 'About — Registry.Home')

@section('content')
<style>
    /* ============================================= */
    /* ABOUT PAGE — extends the homepage system.       */
    /* Reuses: .wrap, .section-title, .section-subtitle, */
    /* .ledger-strip, .code-tab, .category-card,        */
    /* .chat-window/.chat-bubble, .btn-brass/.btn-outline */
    /* New here: .about-hero, .file-timeline, .compare-* */
    /* ============================================= */

    .about-hero {
        padding: 72px 0 48px;
        background:
            radial-gradient(circle at 85% 10%, rgba(242,169,59,0.08), transparent 40%),
            var(--navy, #0a1929);
    }

    .about-hero .wrap {
        max-width: 760px;
    }

    .about-eyebrow {
        display: inline-block;
        font-family: var(--font-mono, 'IBM Plex Mono', monospace);
        font-size: 0.72rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--brass, #d99a3f);
        border: 1px solid rgba(217,154,63,0.35);
        padding: 5px 12px;
        border-radius: 999px;
        margin-bottom: 18px;
    }

    .about-hero h1 {
        color: #fff;
        font-size: 2.4rem;
        line-height: 1.2;
        margin: 0 0 20px;
    }

    .about-hero p {
        color: rgba(255,255,255,0.78);
        line-height: 1.75;
        font-size: 1.02rem;
        margin: 0 0 16px;
        max-width: 620px;
    }

    /* ---- Stats ledger (reuses your homepage ledger-strip look) ---- */
    .about-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 0;
        margin-top: 36px;
        border-top: 1px solid rgba(255,255,255,0.1);
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .about-stat {
        flex: 1 1 160px;
        padding: 20px 22px;
        border-right: 1px solid rgba(255,255,255,0.08);
    }

    .about-stat:last-child {
        border-right: none;
    }

    .about-stat .num {
        font-family: var(--font-mono, 'IBM Plex Mono', monospace);
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--brass, #d99a3f);
        display: block;
    }

    .about-stat .label {
        font-size: 0.78rem;
        color: rgba(255,255,255,0.55);
        margin-top: 4px;
    }

    /* ---- File timeline (the signature element) ---- */
    .file-timeline {
        position: relative;
        margin-top: 24px;
        padding-left: 28px;
    }

    .file-timeline::before {
        content: '';
        position: absolute;
        left: 6px;
        top: 6px;
        bottom: 6px;
        width: 1px;
        background: var(--border, #e5e0d8);
    }

    .file-entry {
        position: relative;
        padding-bottom: 40px;
    }

    .file-entry:last-child {
        padding-bottom: 0;
    }

    .file-entry::before {
        content: '';
        position: absolute;
        left: -28px;
        top: 4px;
        width: 11px;
        height: 11px;
        border-radius: 50%;
        background: var(--brass, #d99a3f);
        border: 2px solid #fff;
        box-shadow: 0 0 0 1px var(--border, #e5e0d8);
    }

    .file-entry .code-tab {
        background: rgba(10,25,41,0.06);
        color: var(--ink, #1f2937);
        border: 1px solid var(--border, #e5e0d8);
        backdrop-filter: none;
    }

    .file-entry h3 {
        margin: 10px 0 6px;
        font-size: 1.15rem;
    }

    .file-entry p {
        margin: 0;
        color: var(--muted, #6b7280);
        line-height: 1.65;
        max-width: 560px;
    }

    .file-entry .file-date {
        font-family: var(--font-mono, 'IBM Plex Mono', monospace);
        font-size: 0.72rem;
        color: var(--muted, #6b7280);
        letter-spacing: 0.03em;
    }

    /* ---- Old way vs Registry way comparison ---- */
    .compare-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-top: 8px;
    }

    @media (max-width: 720px) {
        .compare-grid { grid-template-columns: 1fr; }
    }

    .compare-panel {
        border-radius: 12px;
        padding: 26px 24px;
    }

    .compare-panel.is-old {
        background: #f4f1ea;
        border: 1px solid var(--border, #e5e0d8);
    }

    .compare-panel.is-registry {
        background: var(--navy, #0a1929);
        color: #fff;
    }

    .compare-panel h3 {
        margin: 0 0 16px;
        font-size: 1.05rem;
    }

    .compare-panel.is-registry h3 {
        color: var(--brass, #d99a3f);
    }

    .compare-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .compare-list li {
        display: flex;
        gap: 10px;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .compare-panel.is-old .compare-list li::before {
        content: '✕';
        color: #b3413a;
        flex-shrink: 0;
        font-size: 0.8rem;
        margin-top: 2px;
    }

    .compare-panel.is-registry .compare-list li::before {
        content: '✓';
        color: var(--brass, #d99a3f);
        flex-shrink: 0;
        font-size: 0.8rem;
        margin-top: 2px;
    }

    .compare-panel.is-registry .compare-list li {
        color: rgba(255,255,255,0.85);
    }

    /* ---- Founder note (single chat-bubble, quieter than the hero's) ---- */
    .founder-note {
        max-width: 560px;
        margin: 0 auto;
    }

    .founder-note .chat-bubble {
        opacity: 1;
        transform: none;
        animation: none;
        max-width: 100%;
    }

    .founder-signoff {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 18px;
    }

    .founder-signoff .avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--brass, #d99a3f), #b97a1f);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-mono, 'IBM Plex Mono', monospace);
        font-size: 0.75rem;
        font-weight: 700;
        color: #1a1a1a;
        flex-shrink: 0;
    }

    .founder-signoff strong {
        display: block;
        font-size: 0.9rem;
    }

    .founder-signoff span {
        font-size: 0.78rem;
        color: var(--muted, #6b7280);
    }

    /* ---- Closing CTA ---- */
    .about-cta {
        text-align: center;
        padding: 56px 0 72px;
    }

    .about-cta h2 {
        margin-bottom: 10px;
    }

    .about-cta p {
        color: var(--muted, #6b7280);
        margin-bottom: 26px;
    }

    .about-cta .dual-cta {
        justify-content: center;
        display: flex;
        gap: 12px;
    }
</style>

{{-- ============================================= --}}
{{-- HERO — intro copy, elevated with your navy hero treatment --}}
{{-- ============================================= --}}
<section class="about-hero">
    <div class="wrap">
        <span class="about-eyebrow">◆ Why we exist</span>
        <h1>A registry, not a marketplace with a markup.</h1>
        <p>
            Registry.Home connects property owners directly with tenants and buyers —
            no brokers, no commission, no markup. Every listing is filed with a unique
            code, verified where possible, and connects you straight to the person who
            actually owns the place.
        </p>
        <p>
            We built this because finding a home shouldn't mean paying someone a
            month's rent just to make an introduction.
        </p>

        {{-- [CONFIRM NUMBERS] swap these for real stats once you have them --}}
        <div class="about-stats">
            <div class="about-stat">
                <span class="num">0%</span>
                <span class="label">Commission, ever</span>
            </div>
            <div class="about-stat">
                <span class="num">500+</span>
                <span class="label">Listings filed</span>
            </div>
            <div class="about-stat">
                <span class="num">12</span>
                <span class="label">Cities covered</span>
            </div>
            <div class="about-stat">
                <span class="num">100%</span>
                <span class="label">Direct-to-owner</span>
            </div>
        </div>
    </div>
</section>

{{-- ============================================= --}}
{{-- FILE TIMELINE — the signature "Registry" element --}}
{{-- ============================================= --}}
<section class="wrap" style="padding:64px 0; max-width:720px;">
    <h2 class="section-title">How the registry was built</h2>
    <p class="section-subtitle">Every registry starts somewhere. Here's ours.</p>

    <div class="file-timeline">
        {{-- [CONFIRM CONTENT] replace with your real founding story/milestones --}}
        <div class="file-entry">
            <span class="code-tab">FILE-01 — THE PROBLEM</span>
            <span class="file-date">Early 2025</span>
            <h3>A month's rent, just for an introduction</h3>
            <p>
                Renting a 2BHK meant paying a broker a full month's rent — for a WhatsApp
                number the owner would have shared for free. That gap between "the owner
                is reachable" and "you're allowed to reach them" was the whole business
                model. It didn't need to be.
            </p>
        </div>

        <div class="file-entry">
            <span class="code-tab">FILE-02 — FIRST LISTINGS</span>
            <span class="file-date">Mid 2025</span>
            <h3>Filing the first 50 properties by hand</h3>
            <p>
                We started in Indore, calling owners directly, verifying each listing,
                and giving it a code — the same PR-000001 format you see on every
                listing today. No scraping, no unverified inventory.
            </p>
        </div>

        <div class="file-entry">
            <span class="code-tab">FILE-03 — GOING DIRECT</span>
            <span class="file-date">Late 2025</span>
            <h3>Every listing routes straight to WhatsApp</h3>
            <p>
                Instead of a contact form or a callback queue, we built every listing to
                connect the tenant and owner directly — the way it should have worked
                from the start.
            </p>
        </div>

        <div class="file-entry">
            <span class="code-tab">FILE-04 — TODAY</span>
            <span class="file-date">Now</span>
            <h3>Expanding city by city</h3>
            <p>
                We're adding new cities as fast as we can verify listings properly —
                growth here is deliberately slower than a scraped portal's, because
                every filed property is one we'd vouch for.
            </p>
        </div>
    </div>
</section>

{{-- ============================================= --}}
{{-- OLD WAY VS REGISTRY WAY --}}
{{-- ============================================= --}}
<section class="wrap" style="padding-bottom:64px; max-width:900px;">
    <h2 class="section-title">The broker route vs. the registry route</h2>
    <p class="section-subtitle">Same home. Very different path to the front door.</p>

    <div class="compare-grid">
        <div class="compare-panel is-old">
            <h3>The broker route</h3>
            <ul class="compare-list">
                <li>1 month's rent (or more) in commission</li>
                <li>Listings re-posted by 3–4 different brokers</li>
                <li>You never speak to the actual owner until move-in</li>
                <li>Photos and details often outdated</li>
            </ul>
        </div>
        <div class="compare-panel is-registry">
            <h3>The Registry.Home route</h3>
            <ul class="compare-list">
                <li>Zero commission — always</li>
                <li>One listing, filed once, by the owner</li>
                <li>You message the owner directly, from day one</li>
                <li>Every listing carries a code you can verify</li>
            </ul>
        </div>
    </div>
</section>

{{-- ============================================= --}}
{{-- FOUNDER NOTE — reuses the chat-bubble language from your hero --}}
{{-- ============================================= --}}
<section class="wrap" style="padding-bottom:72px;">
    <div class="founder-note">
        <div class="chat-bubble chat-bubble--in">
            {{-- [CONFIRM CONTENT] replace with a real note, or drop this section entirely --}}
            <p>
                "We're not trying to be the biggest listings site — we're trying to be
                the one where you never wonder if the person you're talking to actually
                owns the place. That's it. That's the whole pitch."
            </p>
        </div>
        <div class="founder-signoff">
            <span class="avatar"></span>
            <div>
                <strong>Founder, Registry.Home</strong>
                <span>Filed under FILE-00 — the reason this exists</span>
            </div>
        </div>
    </div>
</section>

{{-- ============================================= --}}
{{-- CLOSING CTA --}}
{{-- ============================================= --}}
<section class="about-cta">
    <div class="wrap">
        <h2 class="section-title">Ready to skip the broker?</h2>
        <p>Browse verified listings or file your own — either way, no commission.</p>
        <div class="dual-cta">
            <a href="{{ route('properties.index') }}" class="btn btn-brass">Browse listings</a>
            <a href="{{ route('properties.index') }}#post" class="btn btn-outline">Post a property</a>
        </div>
    </div>
</section>
@endsection