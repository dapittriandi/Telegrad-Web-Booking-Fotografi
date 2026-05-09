@extends('base.base-root-index')

@push('css')
<style>
/* ══════════════════════════════════════════════════════════════
   CHECKOUT PAGE — Telegrad Luxury Dark
   Inherits: --gold, --gold-light, --gold-dim, --gold-border,
             --bg, --surface, --card, --text, --muted, --border,
             --success, --danger  dari base-root-index
══════════════════════════════════════════════════════════════ */

/* ── Page wrapper ─────────────────────────────────────────── */
.ck-page {
    min-height: 100vh;
    padding: 100px 0 80px;
    background: var(--bg);
    position: relative;
    overflow: hidden;
}

/* Subtle radial glow behind content */
.ck-page::before {
    content: '';
    position: fixed;
    top: -20%;
    right: -10%;
    width: 600px; height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,169,110,.04) 0%, transparent 70%);
    pointer-events: none;
    z-index: 0;
}
.ck-page::after {
    content: '';
    position: fixed;
    bottom: 10%;
    left: -15%;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,169,110,.03) 0%, transparent 70%);
    pointer-events: none;
    z-index: 0;
}

.ck-page .container { position: relative; z-index: 1; }

/* ── Progress Steps ───────────────────────────────────────── */
.ck-steps {
    display: flex;
    align-items: center;
    margin-bottom: 52px;
    gap: 0;
}
.ck-step {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}
.ck-step-num {
    width: 32px; height: 32px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .72rem;
    font-weight: 700;
    border: 1.5px solid rgba(255,255,255,.1);
    color: var(--muted);
    transition: all .3s;
    letter-spacing: .02em;
}
.ck-step-label {
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--muted);
    transition: color .3s;
}
.ck-step.is-active .ck-step-num {
    background: var(--gold);
    color: #0d0d0d;
    border-color: var(--gold);
    box-shadow: 0 0 0 4px rgba(200,169,110,.15);
}
.ck-step.is-active .ck-step-label { color: var(--gold-light); }
.ck-step.is-done .ck-step-num {
    background: var(--success);
    color: #fff;
    border-color: var(--success);
}
.ck-step.is-done .ck-step-label { color: var(--success); }
.ck-step-track {
    flex: 1;
    height: 1px;
    background: rgba(255,255,255,.07);
    margin: 0 14px;
    position: relative;
    overflow: hidden;
}
.ck-step-track::after {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--gold);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform .5s ease;
}
.ck-step.is-done + .ck-step-track::after { transform: scaleX(1); }

/* ── Page header ──────────────────────────────────────────── */
.ck-header { margin-bottom: 36px; }
.ck-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .16em;
    text-transform: uppercase;
    color: var(--gold);
    border: 1px solid var(--gold-border);
    padding: 5px 14px;
    border-radius: 100px;
    margin-bottom: 16px;
    backdrop-filter: blur(8px);
    background: var(--gold-dim);
}
.ck-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.6rem, 2.8vw, 2.1rem);
    font-weight: 700;
    color: var(--text);
    line-height: 1.2;
    margin: 0 0 8px;
    letter-spacing: -.02em;
}
.ck-desc {
    font-size: .875rem;
    color: var(--muted);
    line-height: 1.7;
    max-width: 480px;
    margin: 0;
}

/* ── Flash alerts ─────────────────────────────────────────── */
.ck-alert {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 18px;
    border-radius: 12px;
    font-size: .83rem;
    line-height: 1.6;
    margin-bottom: 24px;
    animation: alertSlide .35s ease both;
}
@keyframes alertSlide {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}
.ck-alert-icon { flex-shrink: 0; margin-top: 1px; font-size: 1rem; }
.ck-alert.is-error {
    background: rgba(224,92,92,.08);
    border: 1px solid rgba(224,92,92,.25);
    color: #f08080;
}
.ck-alert.is-error .ck-alert-icon { color: var(--danger); }
.ck-alert.is-success {
    background: rgba(76,175,130,.08);
    border: 1px solid rgba(76,175,130,.25);
    color: #7de0b4;
}
.ck-alert.is-success .ck-alert-icon { color: var(--success); }

/* ── Form cards ───────────────────────────────────────────── */
.ck-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 20px;
    transition: border-color .25s;
}
.ck-card:focus-within { border-color: var(--gold-border); }

.ck-card-head {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 20px 26px;
    border-bottom: 1px solid var(--border);
}
.ck-card-icon {
    width: 40px; height: 40px;
    border-radius: 11px;
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold);
    font-size: .95rem;
    flex-shrink: 0;
}
.ck-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    font-weight: 700;
    color: var(--text);
    margin: 0;
    line-height: 1;
}
.ck-card-subtitle {
    font-size: .73rem;
    color: var(--muted);
    margin-top: 3px;
}
.ck-card-body { padding: 26px; }

/* ── Fields ───────────────────────────────────────────────── */
.ck-field { margin-bottom: 22px; }
.ck-field:last-child { margin-bottom: 0; }

.ck-label {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .11em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 9px;
}
.ck-label .req { color: var(--danger); font-size: .8rem; margin-left: 1px; }

.ck-input {
    width: 100%;
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.09);
    border-radius: 10px;
    padding: 11px 15px;
    font-size: .875rem;
    color: var(--text);
    outline: none;
    appearance: none;
    -webkit-appearance: none;
    transition: border-color .2s, background .2s, box-shadow .2s;
    font-family: 'DM Sans', sans-serif;
}
[data-theme="light"] .ck-input {
    background: rgba(0,0,0,.02);
    border-color: rgba(0,0,0,.12);
}
.ck-input::placeholder { color: var(--muted); opacity: .7; }
.ck-input:hover { border-color: rgba(255,255,255,.15); }
[data-theme="light"] .ck-input:hover { border-color: rgba(0,0,0,.2); }
.ck-input:focus {
    border-color: var(--gold-border);
    background: rgba(200,169,110,.04);
    box-shadow: 0 0 0 3px rgba(200,169,110,.08);
}
.ck-input.is-err { border-color: rgba(224,92,92,.5) !important; }

select.ck-input {
    cursor: pointer;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238a8070' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 13px center;
    padding-right: 38px;
}
select.ck-input option {
    background: #1a1a1a;
    color: var(--text);
}
[data-theme="light"] select.ck-input option { background: #fff; }

textarea.ck-input {
    resize: vertical;
    min-height: 110px;
    line-height: 1.6;
}

/* Readonly */
.ck-input[readonly] {
    opacity: .5;
    cursor: not-allowed;
    user-select: none;
}
.ck-input[readonly]:focus {
    border-color: rgba(255,255,255,.09) !important;
    box-shadow: none !important;
    background: rgba(255,255,255,.03) !important;
}

.ck-err-msg {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: .73rem;
    color: var(--danger);
    margin-top: 6px;
}
.ck-err-msg::before { content: '⚠'; font-size: .75rem; }

.ck-hint {
    display: flex;
    align-items: flex-start;
    gap: 7px;
    font-size: .73rem;
    color: var(--muted);
    margin-top: 8px;
    line-height: 1.55;
}
.ck-hint i { color: var(--gold); flex-shrink: 0; margin-top: 1px; font-size: .85rem; }

/* ── Duration pill ────────────────────────────────────────── */
.ck-duration-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
    padding: 13px 16px;
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    border-radius: 10px;
    font-size: .82rem;
    color: var(--muted);
}
.ck-duration-row i { color: var(--gold); }
.ck-duration-row strong { color: var(--gold-light); font-weight: 600; }
.ck-duration-sep {
    width: 1px; height: 14px;
    background: var(--gold-border);
    flex-shrink: 0;
}

/* ── Character counter ────────────────────────────────────── */
.ck-char-count {
    font-size: .7rem;
    color: var(--muted);
    text-align: right;
    margin-top: 5px;
    transition: color .2s;
}
.ck-char-count.is-near { color: var(--gold); }
.ck-char-count.is-over { color: var(--danger); }

/* ── Readonly user info card row ──────────────────────────── */
.ck-user-row {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    background: rgba(255,255,255,.02);
    border: 1px solid var(--border);
    border-radius: 10px;
}
[data-theme="light"] .ck-user-row { background: rgba(0,0,0,.02); }
.ck-user-avatar {
    width: 42px; height: 42px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(200,169,110,.3), rgba(200,169,110,.1));
    border: 1px solid var(--gold-border);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold);
    font-size: 1rem;
    font-weight: 700;
    font-family: 'Playfair Display', serif;
    flex-shrink: 0;
}
.ck-user-name { font-size: .88rem; font-weight: 600; color: var(--text); }
.ck-user-email { font-size: .76rem; color: var(--muted); margin-top: 1px; }
.ck-user-badge {
    margin-left: auto;
    font-size: .63rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--gold);
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    padding: 3px 10px;
    border-radius: 100px;
    flex-shrink: 0;
}

/* ── ORDER SUMMARY SIDEBAR ────────────────────────────────── */
.ck-summary {
    background: var(--card);
    border: 1px solid var(--gold-border);
    border-radius: 16px;
    overflow: hidden;
    position: sticky;
    top: 88px;
}

/* Summary hero */
.ck-sum-hero {
    padding: 24px 22px 20px;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(160deg,
        rgba(200,169,110,.06) 0%,
        rgba(200,169,110,.02) 100%);
    position: relative;
    text-align: center;
}
.ck-sum-hero::before {
    content: '';
    position: absolute;
    top: 0; left: 50%; transform: translateX(-50%);
    width: 60%; height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold-border), transparent);
}
.ck-sum-eyebrow {
    font-size: .62rem;
    font-weight: 700;
    letter-spacing: .15em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 8px;
}
.ck-sum-pkg-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--text);
    line-height: 1.3;
    margin-bottom: 6px;
}
.ck-sum-category {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .68rem;
    font-weight: 600;
    letter-spacing: .06em;
    color: var(--gold);
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    padding: 3px 10px;
    border-radius: 100px;
}

/* Summary body */
.ck-sum-body { padding: 18px 20px; }

.ck-sum-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    padding: 9px 0;
    border-bottom: 1px solid rgba(255,255,255,.05);
    font-size: .82rem;
}
[data-theme="light"] .ck-sum-row { border-bottom-color: rgba(0,0,0,.05); }
.ck-sum-row:last-of-type { border-bottom: none; }
.ck-sum-key {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--muted);
    flex-shrink: 0;
}
.ck-sum-key i { color: var(--gold); font-size: .85rem; width: 14px; text-align: center; }
.ck-sum-val {
    color: var(--text);
    font-weight: 500;
    text-align: right;
}

/* Features list */
.ck-sum-feats {
    list-style: none;
    padding: 0; margin: 0;
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.ck-sum-feats li {
    display: flex;
    align-items: flex-start;
    gap: 7px;
    font-size: .77rem;
    color: var(--muted);
    line-height: 1.5;
}
.ck-sum-feats li i { color: var(--success); font-size: .8rem; flex-shrink: 0; margin-top: 2px; }
.ck-sum-feats li.more { color: var(--gold); }
.ck-sum-feats li.more i { color: var(--gold); }

/* Divider */
.ck-sum-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold-border), transparent);
    margin: 4px 0 14px;
}

/* Total */
.ck-sum-total {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 18px;
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    border-radius: 11px;
    margin-bottom: 16px;
}
.ck-sum-total-label {
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--muted);
}
.ck-sum-total-price {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--gold-light);
    letter-spacing: -.02em;
    line-height: 1;
}

/* CTA Button */
.ck-submit {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 14px 24px;
    font-size: .82rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #0d0d0d;
    background: var(--gold);
    border: none;
    border-radius: 11px;
    cursor: pointer;
    transition: background .22s, transform .18s, box-shadow .22s;
    position: relative;
    overflow: hidden;
}
.ck-submit::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,.12) 0%, transparent 60%);
    pointer-events: none;
}
.ck-submit:hover {
    background: var(--gold-light);
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(200,169,110,.3);
}
.ck-submit:active { transform: translateY(0); box-shadow: none; }
.ck-submit:disabled {
    opacity: .7;
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
    font-size: .7rem;
    color: var(--muted);
    margin-top: 12px;
}
.ck-secure i { color: var(--gold); font-size: .78rem; }

/* Back link */
.ck-back {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    margin-top: 14px;
    font-size: .75rem;
    color: var(--muted);
    text-decoration: none;
    transition: color .18s;
}
.ck-back:hover { color: var(--gold); }
.ck-back i { font-size: .8rem; }

/* ══════════════════════════════════════════════════════════════
   RESPONSIVE — TABLET ≤ 991px
══════════════════════════════════════════════════════════════ */
@media (max-width: 991.98px) {
    /* Page spacing */
    .ck-page { padding: 88px 0 120px; } /* bottom space for sticky CTA */

    /* Summary: lepas sticky, pindah ke bawah form */
    .ck-summary {
        position: static;
        margin-top: 4px;
    }

    /* Summary jadi collapsible di tablet — tampilkan versi compact */
    .ck-sum-hero { padding: 18px 20px 14px; }
    .ck-sum-body { padding: 14px 18px; }

    /* Page title sedikit lebih kecil */
    .ck-title { font-size: clamp(1.4rem, 4vw, 1.9rem); }
}

/* ══════════════════════════════════════════════════════════════
   RESPONSIVE — MOBILE ≤ 767px
══════════════════════════════════════════════════════════════ */
@media (max-width: 767.98px) {
    /* Page */
    .ck-page { padding: 76px 0 100px; }

    /* Steps: lebih compact */
    .ck-steps { margin-bottom: 28px; }
    .ck-step-num { width: 28px; height: 28px; font-size: .7rem; }
    .ck-step-track { margin: 0 8px; }

    /* Page header */
    .ck-header { margin-bottom: 20px; }
    .ck-eyebrow { font-size: .6rem; padding: 4px 11px; }
    .ck-title { font-size: 1.5rem; margin-bottom: 6px; }
    .ck-desc { font-size: .82rem; }

    /* Cards */
    .ck-card { border-radius: 12px; margin-bottom: 14px; }
    .ck-card-head { padding: 14px 16px; gap: 10px; }
    .ck-card-icon { width: 34px; height: 34px; border-radius: 9px; font-size: .85rem; }
    .ck-card-title { font-size: .92rem; }
    .ck-card-subtitle { font-size: .68rem; }
    .ck-card-body { padding: 16px; }

    /* Fields */
    .ck-field { margin-bottom: 16px; }
    .ck-label { font-size: .65rem; }
    .ck-input { font-size: .84rem; padding: 10px 13px; }
    .ck-hint { font-size: .7rem; }

    /* Duration row: stack jika perlu */
    .ck-duration-row {
        font-size: .78rem;
        padding: 10px 13px;
        gap: 8px;
        flex-wrap: wrap;
    }
    .ck-duration-sep { display: none; }

    /* User row */
    .ck-user-row { gap: 10px; padding: 12px; }
    .ck-user-avatar { width: 38px; height: 38px; border-radius: 10px; font-size: .9rem; }
    .ck-user-name { font-size: .84rem; }
    .ck-user-email { font-size: .72rem; }
    .ck-user-badge {
        font-size: .58rem;
        padding: 2px 8px;
        /* Jangan overflow di layar sempit */
        white-space: nowrap;
    }

    /* Alert */
    .ck-alert { font-size: .8rem; padding: 12px 14px; gap: 10px; }

    /* Summary: full width, lebih compact */
    .ck-summary { border-radius: 12px; }
    .ck-sum-hero { padding: 16px 16px 14px; }
    .ck-sum-pkg-name { font-size: 1.05rem; }
    .ck-sum-body { padding: 12px 16px 16px; }
    .ck-sum-total { padding: 12px 14px; }
    .ck-sum-total-price { font-size: 1.35rem; }
}

/* ══════════════════════════════════════════════════════════════
   RESPONSIVE — SMALL MOBILE ≤ 575px
══════════════════════════════════════════════════════════════ */
@media (max-width: 575.98px) {
    /* Page */
    .ck-page { padding: 72px 0 96px; }

    /* Steps: nomor saja, tanpa label */
    .ck-step-label { display: none !important; }
    .ck-step-num { width: 26px; height: 26px; font-size: .68rem; }
    .ck-steps { margin-bottom: 24px; }

    /* Cards */
    .ck-card-head { padding: 12px 14px; }
    .ck-card-body { padding: 14px; }
    .ck-card-icon { width: 30px; height: 30px; font-size: .8rem; }

    /* Input touch-friendly */
    .ck-input { padding: 11px 13px; font-size: .85rem; border-radius: 9px; }
    textarea.ck-input { min-height: 90px; }

    /* User badge: hide on very small to prevent overflow */
    .ck-user-badge { display: none; }

    /* Summary total */
    .ck-sum-total-price { font-size: 1.25rem; }
    .ck-sum-feats li { font-size: .74rem; }
}

/* ══════════════════════════════════════════════════════════════
   STICKY BOTTOM CTA — Mobile only
   Tombol submit mengambang di bawah layar, mudah dijangkau jempol
══════════════════════════════════════════════════════════════ */
@media (max-width: 991.98px) {
    /* Sembunyikan tombol submit di dalam summary card */
    .ck-sum-body .ck-submit { display: none; }
    .ck-sum-body .ck-secure { display: none; }

    /* Sticky bar */
    .ck-sticky-cta {
        position: fixed;
        bottom: 0; left: 0; right: 0;
        z-index: 900;
        background: var(--card);
        border-top: 1px solid var(--gold-border);
        padding: 12px 16px;
        padding-bottom: calc(12px + env(safe-area-inset-bottom));
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideUp .3s cubic-bezier(.16,1,.3,1) both;
    }
    @keyframes slideUp {
        from { transform: translateY(100%); opacity: 0; }
        to   { transform: translateY(0); opacity: 1; }
    }

    .ck-sticky-price {
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
    }
    .ck-sticky-price-label {
        font-size: .6rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--muted);
        line-height: 1;
        margin-bottom: 2px;
    }
    .ck-sticky-price-val {
        font-family: 'Playfair Display', serif;
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--gold-light);
        line-height: 1;
    }

    .ck-sticky-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 13px 20px;
        font-size: .8rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #0d0d0d;
        background: var(--gold);
        border: none;
        border-radius: 11px;
        cursor: pointer;
        transition: background .2s, transform .15s;
        position: relative;
        overflow: hidden;
    }
    .ck-sticky-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,.12) 0%, transparent 60%);
        pointer-events: none;
    }
    .ck-sticky-btn:active {
        background: var(--gold-light);
        transform: scale(.98);
    }
    .ck-sticky-btn:disabled {
        opacity: .65;
        cursor: not-allowed;
        transform: none !important;
    }
}

/* Desktop: sembunyikan sticky bar */
@media (min-width: 992px) {
    .ck-sticky-cta { display: none; }
}
</style>
@endpush

@section('content')
<main id="main">

    <section class="ck-page">
        <div class="container">

            {{-- ── Progress Steps ─────────────────────────── --}}
            <div class="ck-steps" data-aos="fade-up" data-aos-duration="600">
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
            <div class="ck-header" data-aos="fade-up" data-aos-delay="50">
                <div class="ck-eyebrow">
                    <i class="bi bi-calendar-check"></i>
                    Pemesanan Sesi Foto
                </div>
                <h1 class="ck-title">Lengkapi Detail Booking</h1>
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

            {{-- ── Validation error summary ─────────────────── --}}
            @if($errors->any())
                <div class="ck-alert is-error" data-aos="fade-down">
                    <i class="bi bi-exclamation-circle-fill ck-alert-icon"></i>
                    <div>
                        <strong style="display:block; margin-bottom:4px;">Ada beberapa field yang perlu diperbaiki:</strong>
                        @foreach($errors->all() as $err)
                            <div style="opacity:.85;">· {{ $err }}</div>
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
                        <div class="ck-card" data-aos="fade-up" data-aos-delay="80">
                            <div class="ck-card-head">
                                <div class="ck-card-icon">
                                    <i class="bi bi-calendar3"></i>
                                </div>
                                <div>
                                    <div class="ck-card-title">Jadwal Sesi</div>
                                    <div class="ck-card-subtitle">Pilih tanggal & waktu yang kamu inginkan</div>
                                </div>
                            </div>
                            <div class="ck-card-body">
                                <div class="row g-3">

                                    {{-- Tanggal --}}
                                    <div class="col-md-6">
                                        <div class="ck-field">
                                            <label class="ck-label" for="booking_date">
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
                                                <div class="ck-err-msg">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Jam Mulai --}}
                                    <div class="col-md-6">
                                        <div class="ck-field">
                                            <label class="ck-label" for="start_time">
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
                                                <div class="ck-err-msg">{{ $message }}</div>
                                            @enderror
                                            <div class="ck-hint">
                                                <i class="bi bi-info-circle"></i>
                                                Tersedia pukul 06.00 – 17.00 WIB
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Estimasi otomatis --}}
                                <div class="ck-duration-row">
                                    <i class="bi bi-clock-history"></i>
                                    <span>Durasi: <strong>{{ $package->duration ?? 60 }} menit</strong></span>
                                    <div class="ck-duration-sep"></div>
                                    <i class="bi bi-flag"></i>
                                    <span>Estimasi selesai: <strong id="end-time-display">—</strong></span>
                                </div>

                            </div>
                        </div>

                        {{-- 2 · Lokasi Pemotretan --}}
                        <div class="ck-card" data-aos="fade-up" data-aos-delay="120">
                            <div class="ck-card-head">
                                <div class="ck-card-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div>
                                    <div class="ck-card-title">Lokasi Pemotretan</div>
                                    <div class="ck-card-subtitle">Di mana sesi foto akan berlangsung?</div>
                                </div>
                            </div>
                            <div class="ck-card-body">
                                <div class="ck-field">
                                    <label class="ck-label" for="location">
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
                                        <div class="ck-err-msg">{{ $message }}</div>
                                    @enderror
                                    <div class="ck-hint">
                                        <i class="bi bi-map"></i>
                                        Tuliskan nama tempat + lantai/titik spesifik agar fotografer langsung tahu posisinya.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 3 · Catatan / Request --}}
                        <div class="ck-card" data-aos="fade-up" data-aos-delay="160">
                            <div class="ck-card-head">
                                <div class="ck-card-icon">
                                    <i class="bi bi-chat-quote"></i>
                                </div>
                                <div>
                                    <div class="ck-card-title">Catatan & Request</div>
                                    <div class="ck-card-subtitle">Opsional · Ceritakan visi sesi fotomu</div>
                                </div>
                            </div>
                            <div class="ck-card-body">
                                <div class="ck-field">
                                    <label class="ck-label" for="notes">Catatan Tambahan</label>
                                    <textarea id="notes"
                                              name="notes"
                                              class="ck-input @error('notes') is-err @enderror"
                                              maxlength="500"
                                              placeholder="Contoh: moodboard referensi Pinterest, warna outfit, request pose, ada properti khusus...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="ck-err-msg">{{ $message }}</div>
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
                        <div class="ck-card" data-aos="fade-up" data-aos-delay="200">
                            <div class="ck-card-head">
                                <div class="ck-card-icon">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <div>
                                    <div class="ck-card-title">Data Pemesan</div>
                                    <div class="ck-card-subtitle">Diambil dari akun kamu</div>
                                </div>
                            </div>
                            <div class="ck-card-body">

                                {{-- User info pill --}}
                                <div class="ck-user-row mb-4">
                                    <div class="ck-user-avatar">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="ck-user-name">{{ Auth::user()->name }}</div>
                                        <div class="ck-user-email">{{ Auth::user()->email }}</div>
                                    </div>
                                    <div class="ck-user-badge">Pelanggan</div>
                                </div>

                                {{-- Hidden readonly fields --}}
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
                                                <div class="ck-err-msg">{{ $message }}</div>
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
                                       style="color:var(--gold); text-decoration:none; margin-left:2px;">
                                        Edit profil →
                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>
                    {{-- end col-lg-8 --}}

                    {{-- ═══════ RIGHT: Summary ═══════ --}}
                    <div class="col-lg-4" data-aos="fade-left" data-aos-delay="100">
                        <div class="ck-summary">

                            {{-- Hero --}}
                            <div class="ck-sum-hero">
                                <div class="ck-sum-eyebrow">Ringkasan Paket</div>
                                <div class="ck-sum-pkg-name">{{ $package->name }}</div>
                                @if($package->category)
                                    <div class="ck-sum-category">
                                        <i class="bi bi-tag"></i>
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
                                    <span class="ck-sum-key"><i class="bi bi-people"></i> Peserta</span>
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
                                    <span class="ck-sum-key"><i class="bi bi-cloud-download"></i> File</span>
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
                                                <i class="bi bi-plus-circle"></i>
                                                +{{ count($feats) - 6 }} keuntungan lainnya
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                @endif

                                <div class="ck-sum-divider"></div>

                                {{-- Total --}}
                                <div class="ck-sum-total">
                                    <div class="ck-sum-total-label">Total Bayar</div>
                                    <div class="ck-sum-total-price">
                                        Rp {{ number_format($package->price, 0, ',', '.') }}
                                    </div>
                                </div>

                                {{-- CTA --}}
                                <button type="submit" class="ck-submit" id="ck-submit-btn">
                                    <i class="bi bi-calendar-check"></i>
                                    Konfirmasi Booking
                                </button>

                                {{-- Secure note --}}
                                <div class="ck-secure">
                                    <i class="bi bi-shield-lock-fill"></i>
                                    Data kamu aman & terenkripsi
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

            {{-- ── Sticky CTA bar — mobile only (hidden on desktop via CSS) ── --}}
            <div class="ck-sticky-cta">
                <div class="ck-sticky-price">
                    <div class="ck-sticky-price-label">Total</div>
                    <div class="ck-sticky-price-val">
                        Rp {{ number_format($package->price, 0, ',', '.') }}
                    </div>
                </div>
                <button type="submit" form="booking-form" class="ck-sticky-btn" id="ck-sticky-btn">
                    <i class="bi bi-calendar-check"></i>
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

    // ── Auto-calc end time ──────────────────────────────────────
    const DURATION  = {{ $package->duration ?? 60 }};
    const dateEl    = document.getElementById('booking_date');
    const timeEl    = document.getElementById('start_time');
    const displayEl = document.getElementById('end-time-display');

    function updateEndTime() {
        const t = timeEl?.value;
        if (!t) { displayEl.textContent = '—'; return; }
        const [h, m] = t.split(':').map(Number);
        const end = new Date(2000, 0, 1, h, m + DURATION);
        const hh = String(end.getHours()).padStart(2, '0');
        const mm = String(end.getMinutes()).padStart(2, '0');
        displayEl.textContent = `${hh}.${mm} WIB`;
    }

    timeEl?.addEventListener('input', updateEndTime);
    dateEl?.addEventListener('change', updateEndTime);
    updateEndTime();

    // ── Character counter ───────────────────────────────────────
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

    // ── Real-time input validation ──────────────────────────────
    document.querySelectorAll('.ck-input[required]').forEach(input => {
        input.addEventListener('blur', function () {
            if (!this.value.trim()) {
                this.classList.add('is-err');
            } else {
                this.classList.remove('is-err');
            }
        });
        input.addEventListener('input', function () {
            if (this.value.trim()) this.classList.remove('is-err');
        });
    });

    // ── Prevent double-submit ───────────────────────────────────
    const form   = document.getElementById('booking-form');
    const submitBtn = document.getElementById('ck-submit-btn');

    const stickyBtn = document.getElementById('ck-sticky-btn');
    const loadingHTML = `<span class="spinner-border spinner-border-sm" style="width:.9rem;height:.9rem;border-width:2px;" role="status" aria-hidden="true"></span> Memproses...`;

    form?.addEventListener('submit', function () {
        [submitBtn, stickyBtn].forEach(btn => {
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = loadingHTML;
            }
        });
    });

    // ── Date min (set dynamically to avoid timezone issues) ─────
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const yyyy = tomorrow.getFullYear();
    const mm2   = String(tomorrow.getMonth() + 1).padStart(2, '0');
    const dd2   = String(tomorrow.getDate()).padStart(2, '0');
    if (dateEl) dateEl.min = `${yyyy}-${mm2}-${dd2}`;

})();
</script>
@endpush