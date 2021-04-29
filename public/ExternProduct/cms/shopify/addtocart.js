const puppeteer = require("puppeteer-extra");

// add recaptcha plugin and provide it your 2captcha token
// 2captcha is the builtin solution provider but others work as well.
const RecaptchaPlugin = require("puppeteer-extra-plugin-recaptcha");
puppeteer.use(
  RecaptchaPlugin({
    provider: { id: "2captcha", token: "XXXXXXX" },
    visualFeedback: true // colorize reCAPTCHAs (violet = detected, green = solved)
  })
);
var producturl =
  "https://partakefoods.com/products/crunchy-cookie-variety-pack";
(async () => {
  const browser = await puppeteer.launch({
    headless: false
  });
  const page = await browser.newPage();
  // aborting useless resources
  //   await page.setRequestInterception(true);
  //   page.on("request", request => {
  //     if (request.resourceType() === "document") {
  //       request.continue();
  //     } else {
  //       request.abort();
  //     }
  //   });

  /// go to the product page
  await page.goto(producturl, {
    timeout: 0
  });
  ///// adding the product to cart
  await Promise.all([
    page.waitForNavigation(), // The promise resolves after navigation has finished
    await page.$eval("form[action='/cart/add']", form => form.submit()) // Clicking the link will indirectly cause a navigation
  ]);
  await page.goto("https://partakefoods.com/cart", {
    timeout: 0
  });
  await Promise.all([
    page.waitForNavigation(), // The promise resolves after navigation has finished
    await page.click("*[type='submit'][name='checkout']") // Clicking the link will indirectly cause a navigation
  ]);

  // await page.solveRecaptchas();
  //  await Promise.all([
  //    page.waitForNavigation(), // The promise resolves after navigation has finished
  //    await page.click("*[type='submit'][name='checkout']") // Clicking the link will indirectly cause a navigation
  //  ]);

  //browser.close();
})();
