import puppeteer from 'puppeteer-core';
import fs from 'fs';
import path from 'path';

const bravePath = 'C:\\Program Files\\BraveSoftware\\Brave-Browser\\Application\\brave.exe';
const outputDir = 'C:\\Users\\Kevin Leatemia\\.gemini\\antigravity-ide\\brain\\f9451661-ce0e-46ea-bb97-3deb56505e4e\\scratch';

async function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

async function run() {
  console.log('=== TESTING HERO BANNER & LIVE CLOCK IN BRAVE BROWSER ===');
  const browser = await puppeteer.launch({
    executablePath: bravePath,
    headless: true,
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });

  const pagesToTest = [
    { name: 'home', url: 'http://127.0.0.1:8000/' },
    { name: 'aset', url: 'http://127.0.0.1:8000/aset' },
    { name: 'konstruksi-penyaluran', url: 'http://127.0.0.1:8000/konstruksi-penyaluran' },
    { name: 'kku', url: 'http://127.0.0.1:8000/kku' }
  ];

  for (const item of pagesToTest) {
    console.log(`\n--- Testing [${item.name}] (${item.url}) ---`);
    const page = await browser.newPage();
    await page.setViewport({ width: 1366, height: 768 });

    const errors = [];
    page.on('pageerror', err => errors.push(err.message));

    await page.goto(item.url, { waitUntil: 'networkidle0', timeout: 15000 }).catch(() => {});
    await sleep(1200); // Allow clock tick

    // 1. Check live clock
    const clockInfo = await page.evaluate(() => {
      const el = document.getElementById('heroLiveClock');
      return {
        exists: !!el,
        text: el ? el.textContent.trim() : null
      };
    });

    console.log(`[${item.name}] Clock info:`, clockInfo);

    // 2. Check initial hero state
    const initialHero = await page.evaluate(() => {
      const hero = document.querySelector('.hero');
      return {
        height: hero ? hero.offsetHeight : 0,
        isShrunk: hero ? hero.classList.contains('hero-shrink') : false
      };
    });
    console.log(`[${item.name}] Initial Hero: Height=${initialHero.height}px, isShrunk=${initialHero.isShrunk}`);

    // 3. Scroll down past 80px (e.g. 150px)
    await page.evaluate(() => window.scrollTo(0, 150));
    await sleep(400); // Wait for RAF transition

    const shrunkHero = await page.evaluate(() => {
      const hero = document.querySelector('.hero');
      return {
        height: hero ? hero.offsetHeight : 0,
        isShrunk: hero ? hero.classList.contains('hero-shrink') : false
      };
    });
    console.log(`[${item.name}] Scrolled Hero (y=150): Height=${shrunkHero.height}px, isShrunk=${shrunkHero.isShrunk}`);

    // Screenshot shrunk state
    await page.screenshot({ path: path.join(outputDir, `brave_hero_shrunk_${item.name}.png`) });

    // 4. Scroll back up to 0
    await page.evaluate(() => window.scrollTo(0, 0));
    await sleep(400);

    const unShrunkHero = await page.evaluate(() => {
      const hero = document.querySelector('.hero');
      return {
        height: hero ? hero.offsetHeight : 0,
        isShrunk: hero ? hero.classList.contains('hero-shrink') : false
      };
    });
    console.log(`[${item.name}] Unscrolled Hero (y=0): Height=${unShrunkHero.height}px, isShrunk=${unShrunkHero.isShrunk}`);

    if (errors.length > 0) {
      console.error(`[${item.name}] Page errors found:`, errors);
    } else {
      console.log(`[${item.name}] 0 JavaScript errors.`);
    }

    await page.close();
  }

  await browser.close();
  console.log('\n=== TEST FINISHED ===');
}

run().catch(err => {
  console.error('Test execution failed:', err);
  process.exit(1);
});
