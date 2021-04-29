var axios = require("axios");
var cheerio = require("cheerio");
var cookies = {};
var checkoutc = {
  method: "get",
  url: "http://62.210.188.81:8181/"
  //headers: {
  //Cookie:
  // "PHPSESSID=559418cd30dfbc41a21a230b78bd8150; wp_woocommerce_session_f59c8804fda6e47fadcb688c79dd2772=ec5b20299637abfab64d380e0fd4e8ee%7C%7C1617989843%7C%7C1617986243%7C%7C63fb7a3e29ee23b2867347fb6ab4d562; woocommerce_items_in_cart=1; urna_recently_viewed_products_list=a%3A2%3A%7Bi%3A1617817043%3Bi%3A10677%3Bi%3A1617817379%3Bi%3A11647%3B%7D; woocommerce_cart_hash=7a5bb44f30efb6eb6f5355d78706ae68"
  //}
};
var config = {
  method: "post",
  url:
    "http://62.210.188.81:8181/product/uncategorized/boite-la-scintillante-ouverte/?add-to-cart=11647",
  headers: {
    Cookie:
      "PHPSESSID=559418cd30dfbc41a21a230b78bd8150; wp_woocommerce_session_f59c8804fda6e47fadcb688c79dd2772=ec5b20299637abfab64d380e0fd4e8ee%7C%7C1617989843%7C%7C1617986243%7C%7C63fb7a3e29ee23b2867347fb6ab4d562; woocommerce_items_in_cart=1; woocommerce_cart_hash=2dd561fe2cd99d35e90f380f233e8f73; urna_recently_viewed_products_list=a%3A2%3A%7Bi%3A1617817043%3Bi%3A10677%3Bi%3A1617817379%3Bi%3A11647%3B%7D"
  }
};

var checkout = {
  method: "get",
  url: "http://62.210.188.81:8181/checkout/",
  headers: {
    Cookie:
      "PHPSESSID=559418cd30dfbc41a21a230b78bd8150; wp_woocommerce_session_f59c8804fda6e47fadcb688c79dd2772=ec5b20299637abfab64d380e0fd4e8ee%7C%7C1617989843%7C%7C1617986243%7C%7C63fb7a3e29ee23b2867347fb6ab4d562; woocommerce_items_in_cart=1; urna_recently_viewed_products_list=a%3A2%3A%7Bi%3A1617817043%3Bi%3A10677%3Bi%3A1617817379%3Bi%3A11647%3B%7D; woocommerce_cart_hash=7a5bb44f30efb6eb6f5355d78706ae68"
  }
};
var data =
  "billing_first_name=test&billing_last_name=test&billing_company=test&billing_country=FR&billing_address_1=121+rue+de+Groussay&billing_address_2=&billing_postcode=12000&billing_city=RODEZ&billing_state=&billing_phone=0123456789&billing_email=test.test%40gmail.com&shipping_first_name=test&shipping_last_name=test&shipping_company=test&shipping_country=FR&shipping_address_1=121+rue+de+Groussay&shipping_address_2=&shipping_postcode=12000&shipping_city=RODEZ&shipping_state=&shipping_method%5B0%5D=flat_rate%3A8&payment_method=stripe&wc-stripe-payment-token=new&terms-field=0&woocommerce-process-checkout-nonce=1d4767a479&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review&terms-field=0&woocommerce-process-checkout-nonce=1d4767a479&_wp_http_referer=%2F%3Fwc-ajax%3Dupdate_order_review&stripe_source=src_1IdhVsLjfoMVzvYVaXbbglPL";

var configC = {
  method: "post",
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
    Cookie:
      "wp-settings-1=libraryContent%3Dbrowse%26edit_element_vcUIPanelWidth%3D650%26edit_element_vcUIPanelLeft%3D643px%26edit_element_vcUIPanelTop%3D115px%26editor%3Dhtml%26panel_vcUIPanelWidth%3D650%26panel_vcUIPanelLeft%3D674px%26panel_vcUIPanelTop%3D74px%26mfold%3Do; wp-settings-time-1=1617471359; wordpress_logged_in_f59c8804fda6e47fadcb688c79dd2772=admin%7C1618833668%7CsZxN0uPh6EPlAsIjB4s7s4mzDtYJ7yQ1C6euZ7dVh83%7C92f61181ca95a94a5607cf506fac5c4c9fa8cc26fec50ee4aab3bfd2dddfa2b4; PHPSESSID=64d0ca89a38b1698b37211d7b058c66e; tk_ai=woo%3AM69jHyWdIKf%2B1lR7XjqAbOPk; wp_woocommerce_session_f59c8804fda6e47fadcb688c79dd2772=1%7C%7C1617997396%7C%7C1617993796%7C%7Ca8a317c0b767ae190f1a0a31afa0a939; woocommerce_items_in_cart=1; __atuvc=14%7C13%2C19%7C14; __atuvs=606e0e513424ae7e000; woocommerce_cart_hash=2dd561fe2cd99d35e90f380f233e8f73; PHPSESSID=559418cd30dfbc41a21a230b78bd8150; urna_recently_viewed_products_list=a%3A2%3A%7Bi%3A1617817043%3Bi%3A10677%3Bi%3A1617817379%3Bi%3A11647%3B%7D; wp_woocommerce_session_f59c8804fda6e47fadcb688c79dd2772=1%7C%7C1617989843%7C%7C1617986243%7C%7C98f42b63a2833ae9495dc310005ace99"
  },
  data: data
};

axios(checkoutc)
  .then(function (response) {
    console.log(JSON.stringify(response.headers));
  })
  .catch(function (error) {
    console.log(error);
  });

// axios(configc)
//   .then(function (response) {
//     //  console.log(JSON.stringify(response.headers));
//   })
//   .catch(function (error) {
//     console.log(error);
//   });
console.log("//////////////////// checkout nchaalah");

// axios(checkout)
//   .then(function (response) {
//     const $ = cheerio.load(response.data);
//     console.log($("title").text());
//     console.log($("form").serializeArray());
//     var finaldata = [];
//     formdata = $("form").serializeArray();
//     for (var i in formdata) {
//       formdata[i].name.includes("billing") ? finaldata.push(formdata[i]) : "";
//       formdata[i].name.includes("shipping") ? finaldata.push(formdata[i]) : "";
//       formdata[i].name.includes("terms-field")
//         ? finaldata.push(formdata[i])
//         : "";
//       formdata[i].name.includes("cardnumber")
//         ? finaldata.push(formdata[i])
//         : "";
//     }
//     console.log(finaldata);
//   })
//   .catch(function (error) {
//     console.log(error);
// });
//console.log("//////////////////// checkout nchaalah" )
("wp-settings-1=libraryContent%3Dbrowse%26edit_element_vcUIPanelWidth%3D650%26edit_element_vcUIPanelLeft%3D643px%26edit_element_vcUIPanelTop%3D115px%26editor%3Dhtml%26panel_vcUIPanelWidth%3D650%26panel_vcUIPanelLeft%3D674px%26panel_vcUIPanelTop%3D74px%26mfold%3Do; wp-settings-time-1=1617471359; PHPSESSID=64d0ca89a38b1698b37211d7b058c66e; tk_ai=woo%3AM69jHyWdIKf%2B1lR7XjqAbOPk; __atuvc=14%7C13%2C19%…");
