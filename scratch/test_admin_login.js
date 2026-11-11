import puppeteer from 'puppeteer-core';

const bravePath = 'C:\\Program Files\\BraveSoftware\\Brave-Browser\\Application\\brave.exe';

async function testAdmin() {
  const browser = await puppeteer.launch({
    executablePath: bravePath,
    headless: true,
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1280, height: 720 });
  await page.goto('http://127.0.0.1:8000/login', { waitUntil: 'networkidle2' });
  await page.type('input[name="email"]', 'admin@pln.co.id');
  await page.type('input[name="password"]', 'admin123');
  await Promise.all([
    page.waitForNavigation({ waitUntil: 'networkidle2' }),
    page.click('button[type="submit"]')
  ]);

  const adminInfo = await page.evaluate(() => {
    return {
      title: document.title,
      favicons: Array.from(document.querySelectorAll('link')).filter(l => (l.rel || '').includes('icon')).map(l => l.href),
      brandLogo: document.querySelector('.sidebar-brand img')?.src,
      topbarLogo: document.querySelector('.admin-topbar img')?.src,
      topbarTitle: document.querySelector('.page-header h1')?.innerText
    };
  });

  console.log('Admin Dashboard State:', JSON.stringify(adminInfo, null, 2));
  await page.screenshot({ path: 'scratch/admin_logged_in.png' });
  await browser.close();
}

testAdmin().catch(console.error);
