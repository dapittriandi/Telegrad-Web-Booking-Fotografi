@extends('base.base-root-index')

@push('css')
<style>
/* ══════════════════════════════════════════════════════════════
   CHECKOUT PAGE — Telegrad Premium v2
   Fonts: Cormorant Garamond (display) + Sora (body)
   Inherits CSS vars dari base-root-index
══════════════════════════════════════════════════════════════ */

@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Sora:wght@300;400;500;600;700&display=swap');

/* ── Base Variables Override ──────────────────────────────── */
:root {
    --gold:        #c8a96e;
    --gold-light:  #e0c88a;
    --gold-dim:    rgba(200,169,110,.07);
    --gold-border: rgba(200,169,110,.22);
    --surface:     #111111;
    --card:        #161616;
    --border:      rgba(255,255,255,.07);
    --text:        #f0ece4;
    --muted:       #7a7570;
    --success:     #4caf82;
    --danger:      #e05c5c;
    --font-display: 'Cormorant Garamond', Georgia, serif;
    --font-body:    'Sora', system-ui, sans-serif;
    --ease-out:     cubic-bezier(.22,1,.36,1);
    --ease-spring:  cubic-bezier(.34,1.56,.64,1);
    --radius-sm:    10px;
    --radius-md:    16px;
    --radius-lg:    22px;
}
[data-theme="light"] {
    --surface:  #f5f3ef;
    --card:     #ffffff;
    --border:   rgba(0,0,0,.08);
    --text:     #1a1714;
    --muted:    #8a8078;
}

/* ── Page Shell ───────────────────────────────────────────── */
.ck-page {
    min-height: 100vh;
    padding: 104px 0 88px;
    background: var(--surface);
    position: relative;
    font-family: var(--font-body);
}

/* Ambient glow orbs */
.ck-orb {
    position: fixed;
    border-radius: 50%;
    pointer-events: none;
    z-index: 0;
    will-change: transform;
}
.ck-orb-1 {
    width: 700px; height: 700px;
    top: -15%; right: -12%;
    background: radial-gradient(circle, rgba(200,169,110,.055) 0%, transparent 65%);
    animation: orbDrift1 18s ease-in-out infinite alternate;
}
.ck-orb-2 {
    width: 550px; height: 550px;
    bottom: 5%; left: -14%;
    background: radial-gradient(circle, rgba(200,169,110,.04) 0%, transparent 65%);
    animation: orbDrift2 22s ease-in-out infinite alternate;
}
@keyframes orbDrift1 {
    from { transform: translate(0, 0) scale(1); }
    to   { transform: translate(-40px, 30px) scale(1.08); }
}
@keyframes orbDrift2 {
    from { transform: translate(0, 0) scale(1); }
    to   { transform: translate(30px, -40px) scale(1.05); }
}

.ck-page > .container { position: relative; z-index: 1; }

/* ── Noise texture overlay ──────────────────────────────────*/
.ck-page::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.025'/%3E%3C/svg%3E");
    pointer-events: none;
    opacity: .6;
    z-index: 0;
}

/* ── Progress Stepper ─────────────────────────────────────── */
.ck-steps {
    display: flex;
    align-items: center;
    margin-bottom: 48px;
    padding: 0 2px;
    animation: fadeSlideUp .6s var(--ease-out) both;
}
.ck-step {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
    position: relative;
}
.ck-step-num {
    width: 34px; height: 34px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .7rem;
    font-weight: 700;
    font-family: var(--font-body);
    border: 1.5px solid rgba(255,255,255,.1);
    color: var(--muted);
    transition: all .4s var(--ease-spring);
    letter-spacing: .03em;
    position: relative;
}
[data-theme="light"] .ck-step-num {
    border-color: rgba(0,0,0,.15);
}
.ck-step-num::after {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    border: 1px solid transparent;
    transition: border-color .4s;
}
.ck-step-label {
    font-size: .67rem;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--muted);
    transition: color .3s;
}
.ck-step.is-active .ck-step-num {
    background: var(--gold);
    color: #0d0a06;
    border-color: var(--gold);
    box-shadow: 0 0 0 5px rgba(200,169,110,.12), 0 4px 16px rgba(200,169,110,.25);
}
.ck-step.is-active .ck-step-num::after {
    border-color: rgba(200,169,110,.2);
}
.ck-step.is-active .ck-step-label { color: var(--gold-light); }
.ck-step.is-done .ck-step-num {
    background: var(--success);
    border-color: var(--success);
    color: #fff;
    box-shadow: 0 0 0 5px rgba(76,175,130,.1);
}
.ck-step.is-done .ck-step-label { color: var(--success); }

.ck-step-track {
    flex: 1;
    height: 1px;
    margin: 0 12px;
    background: rgba(255,255,255,.08);
    position: relative;
    overflow: hidden;
    border-radius: 1px;
}
[data-theme="light"] .ck-step-track {
    background: rgba(0,0,0,.12);
}
.ck-step-track::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, var(--gold), var(--gold-light));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform .6s var(--ease-out);
}
.ck-step.is-done + .ck-step-track::after { transform: scaleX(1); }

/* ── Page Header ──────────────────────────────────────────── */
.ck-header {
    margin-bottom: 36px;
    animation: fadeSlideUp .65s var(--ease-out) .08s both;
}
.ck-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: .63rem;
    font-weight: 600;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: var(--gold);
    border: 1px solid var(--gold-border);
    padding: 5px 15px;
    border-radius: 100px;
    margin-bottom: 16px;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    background: var(--gold-dim);
    transition: box-shadow .3s;
}
.ck-eyebrow:hover {
    box-shadow: 0 0 20px rgba(200,169,110,.15);
}
.ck-title {
    font-family: var(--font-display);
    font-size: clamp(1.7rem, 3vw, 2.4rem);
    font-weight: 600;
    color: var(--text);
    line-height: 1.15;
    margin: 0 0 10px;
    letter-spacing: -.01em;
}
.ck-title em {
    font-style: italic;
    color: var(--gold);
    font-weight: 400;
}
.ck-desc {
    font-size: .84rem;
    color: var(--muted);
    line-height: 1.75;
    max-width: 460px;
    margin: 0;
    font-weight: 300;
}

/* ── Flash Alerts ─────────────────────────────────────────── */
.ck-alert {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    padding: 15px 20px;
    border-radius: var(--radius-md);
    font-size: .82rem;
    line-height: 1.65;
    margin-bottom: 24px;
    animation: alertIn .4s var(--ease-out) both;
    backdrop-filter: blur(8px);
}
@keyframes alertIn {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}
.ck-alert-icon { flex-shrink: 0; font-size: 1rem; margin-top: 1px; }
.ck-alert.is-error {
    background: rgba(224,92,92,.07);
    border: 1px solid rgba(224,92,92,.2);
    color: #f08080;
}
.ck-alert.is-error .ck-alert-icon { color: var(--danger); }
.ck-alert.is-success {
    background: rgba(76,175,130,.07);
    border: 1px solid rgba(76,175,130,.2);
    color: #7de0b4;
}
.ck-alert.is-success .ck-alert-icon { color: var(--success); }

/* ── Section Cards ────────────────────────────────────────── */
.ck-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    margin-bottom: 18px;
    transition: border-color .3s, box-shadow .3s, transform .3s;
    position: relative;
}
.ck-card::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: inherit;
    background: linear-gradient(135deg, rgba(255,255,255,.015) 0%, transparent 50%);
    pointer-events: none;
}
.ck-card:focus-within {
    border-color: var(--gold-border);
    box-shadow: 0 0 0 1px var(--gold-border), 0 8px 40px rgba(0,0,0,.25);
}
.ck-card:hover {
    border-color: rgba(200,169,110,.14);
}

/* Card section number badge */
.ck-card-head {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 20px 24px;
    border-bottom: 1px solid var(--border);
    position: relative;
}
.ck-card-head::after {
    content: '';
    position: absolute;
    bottom: 0; left: 24px; right: 24px;
    height: 1px;
    background: linear-gradient(90deg, var(--gold-border), transparent);
    opacity: .6;
}

.ck-card-icon {
    width: 42px; height: 42px;
    border-radius: 12px;
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold);
    font-size: 1rem;
    flex-shrink: 0;
    transition: background .25s, box-shadow .25s;
}
.ck-card:focus-within .ck-card-icon {
    background: rgba(200,169,110,.12);
    box-shadow: 0 0 12px rgba(200,169,110,.15);
}

.ck-card-title {
    font-family: var(--font-display);
    font-size: 1.05rem;
    font-weight: 600;
    color: var(--text);
    margin: 0;
    line-height: 1.1;
    letter-spacing: .01em;
}
.ck-card-subtitle {
    font-size: .7rem;
    color: var(--muted);
    margin-top: 4px;
    font-weight: 400;
    letter-spacing: .01em;
}

.ck-card-step-num {
    margin-left: auto;
    font-size: .6rem;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--muted);
    opacity: .5;
    font-family: var(--font-body);
}

.ck-card-body { padding: 24px; }

/* ── Form Fields ──────────────────────────────────────────── */
.ck-field { margin-bottom: 20px; }
.ck-field:last-child { margin-bottom: 0; }

.ck-label {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: .63rem;
    font-weight: 600;
    letter-spacing: .13em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 8px;
    font-family: var(--font-body);
}
.ck-label .req { color: var(--gold); font-size: .8rem; margin-left: 1px; line-height: 1; }

.ck-input {
    width: 100%;
    background: rgba(255,255,255,.025);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: var(--radius-sm);
    padding: 12px 16px;
    font-size: .875rem;
    color: var(--text);
    outline: none;
    appearance: none;
    -webkit-appearance: none;
    transition: border-color .25s, background .25s, box-shadow .25s;
    font-family: var(--font-body);
    font-weight: 400;
    letter-spacing: .01em;
}
[data-theme="light"] .ck-input {
    background: rgba(0,0,0,.025);
    border-color: rgba(0,0,0,.1);
}
.ck-input::placeholder { color: var(--muted); opacity: .55; }
.ck-input:hover {
    border-color: rgba(200,169,110,.18);
    background: rgba(200,169,110,.02);
}
.ck-input:focus {
    border-color: var(--gold-border);
    background: rgba(200,169,110,.035);
    box-shadow: 0 0 0 3px rgba(200,169,110,.07), 0 2px 12px rgba(0,0,0,.12);
}
.ck-input.is-err {
    border-color: rgba(224,92,92,.45) !important;
    background: rgba(224,92,92,.03) !important;
}

select.ck-input {
    cursor: pointer;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%23c8a96e' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 40px;
}
select.ck-input option {
    background: #1a1a1a;
    color: var(--text);
}
[data-theme="light"] select.ck-input option { background: #fff; }

textarea.ck-input {
    resize: vertical;
    min-height: 120px;
    line-height: 1.7;
}

.ck-input[readonly] {
    opacity: .45;
    cursor: not-allowed;
    user-select: none;
    background: rgba(255,255,255,.012) !important;
    border-color: rgba(255,255,255,.05) !important;
    box-shadow: none !important;
}

.ck-err-msg {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: .72rem;
    color: var(--danger);
    margin-top: 6px;
    font-weight: 500;
}
.ck-err-msg i { font-size: .75rem; }

.ck-hint {
    display: flex;
    align-items: flex-start;
    gap: 7px;
    font-size: .71rem;
    color: var(--muted);
    margin-top: 8px;
    line-height: 1.6;
    font-weight: 300;
}
.ck-hint i {
    color: var(--gold);
    flex-shrink: 0;
    margin-top: 1px;
    font-size: .82rem;
    opacity: .8;
}

/* ── Duration Info Bar ────────────────────────────────────── */
.ck-duration-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 14px;
    padding: 13px 18px;
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    border-radius: var(--radius-sm);
    font-size: .81rem;
    color: var(--muted);
    font-family: var(--font-body);
    position: relative;
    overflow: hidden;
}
.ck-duration-row::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, var(--gold), var(--gold-light));
    border-radius: 0 2px 2px 0;
}
.ck-duration-row i { color: var(--gold); flex-shrink: 0; }
.ck-duration-row strong {
    color: var(--gold-light);
    font-weight: 600;
}
.ck-duration-sep {
    width: 1px; height: 14px;
    background: var(--gold-border);
    flex-shrink: 0;
}

/* ── Char Count ───────────────────────────────────────────── */
.ck-char-count {
    font-size: .68rem;
    color: var(--muted);
    text-align: right;
    margin-top: 6px;
    transition: color .2s;
    font-weight: 400;
    letter-spacing: .04em;
}
.ck-char-count.is-near { color: var(--gold); }
.ck-char-count.is-over { color: var(--danger); }

/* ── User Identity Card ───────────────────────────────────── */
.ck-user-row {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    background: rgba(200,169,110,.04);
    border: 1px solid var(--gold-border);
    border-radius: var(--radius-sm);
    margin-bottom: 22px;
    position: relative;
    overflow: hidden;
}
.ck-user-row::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(200,169,110,.04) 0%, transparent 60%);
    pointer-events: none;
}
[data-theme="light"] .ck-user-row { background: rgba(200,169,110,.04); }

.ck-user-avatar {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(200,169,110,.35), rgba(200,169,110,.12));
    border: 1px solid var(--gold-border);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold);
    font-size: 1.1rem;
    font-weight: 700;
    font-family: var(--font-display);
    flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(200,169,110,.12);
}
.ck-user-info { flex: 1; min-width: 0; }
.ck-user-name {
    font-size: .88rem;
    font-weight: 600;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ck-user-email {
    font-size: .74rem;
    color: var(--muted);
    margin-top: 2px;
    font-weight: 300;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.ck-user-badge {
    margin-left: auto;
    font-size: .6rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--gold);
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    padding: 4px 11px;
    border-radius: 100px;
    flex-shrink: 0;
    white-space: nowrap;
}

/* ══════════════════════════════════════════════════════════════
   ORDER SUMMARY SIDEBAR
══════════════════════════════════════════════════════════════ */
.ck-summary {
    background: var(--card);
    border: 1px solid var(--gold-border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    position: sticky;
    top: 92px;
    transition: box-shadow .3s;
}
.ck-summary:hover {
    box-shadow: 0 16px 60px rgba(0,0,0,.3), 0 0 0 1px var(--gold-border);
}

/* Summary hero */
.ck-sum-hero {
    padding: 26px 22px 20px;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(160deg,
        rgba(200,169,110,.08) 0%,
        rgba(200,169,110,.02) 100%);
    position: relative;
    text-align: center;
}
.ck-sum-hero::before {
    content: '';
    position: absolute;
    top: 0; left: 50%; transform: translateX(-50%);
    width: 70%; height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold-border), transparent);
}
.ck-sum-hero::after {
    content: '';
    position: absolute;
    bottom: 0; left: 50%; transform: translateX(-50%);
    width: 50%; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(200,169,110,.12), transparent);
}

/* Decorative icon above package name */
.ck-sum-icon {
    width: 50px; height: 50px;
    border-radius: 14px;
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold);
    font-size: 1.2rem;
    margin: 0 auto 14px;
    box-shadow: 0 4px 20px rgba(200,169,110,.12);
}

.ck-sum-eyebrow {
    font-size: .6rem;
    font-weight: 700;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 8px;
}
.ck-sum-pkg-name {
    font-family: var(--font-display);
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--text);
    line-height: 1.25;
    margin-bottom: 8px;
}
.ck-sum-category {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .65rem;
    font-weight: 600;
    letter-spacing: .07em;
    color: var(--gold);
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    padding: 3px 11px;
    border-radius: 100px;
}

/* Summary body */
.ck-sum-body { padding: 18px 20px 20px; }

.ck-sum-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    padding: 9px 0;
    border-bottom: 1px solid rgba(255,255,255,.04);
    font-size: .81rem;
}
[data-theme="light"] .ck-sum-row { border-bottom-color: rgba(0,0,0,.05); }
.ck-sum-row:last-of-type { border-bottom: none; }
.ck-sum-key {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--muted);
    flex-shrink: 0;
    font-weight: 400;
}
.ck-sum-key i { color: var(--gold); font-size: .82rem; width: 14px; text-align: center; opacity: .85; }
.ck-sum-val {
    color: var(--text);
    font-weight: 500;
    text-align: right;
}

/* Features */
.ck-sum-feats {
    list-style: none;
    padding: 0; margin: 0;
    display: flex;
    flex-direction: column;
    gap: 6px;
    width: 100%;
}
.ck-sum-feats li {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: .76rem;
    color: var(--muted);
    line-height: 1.55;
    font-weight: 300;
}
.ck-sum-feats li i {
    color: var(--success);
    font-size: .78rem;
    flex-shrink: 0;
    margin-top: 2px;
}
.ck-sum-feats li.more { color: var(--gold); font-weight: 500; }
.ck-sum-feats li.more i { color: var(--gold); }

/* Divider */
.ck-sum-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold-border), transparent);
    margin: 8px 0 16px;
}

/* Total */
.ck-sum-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 18px;
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    border-radius: var(--radius-sm);
    margin-bottom: 16px;
    position: relative;
    overflow: hidden;
}
.ck-sum-total::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(200,169,110,.06) 0%, transparent 60%);
    pointer-events: none;
}
.ck-sum-total-label {
    font-size: .62rem;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--muted);
}
.ck-sum-total-price {
    font-family: var(--font-display);
    font-size: 1.55rem;
    font-weight: 600;
    color: var(--gold-light);
    letter-spacing: -.01em;
    line-height: 1;
}

/* Submit CTA */
.ck-submit {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 15px 24px;
    font-size: .78rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: #0d0a06;
    background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
    border: none;
    border-radius: var(--radius-sm);
    cursor: pointer;
    transition: transform .22s var(--ease-spring), box-shadow .22s, opacity .2s;
    position: relative;
    overflow: hidden;
    font-family: var(--font-body);
}
.ck-submit::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(255,255,255,.18) 0%, transparent 55%);
    pointer-events: none;
}
.ck-submit::after {
    content: '';
    position: absolute;
    top: 50%; left: 50%;
    width: 0; height: 0;
    border-radius: 50%;
    background: rgba(255,255,255,.25);
    transform: translate(-50%, -50%);
    transition: width .5s, height .5s, opacity .5s;
    opacity: 0;
    pointer-events: none;
}
.ck-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 36px rgba(200,169,110,.35), 0 4px 12px rgba(0,0,0,.2);
}
.ck-submit:active {
    transform: translateY(0) scale(.98);
    box-shadow: 0 4px 16px rgba(200,169,110,.2);
}
.ck-submit:active::after {
    width: 300px; height: 300px;
    opacity: 0;
    transition: width .3s, height .3s, opacity .5s;
}
.ck-submit:disabled {
    opacity: .65;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
}

/* Secure badge */
.ck-secure {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: .68rem;
    color: var(--muted);
    margin-top: 12px;
    font-weight: 400;
    letter-spacing: .03em;
}
.ck-secure i { color: var(--gold); font-size: .76rem; opacity: .85; }

/* Back link */
.ck-back {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 14px;
    font-size: .73rem;
    color: var(--muted);
    text-decoration: none;
    transition: color .2s, gap .2s;
    font-weight: 400;
}
.ck-back:hover { color: var(--gold); gap: 9px; }
.ck-back i { font-size: .8rem; transition: transform .2s; }
.ck-back:hover i { transform: translateX(-3px); }

/* ── Sticky bottom CTA — mobile ───────────────────────────── */
/* Disembunyikan di desktop via media query di bawah */
.ck-sticky-cta {
    display: flex;
    position: fixed;
    bottom: 0; left: 0; right: 0;
    z-index: 9999;
    background: rgba(22,22,22,.94);
    border-top: 1px solid var(--gold-border);
    padding: 12px 16px;
    padding-bottom: calc(72px + env(safe-area-inset-bottom, 0px));
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    align-items: center;
    gap: 14px;
    
}
@keyframes slideUpCta {
    from { transform: translateY(100%); opacity: 0; }
    to   { transform: translateY(0); opacity: 1; }
}
[data-theme="light"] .ck-sticky-cta {
    background: rgba(245,243,239,.95);
    border-top: 1px solid rgba(200,169,110,.35);
    box-shadow: 0 -4px 24px rgba(0,0,0,.07);
}
.ck-sticky-price { flex-shrink: 0; }
.ck-sticky-price-label {
    font-size: .58rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 2px;
}
.ck-sticky-price-val {
    font-family: var(--font-display);
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--gold-light);
    line-height: 1;
}
[data-theme="light"] .ck-sticky-price-val {
    color: var(--gold);
}
.ck-sticky-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 13px 18px;
    font-size: .76rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #0d0a06;
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    border: none;
    border-radius: var(--radius-sm);
    cursor: pointer;
    transition: transform .18s var(--ease-spring), box-shadow .18s;
    font-family: var(--font-body);
    position: relative;
    overflow: hidden;
}
.ck-sticky-btn::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(255,255,255,.15) 0%, transparent 55%);
    pointer-events: none;
}
.ck-sticky-btn:active { transform: scale(.97); }
.ck-sticky-btn:disabled { opacity: .65; cursor: not-allowed; transform: none !important; }

/* ══════════════════════════════════════════════════════════════
   ANIMATIONS
══════════════════════════════════════════════════════════════ */
@keyframes fadeSlideUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

.ck-card[data-aos] {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity .55s var(--ease-out), transform .55s var(--ease-out), border-color .3s, box-shadow .3s;
}
.ck-card[data-aos].aos-animate {
    opacity: 1;
    transform: translateY(0);
}

/* ══════════════════════════════════════════════════════════════
   RESPONSIVE — TABLET ≤ 991px
══════════════════════════════════════════════════════════════ */
@media (max-width: 991.98px) {
    .ck-page { padding: 88px 0 60px; }

    .ck-summary {
        position: static;
        margin-top: 4px;
    }
    .ck-sum-hero { padding: 20px 20px 16px; }
    .ck-sum-body { padding: 14px 18px 18px; }

    .ck-title { font-size: clamp(1.5rem, 4.5vw, 2rem); }

    /* Tombol submit tetap tampil di summary card (fallback aman) */
    /* tombol di summary card tetap tampil di mobile */

}

/* Sticky bar disembunyikan di semua layar — tombol ada di summary card */
@media (min-width: 0px) {
    .ck-sticky-cta { display: none !important; }
}

/* ══════════════════════════════════════════════════════════════
   RESPONSIVE — MOBILE ≤ 767px
══════════════════════════════════════════════════════════════ */
@media (max-width: 767.98px) {
    .ck-page { padding: 78px 0 108px; }

    .ck-steps { margin-bottom: 30px; }
    .ck-step-num { width: 30px; height: 30px; font-size: .68rem; }
    .ck-step-track { margin: 0 8px; }

    .ck-header { margin-bottom: 24px; }
    .ck-eyebrow { font-size: .6rem; padding: 4px 12px; }
    .ck-title { font-size: 1.55rem; margin-bottom: 8px; }
    .ck-desc { font-size: .8rem; }

    .ck-card { border-radius: var(--radius-md); margin-bottom: 14px; }
    .ck-card-head { padding: 16px 18px; gap: 11px; }
    .ck-card-icon { width: 36px; height: 36px; border-radius: 10px; font-size: .9rem; }
    .ck-card-title { font-size: .95rem; }
    .ck-card-subtitle { font-size: .67rem; }
    .ck-card-body { padding: 18px; }

    .ck-field { margin-bottom: 16px; }
    .ck-label { font-size: .62rem; }
    .ck-input { font-size: .85rem; padding: 11px 14px; }
    .ck-hint { font-size: .69rem; }

    .ck-duration-row { font-size: .78rem; padding: 11px 15px; flex-wrap: wrap; }
    .ck-duration-sep { display: none; }

    .ck-user-row { gap: 11px; padding: 12px 14px; }
    .ck-user-avatar { width: 40px; height: 40px; border-radius: 10px; font-size: .95rem; }
    .ck-user-name { font-size: .85rem; }
    .ck-user-email { font-size: .72rem; }
    .ck-user-badge { font-size: .57rem; padding: 3px 9px; }

    .ck-alert { font-size: .79rem; padding: 12px 14px; gap: 10px; }

    .ck-summary { border-radius: var(--radius-md); }
    .ck-sum-hero { padding: 18px 18px 14px; }
    .ck-sum-pkg-name { font-size: 1.1rem; }
    .ck-sum-body { padding: 12px 16px 16px; }
    .ck-sum-total { padding: 13px 15px; }
    .ck-sum-total-price { font-size: 1.4rem; }
    .ck-sum-icon { width: 44px; height: 44px; border-radius: 12px; font-size: 1rem; }
}

/* ══════════════════════════════════════════════════════════════
   RESPONSIVE — SMALL MOBILE ≤ 575px
══════════════════════════════════════════════════════════════ */
@media (max-width: 575.98px) {
    .ck-page { padding: 72px 0 100px; }
    .ck-step-label { display: none !important; }
    .ck-step-num { width: 28px; height: 28px; font-size: .67rem; }
    .ck-steps { margin-bottom: 26px; }
    .ck-card-head { padding: 13px 15px; }
    .ck-card-body { padding: 15px; }
    .ck-card-icon { width: 32px; height: 32px; font-size: .82rem; }
    .ck-card-step-num { display: none; }
    .ck-input { padding: 11px 13px; font-size: .86rem; border-radius: 9px; }
    textarea.ck-input { min-height: 100px; }
    .ck-user-badge { display: none; }
    .ck-sum-total-price { font-size: 1.3rem; }
    .ck-sum-feats li { font-size: .73rem; }
}
</style>
@endpush

@section('content')
<main id="main">

    {{-- Ambient orbs --}}
    <div class="ck-orb ck-orb-1" aria-hidden="true"></div>
    <div class="ck-orb ck-orb-2" aria-hidden="true"></div>

    <section class="ck-page">
        <div class="container">

            {{-- ── Progress Steps ─────────────────────────── --}}
            <div class="ck-steps" data-aos="fade-up" data-aos-duration="700">
                <div class="ck-step is-active">
                    <div class="ck-step-num">1</div>
                    <span class="ck-step-label d-none d-sm-block">Isi Data</span>
                </div>
                <div class="ck-step-track"></div>
                <div class="ck-step">
                    <div class="ck-step-num">2</div>
                    <span class="ck-step-label d-none d-sm-block">Pembayaran</span>
                </div>
                <div class="ck-step-track"></div>
                <div class="ck-step">
                    <div class="ck-step-num">3</div>
                    <span class="ck-step-label d-none d-sm-block">Konfirmasi</span>
                </div>
            </div>

            {{-- ── Page Header ─────────────────────────────── --}}
            <div class="ck-header" data-aos="fade-up" data-aos-delay="60">
                <div class="ck-eyebrow">
                    <i class="bi bi-camera"></i>
                    Pemesanan Sesi Foto
                </div>
                <h1 class="ck-title">Lengkapi <em>Detail</em> Booking</h1>
                <p class="ck-desc">
                    Pastikan tanggal, waktu, dan lokasi sesuai rencana kamu.
                    Tim kami akan mengonfirmasi dalam 1×24 jam.
                </p>
            </div>

            {{-- ── Flash Messages ──────────────────────────── --}}
            @if(session('error'))
                <div class="ck-alert is-error" data-aos="fade-down">
                    <i class="bi bi-exclamation-triangle-fill ck-alert-icon"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif
            @if(session('success'))
                <div class="ck-alert is-success" data-aos="fade-down">
                    <i class="bi bi-check-circle-fill ck-alert-icon"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="ck-alert is-error" data-aos="fade-down">
                    <i class="bi bi-exclamation-circle-fill ck-alert-icon"></i>
                    <div>
                        <strong style="display:block; margin-bottom:5px; font-weight:600;">Ada beberapa field yang perlu diperbaiki:</strong>
                        @foreach($errors->all() as $err)
                            <div style="opacity:.8; margin-top:2px;">· {{ $err }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ── Main form + sidebar ─────────────────────── --}}
            <form action="{{ route('booking.store') }}" method="POST" id="booking-form" novalidate>
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->id }}">

                <div class="row g-4 align-items-start">

                    {{-- ═══════ LEFT: Form ═══════ --}}
                    <div class="col-lg-8">

                        {{-- 1 · Jadwal Sesi --}}
                        <div class="ck-card" data-aos="fade-up" data-aos-delay="80" data-aos-duration="650">
                            <div class="ck-card-head">
                                <div class="ck-card-icon">
                                    <i class="bi bi-calendar3"></i>
                                </div>
                                <div>
                                    <div class="ck-card-title">Jadwal Sesi</div>
                                    <div class="ck-card-subtitle">Pilih tanggal & waktu yang kamu inginkan</div>
                                </div>
                                <div class="ck-card-step-num">01 / 04</div>
                            </div>
                            <div class="ck-card-body">
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <div class="ck-field">
                                            <label class="ck-label" for="booking_date">
                                                <i class="bi bi-calendar-event" style="font-size:.75rem; opacity:.7;"></i>
                                                Tanggal Sesi <span class="req">*</span>
                                            </label>
                                            <input type="date"
                                                   id="booking_date"
                                                   name="booking_date"
                                                   class="ck-input @error('booking_date') is-err @enderror"
                                                   value="{{ old('booking_date') }}"
                                                   min="{{ now()->addDay()->format('Y-m-d') }}"
                                                   required>
                                            @error('booking_date')
                                                <div class="ck-err-msg">
                                                    <i class="bi bi-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="ck-field">
                                            <label class="ck-label" for="start_time">
                                                <i class="bi bi-clock" style="font-size:.75rem; opacity:.7;"></i>
                                                Jam Mulai <span class="req">*</span>
                                            </label>
                                            <input type="time"
                                                   id="start_time"
                                                   name="start_time"
                                                   class="ck-input @error('start_time') is-err @enderror"
                                                   value="{{ old('start_time', '08:00') }}"
                                                   min="06:00" max="17:00"
                                                   required>
                                            @error('start_time')
                                                <div class="ck-err-msg">
                                                    <i class="bi bi-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="ck-hint">
                                                <i class="bi bi-info-circle"></i>
                                                Tersedia pukul 06.00 – 17.00 WIB
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Duration pill --}}
                                <div class="ck-duration-row">
                                    <i class="bi bi-hourglass-split"></i>
                                    <span>Durasi: <strong>{{ $package->duration ?? 60 }} menit</strong></span>
                                    <div class="ck-duration-sep"></div>
                                    <i class="bi bi-flag-fill" style="opacity:.7;"></i>
                                    <span>Estimasi selesai: <strong id="end-time-display">—</strong></span>
                                </div>
                            </div>
                        </div>

                        {{-- 2 · Lokasi --}}
                        <div class="ck-card" data-aos="fade-up" data-aos-delay="130" data-aos-duration="650">
                            <div class="ck-card-head">
                                <div class="ck-card-icon">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div>
                                    <div class="ck-card-title">Lokasi Pemotretan</div>
                                    <div class="ck-card-subtitle">Di mana sesi foto akan berlangsung?</div>
                                </div>
                                <div class="ck-card-step-num">02 / 04</div>
                            </div>
                            <div class="ck-card-body">
                                <div class="ck-field">
                                    <label class="ck-label" for="location">
                                        <i class="bi bi-pin-map" style="font-size:.75rem; opacity:.7;"></i>
                                        Nama & Alamat Lokasi <span class="req">*</span>
                                    </label>
                                    <input type="text"
                                           id="location"
                                           name="location"
                                           class="ck-input @error('location') is-err @enderror"
                                           placeholder="Contoh: Gedung Rektorat UNJA, Lt. 2 — Jambi"
                                           value="{{ old('location') }}"
                                           required>
                                    @error('location')
                                        <div class="ck-err-msg">
                                            <i class="bi bi-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="ck-hint">
                                        <i class="bi bi-map"></i>
                                        Tuliskan nama tempat + lantai/titik spesifik agar fotografer langsung tahu posisinya.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 3 · Catatan --}}
                        <div class="ck-card" data-aos="fade-up" data-aos-delay="180" data-aos-duration="650">
                            <div class="ck-card-head">
                                <div class="ck-card-icon">
                                    <i class="bi bi-chat-quote-fill"></i>
                                </div>
                                <div>
                                    <div class="ck-card-title">Catatan & Request</div>
                                    <div class="ck-card-subtitle">Opsional · Ceritakan visi sesi fotomu</div>
                                </div>
                                <div class="ck-card-step-num">03 / 04</div>
                            </div>
                            <div class="ck-card-body">
                                <div class="ck-field">
                                    <label class="ck-label" for="notes">
                                        <i class="bi bi-pencil" style="font-size:.75rem; opacity:.7;"></i>
                                        Catatan Tambahan
                                    </label>
                                    <textarea id="notes"
                                              name="notes"
                                              class="ck-input @error('notes') is-err @enderror"
                                              maxlength="500"
                                              placeholder="Contoh: moodboard referensi Pinterest, warna outfit, request pose, ada properti khusus...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="ck-err-msg">
                                            <i class="bi bi-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="ck-char-count" id="notes-count">0 / 500</div>
                                    <div class="ck-hint">
                                        <i class="bi bi-stars"></i>
                                        Semakin detail request-mu, semakin terarah hasil fotonya.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 4 · Data Pemesan --}}
                        <div class="ck-card" data-aos="fade-up" data-aos-delay="230" data-aos-duration="650">
                            <div class="ck-card-head">
                                <div class="ck-card-icon">
                                    <i class="bi bi-person-badge-fill"></i>
                                </div>
                                <div>
                                    <div class="ck-card-title">Data Pemesan</div>
                                    <div class="ck-card-subtitle">Diambil dari akun kamu</div>
                                </div>
                                <div class="ck-card-step-num">04 / 04</div>
                            </div>
                            <div class="ck-card-body">

                                {{-- User pill --}}
                                <div class="ck-user-row">
                                    <div class="ck-user-avatar">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <div class="ck-user-info">
                                        <div class="ck-user-name">{{ Auth::user()->name }}</div>
                                        <div class="ck-user-email">{{ Auth::user()->email }}</div>
                                    </div>
                                    <div class="ck-user-badge">Pelanggan</div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="ck-field">
                                            <label class="ck-label">Nama Lengkap</label>
                                            <input type="text"
                                                   class="ck-input"
                                                   value="{{ Auth::user()->name }}"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="ck-field">
                                            <label class="ck-label">Email</label>
                                            <input type="text"
                                                   class="ck-input"
                                                   value="{{ Auth::user()->email }}"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="ck-field" style="margin-bottom:0;">
                                            <label class="ck-label" for="phone">
                                                <i class="bi bi-phone" style="font-size:.75rem; opacity:.7;"></i>
                                                No. HP / WhatsApp <span class="req">*</span>
                                            </label>
                                            <input type="tel"
                                                   id="phone"
                                                   name="phone"
                                                   class="ck-input @error('phone') is-err @enderror"
                                                   placeholder="Contoh: 08123456789"
                                                   value="{{ old('phone', Auth::user()->phone ?? '') }}"
                                                   required>
                                            @error('phone')
                                                <div class="ck-err-msg">
                                                    <i class="bi bi-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div class="ck-hint">
                                                <i class="bi bi-whatsapp"></i>
                                                Admin akan menghubungi kamu via WhatsApp di nomor ini.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="ck-hint mt-3">
                                    <i class="bi bi-shield-lock"></i>
                                    Nama & email diambil dari akun. Perlu diubah?
                                    <a href="{{ route('admin.profile') }}"
                                       style="color:var(--gold); text-decoration:none; margin-left:2px; transition:opacity .2s;"
                                       onmouseover="this.style.opacity='.7'"
                                       onmouseout="this.style.opacity='1'">
                                        Edit profil →
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>
                    {{-- end col-lg-8 --}}

                    {{-- ═══════ RIGHT: Summary ═══════ --}}
                    <div class="col-lg-4" data-aos="fade-left" data-aos-delay="120" data-aos-duration="700">
                        <div class="ck-summary">

                            {{-- Hero --}}
                            <div class="ck-sum-hero">
                                <div class="ck-sum-icon">
                                    <i class="bi bi-camera2"></i>
                                </div>
                                <div class="ck-sum-eyebrow">Ringkasan Paket</div>
                                <div class="ck-sum-pkg-name">{{ $package->name }}</div>
                                @if($package->category)
                                    <div class="ck-sum-category">
                                        <i class="bi bi-tag-fill"></i>
                                        {{ $package->category->name }}
                                    </div>
                                @endif
                            </div>

                            <div class="ck-sum-body">

                                {{-- Detail rows --}}
                                <div class="ck-sum-row">
                                    <span class="ck-sum-key"><i class="bi bi-clock"></i> Durasi</span>
                                    <span class="ck-sum-val">{{ $package->duration ?? '—' }} menit</span>
                                </div>
                                <div class="ck-sum-row">
                                    <span class="ck-sum-key"><i class="bi bi-people-fill"></i> Peserta</span>
                                    <span class="ck-sum-val">
                                        @if($package->unlimited_participants)
                                            Tidak Dibatasi
                                        @elseif($package->min_participants == $package->max_participants)
                                            {{ $package->min_participants }} Orang
                                        @else
                                            {{ $package->min_participants }}–{{ $package->max_participants }} Orang
                                        @endif
                                    </span>
                                </div>
                                <div class="ck-sum-row">
                                    <span class="ck-sum-key"><i class="bi bi-cloud-arrow-down"></i> File</span>
                                    <span class="ck-sum-val">Google Drive</span>
                                </div>

                                {{-- Features --}}
                                @php $feats = array_values(array_filter(array_map('trim', explode("\n", $package->features ?? '')))); @endphp
                                @if(count($feats))
                                <div class="ck-sum-row" style="flex-direction:column; align-items:flex-start; gap:10px; border-bottom:none; padding-bottom:0;">
                                    <span class="ck-sum-key" style="color:var(--muted);">
                                        <i class="bi bi-stars"></i> Yang Didapat
                                    </span>
                                    <ul class="ck-sum-feats">
                                        @foreach(array_slice($feats, 0, 6) as $f)
                                            <li>
                                                <i class="bi bi-check-circle-fill"></i>
                                                {{ $f }}
                                            </li>
                                        @endforeach
                                        @if(count($feats) > 6)
                                            <li class="more">
                                                <i class="bi bi-plus-circle-fill"></i>
                                                +{{ count($feats) - 6 }} keuntungan lainnya
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                @endif

                                <div class="ck-sum-divider"></div>

                                {{-- Total --}}
                                <div class="ck-sum-total">
                                    <div>
                                        <div class="ck-sum-total-label">Total Bayar</div>
                                    </div>
                                    <div class="ck-sum-total-price">
                                        Rp {{ number_format($package->price, 0, ',', '.') }}
                                    </div>
                                </div>

                                {{-- CTA --}}
                                <button type="submit" class="ck-submit" id="ck-submit-btn">
                                    <i class="bi bi-calendar-check-fill"></i>
                                    Konfirmasi Booking
                                </button>

                                {{-- Secure badge --}}
                                <div class="ck-secure">
                                    <i class="bi bi-shield-lock-fill"></i>
                                    Data kamu aman &amp; terenkripsi
                                </div>

                                {{-- Back --}}
                                <a href="{{ route('packages.detail', $package->id) }}" class="ck-back">
                                    <i class="bi bi-arrow-left"></i> Kembali ke Detail Paket
                                </a>

                            </div>
                        </div>
                    </div>
                    {{-- end summary sidebar --}}

                </div>
                {{-- end row --}}
            </form>

            {{-- ── Sticky CTA bar — mobile only ── --}}
            <div class="ck-sticky-cta">
                <div class="ck-sticky-price">
                    <div class="ck-sticky-price-label">Total</div>
                    <div class="ck-sticky-price-val">
                        Rp {{ number_format($package->price, 0, ',', '.') }}
                    </div>
                </div>
                <button type="submit" form="booking-form" class="ck-sticky-btn" id="ck-sticky-btn">
                    <i class="bi bi-calendar-check-fill"></i>
                    Konfirmasi Booking
                </button>
            </div>

        </div>
    </section>

</main>
@endsection

@push('js')
<script>
(function () {
    'use strict';

    /* ── Auto-calc end time ────────────────────────────────── */
    const DURATION  = {{ $package->duration ?? 60 }};
    const dateEl    = document.getElementById('booking_date');
    const timeEl    = document.getElementById('start_time');
    const displayEl = document.getElementById('end-time-display');

    function updateEndTime() {
        const t = timeEl?.value;
        if (!t) { if (displayEl) displayEl.textContent = '—'; return; }
        const [h, m] = t.split(':').map(Number);
        const end = new Date(2000, 0, 1, h, m + DURATION);
        const hh  = String(end.getHours()).padStart(2, '0');
        const mm  = String(end.getMinutes()).padStart(2, '0');
        if (displayEl) displayEl.textContent = `${hh}.${mm} WIB`;
    }

    timeEl?.addEventListener('input', updateEndTime);
    dateEl?.addEventListener('change', updateEndTime);
    updateEndTime();

    /* ── Character counter ─────────────────────────────────── */
    const notesEl  = document.getElementById('notes');
    const countEl  = document.getElementById('notes-count');
    const MAX_CHAR = 500;

    function updateCount() {
        const len = notesEl?.value?.length ?? 0;
        if (!countEl) return;
        countEl.textContent = `${len} / ${MAX_CHAR}`;
        countEl.classList.toggle('is-near', len >= MAX_CHAR * 0.8 && len < MAX_CHAR);
        countEl.classList.toggle('is-over', len >= MAX_CHAR);
    }

    notesEl?.addEventListener('input', updateCount);
    updateCount();

    /* ── Real-time validation ──────────────────────────────── */
    document.querySelectorAll('.ck-input[required]').forEach(input => {
        input.addEventListener('blur', function () {
            this.classList.toggle('is-err', !this.value.trim());
        });
        input.addEventListener('input', function () {
            if (this.value.trim()) this.classList.remove('is-err');
        });
    });

    /* ── Prevent double-submit ─────────────────────────────── */
    const form       = document.getElementById('booking-form');
    const submitBtn  = document.getElementById('ck-submit-btn');
    const stickyBtn  = document.getElementById('ck-sticky-btn');
    const loadingHTML = `<span class="spinner-border spinner-border-sm" style="width:.85rem;height:.85rem;border-width:2px;" role="status" aria-hidden="true"></span>&nbsp; Memproses...`;

    form?.addEventListener('submit', function () {
        [submitBtn, stickyBtn].forEach(btn => {
            if (btn) { btn.disabled = true; btn.innerHTML = loadingHTML; }
        });
    });

    /* ── Set date min dynamically ──────────────────────────── */
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const yyyy = tomorrow.getFullYear();
    const mm2  = String(tomorrow.getMonth() + 1).padStart(2, '0');
    const dd2  = String(tomorrow.getDate()).padStart(2, '0');
    if (dateEl) dateEl.min = `${yyyy}-${mm2}-${dd2}`;

    /* ── Subtle card entrance on scroll ───────────────────── */
    if ('IntersectionObserver' in window) {
        const cards = document.querySelectorAll('.ck-card[data-aos]');
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('aos-animate');
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: 0.1 });
        cards.forEach(c => obs.observe(c));
    } else {
        document.querySelectorAll('.ck-card[data-aos]').forEach(c => c.classList.add('aos-animate'));
    }

})();
</script>
@endpush