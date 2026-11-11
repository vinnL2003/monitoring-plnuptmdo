import puppeteer from 'puppeteer-core';
import fs from 'fs';
import path from 'path';
import { execSync } from 'child_process';

const bravePath = 'C:\\Program Files\\BraveSoftware\\Brave-Browser\\Application\\brave.exe';
const outputDir = 'C:\\Users\\Kevin Leatemia\\.gemini\\antigravity-ide\\brain\\f9451661-ce0e-46ea-bb97-3deb56505e4e\\scratch';

async function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

async function run() {
  console.log('=== TESTING UNIVERSAL PAGE (COMMON ENEMY) AUTO-LOGOUT ===');
  
  // 1. Temporarily enable restriction on common-enemy via php artisan tinker
  console.log('Enabling restriction on common-enemy...');
  execSync('php artisan tinker --execute="App\\Models\\PageAccessSetting::where(\'page_slug\', \'common-enemy\')->update([\'is_restricted\' => true]);"', {
    cwd: 'c:\\kevin\\Magang\\Web 1\\upt-manado-laravel'
  });

  const browser = await puppeteer.launch({
    executablePath: bravePath,
    headless: true,
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1366, height: 768 });

  try {
    // 2. Open /common-enemy (Should be locked)
    console.log('\n--- 1. Navigating to /common-enemy (Expecting Universal Lock Overlay) ---');
    await page.goto('http://127.0.0.1:8000/common-enemy', { waitUntil: 'networkidle0' });

    const initLock = await page.evaluate(() => {
      const overlay = document.getElementById('universalPageLoginOverlay');
      return {
        overlayDisplay: overlay ? window.getComputedStyle(overlay).display : 'none'
      };
    });
    console.log('Universal Overlay Initial State:', initLock);
    await page.screenshot({ path: path.join(outputDir, 'brave_univ_locked_init.png') });

    // 3. Login with admin credentials
    console.log('\n--- 2. Logging in with administrator credentials (admin / admin) ---');
    await page.type('#univLoginUser', 'admin');
    await page.type('#univLoginPass', 'admin');
    await page.click('#univLoginBtn');
    await sleep(2000);

    const afterLogin = await page.evaluate(() => {
      const overlay = document.getElementById('universalPageLoginOverlay');
      const lockBtn = document.getElementById('btnLockUnivPage');
      return {
        overlayDisplay: overlay ? window.getComputedStyle(overlay).display : 'none',
        lockBtnDisplay: lockBtn ? window.getComputedStyle(lockBtn).display : 'none'
      };
    });
    console.log('Universal Page After Login:', afterLogin);
    await page.screenshot({ path: path.join(outputDir, 'brave_univ_unlocked.png') });

    // 4. Test AFK Auto-Logout on Universal Page (test_afk_ms=3000)
    console.log('\n--- 3. Testing AFK Auto-Logout on Universal Page (test_afk_ms=3000) ---');
    await page.goto('http://127.0.0.1:8000/common-enemy?test_afk_ms=3000', { waitUntil: 'networkidle0' });
    console.log('Waiting 3.8s without user interaction...');
    await sleep(3800);

    const afkState = await page.evaluate(() => {
      const overlay = document.getElementById('universalPageLoginOverlay');
      const notice = document.getElementById('univSessionNotice');
      return {
        overlayDisplay: overlay ? window.getComputedStyle(overlay).display : 'none',
        noticeVisible: notice ? notice.style.display !== 'none' : false,
        noticeText: notice ? notice.innerText.trim() : ''
      };
    });
    console.log('Universal Page After AFK Trigger:', afkState);
    await page.screenshot({ path: path.join(outputDir, 'brave_univ_afk_locked.png') });

    // 5. Test Unopened Page Auto-Logout on Universal Page (test_unopened_ms=3000)
    console.log('\n--- 4. Testing Unopened Page Auto-Logout on Universal Page (test_unopened_ms=3000) ---');
    await page.type('#univLoginUser', 'admin');
    await page.type('#univLoginPass', 'admin');
    await page.click('#univLoginBtn');
    await sleep(2000);

    await page.goto('http://127.0.0.1:8000/common-enemy?test_unopened_ms=3000', { waitUntil: 'networkidle0' });
    console.log('Simulating hidden/unopened for 3.8s...');
    await page.evaluate(() => {
      Object.defineProperty(document, 'visibilityState', { value: 'hidden', writable: true });
      document.dispatchEvent(new Event('visibilitychange'));
    });

    await sleep(3800);

    await page.evaluate(() => {
      Object.defineProperty(document, 'visibilityState', { value: 'visible', writable: true });
      document.dispatchEvent(new Event('visibilitychange'));
      window.dispatchEvent(new Event('focus'));
    });

    await sleep(800);

    const unopenedState = await page.evaluate(() => {
      const overlay = document.getElementById('universalPageLoginOverlay');
      const notice = document.getElementById('univSessionNotice');
      return {
        overlayDisplay: overlay ? window.getComputedStyle(overlay).display : 'none',
        noticeVisible: notice ? notice.style.display !== 'none' : false,
        noticeText: notice ? notice.innerText.trim() : ''
      };
    });
    console.log('Universal Page After Unopened Trigger:', unopenedState);
    await page.screenshot({ path: path.join(outputDir, 'brave_univ_unopened_locked.png') });

  } finally {
    // Revert common-enemy restriction back to false
    console.log('\nReverting common-enemy is_restricted to false...');
    execSync('php artisan tinker --execute="App\\Models\\PageAccessSetting::where(\'page_slug\', \'common-enemy\')->update([\'is_restricted\' => false]);"', {
      cwd: 'c:\\kevin\\Magang\\Web 1\\upt-manado-laravel'
    });
    await browser.close();
    console.log('=== UNIVERSAL PAGE AUTO-LOGOUT TEST COMPLETED ===');
  }
}

run().catch(err => {
  console.error('Test error:', err);
  process.exit(1);
});
