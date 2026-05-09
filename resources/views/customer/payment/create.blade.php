@extends('base.base-root-index')

@push('css')
<style>
/* ══════════════════════════════════════════════════════════════
   PAYMENT PAGE — Telegrad Luxury Dark
   Inherits CSS vars dari base-root-index:
   --gold, --gold-light, --gold-dim, --gold-border,
   --bg, --surface, --card, --text, --muted, --border,
   --success, --danger
══════════════════════════════════════════════════════════════ */

/* ── Page wrapper ─────────────────────────────────────────── */
.py-page {
    min-height: 100vh;
    padding: 100px 0 80px;
    background: var(--bg);
    position: relative;
    overflow: hidden;
}
.py-page::before {
    content: '';
    position: fixed;
    top: -10%; left: -10%;
    width: 500px; height: 500px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,169,110,.035) 0%, transparent 70%);
    pointer-events: none; z-index: 0;
}
.py-page::after {
    content: '';
    position: fixed;
    bottom: 5%; right: -8%;
    width: 420px; height: 420px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(200,169,110,.025) 0%, transparent 70%);
    pointer-events: none; z-index: 0;
}
.py-page .container { position: relative; z-index: 1; }

/* ── Progress Steps ───────────────────────────────────────── */
.py-steps {
    display: flex;
    align-items: center;
    margin-bottom: 48px;
}
.py-step {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}
.py-step-num {
    width: 32px; height: 32px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .72rem; font-weight: 700;
    border: 1.5px solid rgba(255,255,255,.1);
    color: var(--muted);
    transition: all .3s;
}
.py-step-label {
    font-size: .72rem; font-weight: 600;
    letter-spacing: .08em; text-transform: uppercase;
    color: var(--muted);
}
.py-step.is-done .py-step-num {
    background: var(--success); color: #fff;
    border-color: var(--success);
    box-shadow: 0 0 0 4px rgba(76,175,130,.15);
}
.py-step.is-done .py-step-label { color: var(--success); }
.py-step.is-active .py-step-num {
    background: var(--gold); color: #0d0d0d;
    border-color: var(--gold);
    box-shadow: 0 0 0 4px rgba(200,169,110,.15);
}
.py-step.is-active .py-step-label { color: var(--gold-light); }

.py-step-track {
    flex: 1; height: 1px;
    background: rgba(255,255,255,.08);
    margin: 0 14px;
    position: relative; overflow: hidden;
}
.py-step-track.is-done::after {
    content: '';
    position: absolute; inset: 0;
    background: var(--success);
}

/* ── Page Header ──────────────────────────────────────────── */
.py-header { margin-bottom: 36px; }
.py-eyebrow {
    display: inline-flex;
    align-items: center; gap: 7px;
    font-size: .65rem; font-weight: 700;
    letter-spacing: .16em; text-transform: uppercase;
    color: var(--gold);
    border: 1px solid var(--gold-border);
    background: var(--gold-dim);
    padding: 5px 14px; border-radius: 100px;
    margin-bottom: 16px;
    backdrop-filter: blur(8px);
}
.py-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.5rem, 2.8vw, 2rem);
    font-weight: 700; letter-spacing: -.02em;
    color: var(--text); line-height: 1.2;
    margin: 0 0 8px;
}
.py-desc {
    font-size: .875rem; color: var(--muted);
    line-height: 1.7; max-width: 480px; margin: 0;
}

/* ── Alert ────────────────────────────────────────────────── */
.py-alert {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 14px 18px; border-radius: 12px;
    font-size: .83rem; line-height: 1.6;
    margin-bottom: 24px;
    animation: pyAlertIn .3s ease both;
}
@keyframes pyAlertIn {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
}
.py-alert-icon { flex-shrink: 0; font-size: 1rem; margin-top: 1px; }
.py-alert.is-error {
    background: rgba(224,92,92,.08);
    border: 1px solid rgba(224,92,92,.25);
    color: #f08080;
}
.py-alert.is-error .py-alert-icon { color: var(--danger); }
.py-alert.is-success {
    background: rgba(76,175,130,.08);
    border: 1px solid rgba(76,175,130,.25);
    color: #7de0b4;
}
.py-alert.is-success .py-alert-icon { color: var(--success); }

/* ── Form Cards ───────────────────────────────────────────── */
.py-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 20px;
    transition: border-color .25s;
}
.py-card-head {
    display: flex; align-items: center; gap: 14px;
    padding: 20px 26px;
    border-bottom: 1px solid var(--border);
}
.py-card-icon {
    width: 40px; height: 40px; border-radius: 11px;
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: .95rem; flex-shrink: 0;
}
.py-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1rem; font-weight: 700;
    color: var(--text); margin: 0; line-height: 1;
}
.py-card-subtitle {
    font-size: .73rem; color: var(--muted); margin-top: 3px;
}
.py-card-body { padding: 26px; }

/* ── Method Tabs ──────────────────────────────────────────── */
.py-methods {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-bottom: 24px;
}
.py-method {
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.09);
    border-radius: 12px;
    padding: 16px 12px 14px;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s, background .2s, box-shadow .2s;
    user-select: none;
    position: relative;
    overflow: hidden;
}
[data-theme="light"] .py-method {
    background: rgba(0,0,0,.02);
    border-color: rgba(0,0,0,.1);
}
.py-method::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--gold-dim);
    opacity: 0;
    transition: opacity .2s;
}
.py-method:hover::before { opacity: 1; }
.py-method:hover { border-color: var(--gold-border); }
.py-method.is-active {
    border-color: var(--gold);
    box-shadow: 0 0 0 1px var(--gold-border), 0 4px 16px rgba(200,169,110,.12);
}
.py-method.is-active::before { opacity: 1; }
.py-method-check {
    position: absolute; top: 8px; right: 8px;
    width: 16px; height: 16px; border-radius: 50%;
    background: var(--gold); color: #0d0d0d;
    font-size: .55rem;
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transform: scale(0);
    transition: opacity .2s, transform .25s cubic-bezier(.34,1.56,.64,1);
}
.py-method.is-active .py-method-check {
    opacity: 1; transform: scale(1);
}
.py-method-icon {
    position: relative; z-index: 1;
    font-size: 1.5rem; color: var(--muted);
    display: block; margin-bottom: 8px;
    transition: color .2s;
}
.py-method.is-active .py-method-icon,
.py-method:hover .py-method-icon { color: var(--gold); }
.py-method-label {
    position: relative; z-index: 1;
    font-size: .78rem; font-weight: 600;
    color: var(--muted);
    transition: color .2s;
}
.py-method.is-active .py-method-label,
.py-method:hover .py-method-label { color: var(--text); }

/* ── Method Info Panels ───────────────────────────────────── */
.py-method-panel { display: none; }
.py-method-panel.is-show { display: block; }

/* Bank info */
.py-bank-box {
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.09);
    border-radius: 12px;
    padding: 20px 22px;
}
[data-theme="light"] .py-bank-box {
    background: rgba(0,0,0,.02);
    border-color: rgba(0,0,0,.1);
}
.py-bank-name {
    font-size: .75rem; font-weight: 700;
    letter-spacing: .08em; text-transform: uppercase;
    color: var(--muted); margin-bottom: 10px;
}
.py-bank-num {
    font-family: 'DM Mono', 'Courier New', monospace;
    font-size: 1.3rem; font-weight: 500;
    color: var(--gold-light);
    letter-spacing: .12em;
    line-height: 1;
}
.py-bank-holder {
    font-size: .78rem; color: var(--muted);
    margin-top: 5px;
}
.py-copy-btn {
    display: inline-flex; align-items: center; gap: 6px;
    margin-top: 14px;
    font-size: .73rem; font-weight: 700;
    color: var(--gold);
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    padding: 5px 14px; border-radius: 100px;
    cursor: pointer;
    transition: background .18s, transform .15s;
}
.py-copy-btn:hover {
    background: rgba(200,169,110,.2);
    transform: translateY(-1px);
}
.py-copy-btn:active { transform: none; }

/* QRIS box */
.py-qris-box {
    display: flex; flex-direction: column; align-items: center;
    padding: 24px;
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.09);
    border-radius: 12px;
    text-align: center;
    gap: 14px;
}
.py-qris-box img {
    width: 100%; max-width: 200px;
    border-radius: 12px;
    border: 1px solid var(--gold-border);
    background: #fff;
    padding: 8px;
}
.py-qris-hint { font-size: .78rem; color: var(--muted); line-height: 1.6; }

/* Cash box */
.py-cash-box {
    display: flex; gap: 14px; align-items: flex-start;
    padding: 18px 20px;
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.09);
    border-radius: 12px;
}
.py-cash-icon {
    width: 44px; height: 44px; border-radius: 12px;
    background: rgba(76,175,130,.1);
    border: 1px solid rgba(76,175,130,.2);
    display: flex; align-items: center; justify-content: center;
    color: var(--success); font-size: 1.2rem; flex-shrink: 0;
}
.py-cash-text { font-size: .83rem; color: var(--muted); line-height: 1.7; }
.py-cash-text strong { color: var(--text); display: block; margin-bottom: 4px; font-size: .88rem; }

/* Empty state */
.py-empty-state {
    padding: 20px; text-align: center;
    font-size: .82rem; color: var(--muted);
}
.py-empty-state i { font-size: 2rem; color: var(--gold-border); display: block; margin-bottom: 8px; }

/* ── Upload Zone ──────────────────────────────────────────── */
.py-upload-zone {
    border: 2px dashed rgba(255,255,255,.1);
    border-radius: 14px;
    padding: 44px 24px;
    text-align: center;
    cursor: pointer;
    position: relative;
    transition: border-color .2s, background .2s;
}
[data-theme="light"] .py-upload-zone { border-color: rgba(0,0,0,.12); }
.py-upload-zone:hover,
.py-upload-zone.is-drag { border-color: var(--gold-border); background: var(--gold-dim); }
.py-upload-zone input[type="file"] {
    position: absolute; inset: 0;
    opacity: 0; cursor: pointer; width: 100%; height: 100%;
}
.py-upload-cloud {
    font-size: 2.8rem; color: var(--gold-border);
    display: block; margin-bottom: 14px;
    transition: color .2s, transform .2s;
}
.py-upload-zone:hover .py-upload-cloud {
    color: var(--gold); transform: translateY(-3px);
}
.py-upload-main {
    font-size: .88rem; color: var(--muted);
    margin-bottom: 5px;
}
.py-upload-main strong { color: var(--gold); }
.py-upload-hint { font-size: .73rem; color: var(--muted); opacity: .7; }

/* Preview */
.py-preview {
    display: none;
    margin-top: 16px;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid var(--gold-border);
    position: relative;
}
.py-preview img {
    width: 100%; max-height: 280px;
    object-fit: contain;
    background: rgba(0,0,0,.4);
    display: block;
}
.py-preview-bar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 14px;
    background: rgba(0,0,0,.3);
    backdrop-filter: blur(6px);
    border-top: 1px solid rgba(255,255,255,.06);
}
.py-preview-name {
    font-size: .75rem; color: var(--muted);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    max-width: 200px;
}
.py-preview-name strong { color: var(--text); display: block; font-size: .82rem; }
.py-preview-remove {
    display: flex; align-items: center; gap: 5px;
    font-size: .73rem; color: var(--danger);
    background: rgba(224,92,92,.1);
    border: 1px solid rgba(224,92,92,.2);
    padding: 4px 10px; border-radius: 100px;
    cursor: pointer; transition: background .15s;
    white-space: nowrap; flex-shrink: 0;
}
.py-preview-remove:hover { background: rgba(224,92,92,.2); }

/* Upload success state */
.py-upload-success {
    display: none;
    align-items: center; gap: 10px;
    padding: 12px 16px;
    background: rgba(76,175,130,.08);
    border: 1px solid rgba(76,175,130,.2);
    border-radius: 10px;
    margin-top: 10px;
}
.py-upload-success i { color: var(--success); font-size: 1rem; flex-shrink: 0; }
.py-upload-success span { font-size: .8rem; color: var(--muted); }

/* Error msg */
.py-err { font-size: .73rem; color: var(--danger); margin-top: 6px; display: flex; align-items: center; gap: 5px; }
.py-err::before { content: '⚠'; }

/* ── Guide Steps ──────────────────────────────────────────── */
.py-guide {
    list-style: none;
    padding: 0; margin: 0;
    display: flex; flex-direction: column; gap: 0;
    counter-reset: guide;
}
.py-guide-item {
    display: flex; align-items: flex-start; gap: 14px;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
    counter-increment: guide;
}
.py-guide-item:last-child { border-bottom: none; padding-bottom: 0; }
.py-guide-num {
    width: 26px; height: 26px; border-radius: 50%;
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    color: var(--gold);
    font-size: .7rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; margin-top: 1px;
}
.py-guide-text {
    font-size: .83rem; color: var(--muted);
    line-height: 1.6; flex: 1;
}
.py-guide-text strong { color: var(--gold); }

/* ── Order Summary Sidebar ────────────────────────────────── */
.py-summary {
    background: var(--card);
    border: 1px solid var(--gold-border);
    border-radius: 16px;
    overflow: hidden;
    position: sticky;
    top: 88px;
}

/* Hero */
.py-sum-hero {
    padding: 22px 20px 18px;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(160deg,
        rgba(200,169,110,.07) 0%,
        rgba(200,169,110,.02) 100%);
    text-align: center;
    position: relative;
}
.py-sum-hero::before {
    content: '';
    position: absolute; top: 0; left: 50%; transform: translateX(-50%);
    width: 60%; height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold-border), transparent);
}
.py-sum-eyebrow {
    font-size: .62rem; font-weight: 700;
    letter-spacing: .15em; text-transform: uppercase;
    color: var(--muted); margin-bottom: 8px;
}
.py-sum-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem; font-weight: 700;
    color: var(--text); line-height: 1.3; margin-bottom: 6px;
}
.py-sum-cat {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: .68rem; font-weight: 600;
    color: var(--gold); background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    padding: 3px 10px; border-radius: 100px;
}

/* Rows */
.py-sum-body { padding: 16px 18px; }
.py-sum-row {
    display: flex; justify-content: space-between; align-items: flex-start;
    gap: 10px; padding: 8px 0;
    border-bottom: 1px solid rgba(255,255,255,.05);
    font-size: .81rem;
}
[data-theme="light"] .py-sum-row { border-bottom-color: rgba(0,0,0,.05); }
.py-sum-row:last-of-type { border-bottom: none; }
.py-sum-key {
    display: flex; align-items: center; gap: 7px;
    color: var(--muted); flex-shrink: 0;
}
.py-sum-key i { color: var(--gold); font-size: .82rem; width: 13px; text-align: center; }
.py-sum-val { color: var(--text); font-weight: 500; text-align: right; max-width: 130px; }

/* Status badge */
.py-status {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: .68rem; font-weight: 700;
    padding: 3px 9px; border-radius: 100px;
    text-transform: uppercase; letter-spacing: .05em;
}
.py-status-pending {
    background: rgba(224,169,53,.12);
    border: 1px solid rgba(224,169,53,.3);
    color: #e0a935;
}
.py-status-confirmed {
    background: rgba(76,175,130,.12);
    border: 1px solid rgba(76,175,130,.3);
    color: var(--success);
}

/* Divider */
.py-sum-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold-border), transparent);
    margin: 4px 0 14px;
}

/* Total */
.py-sum-total {
    display: flex; justify-content: space-between; align-items: center;
    padding: 14px 16px;
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    border-radius: 11px; margin-bottom: 14px;
}
.py-sum-total-label {
    font-size: .67rem; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase;
    color: var(--muted);
}
.py-sum-total-price {
    font-family: 'Playfair Display', serif;
    font-size: 1.45rem; font-weight: 800;
    color: var(--gold-light); letter-spacing: -.02em; line-height: 1;
}

/* CTA */
.py-submit {
    display: flex; align-items: center; justify-content: center; gap: 9px;
    width: 100%; padding: 14px 20px;
    font-size: .8rem; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    color: #0d0d0d; background: var(--gold);
    border: none; border-radius: 11px; cursor: pointer;
    transition: background .2s, transform .18s, box-shadow .2s;
    position: relative; overflow: hidden;
}
.py-submit::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,.14) 0%, transparent 55%);
    pointer-events: none;
}
.py-submit:hover {
    background: var(--gold-light);
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(200,169,110,.3);
}
.py-submit:active { transform: none; box-shadow: none; }
.py-submit:disabled { opacity: .6; cursor: not-allowed; transform: none !important; box-shadow: none !important; }

/* Secure + back */
.py-secure {
    display: flex; align-items: center; justify-content: center; gap: 5px;
    font-size: .7rem; color: var(--muted); margin-top: 11px;
}
.py-secure i { color: var(--gold); font-size: .75rem; }
.py-back-link {
    display: flex; align-items: center; justify-content: center; gap: 5px;
    margin-top: 12px; font-size: .74rem;
    color: var(--muted); text-decoration: none;
    transition: color .18s;
}
.py-back-link:hover { color: var(--gold); }

/* ══════════════════════════════════════════════════════════════
   RESPONSIVE — Tablet ≤ 991px
══════════════════════════════════════════════════════════════ */
@media (max-width: 991.98px) {
    .py-page    { padding: 88px 0 110px; }
    .py-summary { position: static; margin-top: 4px; }
    .py-sum-hero { padding: 16px 18px 14px; }
    .py-sum-body { padding: 14px 16px; }
    .py-title   { font-size: clamp(1.4rem, 4vw, 1.8rem); }

    /* Hide desktop submit in summary, show sticky */
    .py-sum-body .py-submit   { display: none; }
    .py-sum-body .py-secure   { display: none; }

    /* Sticky CTA bar */
    .py-sticky-cta {
        position: fixed;
        bottom: 0; left: 0; right: 0; z-index: 900;
        background: var(--card);
        border-top: 1px solid var(--gold-border);
        padding: 12px 16px;
        padding-bottom: calc(12px + env(safe-area-inset-bottom));
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        display: flex; align-items: center; gap: 12px;
        animation: pySlideUp .3s cubic-bezier(.16,1,.3,1) both;
    }
    @keyframes pySlideUp {
        from { transform: translateY(100%); opacity: 0; }
        to   { transform: translateY(0); opacity: 1; }
    }
    .py-sticky-price { display: flex; flex-direction: column; flex-shrink: 0; }
    .py-sticky-price-label {
        font-size: .58rem; font-weight: 700; letter-spacing: .1em;
        text-transform: uppercase; color: var(--muted); line-height: 1; margin-bottom: 2px;
    }
    .py-sticky-price-val {
        font-family: 'Playfair Display', serif;
        font-size: 1rem; font-weight: 800; color: var(--gold-light); line-height: 1;
    }
    .py-sticky-btn {
        flex: 1;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        padding: 13px 18px;
        font-size: .78rem; font-weight: 700;
        letter-spacing: .08em; text-transform: uppercase;
        color: #0d0d0d; background: var(--gold);
        border: none; border-radius: 11px; cursor: pointer;
        transition: background .2s, transform .15s;
        position: relative; overflow: hidden;
    }
    .py-sticky-btn::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,.12) 0%, transparent 60%);
        pointer-events: none;
    }
    .py-sticky-btn:active { background: var(--gold-light); transform: scale(.98); }
    .py-sticky-btn:disabled { opacity: .65; cursor: not-allowed; transform: none !important; }
}
@media (min-width: 992px) {
    .py-sticky-cta { display: none; }
}

/* ── Mobile ≤ 767px ───────────────────────────────────────── */
@media (max-width: 767.98px) {
    .py-page    { padding: 76px 0 100px; }
    .py-steps   { margin-bottom: 28px; }
    .py-step-num { width: 28px; height: 28px; font-size: .7rem; }
    .py-step-track { margin: 0 8px; }
    .py-header  { margin-bottom: 20px; }
    .py-eyebrow { font-size: .6rem; padding: 4px 11px; }
    .py-title   { font-size: 1.45rem; }
    .py-desc    { font-size: .82rem; }

    .py-card    { border-radius: 12px; margin-bottom: 14px; }
    .py-card-head { padding: 14px 16px; gap: 10px; }
    .py-card-icon { width: 34px; height: 34px; border-radius: 9px; font-size: .85rem; }
    .py-card-title  { font-size: .92rem; }
    .py-card-subtitle { font-size: .68rem; }
    .py-card-body { padding: 16px; }

    /* Methods: 3-col stays, but smaller */
    .py-methods { gap: 8px; }
    .py-method  { padding: 13px 8px 11px; border-radius: 10px; }
    .py-method-icon  { font-size: 1.25rem; margin-bottom: 6px; }
    .py-method-label { font-size: .72rem; }

    .py-upload-zone { padding: 30px 16px; border-radius: 11px; }
    .py-upload-cloud { font-size: 2.2rem; margin-bottom: 10px; }
    .py-upload-main { font-size: .82rem; }

    .py-bank-num { font-size: 1.1rem; letter-spacing: .08em; }
    .py-guide-item { gap: 10px; padding: 10px 0; }
    .py-guide-text { font-size: .8rem; }

    .py-sum-total-price { font-size: 1.3rem; }
    .py-sum-name { font-size: 1rem; }
}

/* ── Small Mobile ≤ 575px ─────────────────────────────────── */
@media (max-width: 575.98px) {
    .py-page    { padding: 72px 0 96px; }
    .py-step-label { display: none !important; }
    .py-step-num   { width: 26px; height: 26px; font-size: .68rem; }
    .py-steps  { margin-bottom: 22px; }

    .py-card-head { padding: 12px 14px; }
    .py-card-body { padding: 14px; }
    .py-card-icon { width: 30px; height: 30px; font-size: .8rem; }

    /* Methods: 2-col on small */
    .py-methods { grid-template-columns: 1fr 1fr 1fr; }
    .py-method-label { font-size: .65rem; }

    .py-upload-zone { padding: 26px 14px; }
    .py-preview-name { max-width: 130px; }

    .py-sum-total-price { font-size: 1.2rem; }
    .py-bank-num { font-size: 1rem; }
}
</style>
@endpush

@section('content')
<main id="main">

    {{-- ── Breadcrumb ──────────────────────────────────────── --}}
    <div class="breadcrumbs d-flex align-items-center"
         style="background-image: url('{{ asset('root/assets/img/breadcrumbs-bg.jpg') }}');">
        <div class="container position-relative d-flex flex-column align-items-center text-center" data-aos="fade">
            <h2>Pembayaran</h2>
            <ol>
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li><a href="{{ route('customer.orders') }}">Pesanan Saya</a></li>
                <li>Pembayaran</li>
            </ol>
        </div>
    </div>

    <section class="py-page">
        <div class="container">

            {{-- ── Steps ──────────────────────────────────── --}}
            <div class="py-steps" data-aos="fade-up" data-aos-duration="600">
                <div class="py-step is-done">
                    <div class="py-step-num"><i class="bi bi-check"></i></div>
                    <span class="py-step-label d-none d-sm-block">Isi Data</span>
                </div>
                <div class="py-step-track is-done"></div>
                <div class="py-step is-active">
                    <div class="py-step-num">2</div>
                    <span class="py-step-label d-none d-sm-block">Pembayaran</span>
                </div>
                <div class="py-step-track"></div>
                <div class="py-step">
                    <div class="py-step-num">3</div>
                    <span class="py-step-label d-none d-sm-block">Konfirmasi</span>
                </div>
            </div>

            {{-- ── Page Header ─────────────────────────────── --}}
            <div class="py-header" data-aos="fade-up" data-aos-delay="50">
                <div class="py-eyebrow">
                    <i class="bi bi-credit-card"></i>
                    Pembayaran
                </div>
                <h1 class="py-title">Upload Bukti Pembayaran</h1>
                <p class="py-desc">
                    Transfer ke rekening di bawah, lalu upload bukti transfer.
                    Admin akan memverifikasi dalam 1×24 jam.
                </p>
            </div>

            {{-- ── Flash Messages ──────────────────────────── --}}
            @if(session('error'))
            <div class="py-alert is-error" data-aos="fade-down">
                <i class="bi bi-exclamation-triangle-fill py-alert-icon"></i>
                <div>{{ session('error') }}</div>
            </div>
            @endif
            @if(session('success'))
            <div class="py-alert is-success" data-aos="fade-down">
                <i class="bi bi-check-circle-fill py-alert-icon"></i>
                <div>{{ session('success') }}</div>
            </div>
            @endif
            @if($errors->any())
            <div class="py-alert is-error" data-aos="fade-down">
                <i class="bi bi-exclamation-circle-fill py-alert-icon"></i>
                <div>
                    <strong style="display:block; margin-bottom:4px;">Periksa kembali form kamu:</strong>
                    @foreach($errors->all() as $err)
                        <div style="opacity:.85;">· {{ $err }}</div>
                    @endforeach
                </div>
            </div>
            @endif

            <form action="{{ route('customer.payment.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="payment-form"
                  novalidate>
                @csrf
                <input type="hidden" name="order_id"        value="{{ $order->id }}">
                <input type="hidden" name="payment_method"  id="py_method_input" value="transfer">

                <div class="row g-4 align-items-start">

                    {{-- ═══════ LEFT ═══════ --}}
                    <div class="col-lg-8">

                        {{-- 1 · Metode Pembayaran --}}
                        <div class="py-card" data-aos="fade-up" data-aos-delay="80">
                            <div class="py-card-head">
                                <div class="py-card-icon">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                                <div>
                                    <div class="py-card-title">Metode Pembayaran</div>
                                    <div class="py-card-subtitle">Pilih cara transfer yang kamu inginkan</div>
                                </div>
                            </div>
                            <div class="py-card-body">

                                {{-- Method tabs --}}
                                <div class="py-methods">
                                    <div class="py-method is-active" data-method="transfer" onclick="pySelectMethod(this)">
                                        <div class="py-method-check"><i class="bi bi-check"></i></div>
                                        <i class="bi bi-bank py-method-icon"></i>
                                        <div class="py-method-label">Transfer Bank</div>
                                    </div>
                                    <div class="py-method" data-method="qris" onclick="pySelectMethod(this)">
                                        <div class="py-method-check"><i class="bi bi-check"></i></div>
                                        <i class="bi bi-qr-code-scan py-method-icon"></i>
                                        <div class="py-method-label">QRIS</div>
                                    </div>
                                    <div class="py-method" data-method="cash" onclick="pySelectMethod(this)">
                                        <div class="py-method-check"><i class="bi bi-check"></i></div>
                                        <i class="bi bi-cash-coin py-method-icon"></i>
                                        <div class="py-method-label">Cash / COD</div>
                                    </div>
                                </div>

                                {{-- Transfer Panel --}}
                                <div id="panel-transfer" class="py-method-panel is-show">
                                    @if($web->bank_name || $web->bank_account_number)
                                    <div class="py-bank-box">
                                        <div class="py-bank-name">{{ $web->bank_name ?? 'Nama Bank' }}</div>
                                        <div class="py-bank-num" id="rek-number">{{ $web->bank_account_number ?? '-' }}</div>
                                        <div class="py-bank-holder">a.n. {{ $web->bank_account_name ?? '-' }}</div>
                                        <button type="button" class="py-copy-btn" onclick="pyCopyRek()">
                                            <i class="bi bi-clipboard" id="copy-icon"></i>
                                            <span id="copy-label">Salin Nomor Rekening</span>
                                        </button>
                                    </div>
                                    @else
                                    <div class="py-empty-state">
                                        <i class="bi bi-bank"></i>
                                        Info rekening belum dikonfigurasi admin.
                                    </div>
                                    @endif
                                </div>

                                {{-- QRIS Panel --}}
                                <div id="panel-qris" class="py-method-panel">
                                    @if($web->site_qris && $web->site_qris !== 'site_qris.png')
                                    <div class="py-qris-box">
                                        <div style="font-size:.75rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:var(--muted);">Scan QRIS Berikut</div>
                                        <img src="{{ asset('storage/images/default/' . $web->site_qris) }}"
                                             alt="QRIS Telegrad">
                                        <p class="py-qris-hint">
                                            Screenshot atau scan QR di atas menggunakan app pembayaran, lalu upload bukti di bawah.
                                        </p>
                                    </div>
                                    @else
                                    <div class="py-empty-state">
                                        <i class="bi bi-qr-code"></i>
                                        QRIS belum dikonfigurasi admin.
                                    </div>
                                    @endif
                                </div>

                                {{-- Cash Panel --}}
                                <div id="panel-cash" class="py-method-panel">
                                    <div class="py-cash-box">
                                        <div class="py-cash-icon"><i class="bi bi-cash-coin"></i></div>
                                        <div class="py-cash-text">
                                            <strong>Pembayaran Cash / COD</strong>
                                            Bayar langsung di lokasi sesi foto saat bertemu fotografer.
                                            Pastikan kamu membawa uang tunai sesuai total.
                                            Upload foto konfirmasi (screenshot chat / nota) sebagai bukti.
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- 2 · Upload Bukti --}}
                        <div class="py-card" data-aos="fade-up" data-aos-delay="120">
                            <div class="py-card-head">
                                <div class="py-card-icon">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                </div>
                                <div>
                                    <div class="py-card-title">Bukti Pembayaran</div>
                                    <div class="py-card-subtitle">Upload screenshot atau foto transfer kamu</div>
                                </div>
                            </div>
                            <div class="py-card-body">

                                <div class="py-upload-zone" id="py-upload-zone">
                                    <input type="file"
                                           name="payment_proof"
                                           id="payment_proof"
                                           accept="image/jpg,image/jpeg,image/png"
                                           onchange="pyPreviewProof(event)">
                                    <i class="bi bi-cloud-arrow-up py-upload-cloud"></i>
                                    <div class="py-upload-main">
                                        <strong>Klik untuk pilih file</strong> atau drag & drop di sini
                                    </div>
                                    <div class="py-upload-hint">JPG, JPEG, PNG &middot; Maks. 2MB</div>
                                </div>

                                {{-- Preview --}}
                                <div class="py-preview" id="py-preview">
                                    <img id="py-preview-img" src="" alt="Preview bukti pembayaran">
                                    <div class="py-preview-bar">
                                        <div class="py-preview-name">
                                            <strong id="py-preview-filename">file.jpg</strong>
                                            <span id="py-preview-size"></span>
                                        </div>
                                        <button type="button" class="py-preview-remove" onclick="pyRemoveProof()">
                                            <i class="bi bi-x-circle"></i> Hapus
                                        </button>
                                    </div>
                                </div>

                                @error('payment_proof')
                                    <div class="py-err">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>

                        {{-- 3 · Panduan --}}
                        <div class="py-card" data-aos="fade-up" data-aos-delay="160">
                            <div class="py-card-head">
                                <div class="py-card-icon">
                                    <i class="bi bi-info-circle"></i>
                                </div>
                                <div>
                                    <div class="py-card-title">Panduan Pembayaran</div>
                                    <div class="py-card-subtitle">Ikuti langkah berikut dengan benar</div>
                                </div>
                            </div>
                            <div class="py-card-body">
                                <ol class="py-guide">
                                    <li class="py-guide-item">
                                        <div class="py-guide-num">1</div>
                                        <div class="py-guide-text">Pilih metode pembayaran yang sesuai.</div>
                                    </li>
                                    <li class="py-guide-item">
                                        <div class="py-guide-num">2</div>
                                        <div class="py-guide-text">Transfer sesuai total yang tertera di ringkasan pesanan di samping.</div>
                                    </li>
                                    <li class="py-guide-item">
                                        <div class="py-guide-num">3</div>
                                        <div class="py-guide-text">Ambil screenshot atau foto bukti transfer dari aplikasi bankmu.</div>
                                    </li>
                                    <li class="py-guide-item">
                                        <div class="py-guide-num">4</div>
                                        <div class="py-guide-text">Upload bukti pembayaran di kolom di atas (JPG/PNG, maks 2MB).</div>
                                    </li>
                                    <li class="py-guide-item">
                                        <div class="py-guide-num">5</div>
                                        <div class="py-guide-text">Klik tombol <strong>Kirim Pembayaran</strong> dan tunggu verifikasi admin dalam 1×24 jam.</div>
                                    </li>
                                </ol>
                            </div>
                        </div>

                    </div>
                    {{-- end col-lg-8 --}}

                    {{-- ═══════ RIGHT: Summary ═══════ --}}
                    <div class="col-lg-4" data-aos="fade-left" data-aos-delay="100">
                        <div class="py-summary">

                            <div class="py-sum-hero">
                                <div class="py-sum-eyebrow">Ringkasan Pesanan</div>
                                <div class="py-sum-name">{{ $order->package->name ?? '-' }}</div>
                                @if($order->package->category ?? null)
                                    <div class="py-sum-cat">
                                        <i class="bi bi-tag"></i>
                                        {{ $order->package->category->name }}
                                    </div>
                                @endif
                            </div>

                            <div class="py-sum-body">

                                <div class="py-sum-row">
                                    <span class="py-sum-key"><i class="bi bi-hash"></i> ID Order</span>
                                    <span class="py-sum-val">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="py-sum-row">
                                    <span class="py-sum-key"><i class="bi bi-calendar3"></i> Tanggal</span>
                                    <span class="py-sum-val">{{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('D MMM YYYY') }}</span>
                                </div>
                                <div class="py-sum-row">
                                    <span class="py-sum-key"><i class="bi bi-clock"></i> Waktu</span>
                                    <span class="py-sum-val">
                                        {{ \Carbon\Carbon::parse($order->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($order->end_time)->format('H:i') }} WIB
                                    </span>
                                </div>
                                <div class="py-sum-row">
                                    <span class="py-sum-key"><i class="bi bi-geo-alt"></i> Lokasi</span>
                                    <span class="py-sum-val">{{ $order->location ?? '-' }}</span>
                                </div>
                                <div class="py-sum-row">
                                    <span class="py-sum-key"><i class="bi bi-clock-history"></i> Durasi</span>
                                    <span class="py-sum-val">{{ $order->package->duration ?? '-' }} menit</span>
                                </div>
                                <div class="py-sum-row">
                                    <span class="py-sum-key"><i class="bi bi-flag"></i> Status</span>
                                    <span class="py-sum-val">
                                        <span class="py-status py-status-pending">
                                            <i class="bi bi-hourglass-split"></i> Menunggu
                                        </span>
                                    </span>
                                </div>

                                <div class="py-sum-divider"></div>

                                <div class="py-sum-total">
                                    <div class="py-sum-total-label">Total Bayar</div>
                                    <div class="py-sum-total-price">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </div>
                                </div>

                                <button type="submit" class="py-submit" id="py-submit-btn">
                                    <i class="bi bi-send-check"></i>
                                    Kirim Pembayaran
                                </button>

                                <div class="py-secure">
                                    <i class="bi bi-shield-lock-fill"></i>
                                    Data kamu aman & terenkripsi
                                </div>

                                <a href="{{ route('customer.orders') }}" class="py-back-link">
                                    <i class="bi bi-list-ul"></i> Lihat Semua Pesanan
                                </a>

                            </div>
                        </div>
                    </div>

                </div>
                {{-- end row --}}
            </form>

            {{-- ── Sticky CTA bar — mobile only ── --}}
            <div class="py-sticky-cta">
                <div class="py-sticky-price">
                    <div class="py-sticky-price-label">Total</div>
                    <div class="py-sticky-price-val">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </div>
                </div>
                <button type="submit" form="payment-form" class="py-sticky-btn" id="py-sticky-btn">
                    <i class="bi bi-send-check"></i>
                    Kirim Pembayaran
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

    // ── Method selection ────────────────────────────────────────
    window.pySelectMethod = function (el) {
        document.querySelectorAll('.py-method').forEach(m => m.classList.remove('is-active'));
        el.classList.add('is-active');

        const method = el.dataset.method;
        document.getElementById('py_method_input').value = method;

        document.querySelectorAll('.py-method-panel').forEach(p => p.classList.remove('is-show'));
        const panel = document.getElementById('panel-' + method);
        if (panel) {
            panel.classList.add('is-show');
            panel.style.animation = 'none';
            requestAnimationFrame(() => {
                panel.style.animation = 'pyAlertIn .25s ease both';
            });
        }
    };

    // ── Preview proof ───────────────────────────────────────────
    window.pyPreviewProof = function (event) {
        const file = event.target.files[0];
        if (!file) return;

        // Size check (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file melebihi 2MB. Silakan pilih file yang lebih kecil.');
            event.target.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('py-preview-img').src = e.target.result;
            document.getElementById('py-preview-filename').textContent = file.name;
            document.getElementById('py-preview-size').textContent =
                '(' + (file.size / 1024).toFixed(0) + ' KB)';
            document.getElementById('py-preview').style.display = 'block';
            document.getElementById('py-upload-zone').style.display = 'none';
        };
        reader.readAsDataURL(file);
    };

    window.pyRemoveProof = function () {
        document.getElementById('payment_proof').value = '';
        document.getElementById('py-preview').style.display = 'none';
        document.getElementById('py-upload-zone').style.display = 'block';
    };

    // ── Copy rekening ───────────────────────────────────────────
    window.pyCopyRek = function () {
        const num = document.getElementById('rek-number')?.textContent?.replace(/\s/g, '') ?? '';
        if (!num) return;
        navigator.clipboard.writeText(num).then(() => {
            const icon  = document.getElementById('copy-icon');
            const label = document.getElementById('copy-label');
            icon.className  = 'bi bi-check2';
            label.textContent = 'Tersalin!';
            setTimeout(() => {
                icon.className  = 'bi bi-clipboard';
                label.textContent = 'Salin Nomor Rekening';
            }, 2200);
        }).catch(() => {
            // Fallback for older browsers
            const ta = document.createElement('textarea');
            ta.value = num; ta.style.position = 'fixed'; ta.style.opacity = '0';
            document.body.appendChild(ta); ta.focus(); ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
        });
    };

    // ── Drag & drop ─────────────────────────────────────────────
    const zone = document.getElementById('py-upload-zone');
    if (zone) {
        zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('is-drag'); });
        zone.addEventListener('dragleave', ()  => zone.classList.remove('is-drag'));
        zone.addEventListener('drop', e => {
            e.preventDefault(); zone.classList.remove('is-drag');
            const file = e.dataTransfer.files[0];
            if (!file) return;
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('payment_proof').files = dt.files;
            pyPreviewProof({ target: { files: [file] } });
        });
    }

    // ── Prevent double submit — sync both buttons ───────────────
    const loadingHTML = `<span class="spinner-border spinner-border-sm" style="width:.85rem;height:.85rem;border-width:2px;" role="status" aria-hidden="true"></span> Mengirim...`;

    document.getElementById('payment-form')?.addEventListener('submit', function () {
        ['py-submit-btn', 'py-sticky-btn'].forEach(id => {
            const btn = document.getElementById(id);
            if (btn) { btn.disabled = true; btn.innerHTML = loadingHTML; }
        });
    });

})();
</script>
@endpush