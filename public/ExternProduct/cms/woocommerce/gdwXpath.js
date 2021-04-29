const puppeteer = require("puppeteer");
var producturl =
  //"http://62.210.188.81:8181/product/uncategorized/boite-la-scintillante-ouverte/";
  "https://barefootbuttons.com/product/v1-mini-black/";

//"https://porterandyork.com/product/buy-flat-iron/";
const selector =
  "div.product-info.summary.col-fit.col.entry-summary.product-summary > div.product_meta > span.sku_wrapper > span";
// '//*[@id="product-22736"]/div/div[1]/div/div[2]/div[4]/span[1]/span';
(async () => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();
  await page.setRequestInterception(true);
  page.on("request", request => {
    if (request.resourceType() === "document") {
      request.continue();
    } else {
      request.abort();
    }
  });
  await page.goto(producturl, {
    timeout: 0
  });
  const data = await page.$eval(selector, el => el.textContent);
  //   var data = await page.evaluate(
  //     () => document.querySelector(selector).textContent
  //   );

  console.log(data);
  browser.close();
})();
