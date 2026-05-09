@extends('base.base-root-index')

@push('css')
<style>
/* ══════════════════════════════════════════════════════════════
   PAYMENT PAGE — Telegrad Premium v2
   Konsisten dengan checkout page (Cormorant Garamond + Sora)
══════════════════════════════════════════════════════════════ */

@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Sora:wght@300;400;500;600;700&display=swap');

/* ── Variables ────────────────────────────────────────────── */
:root {
    --gold:         #c8a96e;
    --gold-light:   #e0c88a;
    --gold-dim:     rgba(200,169,110,.07);
    --gold-border:  rgba(200,169,110,.22);
    --surface:      #111111;
    --card:         #161616;
    --border:       rgba(255,255,255,.07);
    --text:         #f0ece4;
    --muted:        #7a7570;
    --success:      #4caf82;
    --danger:       #e05c5c;
    --font-display: 'Cormorant Garamond', Georgia, serif;
    --font-body:    'Sora', system-ui, sans-serif;
    --font-mono:    'DM Mono', 'Courier New', monospace;
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
.py-page {
    min-height: 100vh;
    padding: 104px 0 80px;
    background: var(--surface);
    position: relative;
    font-family: var(--font-body);
}

/* Ambient orbs */
.py-orb {
    position: fixed;
    border-radius: 50%;
    pointer-events: none;
    z-index: 0;
}
.py-orb-1 {
    width: 600px; height: 600px;
    top: -15%; left: -12%;
    background: radial-gradient(circle, rgba(200,169,110,.05) 0%, transparent 65%);
    animation: pyOrb1 20s ease-in-out infinite alternate;
}
.py-orb-2 {
    width: 500px; height: 500px;
    bottom: 5%; right: -10%;
    background: radial-gradient(circle, rgba(200,169,110,.04) 0%, transparent 65%);
    animation: pyOrb2 24s ease-in-out infinite alternate;
}
@keyframes pyOrb1 {
    from { transform: translate(0,0) scale(1); }
    to   { transform: translate(30px,-30px) scale(1.06); }
}
@keyframes pyOrb2 {
    from { transform: translate(0,0) scale(1); }
    to   { transform: translate(-25px,35px) scale(1.04); }
}
.py-page > .container { position: relative; z-index: 1; }

/* ── Progress Steps ───────────────────────────────────────── */
.py-steps {
    display: flex;
    align-items: center;
    margin-bottom: 48px;
    animation: pyFadeUp .65s var(--ease-out) both;
}
.py-step {
    display: flex; align-items: center; gap: 10px; flex-shrink: 0;
}
.py-step-num {
    width: 34px; height: 34px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .7rem; font-weight: 700;
    font-family: var(--font-body);
    border: 1.5px solid rgba(255,255,255,.1);
    color: var(--muted);
    transition: all .4s var(--ease-spring);
}
[data-theme="light"] .py-step-num { border-color: rgba(0,0,0,.15); }
.py-step-label {
    font-size: .67rem; font-weight: 600;
    letter-spacing: .1em; text-transform: uppercase;
    color: var(--muted); transition: color .3s;
}
.py-step.is-done .py-step-num {
    background: var(--success); color: #fff;
    border-color: var(--success);
    box-shadow: 0 0 0 5px rgba(76,175,130,.1);
}
.py-step.is-done .py-step-label { color: var(--success); }
.py-step.is-active .py-step-num {
    background: var(--gold); color: #0d0a06;
    border-color: var(--gold);
    box-shadow: 0 0 0 5px rgba(200,169,110,.12), 0 4px 16px rgba(200,169,110,.25);
}
.py-step.is-active .py-step-label { color: var(--gold-light); }

.py-step-track {
    flex: 1; height: 1px; margin: 0 12px;
    background: rgba(255,255,255,.08);
    position: relative; overflow: hidden; border-radius: 1px;
}
[data-theme="light"] .py-step-track { background: rgba(0,0,0,.12); }
.py-step-track.is-done::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(90deg, var(--success), #6fcfa0);
}

/* ── Page Header ──────────────────────────────────────────── */
.py-header {
    margin-bottom: 36px;
    animation: pyFadeUp .65s var(--ease-out) .08s both;
}
.py-eyebrow {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: .63rem; font-weight: 600;
    letter-spacing: .18em; text-transform: uppercase;
    color: var(--gold);
    border: 1px solid var(--gold-border);
    padding: 5px 15px; border-radius: 100px;
    margin-bottom: 16px;
    backdrop-filter: blur(12px);
    background: var(--gold-dim);
}
.py-title {
    font-family: var(--font-display);
    font-size: clamp(1.7rem, 3vw, 2.4rem);
    font-weight: 600; letter-spacing: -.01em;
    color: var(--text); line-height: 1.15; margin: 0 0 10px;
}
.py-title em { font-style: italic; color: var(--gold); font-weight: 400; }
.py-desc {
    font-size: .84rem; color: var(--muted);
    line-height: 1.75; max-width: 460px; margin: 0; font-weight: 300;
}

/* ── Alerts ───────────────────────────────────────────────── */
.py-alert {
    display: flex; align-items: flex-start; gap: 13px;
    padding: 15px 20px; border-radius: var(--radius-md);
    font-size: .82rem; line-height: 1.65;
    margin-bottom: 24px;
    animation: pyFadeUp .4s var(--ease-out) both;
    backdrop-filter: blur(8px);
}
.py-alert-icon { flex-shrink: 0; font-size: 1rem; margin-top: 1px; }
.py-alert.is-error {
    background: rgba(224,92,92,.07);
    border: 1px solid rgba(224,92,92,.2); color: #f08080;
}
.py-alert.is-error .py-alert-icon { color: var(--danger); }
.py-alert.is-success {
    background: rgba(76,175,130,.07);
    border: 1px solid rgba(76,175,130,.2); color: #7de0b4;
}
.py-alert.is-success .py-alert-icon { color: var(--success); }

/* ── Cards ────────────────────────────────────────────────── */
.py-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden; margin-bottom: 18px;
    transition: border-color .3s, box-shadow .3s;
    position: relative;
}
.py-card::before {
    content: '';
    position: absolute; inset: 0; border-radius: inherit;
    background: linear-gradient(135deg, rgba(255,255,255,.012) 0%, transparent 50%);
    pointer-events: none;
}
.py-card:hover { border-color: rgba(200,169,110,.14); }
.py-card:focus-within {
    border-color: var(--gold-border);
    box-shadow: 0 0 0 1px var(--gold-border), 0 8px 40px rgba(0,0,0,.2);
}

.py-card-head {
    display: flex; align-items: center; gap: 14px;
    padding: 20px 24px;
    border-bottom: 1px solid var(--border);
    position: relative;
}
.py-card-head::after {
    content: '';
    position: absolute; bottom: 0; left: 24px; right: 24px;
    height: 1px;
    background: linear-gradient(90deg, var(--gold-border), transparent);
    opacity: .5;
}
.py-card-icon {
    width: 42px; height: 42px; border-radius: 12px;
    background: var(--gold-dim); border: 1px solid var(--gold-border);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: 1rem; flex-shrink: 0;
    transition: background .25s, box-shadow .25s;
}
.py-card:focus-within .py-card-icon {
    background: rgba(200,169,110,.12);
    box-shadow: 0 0 12px rgba(200,169,110,.15);
}
.py-card-title {
    font-family: var(--font-display);
    font-size: 1.05rem; font-weight: 600;
    color: var(--text); margin: 0; line-height: 1.1;
}
.py-card-subtitle {
    font-size: .7rem; color: var(--muted); margin-top: 4px; font-weight: 300;
}
.py-card-step {
    margin-left: auto;
    font-size: .6rem; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase;
    color: var(--muted); opacity: .45;
    font-family: var(--font-body);
}
.py-card-body { padding: 24px; }

/* ── Payment Method Tabs ──────────────────────────────────── */
.py-methods {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px; margin-bottom: 24px;
}
.py-method {
    background: rgba(255,255,255,.025);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: var(--radius-sm);
    padding: 18px 12px 16px;
    text-align: center; cursor: pointer;
    transition: border-color .25s, background .25s, box-shadow .25s;
    user-select: none; position: relative; overflow: hidden;
}
[data-theme="light"] .py-method {
    background: rgba(0,0,0,.02); border-color: rgba(0,0,0,.1);
}
.py-method::before {
    content: ''; position: absolute; inset: 0;
    background: var(--gold-dim); opacity: 0; transition: opacity .25s;
}
.py-method:hover::before { opacity: 1; }
.py-method:hover { border-color: var(--gold-border); }
.py-method.is-active {
    border-color: var(--gold);
    box-shadow: 0 0 0 1px var(--gold-border), 0 4px 20px rgba(200,169,110,.14);
}
.py-method.is-active::before { opacity: 1; }

/* Checkmark tick */
.py-method-check {
    position: absolute; top: 8px; right: 8px;
    width: 17px; height: 17px; border-radius: 50%;
    background: var(--gold); color: #0d0a06;
    font-size: .56rem;
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transform: scale(0);
    transition: opacity .2s, transform .25s var(--ease-spring);
}
.py-method.is-active .py-method-check { opacity: 1; transform: scale(1); }

.py-method-icon {
    position: relative; z-index: 1;
    font-size: 1.55rem; color: var(--muted);
    display: block; margin-bottom: 9px;
    transition: color .2s;
}
.py-method.is-active .py-method-icon,
.py-method:hover .py-method-icon { color: var(--gold); }
.py-method-label {
    position: relative; z-index: 1;
    font-size: .76rem; font-weight: 600; color: var(--muted);
    transition: color .2s;
}
.py-method.is-active .py-method-label,
.py-method:hover .py-method-label { color: var(--text); }

/* ── Method Panels ────────────────────────────────────────── */
.py-method-panel { display: none; }
.py-method-panel.is-show {
    display: block;
    animation: pyFadeUp .25s var(--ease-out) both;
}

/* Bank box */
.py-bank-box {
    background: rgba(200,169,110,.04);
    border: 1px solid var(--gold-border);
    border-radius: var(--radius-sm);
    padding: 20px 22px;
    position: relative; overflow: hidden;
}
.py-bank-box::before {
    content: '';
    position: absolute; left: 0; top: 0; bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, var(--gold), var(--gold-light));
    border-radius: 0 2px 2px 0;
}
[data-theme="light"] .py-bank-box { background: rgba(200,169,110,.04); }

.py-bank-name {
    font-size: .68rem; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    color: var(--muted); margin-bottom: 10px;
}
.py-bank-num {
    font-family: var(--font-mono);
    font-size: 1.35rem; font-weight: 500;
    color: var(--gold-light); letter-spacing: .14em; line-height: 1;
}
[data-theme="light"] .py-bank-num { color: var(--gold); }
.py-bank-holder {
    font-size: .76rem; color: var(--muted); margin-top: 5px; font-weight: 300;
}
.py-copy-btn {
    display: inline-flex; align-items: center; gap: 6px;
    margin-top: 14px;
    font-size: .71rem; font-weight: 700;
    color: var(--gold);
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    padding: 5px 14px; border-radius: 100px; cursor: pointer;
    transition: background .2s, transform .18s var(--ease-spring);
    font-family: var(--font-body);
}
.py-copy-btn:hover { background: rgba(200,169,110,.14); transform: translateY(-1px); }
.py-copy-btn:active { transform: none; }

/* QRIS */
.py-qris-box {
    display: flex; flex-direction: column; align-items: center;
    padding: 28px 24px;
    background: rgba(255,255,255,.02);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    text-align: center; gap: 14px;
}
.py-qris-box img {
    width: 100%; max-width: 200px;
    border-radius: var(--radius-sm);
    border: 1px solid var(--gold-border);
    background: #fff; padding: 8px;
}
.py-qris-hint { font-size: .78rem; color: var(--muted); line-height: 1.65; font-weight: 300; }

/* Cash */
.py-cash-box {
    display: flex; gap: 14px; align-items: flex-start;
    padding: 18px 20px;
    background: rgba(76,175,130,.04);
    border: 1px solid rgba(76,175,130,.18);
    border-radius: var(--radius-sm);
}
.py-cash-icon {
    width: 44px; height: 44px; border-radius: 12px;
    background: rgba(76,175,130,.1);
    border: 1px solid rgba(76,175,130,.2);
    display: flex; align-items: center; justify-content: center;
    color: var(--success); font-size: 1.2rem; flex-shrink: 0;
}
.py-cash-text { font-size: .82rem; color: var(--muted); line-height: 1.7; font-weight: 300; }
.py-cash-text strong { color: var(--text); display: block; margin-bottom: 4px; font-size: .87rem; font-weight: 600; }

/* Empty state */
.py-empty-state {
    padding: 24px; text-align: center;
    font-size: .82rem; color: var(--muted);
}
.py-empty-state i { font-size: 2rem; color: var(--gold-border); display: block; margin-bottom: 8px; opacity: .5; }

/* ── Upload Zone ──────────────────────────────────────────── */
.py-upload-zone {
    border: 2px dashed rgba(255,255,255,.1);
    border-radius: var(--radius-md);
    padding: 44px 24px;
    text-align: center; cursor: pointer;
    position: relative;
    transition: border-color .25s, background .25s;
}
[data-theme="light"] .py-upload-zone { border-color: rgba(0,0,0,.12); }
.py-upload-zone:hover,
.py-upload-zone.is-drag {
    border-color: var(--gold-border);
    background: var(--gold-dim);
}
.py-upload-zone input[type="file"] {
    position: absolute; inset: 0;
    opacity: 0; cursor: pointer; width: 100%; height: 100%;
}
.py-upload-cloud {
    font-size: 2.8rem; color: var(--gold-border);
    display: block; margin-bottom: 14px;
    transition: color .25s, transform .25s var(--ease-spring);
}
.py-upload-zone:hover .py-upload-cloud {
    color: var(--gold); transform: translateY(-4px);
}
.py-upload-main {
    font-size: .87rem; color: var(--muted); margin-bottom: 5px;
}
.py-upload-main strong { color: var(--gold); font-weight: 600; }
.py-upload-hint { font-size: .72rem; color: var(--muted); opacity: .6; }

/* Preview */
.py-preview {
    display: none; margin-top: 16px;
    border-radius: var(--radius-sm);
    overflow: hidden; border: 1px solid var(--gold-border);
    position: relative;
}
.py-preview img {
    width: 100%; max-height: 280px;
    object-fit: contain;
    background: rgba(0,0,0,.4); display: block;
}
.py-preview-bar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 14px;
    background: rgba(0,0,0,.3);
    backdrop-filter: blur(6px);
    border-top: 1px solid rgba(255,255,255,.06);
}
[data-theme="light"] .py-preview-bar { background: rgba(0,0,0,.06); }
.py-preview-name {
    font-size: .74rem; color: var(--muted);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;
}
.py-preview-name strong { color: var(--text); display: block; font-size: .8rem; }
.py-preview-remove {
    display: flex; align-items: center; gap: 5px;
    font-size: .72rem; color: var(--danger);
    background: rgba(224,92,92,.1); border: 1px solid rgba(224,92,92,.2);
    padding: 4px 10px; border-radius: 100px;
    cursor: pointer; transition: background .15s;
    white-space: nowrap; flex-shrink: 0; font-family: var(--font-body);
}
.py-preview-remove:hover { background: rgba(224,92,92,.2); }

.py-err {
    font-size: .72rem; color: var(--danger);
    margin-top: 6px; display: flex; align-items: center; gap: 5px; font-weight: 500;
}
.py-err::before { content: '⚠'; font-size: .75rem; }

/* ── Guide Steps ──────────────────────────────────────────── */
.py-guide {
    list-style: none; padding: 0; margin: 0;
    display: flex; flex-direction: column; gap: 0;
}
.py-guide-item {
    display: flex; align-items: flex-start; gap: 14px;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
}
.py-guide-item:last-child { border-bottom: none; padding-bottom: 0; }
.py-guide-num {
    width: 26px; height: 26px; border-radius: 50%;
    background: var(--gold-dim); border: 1px solid var(--gold-border);
    color: var(--gold); font-size: .68rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; margin-top: 1px;
}
.py-guide-text {
    font-size: .82rem; color: var(--muted); line-height: 1.65; flex: 1; font-weight: 300;
}
.py-guide-text strong { color: var(--gold); font-weight: 600; }

/* ── Order Summary Sidebar ────────────────────────────────── */
.py-summary {
    background: var(--card);
    border: 1px solid var(--gold-border);
    border-radius: var(--radius-lg);
    overflow: hidden; position: sticky; top: 92px;
    transition: box-shadow .3s;
}
.py-summary:hover {
    box-shadow: 0 16px 60px rgba(0,0,0,.3), 0 0 0 1px var(--gold-border);
}

.py-sum-hero {
    padding: 26px 22px 20px;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(160deg, rgba(200,169,110,.08) 0%, rgba(200,169,110,.02) 100%);
    text-align: center; position: relative;
}
.py-sum-hero::before {
    content: '';
    position: absolute; top: 0; left: 50%; transform: translateX(-50%);
    width: 70%; height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold-border), transparent);
}

/* Icon di hero summary */
.py-sum-icon {
    width: 50px; height: 50px; border-radius: 14px;
    background: var(--gold-dim); border: 1px solid var(--gold-border);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: 1.2rem;
    margin: 0 auto 14px;
    box-shadow: 0 4px 20px rgba(200,169,110,.12);
}
.py-sum-eyebrow {
    font-size: .6rem; font-weight: 700;
    letter-spacing: .18em; text-transform: uppercase;
    color: var(--muted); margin-bottom: 8px;
}
.py-sum-name {
    font-family: var(--font-display);
    font-size: 1.2rem; font-weight: 600;
    color: var(--text); line-height: 1.25; margin-bottom: 8px;
}
.py-sum-cat {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: .65rem; font-weight: 600;
    color: var(--gold); background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    padding: 3px 11px; border-radius: 100px;
}

.py-sum-body { padding: 16px 18px 20px; }
.py-sum-row {
    display: flex; justify-content: space-between; align-items: flex-start;
    gap: 10px; padding: 8px 0;
    border-bottom: 1px solid rgba(255,255,255,.04);
    font-size: .8rem;
}
[data-theme="light"] .py-sum-row { border-bottom-color: rgba(0,0,0,.05); }
.py-sum-row:last-of-type { border-bottom: none; }
.py-sum-key {
    display: flex; align-items: center; gap: 7px;
    color: var(--muted); flex-shrink: 0; font-weight: 400;
}
.py-sum-key i { color: var(--gold); font-size: .8rem; width: 13px; text-align: center; opacity: .85; }
.py-sum-val { color: var(--text); font-weight: 500; text-align: right; max-width: 140px; }

/* Status badges */
.py-status {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: .63rem; font-weight: 700;
    padding: 3px 9px; border-radius: 100px;
    text-transform: uppercase; letter-spacing: .06em;
}
.py-status-pending {
    background: rgba(224,169,53,.1);
    border: 1px solid rgba(224,169,53,.25);
    color: #e0a935;
}
.py-status-confirmed {
    background: rgba(76,175,130,.1);
    border: 1px solid rgba(76,175,130,.25);
    color: var(--success);
}

.py-sum-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--gold-border), transparent);
    margin: 8px 0 14px;
}

.py-sum-total {
    display: flex; justify-content: space-between; align-items: center;
    padding: 15px 16px;
    background: var(--gold-dim); border: 1px solid var(--gold-border);
    border-radius: var(--radius-sm); margin-bottom: 16px;
    position: relative; overflow: hidden;
}
.py-sum-total::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(200,169,110,.06) 0%, transparent 60%);
    pointer-events: none;
}
.py-sum-total-label {
    font-size: .62rem; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase; color: var(--muted);
}
.py-sum-total-price {
    font-family: var(--font-display);
    font-size: 1.55rem; font-weight: 600;
    color: var(--gold-light); letter-spacing: -.01em; line-height: 1;
}
[data-theme="light"] .py-sum-total-price { color: var(--gold); }

/* Submit CTA */
.py-submit {
    display: flex; align-items: center; justify-content: center; gap: 10px;
    width: 100%; padding: 15px 24px;
    font-size: .78rem; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase;
    color: #0d0a06;
    background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
    border: none; border-radius: var(--radius-sm); cursor: pointer;
    transition: transform .22s var(--ease-spring), box-shadow .22s, opacity .2s;
    position: relative; overflow: hidden; font-family: var(--font-body);
}
.py-submit::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(180deg, rgba(255,255,255,.18) 0%, transparent 55%);
    pointer-events: none;
}
.py-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 36px rgba(200,169,110,.35), 0 4px 12px rgba(0,0,0,.2);
}
.py-submit:active { transform: translateY(0) scale(.98); }
.py-submit:disabled { opacity: .65; cursor: not-allowed; transform: none !important; box-shadow: none !important; }

.py-secure {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    font-size: .68rem; color: var(--muted); margin-top: 12px;
    font-weight: 400; letter-spacing: .03em;
}
.py-secure i { color: var(--gold); font-size: .76rem; opacity: .85; }

.py-back-link {
    display: flex; align-items: center; justify-content: center; gap: 5px;
    margin-top: 14px; font-size: .73rem;
    color: var(--muted); text-decoration: none;
    transition: color .2s; font-weight: 400;
}
.py-back-link:hover { color: var(--gold); }

/* ── Animations ───────────────────────────────────────────── */
@keyframes pyFadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
.py-card[data-aos] {
    opacity: 0; transform: translateY(20px);
    transition: opacity .55s var(--ease-out), transform .55s var(--ease-out), border-color .3s, box-shadow .3s;
}
.py-card[data-aos].aos-animate { opacity: 1; transform: translateY(0); }

/* ══════════════════════════════════════════════════════════════
   RESPONSIVE — Tablet ≤ 991px
══════════════════════════════════════════════════════════════ */
@media (max-width: 991.98px) {
    .py-page    { padding: 88px 0 60px; }
    .py-summary { position: static; margin-top: 4px; }
    .py-sum-hero { padding: 20px 20px 16px; }
    .py-sum-body { padding: 14px 18px 18px; }
    .py-title   { font-size: clamp(1.5rem, 4.5vw, 2rem); }
}

/* Desktop: sembunyikan sticky bar */
@media (min-width: 0px) {
    .py-sticky-cta { display: none !important; }
}

/* ── Mobile ≤ 767px ───────────────────────────────────────── */
@media (max-width: 767.98px) {
    .py-page    { padding: 78px 0 50px; }
    .py-steps   { margin-bottom: 30px; }
    .py-step-num { width: 30px; height: 30px; font-size: .68rem; }
    .py-step-track { margin: 0 8px; }
    .py-header  { margin-bottom: 24px; }
    .py-eyebrow { font-size: .6rem; padding: 4px 12px; }
    .py-title   { font-size: 1.55rem; margin-bottom: 8px; }
    .py-desc    { font-size: .8rem; }

    .py-card    { border-radius: var(--radius-md); margin-bottom: 14px; }
    .py-card-head { padding: 16px 18px; gap: 11px; }
    .py-card-icon { width: 36px; height: 36px; border-radius: 10px; font-size: .9rem; }
    .py-card-title  { font-size: .95rem; }
    .py-card-subtitle { font-size: .67rem; }
    .py-card-body { padding: 18px; }
    .py-card-step { display: none; }

    .py-methods { gap: 8px; }
    .py-method  { padding: 14px 8px 12px; border-radius: var(--radius-sm); }
    .py-method-icon  { font-size: 1.3rem; margin-bottom: 6px; }
    .py-method-label { font-size: .72rem; }

    .py-upload-zone { padding: 32px 16px; border-radius: var(--radius-sm); }
    .py-upload-cloud { font-size: 2.2rem; margin-bottom: 10px; }
    .py-upload-main { font-size: .82rem; }

    .py-bank-num { font-size: 1.1rem; letter-spacing: .08em; }
    .py-guide-item { gap: 10px; padding: 10px 0; }
    .py-guide-text { font-size: .8rem; }

    .py-sum-total-price { font-size: 1.4rem; }
    .py-sum-name { font-size: 1.05rem; }
    .py-sum-icon { width: 44px; height: 44px; border-radius: 12px; font-size: 1rem; }
    .py-summary { border-radius: var(--radius-md); }
}

/* ── Small Mobile ≤ 575px ─────────────────────────────────── */
@media (max-width: 575.98px) {
    .py-page    { padding: 72px 0 40px; }
    .py-step-label { display: none !important; }
    .py-step-num   { width: 28px; height: 28px; font-size: .67rem; }
    .py-steps  { margin-bottom: 26px; }
    .py-card-head { padding: 13px 15px; }
    .py-card-body { padding: 15px; }
    .py-card-icon { width: 32px; height: 32px; font-size: .82rem; }
    .py-upload-zone { padding: 26px 14px; }
    .py-preview-name { max-width: 130px; }
    .py-sum-total-price { font-size: 1.3rem; }
    .py-bank-num { font-size: 1rem; }
    .py-methods { gap: 7px; }
    .py-method-label { font-size: .65rem; }
}
</style>
@endpush

@section('content')
<main id="main">

    {{-- Ambient orbs --}}
    <div class="py-orb py-orb-1" aria-hidden="true"></div>
    <div class="py-orb py-orb-2" aria-hidden="true"></div>

    <section class="py-page">
        <div class="container">

            {{-- ── Steps ──────────────────────────────────── --}}
            <div class="py-steps" data-aos="fade-up" data-aos-duration="700">
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
            <div class="py-header" data-aos="fade-up" data-aos-delay="60">
                <div class="py-eyebrow">
                    <i class="bi bi-credit-card"></i>
                    Pembayaran
                </div>
                <h1 class="py-title">Upload Bukti <em>Pembayaran</em></h1>
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
                    <strong style="display:block; margin-bottom:5px; font-weight:600;">Periksa kembali form kamu:</strong>
                    @foreach($errors->all() as $err)
                        <div style="opacity:.8; margin-top:2px;">· {{ $err }}</div>
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
                <input type="hidden" name="order_id"       value="{{ $order->id }}">
                <input type="hidden" name="payment_method" id="py_method_input" value="transfer">

                <div class="row g-4 align-items-start">

                    {{-- ═══════ LEFT ═══════ --}}
                    <div class="col-lg-8">

                        {{-- 1 · Metode Pembayaran --}}
                        <div class="py-card" data-aos="fade-up" data-aos-delay="80" data-aos-duration="650">
                            <div class="py-card-head">
                                <div class="py-card-icon"><i class="bi bi-wallet2"></i></div>
                                <div>
                                    <div class="py-card-title">Metode Pembayaran</div>
                                    <div class="py-card-subtitle">Pilih cara transfer yang kamu inginkan</div>
                                </div>
                                <div class="py-card-step">01 / 03</div>
                            </div>
                            <div class="py-card-body">

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
                                        <div style="font-size:.68rem; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--muted);">Scan QRIS Berikut</div>
                                        <img src="{{ asset('storage/images/default/' . $web->site_qris) }}" alt="QRIS Telegrad">
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
                        <div class="py-card" data-aos="fade-up" data-aos-delay="130" data-aos-duration="650">
                            <div class="py-card-head">
                                <div class="py-card-icon"><i class="bi bi-cloud-arrow-up-fill"></i></div>
                                <div>
                                    <div class="py-card-title">Bukti Pembayaran</div>
                                    <div class="py-card-subtitle">Upload screenshot atau foto transfer kamu</div>
                                </div>
                                <div class="py-card-step">02 / 03</div>
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
                                        <strong>Klik untuk pilih file</strong> atau drag &amp; drop di sini
                                    </div>
                                    <div class="py-upload-hint">JPG, JPEG, PNG &middot; Maks. 2MB</div>
                                </div>

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
                        <div class="py-card" data-aos="fade-up" data-aos-delay="180" data-aos-duration="650">
                            <div class="py-card-head">
                                <div class="py-card-icon"><i class="bi bi-info-circle-fill"></i></div>
                                <div>
                                    <div class="py-card-title">Panduan Pembayaran</div>
                                    <div class="py-card-subtitle">Ikuti langkah berikut dengan benar</div>
                                </div>
                                <div class="py-card-step">03 / 03</div>
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
                    <div class="col-lg-4" data-aos="fade-left" data-aos-delay="120" data-aos-duration="700">
                        <div class="py-summary">

                            <div class="py-sum-hero">
                                <div class="py-sum-icon">
                                    <i class="bi bi-receipt"></i>
                                </div>
                                <div class="py-sum-eyebrow">Ringkasan Pesanan</div>
                                <div class="py-sum-name">{{ $order->package->name ?? '-' }}</div>
                                @if($order->package->category ?? null)
                                    <div class="py-sum-cat">
                                        <i class="bi bi-tag-fill"></i>
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
                                    <span class="py-sum-key"><i class="bi bi-geo-alt-fill"></i> Lokasi</span>
                                    <span class="py-sum-val">{{ $order->location ?? '-' }}</span>
                                </div>
                                <div class="py-sum-row">
                                    <span class="py-sum-key"><i class="bi bi-hourglass-split"></i> Durasi</span>
                                    <span class="py-sum-val">{{ $order->package->duration ?? '-' }} menit</span>
                                </div>
                                <div class="py-sum-row">
                                    <span class="py-sum-key"><i class="bi bi-flag-fill"></i> Status</span>
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
                                    <i class="bi bi-send-check-fill"></i>
                                    Kirim Pembayaran
                                </button>

                                <div class="py-secure">
                                    <i class="bi bi-shield-lock-fill"></i>
                                    Data kamu aman &amp; terenkripsi
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

            {{-- Sticky CTA — disabled, tombol ada di summary card --}}
            <div class="py-sticky-cta" style="display:none !important;">
                <div class="py-sticky-price">
                    <div class="py-sticky-price-label">Total</div>
                    <div class="py-sticky-price-val">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </div>
                </div>
                <button type="submit" form="payment-form" class="py-sticky-btn" id="py-sticky-btn">
                    <i class="bi bi-send-check-fill"></i>
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

    /* ── Method selection ──────────────────────────────────── */
    window.pySelectMethod = function (el) {
        document.querySelectorAll('.py-method').forEach(m => m.classList.remove('is-active'));
        el.classList.add('is-active');
        document.getElementById('py_method_input').value = el.dataset.method;
        document.querySelectorAll('.py-method-panel').forEach(p => p.classList.remove('is-show'));
        const panel = document.getElementById('panel-' + el.dataset.method);
        if (panel) panel.classList.add('is-show');
    };

    /* ── Preview proof ─────────────────────────────────────── */
    window.pyPreviewProof = function (event) {
        const file = event.target.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file melebihi 2MB. Silakan pilih file yang lebih kecil.');
            event.target.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('py-preview-img').src = e.target.result;
            document.getElementById('py-preview-filename').textContent = file.name;
            document.getElementById('py-preview-size').textContent = '(' + (file.size / 1024).toFixed(0) + ' KB)';
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

    /* ── Copy rekening ─────────────────────────────────────── */
    window.pyCopyRek = function () {
        const num = document.getElementById('rek-number')?.textContent?.replace(/\s/g, '') ?? '';
        if (!num) return;
        navigator.clipboard.writeText(num).then(() => {
            document.getElementById('copy-icon').className  = 'bi bi-check2';
            document.getElementById('copy-label').textContent = 'Tersalin!';
            setTimeout(() => {
                document.getElementById('copy-icon').className  = 'bi bi-clipboard';
                document.getElementById('copy-label').textContent = 'Salin Nomor Rekening';
            }, 2200);
        }).catch(() => {
            const ta = document.createElement('textarea');
            ta.value = num; ta.style.position = 'fixed'; ta.style.opacity = '0';
            document.body.appendChild(ta); ta.focus(); ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
        });
    };

    /* ── Drag & drop ───────────────────────────────────────── */
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

    /* ── Prevent double submit ─────────────────────────────── */
    const loadingHTML = `<span class="spinner-border spinner-border-sm" style="width:.85rem;height:.85rem;border-width:2px;" role="status" aria-hidden="true"></span>&nbsp; Mengirim...`;
    document.getElementById('payment-form')?.addEventListener('submit', function () {
        const btn = document.getElementById('py-submit-btn');
        if (btn) { btn.disabled = true; btn.innerHTML = loadingHTML; }
    });

    /* ── Card entrance on scroll ───────────────────────────── */
    if ('IntersectionObserver' in window) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('aos-animate'); obs.unobserve(e.target); }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.py-card[data-aos]').forEach(c => obs.observe(c));
    } else {
        document.querySelectorAll('.py-card[data-aos]').forEach(c => c.classList.add('aos-animate'));
    }

})();
</script>
@endpush