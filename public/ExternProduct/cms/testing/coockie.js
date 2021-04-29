// var cookies = [
//   {
//     name: "PHPSESSID",
//     value: "d8839a43ea9ab8608d6f2484baab0b90",
//     domain: "62.210.188.81",
//     path: "/",
//     expires: -1,
//     size: 41,
//     httpOnly: false,
//     secure: false,
//     session: true,
//     priority: "Medium",
//     sameParty: false,
//     sourceScheme: "NonSecure",
//     sourcePort: 8181
//   },
//   {
//     name: "woocommerce_items_in_cart",
//     value: "1",
//     domain: "62.210.188.81",
//     path: "/",
//     expires: -1,
//     size: 26,
//     httpOnly: false,
//     secure: false,
//     session: true,
//     priority: "Medium",
//     sameParty: false,
//     sourceScheme: "NonSecure",
//     sourcePort: 8181
//   },
//   {
//     name: "wp_woocommerce_session_f59c8804fda6e47fadcb688c79dd2772",
//     value:
//       "a583203199cfc37ed35f12255507532e%7C%7C1618162543%7C%7C1618158943%7C%7Cae2a5fdef1916e0d6f5ed75f68ee4aac",
//     domain: "62.210.188.81",
//     path: "/",
//     expires: 1618162543.474555,
//     size: 157,
//     httpOnly: true,
//     secure: false,
//     session: false,
//     priority: "Medium",
//     sameParty: false,
//     sourceScheme: "NonSecure",
//     sourcePort: 8181
//   },
//   {
//     name: "urna_recently_viewed_products_list",
//     value: "a%3A1%3A%7Bi%3A1617989743%3Bi%3A11647%3B%7D",
//     domain: "62.210.188.81",
//     path: "/",
//     expires: 1618421743.474601,
//     size: 77,
//     httpOnly: true,
//     secure: false,
//     session: false,
//     priority: "Medium",
//     sameParty: false,
//     sourceScheme: "NonSecure",
//     sourcePort: 8181
//   },
//   {
//     name: "__atuvc",
//     value: "1%7C14",
//     domain: "62.210.188.81",
//     path: "/",
//     expires: 1652117754,
//     size: 13,
//     httpOnly: false,
//     secure: false,
//     session: false,
//     priority: "Medium",
//     sameParty: false,
//     sourceScheme: "NonSecure",
//     sourcePort: 8181
//   },
//   {
//     name: "__atuvs",
//     value: "607090720c93f993000",
//     domain: "62.210.188.81",
//     path: "/",
//     expires: 1617991554,
//     size: 26,
//     httpOnly: false,
//     secure: false,
//     session: false,
//     priority: "Medium",
//     sameParty: false,
//     sourceScheme: "NonSecure",
//     sourcePort: 8181
//   },
//   {
//     name: "woocommerce_cart_hash",
//     value: "7a5bb44f30efb6eb6f5355d78706ae68",
//     domain: "62.210.188.81",
//     path: "/",
//     expires: -1,
//     size: 53,
//     httpOnly: false,
//     secure: false,
//     session: true,
//     priority: "Medium",
//     sameParty: false,
//     sourceScheme: "NonSecure",
//     sourcePort: 8181
//   },
//   {
//     name: "uvc",
//     value: "1%7C14",
//     domain: ".addthis.com",
//     path: "/",
//     expires: 1652117755,
//     size: 9,
//     httpOnly: false,
//     secure: true,
//     session: false,
//     sameSite: "None",
//     priority: "Medium",
//     sameParty: false,
//     sourceScheme: "Secure",
//     sourcePort: 443
//   }
// ];

// result = cookies
//   .map(c => {
//     return c.name + "=" + c.value;

//     //  console.log(c.name);
//   })
//   .join(";");

// console.log(result);

var str = "How=134135135&are=12E435&you=4331&doing=135315&today=1351353?";
var res = str.split("&");
var r = "";
res.forEach(index => {
  if (index.includes("ar")) {
    r = index;
  }
});
r = r.split("=");
console.log(r[1]);
