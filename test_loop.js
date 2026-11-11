import puppeteer from 'puppeteer-core';

const bravePath = 'C:\\Program Files\\BraveSoftware\\Brave-Browser\\Application\\brave.exe';

async function run() {
  console.log('Testing down and up scroll with overflowAnchor = none in Brave...');
  const browser = await puppeteer.launch({
    executablePath: bravePath,
    headless: true,
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1366, height: 768 });
  await page.goto('http://127.0.0.1:8000/konstruksi-penyaluran', { waitUntil: 'networkidle0' });

  await page.evaluate(() => {
    document.documentElement.style.overflowAnchor = 'none';
    document.body.style.overflowAnchor = 'none';

    window.scrollEvents = [];
    let count = 0;
    window.addEventListener('scroll', () => {
      const hero = document.querySelector('.hero');
      const isShrunk = hero ? hero.classList.contains('hero-shrink') : false;
      const h = hero ? hero.getBoundingClientRect().height : 0;
      window.scrollEvents.push({
        idx: count++,
        scrollY: window.scrollY,
        isShrunk,
        height: Math.round(h)
      });
    }, { passive: true });
  });

  // Scroll down 0 to 150
  for (let y = 0; y <= 150; y += 4) {
    await page.evaluate((pos) => window.scrollTo(0, pos), y);
    await new Promise(r => setTimeout(r, 15));
  }
  await new Promise(r => setTimeout(r, 300));

  // Scroll back up 150 to 0
  for (let y = 150; y >= 0; y -= 4) {
    await page.evaluate((pos) => window.scrollTo(0, pos), y);
    await new Promise(r => setTimeout(r, 15));
  }
  await new Promise(r => setTimeout(r, 300));

  const events = await page.evaluate(() => window.scrollEvents);
  const transitions = events.filter((e, i, arr) => i > 0 && e.isShrunk !== arr[i-1].isShrunk);
  console.log('Transitions (should be exactly 2: one shrink, one unshrink):', transitions);

  await browser.close();
}

run().catch(console.error);
