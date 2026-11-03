// Ubah dari 24, 14 menjadi lebih besar
const COLS = 48, ROWS = 28; 
let overlay, pixels = [], initialized = false;

/* --- 1. Bangun grid (dipanggil sekali saat DOM siap) --- */
function buildGrid() {
  if (initialized) return;

  overlay = document.getElementById('pixel-overlay');

  if (!overlay) {
    overlay = document.createElement('div');
    overlay.id = 'pixel-overlay';
    overlay.setAttribute('aria-hidden', 'true');
    document.body.appendChild(overlay);
  }

  overlay.style.position = 'fixed';
  overlay.style.inset = '0';
  overlay.style.display = 'grid';
  overlay.style.zIndex = '9999';
  overlay.style.pointerEvents = 'none';
  overlay.style.visibility = 'hidden';

  overlay.style.gridTemplateColumns = `repeat(${COLS}, 1fr)`;
  overlay.style.gridTemplateRows    = `repeat(${ROWS}, 1fr)`;

  const frag = document.createDocumentFragment();
  for (let i = 0; i < COLS * ROWS; i++) {
    const p = document.createElement('div');
    p.className = 'pixel';
    frag.appendChild(p);
    pixels.push(p);
  }
  overlay.appendChild(frag);
  initialized = true;
}

/* --- 2. Atur jeda (delay) tiap piksel --- */
function setStagger(step, direction) {
  const cx = (COLS - 1) / 2, cy = (ROWS - 1) / 2;
  const maxD = Math.hypot(cx, cy);
  pixels.forEach((el, i) => {
    const x = i % COLS, y = Math.floor(i / COLS);
    const d = Math.hypot(x - cx, y - cy) / maxD;
    const delay = direction === 'in'
      ? (1 - d) * step * 18
      : d * step * 18;
    el.style.transitionDelay = `${Math.round(delay)}ms`;
  });
}

const wait = ms => new Promise(r => setTimeout(r, ms));
const nextFrame = () => new Promise(r => requestAnimationFrame(() => requestAnimationFrame(r)));

/* --- 3. Profil kecepatan sinyal --- */
let lastLatency = 200;
function getProfile() {
  const c = navigator.connection || {};
  const mbps = c.downlink ?? 10;
  const rtt  = c.rtt ?? lastLatency;

  if (mbps < 0.5 || rtt > 800) return { dur: 900, stagger: 16 };
  if (mbps < 1.5 || rtt > 400) return { dur: 750, stagger: 13 };
  if (mbps < 5   || rtt > 200) return { dur: 580, stagger: 10 };
  return { dur: 420, stagger: 7 };
}

/* --- 4. Fungsi transisi utama --- */
// PASTIKAN ADA KATA 'export' DI SINI
export async function pixelTransition({ update, waitFor } = {}) {
  if (!initialized) buildGrid();

  if (matchMedia('(prefers-reduced-motion: reduce)').matches) {
    await update?.();
    await waitFor?.();
    return;
  }

  const profile = getProfile();
  overlay.style.setProperty('--pixel-dur', `${profile.dur}ms`);
  overlay.style.visibility = 'visible';

  /* FASE 1 — TUTUP */
  setStagger(profile.stagger * 0.5, 'in');
  await nextFrame();
  pixels.forEach(p => p.classList.add('on'));
  await wait(profile.dur * 0.5 + profile.stagger * 10);

  /* FASE 2 — TUKAR KONTEN */
  await update?.();
  if (waitFor) {
    const t0 = performance.now();
    await waitFor();
    lastLatency = performance.now() - t0;
  }

  /* FASE 3 — BUKA */
  setStagger(profile.stagger, 'out');
  pixels.forEach(p => p.classList.remove('on'));
  await wait(profile.dur + profile.stagger * 20);

  overlay.style.visibility = 'hidden';
}

/* --- 5. Inisialisasi --- */
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', buildGrid, { once: true });
} else {
  buildGrid();
}
