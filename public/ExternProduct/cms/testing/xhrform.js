//https://ecommerce-platforms.com/fr/compare/dropified-vs-oberlo
var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
var FormData = require("form-data");

const Apify = require("apify");

Apify.main(async () => {
  const requestQueue = await Apify.openRequestQueue();
  var xhr = new XMLHttpRequest();
  xhr.open(
    "POST",
    "http://62.210.188.81:8181/product/uncategorized/boite-la-scintillante-ouverte/?add-to-cart=11647",
    true
  );
  xhr.send();

  console.log("///////////// XHR");
  xhr.onload = function () {
    console.log(this.responseXML.title);
  };

  xhr.open("GET", "http://62.210.188.81:8181/checkout/");
  xhr.responseType = "document";
  xhr.send();
  await requestQueue.addRequest({ url: "http://62.210.188.81:8181/" });
  // await requestQueue.addRequest({ url: 'http://62.210.188.81:8181/checkout/' });
  const handlePageFunction = async ({ request, $ }) => {
    const title = $("title").text();
    // console.log(`The title of "${request.url}" is: ${title}.`);
    //Get Product data
    //console.log("/////////////Get Product data")
    //const jsonLD = $('script[type="application/ld+json"]');
    //Display Product Data
    //console.log(jsonLD.html());

    var form = "form[name='checkout'] :input";
    console.log("/////////////display form");

    console.log($("#billing_first_name").html());
    // console.log($("form").html())
    //  console.log($("body"))
    $("form[action='http://62.210.188.81:8181/checkout/'] input").each(
      function (index) {
        var input = $(this);

        //console.log(input)
        //      console.log('Type: ' + input.attr('type') + ' Name: ' + input.attr('name') + ' Value: ' + input.val());
      }
    );

    // Affiche les valeurs

    //console.log($('form'));
    // console.log($('form').serializeArray());

    // Display cart

    //console.log("/////////////Display cart")
    //request.open( "GET", "https://partakefoods.com/cart.js", false )
    //request.onreadystatechange = function() {
    //if(request.readyState == 4 && request.status == 200) {
    //  result = JSON.parse(XMLReq.responseText);
    // console.log( request.responseText);
    //}
    //}
    // request.send();
  };

  // Set up the crawler, passing a single options object as an argument.
  const crawler = new Apify.CheerioCrawler({
    requestQueue,
    handlePageFunction
  });

  await crawler.run();
});
