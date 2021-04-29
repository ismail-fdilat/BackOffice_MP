const puppeteer = require("puppeteer");
(async () => {
  const browser = await puppeteer.launch({ headless: false });

  const page = await browser.newPage();

  await page.goto("https://barefootbuttons.com/contact/");

  // Gather assets page urls for all the blockchains
  const mails = await page.$$eval("a[href^='mailto:']", assetLinks =>
    assetLinks.map(link => link.href)
  );
  console.log(mails);
  browser.close();
})();
