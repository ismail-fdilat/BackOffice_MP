const puppeteer = require("puppeteer");
const request_client = require("request-promise-native");

(async () => {
  const browser = await puppeteer.launch({ headless: false });
  const page = await browser.newPage();
  const result = [];

  await page.setRequestInterception(true);

  page.on("response", response => {
    request_client({
      uri: response.url(),
      resolveWithFullResponse: true
    })
      .then(response => {
        const request_url = response.url();
        // const request_headers = request.headers();
        // const request_post_data = request.postData();
        // const response_headers = response.headers;
        // const response_size = response_headers["content-length"];
        const response_body = response.body;

        result.push({
          request_url,
          //   request_headers,
          //   request_post_data,
          //   response_headers,
          //   response_size,
          response_body
        });

        request.continue();
      })
      .catch(error => {
        console.error(error);
        request.abort();
      });
  });

  await page.goto(
    "http://62.210.188.81:8181/product/uncategorized/boite-la-scintillante-ouverte/?add-to-cart=11647",
    {
      waitUntil: "networkidle0",
      timeout: 0
    }
  );
  await page.goto("http://62.210.188.81:8181/checkout", {
    waitUntil: "networkidle0",
    timeout: 0
  });
  //   await page.goto("https://api.stripe.com/v1/sources", {
  //     waitUntil: "networkidle0",
  //     timeout: 0
  //   });
  result.forEach((item, index) => {
    // if (item.request_url === "https://m.stripe.com/6")
    console.log(item);
  });
  //console.log(result);
  await browser.close();
})();
