/**
 * ReactBits Modern Animations Suite for PLN UPT Manado
 * Optimized for true 60fps performance (zero lag, no canvas redraws)
 * 1. Spotlight Card (Mouse-following radial border & background glow)
 * 2. 3D Tilt Card (Subtle perspective tilt on hover)
 * 3. Magnet Buttons (Tactile magnetic button hover)
 * 4. Page Dropdown Transitions (Content slides down from top on load & navigation)
 * 5. Calculated Number Animations (Count-up ticker with high-tech calculation phase)
 */

(function () {
  'use strict';

  // Check reduced motion preference
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ============================================================
   * 1. SPOTLIGHT CARD (React Bits "Spotlight Card")
   * Smooth, delegated mouse-following radial glow
   * ============================================================ */
  function initSpotlightCards() {
    if (prefersReducedMotion) return;
    let activeCard = null;
    let cardRect = null;
    let rafId = null;
    let lastX = 0;
    let lastY = 0;

    const cardSelector = '.rb-spotlight-card, .card, .asset-stat-card, .aset-metric-card, .ultg-card, .summary-card, .login-box, .page-login-box, .card-box';

    document.addEventListener('pointerover', (e) => {
      const card = e.target.closest(cardSelector);
      if (card) {
        activeCard = card;
        cardRect = card.getBoundingClientRect();
      }
    }, { passive: true });

    document.addEventListener('pointerout', (e) => {
      if (activeCard && !activeCard.contains(e.relatedTarget)) {
        activeCard = null;
        cardRect = null;
      }
    }, { passive: true });

    document.addEventListener('pointermove', (e) => {
      if (!activeCard) return;
      lastX = e.clientX;
      lastY = e.clientY;

      if (!rafId) {
        rafId = requestAnimationFrame(() => {
          if (activeCard) {
            if (!cardRect) cardRect = activeCard.getBoundingClientRect();
            const x = lastX - cardRect.left;
            const y = lastY - cardRect.top;
            activeCard.style.setProperty('--mouse-x', `${x.toFixed(1)}px`);
            activeCard.style.setProperty('--mouse-y', `${y.toFixed(1)}px`);
          }
          rafId = null;
        });
      }
    }, { passive: true });
  }

  /* ============================================================
   * 2. 3D TILT CARD (React Bits "Tilted Card")
   * Subtle 3D perspective tilt on hover with smooth spring decay
   * ============================================================ */
  function initTiltCards() {
    if (prefersReducedMotion) return;
    let activeTiltEl = null;
    let tiltRect = null;
    let tiltRafId = null;
    let tiltXCoord = 0;
    let tiltYCoord = 0;

    const tiltSelector = '.asset-stat-card, .aset-metric-card, .summary-card, .login-box, .page-login-box, .rb-tilt';

    document.addEventListener('pointerover', (e) => {
      const el = e.target.closest(tiltSelector);
      if (el) {
        activeTiltEl = el;
        tiltRect = el.getBoundingClientRect();
        if (!el.classList.contains('rb-tilt')) el.classList.add('rb-tilt');
      }
    }, { passive: true });

    document.addEventListener('pointerout', (e) => {
      if (activeTiltEl && !activeTiltEl.contains(e.relatedTarget)) {
        activeTiltEl.style.setProperty('--tilt-x', '0deg');
        activeTiltEl.style.setProperty('--tilt-y', '0deg');
        activeTiltEl = null;
        tiltRect = null;
      }
    }, { passive: true });

    document.addEventListener('pointermove', (e) => {
      if (!activeTiltEl) return;
      tiltXCoord = e.clientX;
      tiltYCoord = e.clientY;

      if (!tiltRafId) {
        tiltRafId = requestAnimationFrame(() => {
          if (activeTiltEl) {
            if (!tiltRect) tiltRect = activeTiltEl.getBoundingClientRect();
            const x = tiltXCoord - tiltRect.left;
            const y = tiltYCoord - tiltRect.top;
            const cx = tiltRect.width / 2;
            const cy = tiltRect.height / 2;
            const tiltMax = 4.5; // subtle tilt angle
            const rx = ((y - cy) / cy) * -tiltMax;
            const ry = ((x - cx) / cx) * tiltMax;

            activeTiltEl.style.setProperty('--tilt-x', `${rx.toFixed(2)}deg`);
            activeTiltEl.style.setProperty('--tilt-y', `${ry.toFixed(2)}deg`);
          }
          tiltRafId = null;
        });
      }
    }, { passive: true });
  }

  /* ============================================================
   * 3. MAGNET (React Bits "Magnet")
   * Magnetic cursor pull for pill buttons
   * ============================================================ */
  function initMagnetButtons() {
    if (prefersReducedMotion) return;
    const magnetSelector = '.theme-toggle-btn, .admin-badge-btn, #btnLockUnivPage, #btnLockAnggaran, .btn-detail-link, .mode-switch-btn, .rb-magnet';

    document.addEventListener('pointermove', (e) => {
      const btn = e.target.closest(magnetSelector);
      if (btn) {
        const rect = btn.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        const deltaX = (e.clientX - centerX) * 0.22;
        const deltaY = (e.clientY - centerY) * 0.22;
        btn.style.transform = `translate3d(${deltaX.toFixed(1)}px, ${deltaY.toFixed(1)}px, 0)`;
      }
    }, { passive: true });

    document.addEventListener('pointerout', (e) => {
      const btn = e.target.closest(magnetSelector);
      if (btn && !btn.contains(e.relatedTarget)) {
        btn.style.transform = 'translate3d(0, 0, 0)';
      }
    }, { passive: true });
  }

  /* ============================================================
   * 4. MODERN PAGE DROPDOWN TRANSITION
   * Content smoothly drops down from top when loading or navigating
   * ============================================================ */
  function initPageDropdownTransition() {
    if (prefersReducedMotion) return;

    // Apply enter class to main content (never to parent .page-layout to prevent nested compounding)
    const targetMains = document.querySelectorAll('#pageAppWrapper > .container, #pageAppWrapper > main, .page-layout > main, body > main');
    targetMains.forEach((m) => {
      if (!m.classList.contains('rb-dropdown-enter')) {
        m.classList.add('rb-dropdown-enter');
      }
    });

    // Intercept internal navigation link clicks for smooth exit
    document.addEventListener('click', (e) => {
      const link = e.target.closest('a');
      if (!link) return;

      const href = link.getAttribute('href');
      if (!href) return;

      // Skip hash links, external links, targets, javascript, mailto
      if (href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
      if (link.target === '_blank' || link.hasAttribute('download') || e.ctrlKey || e.metaKey || e.shiftKey) return;
      if (link.classList.contains('no-transition') || link.closest('.no-transition')) return;

      try {
        const targetUrl = new URL(link.href, window.location.href);
        if (targetUrl.origin !== window.location.origin) return;
        if (targetUrl.pathname === window.location.pathname && targetUrl.search === window.location.search) return;
      } catch (err) {
        return;
      }

      // Smooth dropdown exit
      e.preventDefault();
      document.body.classList.add('rb-page-exit');
      setTimeout(() => {
        window.location.href = href;
      }, 180);
    });

    // Remove exit class if navigating back via browser history cache (bfcache)
    window.addEventListener('pageshow', (e) => {
      if (e.persisted) {
        document.body.classList.remove('rb-page-exit');
      }
    });
  }

  /* ============================================================
   * 5. CALCULATED NUMBER ANIMATION (COUNT-UP & CALCULATION TICKER)
   * Numbers animate as if calculating before revealing actual value
   * ============================================================ */

  // Parse any number string with arbitrary prefixes, suffixes, separators
  function parseNumberString(str) {
    if (!str || typeof str !== 'string') return null;
    const trimmed = str.trim();
    if (!trimmed || trimmed === '-' || trimmed.toLowerCase() === 'memuat...' || trimmed === '●') return null;

    // Match numbers like "101.35", "96,26", "154,2", "3.188", "41", "2.450.000", "-0,075"
    const match = trimmed.match(/^([^\d\-+]*)([-+]?\d[\d.,]*)(.*)$/s);
    if (!match) return null;

    const prefix = match[1] || '';
    const numPart = match[2] || '';
    const suffix = match[3] || '';

    let rawNum = numPart;
    let hasComma = rawNum.includes(',');
    let hasDot = rawNum.includes('.');
    let decimalSeparator = '.';
    let thousandSeparator = '';
    let decimals = 0;

    if (hasComma && !hasDot) {
      // e.g. "154,2" or "96,26" or "10,5"
      const parts = rawNum.split(',');
      if (parts[1] && parts[1].length <= 3) {
        decimalSeparator = ',';
        decimals = parts[1].length;
        rawNum = parts[0] + '.' + parts[1];
      } else {
        thousandSeparator = ',';
        rawNum = rawNum.replace(/,/g, '');
      }
    } else if (hasDot && !hasComma) {
      const parts = rawNum.split('.');
      if (parts.length > 2) {
        // multiple dots: thousands e.g. "1.250.000"
        thousandSeparator = '.';
        rawNum = parts.join('');
      } else if (parts[1] && parts[1].length === 3 && parseInt(parts[0], 10) > 0 && !trimmed.includes('%')) {
        // e.g. "3.188" titik / tower (thousand)
        thousandSeparator = '.';
        rawNum = parts.join('');
      } else if (parts[1]) {
        // e.g. "96.26" or "101.35"
        decimalSeparator = '.';
        decimals = parts[1].length;
      }
    } else if (hasDot && hasComma) {
      if (rawNum.lastIndexOf(',') > rawNum.lastIndexOf('.')) {
        // Indonesian: 1.250,50
        thousandSeparator = '.';
        decimalSeparator = ',';
        decimals = rawNum.length - rawNum.lastIndexOf(',') - 1;
        rawNum = rawNum.replace(/\./g, '').replace(',', '.');
      } else {
        // English: 1,250.50
        thousandSeparator = ',';
        decimalSeparator = '.';
        decimals = rawNum.length - rawNum.lastIndexOf('.') - 1;
        rawNum = rawNum.replace(/,/g, '');
      }
    }

    const value = parseFloat(rawNum);
    if (isNaN(value)) return null;

    return {
      prefix,
      suffix,
      targetValue: value,
      decimals,
      decimalSeparator,
      thousandSeparator,
      originalText: trimmed
    };
  }

  // Format number back to exact representation
  function formatNumber(val, parsed) {
    const fixed = Math.abs(val).toFixed(parsed.decimals);
    let [intPart, decPart] = fixed.split('.');

    if (parsed.thousandSeparator) {
      intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, parsed.thousandSeparator);
    }

    let result = (val < 0 ? '-' : '') + intPart;
    if (parsed.decimals > 0 && decPart !== undefined) {
      result += parsed.decimalSeparator + decPart;
    }

    return `${parsed.prefix}${result}${parsed.suffix}`;
  }

  // Animate a single element with calculation phase + count-up
  function animateCalculatedNumber(el) {
    if (!el || el.dataset.calcRunning === 'true') return;

    const originalHTML = el.innerHTML;
    const fullText = el.textContent.trim();

    // Check if there is an existing text node holding the digits (e.g. "96.26 " before <span>Poin</span>)
    let targetTextNode = null;
    const hasChildElements = el.children && el.children.length > 0;
    if (hasChildElements && el.childNodes) {
      for (let i = 0; i < el.childNodes.length; i++) {
        const node = el.childNodes[i];
        if (node.nodeType === Node.TEXT_NODE && /\d/.test(node.textContent)) {
          targetTextNode = node;
          break;
        }
      }
    }

    const textToParse = targetTextNode ? targetTextNode.textContent.trim() : fullText;
    const parsed = parseNumberString(textToParse);
    if (!parsed) return;

    el.dataset.calcRunning = 'true';
    el.dataset.calcAnimated = 'true';
    el.dataset.lastCalculatedVal = fullText;
    el.classList.add('rb-calculating');

    const duration = 1250; // Total ms
    const calcJitterDuration = 350; // ms high-tech calculation scramble phase
    const startTime = performance.now();
    const target = parsed.targetValue;

    function step(now) {
      const elapsed = now - startTime;
      const progress = Math.min(elapsed / duration, 1);

      if (elapsed < calcJitterDuration) {
        // Phase 1: High-tech calculation ticker (rapid cycling numbers / computation scramble)
        const jitterProgress = elapsed / calcJitterDuration;
        let currentInter;
        if (target === 0) {
          currentInter = Math.floor(Math.random() * 4);
        } else {
          const scrambleFactor = 0.25 + Math.random() * 0.75;
          currentInter = target * (0.15 + 0.85 * jitterProgress * scrambleFactor);
        }
        const displayStr = formatNumber(Math.max(0, currentInter), parsed);
        if (targetTextNode) {
          targetTextNode.textContent = displayStr + ' ';
        } else {
          el.textContent = displayStr;
        }
        requestAnimationFrame(step);
      } else if (progress < 1) {
        // Phase 2: Decelerating count-up (easeOutExpo)
        const t = (elapsed - calcJitterDuration) / (duration - calcJitterDuration);
        const ease = t === 1 ? 1 : 1 - Math.pow(2, -10 * t);
        const currentValue = target === 0 ? 0 : target * (0.35 + 0.65 * ease);
        const displayStr = formatNumber(currentValue, parsed);
        if (targetTextNode) {
          targetTextNode.textContent = displayStr + ' ';
        } else {
          el.textContent = displayStr;
        }
        requestAnimationFrame(step);
      } else {
        // Phase 3: Final confirmation - restore original HTML & markup perfectly
        el.innerHTML = originalHTML;
        el.classList.remove('rb-calculating');
        el.classList.add('rb-calc-settled');
        el.dataset.calcRunning = 'false';

        setTimeout(() => {
          el.classList.remove('rb-calc-settled');
        }, 450);
      }
    }

    requestAnimationFrame(step);
  }

  function initNumberCalculationAnimation() {
    if (prefersReducedMotion) return;

    const selector = [
      '.card-val',
      '.card-value',
      '.nko-val',
      '.nko110-val',
      '.fois-val',
      '.donut-center-label .pct',
      '.stat-value',
      '.stat-number',
      '.stat-card-val',
      '.count-number',
      '.asset-stat-info .num',
      '.asset-stat-card .num',
      '.am-info .val',
      '.km-info .val',
      '.kku-info .val',
      '.kp-metric-card .val',
      '.kku-metric-card .val',
      '.summary-card .val',
      '.ce-stat-val',
      '.st-val',
      '.tl-dot',
      '.bar-value',
      '.vbar-value',
      '.pc-pct',
      '.kku-kpi-val',
      '.metric-value',
      '.metric-val',
      '.score-val',
      '.rb-calc-num',
      '.underach-vals',
      '.progress-label > span:last-child'
    ].join(', ');

    let calcObserver = null;
    if ('IntersectionObserver' in window) {
      calcObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const el = entry.target;
            calcObserver.unobserve(el);
            if (el.dataset.calcAnimated !== 'true') {
              animateCalculatedNumber(el);
            }
          }
        });
      }, { rootMargin: '80px 0px 80px 0px', threshold: 0 });
    }

    function scanAndAnimate() {
      const elements = document.querySelectorAll(selector);
      elements.forEach((el) => {
        if (el.dataset.calcRunning === 'true') return;
        const text = el.textContent.trim();
        if (!text || text === '-' || text.toLowerCase() === 'memuat...' || text === '●') return;

        // If data value changed (e.g. user selected another month or data freshly loaded), reset to re-animate!
        if (el.dataset.calcAnimated === 'true') {
          if (el.dataset.lastCalculatedVal && el.dataset.lastCalculatedVal !== text) {
            el.dataset.calcAnimated = 'false';
          } else {
            return;
          }
        }

        const rect = el.getBoundingClientRect();
        const inViewport = (rect.top < window.innerHeight + 150 && rect.bottom > -50);
        if (inViewport) {
          animateCalculatedNumber(el);
        } else if (calcObserver) {
          calcObserver.observe(el);
        }
      });
    }

    // Debounced MutationObserver to trigger calculation when CSV / Google Sheets data loads asynchronously
    let debounceTimer = null;
    const domObserver = new MutationObserver((mutations) => {
      let shouldScan = false;
      for (let i = 0; i < mutations.length; i++) {
        const m = mutations[i];
        if (m.type === 'characterData' || m.type === 'childList') {
          shouldScan = true;
          break;
        }
      }
      if (shouldScan) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(scanAndAnimate, 40);
      }
    });

    if (document.body) {
      domObserver.observe(document.body, {
        childList: true,
        subtree: true,
        characterData: true
      });
    }

    // Multi-pass scans on load to catch synchronous and fast async data
    setTimeout(scanAndAnimate, 150);
    setTimeout(scanAndAnimate, 650);
    setTimeout(scanAndAnimate, 1600);

    // Global hook for manual trigger
    window.animateNumberCalculation = scanAndAnimate;
  }

  /* ============================================================
   * INITIALIZE SUITE
   * ============================================================ */
  function initReactBits() {
    initSpotlightCards();
    initTiltCards();
    initMagnetButtons();
    initPageDropdownTransition();
    initNumberCalculationAnimation();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReactBits);
  } else {
    initReactBits();
  }
})();
