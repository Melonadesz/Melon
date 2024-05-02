const puppeteer = require('puppeteer');

(async () => {
  const browser = await puppeteer.launch({
    headless: false, // Launch a non-headless browser
    defaultViewport: null, // Set the default viewport to null
  });
  const page = await browser.newPage();

  await page.setViewport({ width: 1920, height: 1080 }); // Adjusted width to 1920px

  // Navigate to the specified URL
  await page.goto(process.argv[2]);

  // Capture a screenshot of the page
  await page.screenshot({ path: process.argv[3] });

  await browser.close();
})();
