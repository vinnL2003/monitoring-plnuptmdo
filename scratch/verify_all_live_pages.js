import puppeteer from 'puppeteer-core';

const bravePath = 'C:\\Program Files\\BraveSoftware\\Brave-Browser\\Application\\brave.exe';

const pages = [
  { name: 'home', url: 'http://127.0.0.1:8000/' },
  { name: 'common-enemy', url: 'http://127.0.0.1:8000/common-enemy' },
  { name: 'abo', url: 'http://127.0.0.1:8000/abo' },
  { name: 'aset', url: 'http://127.0.0.1:8000/aset' },
  { name: 'anggaran', url: 'http://127.0.0.1:8000/anggaran' },
  { name: 'kinerja-transmisi', url: 'http://127.0.0.1:8000/kinerja-transmisi' },
  { name: 'ahi', url: 'http://127.0.0.1:8000/ahi' }
];

async function verifyAllPages() {
  console.log('Testing live Google Spreadsheet data on all pages via Brave browser...');
  const browser = await puppeteer.launch({
    executablePath: bravePath,
    headless: true,
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });

  for (const p of pages) {
    const page = await browser.newPage();
    const errors = [];
    page.on('pageerror', err => errors.push(err.message));
    page.on('console', msg => {
      if (msg.type() === 'error') errors.push(msg.text());
    });

    try {
      await page.goto(p.url, { waitUntil: 'networkidle2', timeout: 35000 });
      // Wait extra 3 seconds for async fetches to finish
      await new Promise(r => setTimeout(r, 3000));

      const evaluation = await page.evaluate((pageName) => {
        let status = 'OK';
        let detail = '';

        if (pageName === 'common-enemy' || pageName === 'abo') {
          const content = document.getElementById('content');
          const errorEl = content?.querySelector('.err');
          const loadingEl = content?.querySelector('.loading');
          const cards = document.querySelectorAll('.ce-stat-card, .program-card, .table-wrap, table');
          if (errorEl) { status = 'ERROR'; detail = errorEl.innerText; }
          else if (loadingEl) { status = 'STILL_LOADING'; detail = loadingEl.innerText; }
          else { detail = `Found ${cards.length} elements/cards loaded`; }
        } else if (pageName === 'home') {
          const nkoVal = document.getElementById('valNko')?.innerText;
          const mapCards = document.querySelectorAll('.asset-stat-card');
          detail = `NKO: ${nkoVal}, Asset cards: ${mapCards.length}`;
        } else if (pageName === 'anggaran') {
          const content = document.getElementById('content');
          const errorEl = content?.querySelector('.err');
          detail = errorEl ? errorEl.innerText : 'Loaded successfully';
        } else if (pageName === 'kinerja-transmisi') {
          const errorEl = document.querySelector('.err');
          detail = errorEl ? errorEl.innerText : 'Loaded successfully';
        } else if (pageName === 'ahi') {
          const content = document.getElementById('content');
          const errorEl = content?.querySelector('.err');
          detail = errorEl ? errorEl.innerText : 'Loaded successfully';
        }

        const dataSources = window.APP_DATA_SOURCES || {};
        return { status, detail, dataSources };
      }, p.name);

      console.log(`[${p.name.toUpperCase()}] Status: ${evaluation.status} | ${evaluation.detail}`);
      if (errors.length > 0) {
        console.log(`   Console errors (${errors.length}):`, errors.slice(0, 3));
      }
    } catch (e) {
      console.error(`[${p.name.toUpperCase()}] Page load failed: ${e.message}`);
    } finally {
      await page.close();
    }
  }

  await browser.close();
  console.log('ALL PAGE VERIFICATIONS FINISHED.');
}

verifyAllPages().catch(console.error);
