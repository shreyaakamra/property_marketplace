@extends('layouts.app')

@section('title', 'Terms & Conditions — Registry.Home')

@section('content')
<style>
    .terms-hero {
        padding: 56px 0 40px;
        background: var(--navy, #0a1929);
    }

    .terms-hero .wrap {
        max-width: 720px;
    }

    .terms-hero h1 {
        color: #fff;
        font-size: clamp(1.7rem, 3vw, 2.2rem);
        margin: 14px 0 10px;
    }

    .terms-hero p {
        color: rgba(255,255,255,0.65);
        font-size: 0.9rem;
    }

    .terms-body {
        padding: 48px 0 80px;
    }

    .terms-body .wrap {
        max-width: 720px;
    }

    .terms-toc {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 44px;
        padding-bottom: 32px;
        border-bottom: 1px solid var(--border, #e5e0d8);
    }

    .terms-toc a {
        font-size: 0.82rem;
        padding: 6px 12px;
        border-radius: 999px;
        border: 1px solid var(--border, #e5e0d8);
        color: var(--muted, #6b7280);
        text-decoration: none;
        transition: border-color 0.15s ease, color 0.15s ease;
    }

    .terms-toc a:hover {
        border-color: var(--brass, #d99a3f);
        color: var(--brass, #d99a3f);
    }

    .terms-section {
        margin-bottom: 36px;
        scroll-margin-top: 24px;
    }

    .terms-section h2 {
        display: flex;
        align-items: baseline;
        gap: 10px;
        font-size: 1.15rem;
        margin: 0 0 12px;
    }

    .terms-section .num {
        font-family: var(--font-mono, 'IBM Plex Mono', monospace);
        font-size: 0.85rem;
        color: var(--brass, #d99a3f);
    }

    .terms-section p,
    .terms-section li {
        color: var(--muted, #6b7280);
        line-height: 1.75;
        font-size: 0.94rem;
    }

    .terms-section ul {
        margin: 10px 0 0;
        padding-left: 20px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .terms-updated {
        margin-top: 48px;
        padding-top: 20px;
        border-top: 1px solid var(--border, #e5e0d8);
        font-size: 0.82rem;
        color: var(--muted, #6b7280);
    }
</style>

<section class="terms-hero">
    <div class="wrap">
        <span class="about-eyebrow">◆ The fine print</span>
        <h1>Terms &amp; Conditions</h1>
        <p>Plain-language summary up top, full terms below. Last updated {{ now()->format('d M Y') }}.</p>
    </div>
</section>

<section class="terms-body">
    <div class="wrap">
        <nav class="terms-toc">
            <a href="#what-we-are">What we are</a>
            <a href="#no-broker">No broker relationship</a>
            <a href="#verify">Verifying listings</a>
            <a href="#disputes">Disputes &amp; transactions</a>
            <a href="#accounts">Accounts &amp; conduct</a>
            <a href="#content">Listing content</a>
            <a href="#liability">Limitation of liability</a>
            <a href="#changes">Changes to these terms</a>
            <a href="#contact">Contact</a>
        </nav>

        <div class="terms-section" id="what-we-are">
            <h2><span class="num">01</span> What Registry.Home is</h2>
            <p>
                Registry.Home is a platform that connects property owners directly
                with tenants and buyers. We provide the space for owners to list
                properties and for seekers to browse, search, and contact owners
                directly. We do not buy, sell, rent, manage, or take ownership of
                any property listed on the platform.
            </p>
        </div>

        <div class="terms-section" id="no-broker">
            <h2><span class="num">02</span> We are not a broker or agent</h2>
            <p>
                Registry.Home acts only as a medium connecting property owners and
                property seekers. We are not a real estate broker, agent, or party
                to any agreement made between users. We do not negotiate on behalf
                of any user, collect rent or sale proceeds, or hold any deposit or
                payment related to a listing.
            </p>
        </div>

        <div class="terms-section" id="verify">
            <h2><span class="num">03</span> Verify everything independently</h2>
            <p>
                Users are advised to independently verify all listing details —
                ownership, pricing, availability, legal status, and property
                condition — before entering into any agreement or making any
                payment. We make reasonable efforts to indicate verified owners
                where possible, but this is not a guarantee and does not replace
                your own due diligence.
            </p>
        </div>

        <div class="terms-section" id="disputes">
            <h2><span class="num">04</span> Transactions and disputes are between users</h2>
            <p>
                Any transaction, payment, agreement, viewing, or dispute that
                takes place as a result of a connection made through Registry.Home
                is strictly between the property owner and the property seeker.
                Registry.Home is not responsible for and does not mediate:
            </p>
            <ul>
                <li>Payments, deposits, rent, or sale amounts exchanged between users</li>
                <li>The accuracy of any information a user provides to another user</li>
                <li>Property condition, legal title, or documentation</li>
                <li>Any dispute, breach, fraud, or disagreement arising between users</li>
            </ul>
        </div>

        <div class="terms-section" id="accounts">
            <h2><span class="num">05</span> Accounts and acceptable use</h2>
            <p>
                You agree to provide accurate information when posting a listing
                or a requirement. You agree not to use the platform to post
                fraudulent listings, impersonate another person, harass other
                users, or use contact details obtained through the platform for
                unsolicited marketing.
            </p>
        </div>

        <div class="terms-section" id="content">
            <h2><span class="num">06</span> Listing content</h2>
            <p>
                Owners are responsible for the accuracy of the information and
                photos they submit. Registry.Home may remove any listing that
                appears fraudulent, duplicated, or in violation of these terms,
                at our discretion and without prior notice.
            </p>
        </div>

        <div class="terms-section" id="liability">
            <h2><span class="num">07</span> Limitation of liability</h2>
            <p>
                To the maximum extent permitted by law, Registry.Home and its
                team are not liable for any direct, indirect, incidental, or
                consequential loss or damage arising from your use of the
                platform, reliance on any listing, or any transaction or dispute
                between users.
            </p>
        </div>

        <div class="terms-section" id="changes">
            <h2><span class="num">08</span> Changes to these terms</h2>
            <p>
                We may update these terms from time to time. Continued use of
                Registry.Home after changes are posted means you accept the
                updated terms. We'll update the date at the top of this page
                whenever that happens.
            </p>
        </div>

        <div class="terms-section" id="contact">
            <h2><span class="num">09</span> Questions</h2>
            <p>
                If anything here is unclear, reach out through our
                <a href="{{ route('contact') }}" style="color: var(--brass, #d99a3f);">contact page</a>
                and we'll walk you through it.
            </p>
        </div>

        <p class="terms-updated">
            [CONFIRM CONTENT] — this is a starting draft covering the same points
            as your disclaimer modal. Have an actual lawyer or someone versed in
            Indian real-estate/intermediary regulations review this before treating
            it as your live, binding terms — especially the liability and dispute
            sections, since real-estate intermediary rules vary by state.
        </p>
    </div>
</section>
@endsection