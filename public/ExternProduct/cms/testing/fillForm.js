var axios = require("axios");
var qs = require("qs");

var data = qs.stringify({
  billing_first_name: "test",
  billing_last_name: "test",
  billing_company: "test",
  billing_address_1: "35 Rue du Chevalier de la Barre",
  billing_city: "Paris",
  billing_state: "France",
  billing_postcode: "12000",
  billing_phone: "0612334556",
  billing_email: "test@gmail.com",
  "terms-field": "0"
});
var config = {
  method: "post",
  url: "https://barefootbuttons.com/checkout-2/",
  headers: {
    "Content-Type": "application/x-www-form-urlencoded",
    Cookie:
      "woocommerce_items_in_cart=1; wp_woocommerce_session_67203ed4f0f3a9390f5d2c6a1c52e7b9=7d8d6a063017a5c01926ffbbd58f6084%7C%7C1617714274%7C%7C1617710674%7C%7C49859a05273459288642e6971907de6f; woocommerce_cart_hash=399a797ac66e5c6cd6954967e5a409a1; woocommerce_recently_viewed=25559"
  },
  data: data
};

axios(config)
  .then(function (response) {
    console.log(response.headers);
  })
  .catch(function (error) {
    console.log(error);
  });
