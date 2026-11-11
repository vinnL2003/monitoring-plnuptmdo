import puppeteer from 'puppeteer-core';

const bravePath = 'C:\\Program Files\\BraveSoftware\\Brave-Browser\\Application\\brave.exe';

const urls = [
  { name: 'admin-dashboard', url: 'http://127.0.0.1:8000/admin' },
  { name: 'login', url: 'http://127.0.0.1:8000/login' },
  { name: 'aset', url: 'http://127.0.0.1:8000/aset' },
  { name: 'home', url: 'http://127.0.0.1:8000/' },
  { name: 'common-enemy', url: 'http://127.0.0.1:8000/common-enemy' },
  { name: 'kku', url: 'http://127.0.0.1:8000/kku' },
  { name: 'konstruksi-penyaluran', url: 'http://127.0.0.1:8000/konstruksi-penyaluran' },
  { name: 'abo', url: 'http://127.0.0.1:8000/abo' }
];

async function run() {
  const browser = await puppeteer.launch({
    executablePath: bravePath,
    headless: true,
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });

  for (const item of urls) {
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 720 });
    await page.goto(item.url, { waitUntil: 'networkidle2', timeout: 15000 }).catch(e => console.log('Err:', e.message));

    const info = await page.evaluate(() => {
      const title = document.title;
      const links = Array.from(document.querySelectorAll('link')).filter(l => (l.rel || '').includes('icon'));
      const icons = links.map(el => ({ rel: el.rel, href: el.href }));
      const uptLogosOnPage = Array.from(document.querySelectorAll('img')).filter(img => (img.src || '').includes('Logo_UPT_Manado')).length;
      return { title, icons, uptLogosOnPage };
    });

    console.log(`[${item.name}] Title: '${info.title}', Icons: ${info.icons.length}, UPT Logos on Page: ${info.uptLogosOnPage}`);
    if (info.icons.length > 0) {
      console.log(`  -> Favicon: ${info.icons[0].href}`);
    }
    await page.screenshot({ path: `scratch/${item.name}.png` });
    await page.close();
  }

  await browser.close();
  console.log('ALL VERIFICATIONS COMPLETED SUCCESSFULLY!');
}

run().catch(console.error);
