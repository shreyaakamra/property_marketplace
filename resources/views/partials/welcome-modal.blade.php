{{-- ============================================= --}}
{{-- WELCOME / DISCLAIMER MODAL                       --}}
{{-- Include this in layouts/app.blade.php, right      --}}
{{-- before the closing </body> tag.                   --}}
{{-- Shows once per browser (localStorage), until the   --}}
{{-- user checks the box and clicks Continue.           --}}
{{-- ============================================= --}}
<style>
    .welcome-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(10, 25, 41, 0.6);
        backdrop-filter: blur(3px);
    }

    .welcome-modal-overlay.is-open {
        display: flex;
    }

    .welcome-modal {
        width: 100%;
        max-width: 480px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 30px 70px rgba(0,0,0,0.35);
        overflow: hidden;
        opacity: 0;
        transform: translateY(16px) scale(0.98);
        transition: opacity 0.25s ease, transform 0.25s ease;
    }

    .welcome-modal-overlay.is-open .welcome-modal {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    .welcome-modal__header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px 24px;
        border-bottom: 1px solid var(--border, #e5e0d8);
    }

    .welcome-modal__logo {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        flex-shrink: 0;
    }

    .welcome-modal__header h2 {
        margin: 0;
        font-size: 1.15rem;
        color: var(--navy, #0a1929);
        flex: 1;
        text-align: center;
    }

    .welcome-modal__body {
        padding: 22px 24px 20px;
    }

    .welcome-modal__body p {
        margin: 0 0 14px;
        font-size: 0.9rem;
        line-height: 1.65;
        color: var(--muted, #6b7280);
    }

    .welcome-modal__body p:last-of-type {
        margin-bottom: 0;
    }

    .welcome-modal__agree {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid var(--border, #e5e0d8);
        font-size: 0.88rem;
        color: var(--ink, #1f2937);
    }

    .welcome-modal__agree input[type="checkbox"] {
        margin-top: 2px;
        width: 16px;
        height: 16px;
        accent-color: var(--brass, #d99a3f);
        flex-shrink: 0;
        cursor: pointer;
    }

    .welcome-modal__agree label {
        cursor: pointer;
    }

    .welcome-modal__agree a {
        color: var(--brass, #d99a3f);
        text-decoration: underline;
    }

    .welcome-modal__footer {
        display: flex;
        justify-content: flex-end;
        padding: 16px 24px 22px;
    }

    .welcome-modal__continue {
        border: none;
        cursor: not-allowed;
        padding: 11px 26px;
        border-radius: 999px;
        font: inherit;
        font-weight: 600;
        font-size: 0.9rem;
        background: #d9d4c8;
        color: #8a8578;
        transition: background 0.15s ease, color 0.15s ease, box-shadow 0.15s ease, transform 0.15s ease;
    }

    .welcome-modal__continue.is-enabled {
        cursor: pointer;
        background: var(--brass, #d99a3f);
        color: #1a1a1a;
    }

    .welcome-modal__continue.is-enabled:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(217,154,63,0.35);
    }
</style>

<div class="welcome-modal-overlay" id="welcomeModalOverlay">
    <div class="welcome-modal" role="dialog" aria-modal="true" aria-labelledby="welcomeModalTitle">
        <div class="welcome-modal__header">
            <img src="{{ asset('images/logo.png') }}" alt="Registry.Home logo" class="welcome-modal__logo">
            <h2 id="welcomeModalTitle">Welcome to Registry.Home</h2>
        </div>

        <div class="welcome-modal__body">
            <p>
                This platform only acts as a medium to connect property owners and
                property seekers. We are not responsible for any transactions,
                payments, agreements, or disputes between users.
            </p>
            <p>
                Users are advised to verify all information independently before
                entering into any deal.
            </p>

            <div class="welcome-modal__agree">
                <input type="checkbox" id="welcomeAgreeCheckbox">
                <label for="welcomeAgreeCheckbox">
                    I agree to the <a href="{{ route('terms') }}" target="_blank" rel="noopener">Terms &amp; Conditions</a>
                </label>
            </div>
        </div>

        <div class="welcome-modal__footer">
            <button type="button" class="welcome-modal__continue" id="welcomeContinueBtn" disabled>
                Continue
            </button>
        </div>
    </div>
</div>

<script>
(function () {
    var STORAGE_KEY = 'registry_home_welcome_ack';
    var overlay = document.getElementById('welcomeModalOverlay');
    var checkbox = document.getElementById('welcomeAgreeCheckbox');
    var continueBtn = document.getElementById('welcomeContinueBtn');

    if (!overlay || !checkbox || !continueBtn) return;

    // Show only if the user hasn't already agreed on this browser.
    var alreadyAgreed = false;
    try {
        alreadyAgreed = localStorage.getItem(STORAGE_KEY) === '1';
    } catch (e) {
        // localStorage unavailable (private browsing etc.) — fall back to always showing.
    }

    if (!alreadyAgreed) {
        overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    checkbox.addEventListener('change', function () {
        var checked = checkbox.checked;
        continueBtn.disabled = !checked;
        continueBtn.classList.toggle('is-enabled', checked);
    });

    continueBtn.addEventListener('click', function () {
        if (continueBtn.disabled) return;

        try {
            localStorage.setItem(STORAGE_KEY, '1');
        } catch (e) {
            // ignore — worst case it shows again next visit
        }

        overlay.classList.remove('is-open');
        document.body.style.overflow = '';
    });
})();
</script>