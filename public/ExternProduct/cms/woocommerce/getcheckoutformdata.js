const puppeteer = require("puppeteer");

var request = require("request");
const results = [];
var src_stripe = "";
(async () => {
  const browser = await puppeteer.launch({
    headless: false
  });
  const page = await browser.newPage({ devtools: true });
  const client = await page.target().createCDPSession();

  await client.send("Network.enable");

  await client.send("Network.setRequestInterception", {
    patterns: [
      {
        urlPattern: "*",
        resourceType: "XHR",
        interceptionStage: "HeadersReceived"
      }
    ]
  });
  var checkout_nonce = "";
  var Pdata = "";
  client.on(
    "Network.requestIntercepted",
    async ({ interceptionId, request, responseHeaders, resourceType }) => {
      if (
        request.url === "http://62.210.188.81:8181/?wc-ajax=update_order_review"
      ) {
        Pdata = await request.postData;
        var res = Pdata.toString().split("%26");
        console.log(res);
      } else {
        console.log(`Continuing interception ${interceptionId}`);
        client.send("Network.continueInterceptedRequest", {
          interceptionId
        });
      }
      // if (Pdata === "")

      // else {
      //   var res = Pdata.toString().split("%26");

      //   res.forEach(index => {
      //     if (index.includes("woocommerce-process-checkout-nonce")) {
      //       checkout_nonce = index.split("%3D");
      //     }
      //   });
      //   console.log("//////// get checkout_nonce value");

      //   console.log(checkout_nonce[1]);
      // }
    }
  );
  // add product to cart
  //  console.log("//// adding products to cart ");

  await page.goto(
    "http://62.210.188.81:8181/product/uncategorized/boite-la-scintillante-ouverte/?add-to-cart=11647",
    {
      waitUntil: "networkidle2",
      timeout: 0
    }
  );
  //  console.log("//// acceding to the checkout page ");
  await page.goto("http://62.210.188.81:8181/checkout", {
    waitUntil: "networkidle0",
    timeout: 0
  });
  //end
})();
