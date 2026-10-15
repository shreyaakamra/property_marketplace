@extends('layouts.app')

@section('title', 'Contact — Registry.Home')

@section('content')
<style>
    /* ============================================= */
    /* CONTACT — chat-thread redesign                  */
    /* Reuses: .wrap, .chat-window, .chat-bubble,       */
    /* .chat-window__header/__dot/__title/__badge,      */
    /* .btn-brass, --navy/--brass/--border/--muted       */
    /* ============================================= */

    .contact-hero {
        padding: 72px 0 48px;
        text-align: center;
        background: var(--navy, #0a1929);
    }

    .contact-hero .wrap {
        max-width: 640px;
    }

    .contact-hero h1 {
        color: #fff;
        font-size: clamp(1.9rem, 3.6vw, 2.6rem);
        margin: 16px 0 14px;
    }

    .contact-hero p {
        color: rgba(255,255,255,0.72);
        font-size: 1rem;
        line-height: 1.7;
    }

    .contact-body {
        padding: 56px 0 88px;
    }

    .contact-layout {
        display: grid;
        grid-template-columns: 1.3fr 0.9fr;
        gap: 32px;
        align-items: start;
    }

    @media (max-width: 860px) {
        .contact-layout { grid-template-columns: 1fr; }
    }

    /* ---- Main chat window, scaled up as the real page content ---- */
    .contact-chat {
        max-width: none;
    }

    .contact-chat .chat-window__body {
        min-height: 0;
        padding: 22px 20px;
    }

    .contact-chat .chat-bubble {
        opacity: 1;
        transform: none;
        animation: none;
        max-width: 85%;
    }

    /* Flash / status bubble at top of thread */
    .contact-flash {
        margin: 0 0 4px;
    }

    .contact-flash.is-success {
        background: rgba(217,154,63,0.16);
        border: 1px solid rgba(217,154,63,0.4);
        color: #f2d9a8;
    }

    .contact-flash.is-error {
        background: rgba(255,90,110,0.14);
        border: 1px solid rgba(255,90,110,0.4);
        color: #ffb3bd;
    }

    .contact-flash ul {
        margin: 6px 0 0;
        padding-left: 18px;
    }

    /* ---- Quick reply chips ---- */
    .quick-replies {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        padding: 4px 20px 18px;
        border-top: 1px solid rgba(255,255,255,0.06);
    }

    .quick-reply {
        font: inherit;
        cursor: pointer;
        padding: 8px 14px;
        border-radius: 999px;
        border: 1px solid rgba(217,154,63,0.35);
        background: transparent;
        color: var(--brass, #d99a3f);
        font-size: 0.8rem;
        transition: background 0.15s ease, color 0.15s ease;
    }

    .quick-reply:hover,
    .quick-reply.is-picked {
        background: var(--brass, #d99a3f);
        color: #1a1a1a;
    }

    /* ---- Composer (the actual form, styled as a chat input bar) ---- */
    .composer {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 16px 20px 20px;
        background: #142c46;
        border-top: 1px solid rgba(255,255,255,0.06);
    }

    .composer-row {
        display: flex;
        gap: 10px;
    }

    .composer input[type="text"],
    .composer input[type="email"],
    .composer textarea {
        width: 100%;
        border: 1px solid rgba(255,255,255,0.12);
        background: rgba(255,255,255,0.05);
        color: #fff;
        border-radius: 10px;
        padding: 10px 13px;
        font: inherit;
        font-size: 0.88rem;
    }

    .composer input::placeholder,
    .composer textarea::placeholder {
        color: rgba(255,255,255,0.4);
    }

    .composer input:focus,
    .composer textarea:focus {
        outline: none;
        border-color: var(--brass, #d99a3f);
    }

    .composer textarea {
        resize: vertical;
        min-height: 78px;
    }

    .composer-send-row {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
    }

    .composer-hint {
        margin-right: auto;
        font-size: 0.72rem;
        color: rgba(255,255,255,0.4);
    }

    .send-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        padding: 10px 22px;
        border-radius: 999px;
        background: var(--brass, #d99a3f);
        color: #1a1a1a;
        font: inherit;
        font-weight: 600;
        font-size: 0.9rem;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .send-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(217,154,63,0.35);
    }

    .send-btn:disabled {
        opacity: 0.6;
        cursor: default;
        transform: none;
        box-shadow: none;
    }

    /* ---- Sidebar: direct contact cards ---- */
    .contact-side {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .contact-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px;
        border-radius: 14px;
        background: #fff;
        border: 1px solid var(--border, #e5e0d8);
        text-decoration: none;
        color: var(--ink, #1f2937);
        transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
    }

    .contact-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 28px rgba(15,23,42,0.08);
        border-color: var(--brass, #d99a3f);
    }

    .contact-card__icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        background: rgba(217,154,63,0.14);
    }

    .contact-card strong {
        display: block;
        font-size: 0.92rem;
    }

    .contact-card span {
        font-size: 0.8rem;
        color: var(--muted, #6b7280);
    }

    .contact-hours {
        padding: 18px;
        border-radius: 14px;
        background: #f4f1ea;
        border: 1px solid var(--border, #e5e0d8);
        font-size: 0.85rem;
        color: var(--muted, #6b7280);
        line-height: 1.7;
    }

    .contact-hours strong {
        display: block;
        color: var(--ink, #1f2937);
        margin-bottom: 4px;
        font-size: 0.9rem;
    }
</style>

{{-- ============================================= --}}
{{-- HERO --}}
{{-- ============================================= --}}
<section class="contact-hero">
    <div class="wrap">
        <span class="about-eyebrow">◆ Let's talk</span>
        <h1>Got a question? Just ask.</h1>
        <p>No ticket numbers, no support queue. Send a message below and an actual person on our team replies — usually the same day.</p>
    </div>
</section>

{{-- ============================================= --}}
{{-- MAIN CONTACT LAYOUT --}}
{{-- ============================================= --}}
<section class="contact-body wrap">
    <div class="contact-layout">

        {{-- ---- Chat thread + composer (this IS the form) ---- --}}
        <div class="chat-window contact-chat">
            <div class="chat-window__header">
                <span class="chat-window__dot"></span>
                <div class="chat-window__title">
                    <strong>Registry.Home Team</strong>
                    <span>Usually replies within a few hours</span>
                </div>
                <span class="chat-window__badge">Online</span>
            </div>

            <div class="chat-window__body">
                {{-- Flash messages rendered as bubbles in the thread --}}
                @if (session('success'))
                    <div class="chat-bubble chat-bubble--in contact-flash is-success">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="chat-bubble chat-bubble--in contact-flash is-error">
                        <p>Hmm, a couple of things need fixing:</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="chat-bubble chat-bubble--in">
                    <p>Hey! 👋 What's on your mind?</p>
                </div>
                <div class="chat-bubble chat-bubble--in">
                    <p>Pick a quick topic below, or just type your own message.</p>
                </div>
            </div>

            <div class="quick-replies" id="quickReplies">
                <button type="button" class="quick-reply" data-fill="I have a general question about Registry.Home.">General question</button>
                <button type="button" class="quick-reply" data-fill="I'd like to report an issue with a listing.">Report a listing</button>
                <button type="button" class="quick-reply" data-fill="I'm interested in a partnership or collaboration.">Partnership</button>
                <button type="button" class="quick-reply" data-fill="I'm a journalist / press inquiry.">Press</button>
            </div>

            {{-- ---- The actual form, styled as a chat composer ---- --}}
            {{-- [CONFIRM ROUTE] swap 'contact.submit' for your real route name --}}
            <form action="{{ route('contact.submit') }}" method="POST" class="composer" id="contactForm">
                @csrf
                <div class="composer-row">
                    <input type="text" name="name" placeholder="Your name" value="{{ old('name') }}" required>
                    <input type="email" name="email" placeholder="Your email" value="{{ old('email') }}" required>
                </div>
                <textarea name="message" id="contactMessage" placeholder="Type your message..." required>{{ old('message') }}</textarea>
                <div class="composer-send-row">
                    <span class="composer-hint">We'll never share your email.</span>
                    <button type="submit" class="send-btn" id="sendBtn">Send message →</button>
                </div>
            </form>
        </div>

        {{-- ---- Sidebar: direct channels ---- --}}
        <div class="contact-side">
            {{-- [CONFIRM DETAILS] swap in your real contact info --}}
            <a href="https://wa.me/919999999999" target="_blank" rel="noopener" class="contact-card">
                <span class="contact-card__icon">💬</span>
                <div>
                    <strong>WhatsApp us directly</strong>
                    <span>Fastest way to reach us</span>
                </div>
            </a>
            <a href="mailto:hello@registry.home" class="contact-card">
                <span class="contact-card__icon">✉️</span>
                <div>
                    <strong>hello@registry.home</strong>
                    <span>For anything in writing</span>
                </div>
            </a>
            <a href="tel:+919999999999" class="contact-card">
                <span class="contact-card__icon">📞</span>
                <div>
                    <strong>+91 99999 99999</strong>
                    <span>Mon–Sat, 10am–7pm</span>
                </div>
            </a>

            <div class="contact-hours">
                <strong>Response times</strong>
                Chat &amp; WhatsApp: within a few hours<br>
                Email: within 1 business day<br>
                We're a small team — real humans, no bots.
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    var chips = document.getElementById('quickReplies');
    var textarea = document.getElementById('contactMessage');
    var form = document.getElementById('contactForm');
    var sendBtn = document.getElementById('sendBtn');

    if (chips && textarea) {
        chips.addEventListener('click', function (e) {
            var chip = e.target.closest('.quick-reply');
            if (!chip) return;

            chips.querySelectorAll('.quick-reply').forEach(function (c) {
                c.classList.remove('is-picked');
            });
            chip.classList.add('is-picked');

            textarea.value = chip.dataset.fill;
            textarea.focus();
        });
    }

    // Prevents double-submits and gives a little "sending" feedback
    if (form && sendBtn) {
        form.addEventListener('submit', function () {
            sendBtn.disabled = true;
            sendBtn.textContent = 'Sending...';
        });
    }
})();
</script>
@endsection