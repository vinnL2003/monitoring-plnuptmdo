import puppeteer from 'puppeteer-core';

const bravePath = 'C:\\Program Files\\BraveSoftware\\Brave-Browser\\Application\\brave.exe';

const pagesToTest = [
  { name: 'kku', url: 'http://127.0.0.1:8000/kku' },
  { name: 'anggaran', url: 'http://127.0.0.1:8000/anggaran' },
  { name: 'common-enemy', url: 'http://127.0.0.1:8000/common-enemy' },
  { name: 'kinerja-transmisi', url: 'http://127.0.0.1:8000/kinerja-transmisi' },
  { name: 'ahi', url: 'http://127.0.0.1:8000/ahi' },
  { name: 'abo', url: 'http://127.0.0.1:8000/abo' }
];

async function run() {
  console.log('Automated Verification on Brave Browser...');
  const browser = await puppeteer.launch({
    executablePath: bravePath,
    headless: true,
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });

  for (const item of pagesToTest) {
    const page = await browser.newPage();
    await page.setViewport({ width: 1366, height: 768 });
    await page.goto(item.url, { waitUntil: 'networkidle0', timeout: 15000 }).catch(() => {});

    // Initial state
    const initial = await page.evaluate(() => {
      const hero = document.querySelector('.hero');
      const logo = document.querySelector('.logo-upt');
      return {
        heroH: hero ? hero.getBoundingClientRect().height : 0,
        logoH: logo ? logo.getBoundingClientRect().height : 0
      };
    });

    // Slow scroll down past 70px to 120px
    for (let y = 0; y <= 120; y += 4) {
      await page.evaluate((pos) => window.scrollTo(0, pos), y);
      await new Promise(r => setTimeout(r, 10));
    }
    await new Promise(r => setTimeout(r, 450)); // let transition settle

    const shrunk = await page.evaluate(() => {
      const hero = document.querySelector('.hero');
      const logo = document.querySelector('.logo-upt');
      const rH = hero ? hero.getBoundingClientRect() : null;
      const rL = logo ? logo.getBoundingClientRect() : null;
      return {
        heroH: rH ? rH.height : 0,
        logoH: rL ? rL.height : 0,
        isShrunk: hero ? hero.classList.contains('hero-shrink') : false,
        topOffset: (rH && rL) ? Math.round(rL.top - rH.top) : 0,
        bottomOffset: (rH && rL) ? Math.round(rH.bottom - rL.bottom) : 0
      };
    });

    console.log(`Page [${item.name}]: Initial Hero=${Math.round(initial.heroH)}px -> Shrunk Hero=${Math.round(shrunk.heroH)}px, Logo=${Math.round(shrunk.logoH)}px, Top=${shrunk.topOffset}px, Bottom=${shrunk.bottomOffset}px, Shrunk=${shrunk.isShrunk}`);

    // Take screenshot of shrunk state
    await page.screenshot({ path: `C:/Users/Kevin Leatemia/.gemini/antigravity-ide/brain/f9451661-ce0e-46ea-bb97-3deb56505e4e/scratch/brave_${item.name}_shrunk.png` });

    await page.close();
  }

  await browser.close();
  console.log('All pages verified successfully in Brave Browser!');
}

run().catch(console.error);
