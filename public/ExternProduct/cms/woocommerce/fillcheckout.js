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
        Pdata = request.postData;
      }
      console.log(`Continuing interception ${interceptionId}`);
      if (Pdata === "")
        client.send("Network.continueInterceptedRequest", {
          interceptionId
        });
      else {
        var res = Pdata.toString().split("%26");

        res.forEach(index => {
          if (index.includes("woocommerce-process-checkout-nonce")) {
            checkout_nonce = index.split("%3D");
          }
        });
        console.log("//////// get checkout_nonce value");

        console.log(checkout_nonce[1]);
        client.send("Network.continueInterceptedRequest", {
          interceptionId
        });
      }
    }
  );
  // add product to cart
  console.log("//// adding products to cart ");
  await page.goto(
    "http://62.210.188.81:8181/product/uncategorized/boite-la-scintillante-ouverte/?add-to-cart=11647",
    {
      waitUntil: "networkidle2",
      timeout: 0
    }
  );

  console.log("//// acceding to the checkout page ");
  await page.goto("http://62.210.188.81:8181/checkout", {
    waitUntil: "networkidle0",
    timeout: 0
  });
  var coockie = await page._client.send("Network.getAllCookies");

  // var Networkresponse = await page._client.send("Network.getResponseBody");
  //console.log(Networkresponse);
  var fcoockie = coockie.cookies
    .map(c => {
      return c.name + "=" + c.value;
    })
    .join(";");

  //send Stripe form
  console.log("//////send stripe form");

  var options = {
    method: "POST",
    url: "https://api.stripe.com/v1/sources",
    headers: {
      authority: "api.stripe.com",
      accept: "application/json",
      "user-agent":
        "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36",
      "content-type": "application/x-www-form-urlencoded",
      origin: "https://js.stripe.com",
      "sec-fetch-site": "same-site",
      "sec-fetch-mode": "cors",
      "sec-fetch-dest": "empty",
      referer: "https://js.stripe.com/",
      "accept-language": "fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7"
    },
    form: {
      type: "card",
      "owner[name]": "test+test",
      "owner[address][line1]": "121+rue+de+Groussay",
      "owner[address][city]": "RODEZ",
      "owner[address][postal_code]": "12000",
      "owner[address][country]": "FR",
      "owner[email]": "test.test@gmail.com",
      "owner[phone]": "0123456789",
      "card[number]": "4242424242424242",
      "card[cvc]": "424",
      "card[exp_month]": "04",
      "card[exp_year]": "24",
      time_on_page: "61064",
      referrer: "http://62.210.188.81:8181/",
      key: "pk_test_PDKRbkqjxrxlZTUjwse2zIjP00LWdXNtdL"
    }
  };

  request(options, function (error, response) {
    if (error) throw new Error(error);
    body = JSON.parse(response.body);

    console.log("////// get stripe id //////");
    console.log(body.id);

    // send checkout form
    console.log("//////send checkout form");
    var Coptions = {
      method: "POST",
      url: "http://62.210.188.81:8181/?wc-ajax=checkout",
      headers: {
        Connection: "keep-alive",
        Accept: "application/json, text/javascript, */*; q=0.01",
        "X-Requested-With": "XMLHttpRequest",
        "User-Agent":
          "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36",
        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        Origin: "http://62.210.188.81:8181",
        Referer: "http://62.210.188.81:8181/checkout/",
        "Accept-Language": "fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7",
        Cookie: String(fcoockie)
      },
      body:
        "billing_first_name=test&billing_last_name=test&billing_company=test&billing_country=FR&billing_address_1=121+rue+de+Groussay&billing_address_2=&billing_postcode=12000&billing_city=RODEZ&billing_state=&billing_phone=0123456789&billing_email=test.test%40gmail.com&shipping_first_name=test&shipping_last_name=test&shipping_company=test&shipping_country=FR&shipping_address_1=121+rue+de+Groussay&shipping_address_2=&shipping_postcode=12000&shipping_city=RODEZ&shipping_state=&shipping_method%5B0%5D=flat_rate%3A8&payment_method=stripe&wc-stripe-payment-token=new&terms-field=0&woocommerce-process-checkout-nonce=" +
        checkout_nonce[1] +
        "&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review&terms-field=0&woocommerce-process-checkout-nonce=" +
        checkout_nonce[1] +
        "&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review&stripe_source=" +
        String(body.id)
    };
    request(Coptions, function (error, response) {
      if (error) throw new Error(error);
      console.log(response.body);
    });
  });

  //end
})();
