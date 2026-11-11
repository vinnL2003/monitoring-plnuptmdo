import puppeteer from 'puppeteer-core';
import fs from 'fs';
import path from 'path';

const bravePath = 'C:\\Program Files\\BraveSoftware\\Brave-Browser\\Application\\brave.exe';
const outputDir = 'C:\\Users\\Kevin Leatemia\\.gemini\\antigravity-ide\\brain\\f9451661-ce0e-46ea-bb97-3deb56505e4e\\scratch';

if (!fs.existsSync(outputDir)) {
  fs.mkdirSync(outputDir, { recursive: true });
}

async function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

async function run() {
  console.log('=== STARTING BRAVE BROWSER AUTO-LOGOUT TEST ===');
  const browser = await puppeteer.launch({
    executablePath: bravePath,
    headless: true,
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1366, height: 768 });

  // TEST 1: Anggaran initial state (Restricted & Locked)
  console.log('\n--- 1. Testing /anggaran initial state (Locked) ---');
  await page.goto('http://127.0.0.1:8000/anggaran', { waitUntil: 'networkidle0' });
  
  const isLockedInit = await page.evaluate(() => {
    const overlay = document.getElementById('loginOverlay');
    const layout = document.querySelector('.page-layout');
    return {
      overlayDisplay: overlay ? window.getComputedStyle(overlay).display : 'none',
      isBlurred: layout ? layout.classList.contains('page-blurred') : false
    };
  });
  console.log('Initial Anggaran State:', isLockedInit);

  // TEST 2: Login with personnel account (92141105ZY / Manado28)
  console.log('\n--- 2. Logging in with personnel account ---');
  await page.type('#loginUser', '92141105ZY');
  await page.type('#loginPass', 'Manado28');
  await page.click('#loginSubmitBtn');
  await sleep(1500);

  const isUnlockedAfterLogin = await page.evaluate(() => {
    const overlay = document.getElementById('loginOverlay');
    const layout = document.querySelector('.page-layout');
    const lockBtn = document.getElementById('btnLockAnggaran');
    return {
      overlayDisplay: overlay ? window.getComputedStyle(overlay).display : 'none',
      isBlurred: layout ? layout.classList.contains('page-blurred') : false,
      lockBtnDisplay: lockBtn ? window.getComputedStyle(lockBtn).display : 'none'
    };
  });
  console.log('State After Login:', isUnlockedAfterLogin);
  await page.screenshot({ path: path.join(outputDir, 'brave_anggaran_logged_in.png') });

  // TEST 3: Test Rule 1 - 3 Minutes AFK Auto-Logout (using test_afk_ms=3000)
  console.log('\n--- 3. Testing Rule 1: AFK Auto-Logout (idle 3 seconds) ---');
  await page.goto('http://127.0.0.1:8000/anggaran?test_afk_ms=3000', { waitUntil: 'networkidle0' });

  // Ensure unlocked initially
  const checkInitialUnlocked = await page.evaluate(() => {
    const overlay = document.getElementById('loginOverlay');
    return overlay ? window.getComputedStyle(overlay).display : 'none';
  });
  console.log('Initial overlay before AFK wait:', checkInitialUnlocked);

  console.log('Waiting 3.8s without user interaction (simulating AFK)...');
  await sleep(3800);

  const afkState = await page.evaluate(() => {
    const overlay = document.getElementById('loginOverlay');
    const layout = document.querySelector('.page-layout');
    const notice = document.getElementById('anggaranSessionNotice');
    return {
      overlayDisplay: overlay ? window.getComputedStyle(overlay).display : 'none',
      isBlurred: layout ? layout.classList.contains('page-blurred') : false,
      noticeVisible: notice ? notice.style.display !== 'none' : false,
      noticeText: notice ? notice.innerText.trim() : ''
    };
  });
  console.log('State After AFK Trigger:', afkState);
  await page.screenshot({ path: path.join(outputDir, 'brave_anggaran_afk_locked.png') });

  // TEST 4: Login again and test Rule 2 - 10 Minutes Unopened Page Auto-Logout (using test_unopened_ms=3000)
  console.log('\n--- 4. Testing Rule 2: 10 Minutes Unopened Page Auto-Logout (using test_unopened_ms=3000) ---');
  await page.type('#loginUser', '92141105ZY');
  await page.type('#loginPass', 'Manado28');
  await page.click('#loginSubmitBtn');
  await sleep(1500);

  // Navigate to url with test_unopened_ms=3000
  await page.goto('http://127.0.0.1:8000/anggaran?test_unopened_ms=3000', { waitUntil: 'networkidle0' });
  console.log('Simulating page hidden / unopened for 3.8s...');
  
  // Set tab visibility to hidden
  await page.evaluate(() => {
    Object.defineProperty(document, 'visibilityState', { value: 'hidden', writable: true });
    document.dispatchEvent(new Event('visibilitychange'));
  });

  await sleep(3800);

  // Restore visibility / open tab again
  await page.evaluate(() => {
    Object.defineProperty(document, 'visibilityState', { value: 'visible', writable: true });
    document.dispatchEvent(new Event('visibilitychange'));
    window.dispatchEvent(new Event('focus'));
  });

  await sleep(800);

  const unopenedState = await page.evaluate(() => {
    const overlay = document.getElementById('loginOverlay');
    const layout = document.querySelector('.page-layout');
    const notice = document.getElementById('anggaranSessionNotice');
    return {
      overlayDisplay: overlay ? window.getComputedStyle(overlay).display : 'none',
      isBlurred: layout ? layout.classList.contains('page-blurred') : false,
      noticeVisible: notice ? notice.style.display !== 'none' : false,
      noticeText: notice ? notice.innerText.trim() : ''
    };
  });
  console.log('State After Unopened Trigger:', unopenedState);
  await page.screenshot({ path: path.join(outputDir, 'brave_anggaran_unopened_locked.png') });

  // TEST 5: Test Universal Page Overlay on a layout page (e.g. /aset with isRestricted simulation or toggle)
  console.log('\n--- 5. Testing Universal Layout Page (Common Enemy / Universal Overlay) ---');
  // Let's test the lock notice and modal in universal overlay directly
  await page.goto('http://127.0.0.1:8000/anggaran', { waitUntil: 'networkidle0' });
  const finalCheck = await page.evaluate(() => {
    const overlay = document.getElementById('loginOverlay');
    return {
      overlayDisplay: overlay ? window.getComputedStyle(overlay).display : 'none'
    };
  });
  console.log('Final confirmation on refresh:', finalCheck);

  await browser.close();
  console.log('=== BRAVE BROWSER TEST COMPLETED SUCCESSFULLY ===');
}

run().catch(err => {
  console.error('Test error:', err);
  process.exit(1);
});
