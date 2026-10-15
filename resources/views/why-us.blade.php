@extends('layouts.app')

@section('title', 'About — Registry.Home')

@section('content')
<style>
    /* ============================================= */
    /* ABOUT — GEN-Z EDITORIAL REDESIGN                */
    /* Reuses: .wrap, .section-title, .section-subtitle,*/
    /* .code-tab, .btn/.btn-brass/.btn-outline           */
    /* New tokens: --coral (sparingly, vibe tags only)   */
    /* ============================================= */

    :root {
        --au-coral: #ff5a6e;
        --au-coral-soft: rgba(255,90,110,0.12);
    }

    .au-reveal {
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }

    .au-reveal.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    @media (prefers-reduced-motion: reduce) {
        .au-reveal {
            opacity: 1;
            transform: none;
            transition: none;
        }
    }

    /* ---------------- HERO ---------------- */
    .au-hero {
        padding: 88px 0 64px;
        background: var(--navy, #0a1929);
        overflow: hidden;
    }

    .au-hero-inner {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 48px;
        align-items: center;
    }

    @media (max-width: 860px) {
        .au-hero-inner { grid-template-columns: 1fr; }
    }

    .au-hero h1 {
        color: #fff;
        font-size: clamp(2.1rem, 4.2vw, 3.4rem);
        line-height: 1.12;
        margin: 16px 0 20px;
    }

    .au-hero-sub {
        color: rgba(255,255,255,0.72);
        font-size: 1.05rem;
        line-height: 1.7;
        max-width: 480px;
    }

    /* Fake browser-tab chaos visual */
    .au-tab-chaos {
        position: relative;
        height: 320px;
    }

    .au-tab-card {
        position: absolute;
        left: 50%;
        top: 50%;
        width: 230px;
        padding: 14px 16px;
        border-radius: 12px;
        background: #142c46;
        border: 1px solid rgba(255,255,255,0.08);
        box-shadow: 0 16px 40px rgba(0,0,0,0.35);
        color: rgba(255,255,255,0.85);
        font-size: 0.85rem;
        font-family: var(--font-mono, 'IBM Plex Mono', monospace);
        transform: translate(-50%, -50%) rotate(var(--r, 0deg)) translateY(calc(var(--i, 0) * 6px));
        transition: transform 0.35s ease, box-shadow 0.35s ease;
    }

    .au-tab-card::before {
        content: '';
        display: block;
        width: 36px;
        height: 4px;
        border-radius: 2px;
        background: var(--brass, #d99a3f);
        margin-bottom: 8px;
        opacity: 0.7;
    }

    .au-tab-card:nth-child(1) { --r: -8deg; --i: 0; z-index: 4; }
    .au-tab-card:nth-child(2) { --r: 5deg;  --i: 1; z-index: 3; margin-top: 28px; }
    .au-tab-card:nth-child(3) { --r: -3deg; --i: 2; z-index: 2; margin-top: 56px; }
    .au-tab-card:nth-child(4) { --r: 9deg;  --i: 3; z-index: 1; margin-top: 84px; }

    .au-tab-chaos:hover .au-tab-card {
        transform: translate(-50%, -50%) rotate(0deg) translateY(0);
    }

    @media (max-width: 860px) {
        .au-tab-chaos { height: 260px; margin-top: 8px; }
    }

    /* ---------------- PROBLEM ---------------- */
    .au-problem {
        padding: 72px 0 56px;
        text-align: center;
    }

    .au-kicker {
        font-family: var(--font-mono, 'IBM Plex Mono', monospace);
        font-size: 0.78rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--muted, #6b7280);
        margin-bottom: 28px;
    }

    .au-query-board {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 16px;
        max-width: 780px;
        margin: 0 auto;
    }

    .au-query-card {
        display: inline-block;
        padding: 12px 20px;
        border-radius: 999px;
        background: #fff;
        border: 1px solid var(--border, #e5e0d8);
        box-shadow: 0 6px 16px rgba(15,23,42,0.06);
        font-size: 0.92rem;
        color: var(--ink, #1f2937);
        transform: rotate(var(--r, 0deg));
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        cursor: default;
    }

    .au-query-card:hover {
        transform: rotate(0deg) scale(1.06);
        box-shadow: 0 12px 28px rgba(15,23,42,0.12);
        border-color: var(--brass, #d99a3f);
    }

    .au-problem-line {
        margin-top: 36px;
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--ink, #1f2937);
    }

    /* ---------------- WHY WE BUILT THIS ---------------- */
    .au-why {
        padding: 72px 0;
        text-align: center;
        max-width: 720px;
    }

    .au-statement {
        font-size: clamp(1.8rem, 3.6vw, 2.6rem);
        line-height: 1.25;
        margin-bottom: 22px;
    }

    .au-statement .hl {
        color: var(--brass, #d99a3f);
    }

    .au-why-copy {
        color: var(--muted, #6b7280);
        font-size: 1.05rem;
        line-height: 1.75;
    }

    /* ---------------- HOW IT WORKS ---------------- */
    .au-steps {
        padding: 56px 0 72px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }

    @media (max-width: 780px) {
        .au-steps { grid-template-columns: 1fr; gap: 20px; }
    }

    .au-step {
        padding: 32px 26px;
        border-radius: 16px;
        background: #fff;
        border: 1px solid var(--border, #e5e0d8);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .au-step:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(15,23,42,0.1);
    }

    .au-step-num {
        display: block;
        font-family: var(--font-mono, 'IBM Plex Mono', monospace);
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--au-coral);
        margin-bottom: 14px;
    }

    .au-step h3 {
        margin: 0 0 8px;
        font-size: 1.2rem;
    }

    .au-step p {
        margin: 0;
        color: var(--muted, #6b7280);
        line-height: 1.6;
        font-size: 0.94rem;
    }

    /* ---------------- FIND YOUR VIBE ---------------- */
    .au-vibes {
        padding: 56px 0 72px;
        background: #f4f1ea;
        border-radius: 24px;
    }

    .au-vibe-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 28px;
    }

    .au-vibe-tag {
        font: inherit;
        cursor: pointer;
        padding: 12px 20px;
        border-radius: 999px;
        border: 1.5px solid var(--border, #e5e0d8);
        background: #fff;
        color: var(--ink, #1f2937);
        font-size: 0.92rem;
        transform: rotate(var(--r, 0deg));
        transition: transform 0.2s ease, border-color 0.2s ease, background 0.2s ease, color 0.2s ease;
    }

    .au-vibe-tag:hover {
        transform: rotate(0deg) translateY(-3px);
        border-color: var(--au-coral);
    }

    .au-vibe-tag.is-active {
        background: var(--au-coral);
        border-color: var(--au-coral);
        color: #fff;
        transform: rotate(0deg) scale(1.05);
    }

    /* ---------------- OLD WAY VS OUR WAY ---------------- */
    .au-compare {
        padding: 72px 0;
    }

    .au-compare-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 12px;
    }

    @media (max-width: 780px) {
        .au-compare-grid { grid-template-columns: 1fr; }
    }

    .au-compare-col {
        padding: 30px 26px;
        border-radius: 18px;
    }

    .au-compare-col.is-old {
        background: #f4f1ea;
        border: 1px dashed var(--border, #e5e0d8);
    }

    .au-compare-col.is-new {
        background: var(--navy, #0a1929);
    }

    .au-compare-label {
        display: inline-block;
        font-family: var(--font-mono, 'IBM Plex Mono', monospace);
        font-size: 0.72rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 18px;
        color: var(--muted, #6b7280);
    }

    .au-compare-col.is-new .au-compare-label {
        color: var(--brass, #d99a3f);
    }

    .au-flow {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        font-size: 0.98rem;
    }

    .au-flow span:not(.arrow) {
        padding: 6px 12px;
        border-radius: 999px;
        background: rgba(15,23,42,0.05);
        color: var(--ink, #1f2937);
    }

    .au-compare-col.is-new .au-flow span:not(.arrow) {
        background: rgba(255,255,255,0.08);
        color: #fff;
    }

    .au-flow .arrow {
        color: var(--muted, #6b7280);
        opacity: 0.6;
    }

    /* ---------------- FINAL CTA ---------------- */
    .au-cta {
        padding: 90px 0 100px;
        text-align: center;
    }

    .au-cta h2 {
        font-size: clamp(1.8rem, 3.6vw, 2.8rem);
        line-height: 1.2;
        max-width: 620px;
        margin: 0 auto 30px;
    }

    .au-cta-btn {
        display: inline-block;
        padding: 16px 34px;
        border-radius: 999px;
        background: var(--brass, #d99a3f);
        color: #1a1a1a;
        font-weight: 600;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .au-cta-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 32px rgba(217,154,63,0.35);
    }
</style>

{{-- ============================================= --}}
{{-- 1. HERO — puts the user in the pain point       --}}
{{-- ============================================= --}}
<section class="au-hero">
    <div class="wrap au-hero-inner">
        <div class="au-reveal">
            <span class="about-eyebrow">◆ Real talk</span>
            <h1>Finding a place shouldn't feel like a full-time job.</h1>
            <p class="au-hero-sub">
                Too many tabs. Too many listings. Too much information.
                Too many "wait, is this even the right neighbourhood?" moments.
            </p>
        </div>
        <div class="au-tab-chaos au-reveal" aria-hidden="true">
            <div class="au-tab-card">2BHK under 25k</div>
            <div class="au-tab-card">Best area near college</div>
            <div class="au-tab-card">Apartment near metro</div>
            <div class="au-tab-card">Is this legit??</div>
        </div>
    </div>
</section>

{{-- ============================================= --}}
{{-- 2. THE PROBLEM — scattered search-query board   --}}
{{-- ============================================= --}}
<section class="au-problem wrap">
    <p class="au-kicker au-reveal">Sound familiar?</p>
    <div class="au-query-board">
        <span class="au-query-card au-reveal" style="--r:-4deg">"2BHK under 25k"</span>
        <span class="au-query-card au-reveal" style="--r:6deg">"Best area near college"</span>
        <span class="au-query-card au-reveal" style="--r:-8deg">"Apartment near metro"</span>
        <span class="au-query-card au-reveal" style="--r:3deg">"Is this neighbourhood actually good?"</span>
        <span class="au-query-card au-reveal" style="--r:-2deg">"Affordable + aesthetic pls"</span>
    </div>
    <p class="au-problem-line au-reveal">Yeah. We know.</p>
</section>

{{-- ============================================= --}}
{{-- 3. WHY WE BUILT THIS                            --}}
{{-- ============================================= --}}
<section class="au-why wrap au-reveal">
    <h2 class="au-statement">So we built <span class="hl">something better.</span></h2>
    <p class="au-why-copy">
        Property hunting shouldn't feel like solving a puzzle with half the
        pieces missing. We built Registry.Home to make discovering a place
        simpler and a little more enjoyable — instead of digging through
        endless listings, you get to actually see, compare, and shortlist
        the ones that fit how you live.
    </p>
</section>

{{-- ============================================= --}}
{{-- 4. HOW IT WORKS                                 --}}
{{-- ============================================= --}}
<section class="wrap">
    <div class="au-steps">
        <div class="au-step au-reveal">
            <span class="au-step-num">01</span>
            <h3>Explore</h3>
            <p>Discover properties that match what you're actually looking for — not just what's paying to rank first.</p>
        </div>
        <div class="au-step au-reveal">
            <span class="au-step-num">02</span>
            <h3>Compare</h3>
            <p>Understand your options side by side, without twenty browser tabs and a dozen screenshots.</p>
        </div>
        <div class="au-step au-reveal">
            <span class="au-step-num">03</span>
            <h3>Decide</h3>
            <p>Shortlist the places that actually feel right, then message the owner directly.</p>
        </div>
    </div>
</section>

{{-- ============================================= --}}
{{-- 5. FIND YOUR VIBE — interactive tag cloud       --}}
{{-- ============================================= --}}
<section class="wrap au-reveal">
    <div class="au-vibes wrap">
        <h2 class="section-title">Find your vibe</h2>
        <p class="section-subtitle">Tap the ones that sound like you.</p>
        <div class="au-vibe-grid" id="auVibeGrid">
            <button type="button" class="au-vibe-tag" style="--r:-2deg">🌿 Quiet &amp; Peaceful</button>
            <button type="button" class="au-vibe-tag" style="--r:3deg">🎓 Student Friendly</button>
            <button type="button" class="au-vibe-tag" style="--r:-4deg">💻 Work From Home</button>
            <button type="button" class="au-vibe-tag" style="--r:2deg">🚇 Metro Connected</button>
            <button type="button" class="au-vibe-tag" style="--r:-3deg">🐶 Pet Friendly</button>
            <button type="button" class="au-vibe-tag" style="--r:4deg">🌆 City Energy</button>
            <button type="button" class="au-vibe-tag" style="--r:-2deg">☀️ Lots of Natural Light</button>
            <button type="button" class="au-vibe-tag" style="--r:3deg">✨ Modern &amp; Minimal</button>
        </div>
    </div>
</section>

{{-- ============================================= --}}
{{-- 6. OLD WAY VS OUR WAY                           --}}
{{-- ============================================= --}}
<section class="au-compare wrap au-reveal">
    <h2 class="section-title">The old way vs. our way</h2>
    <div class="au-compare-grid">
        <div class="au-compare-col is-old">
            <span class="au-compare-label">Old way</span>
            <div class="au-flow">
                <span>Search</span><span class="arrow">→</span>
                <span>47 tabs</span><span class="arrow">→</span>
                <span>Screenshots</span><span class="arrow">→</span>
                <span>WhatsApp</span><span class="arrow">→</span>
                <span>Confusion</span><span class="arrow">→</span>
                <span>Headache 🤕</span>
            </div>
        </div>
        <div class="au-compare-col is-new">
            <span class="au-compare-label">Our way</span>
            <div class="au-flow">
                <span>Discover</span><span class="arrow">→</span>
                <span>Compare</span><span class="arrow">→</span>
                <span>Shortlist</span><span class="arrow">→</span>
                <span>Move in 🏠</span>
            </div>
        </div>
    </div>
</section>

{{-- ============================================= --}}
{{-- 7. FINAL CTA                                    --}}
{{-- ============================================= --}}
<section class="au-cta wrap au-reveal">
    <h2>Your next chapter might be closer than you think.</h2>
    <a href="{{ route('properties.index') }}" class="au-cta-btn">Start exploring →</a>
</section>

<script>
(function () {
    var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var reveals = document.querySelectorAll('.au-reveal');

    if (prefersReduced || !('IntersectionObserver' in window)) {
        reveals.forEach(function (el) { el.classList.add('is-visible'); });
    } else {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        reveals.forEach(function (el) { observer.observe(el); });
    }

    // Vibe tags: toggle a visual "selected" state. Purely cosmetic —
    // no filtering wired up yet. Hook this into a real query param
    // later if you want vibes to actually filter listings.
    var vibeGrid = document.getElementById('auVibeGrid');
    if (vibeGrid) {
        vibeGrid.addEventListener('click', function (e) {
            var tag = e.target.closest('.au-vibe-tag');
            if (!tag) return;
            tag.classList.toggle('is-active');
        });
    }
})();
</script>
@endsection