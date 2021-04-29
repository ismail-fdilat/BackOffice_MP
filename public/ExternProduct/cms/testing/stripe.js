fetch("https://api.stripe.com/v1/sources", {
  headers: {
    accept: "application/json",
    "accept-language": "fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7",
    "content-type": "application/x-www-form-urlencoded",
    "sec-fetch-dest": "empty",
    "sec-fetch-mode": "cors",
    "sec-fetch-site": "same-site"
  },
  referrer: "https://js.stripe.com/",
  referrerPolicy: "strict-origin-when-cross-origin",
  body:
    "type=card&owner[name]=test+test&owner[address][line1]=121+rue+de+Groussay&owner[address][city]=RODEZ&owner[address][postal_code]=12000&owner[address][country]=FR&owner[email]=test.test%40gmail.com&owner[phone]=0123456789&card[number]=4242424242424242&card[cvc]=424&card[exp_month]=04&card[exp_year]=24&guid=5ca3c332-8817-4810-8bcc-819421f62426b68a2c&muid=cf72c5d0-f0bd-4b91-b988-639188855bc03a0aa7&sid=45a38b65-0a6a-400a-ac77-bd96370c76e7121444&payment_user_agent=stripe.js%2F26dc2758d%3B+stripe-js-v3%2F26dc2758d&time_on_page=276693&referrer=http%3A%2F%2F62.210.188.81%3A8181%2F&key=pk_test_PDKRbkqjxrxlZTUjwse2zIjP00LWdXNtdL",
  method: "POST",
  mode: "cors"
});
/////////////////////////////
/*
type: card
owner[name]: test test
owner[address][line1]: 121 rue de Groussay
owner[address][city]: RODEZ
owner[address][postal_code]: 12000
owner[address][country]: FR
owner[email]: test.test@gmail.com
owner[phone]: 0123456789
card[number]: 4242424242424242
card[cvc]: 424
card[exp_month]: 04
card[exp_year]: 24
guid: 5ca3c332-8817-4810-8bcc-819421f62426b68a2c
muid: cf72c5d0-f0bd-4b91-b988-639188855bc03a0aa7
sid: 45a38b65-0a6a-400a-ac77-bd96370c76e7121444
payment_user_agent: stripe.js/26dc2758d; stripe-js-v3/26dc2758d
time_on_page: 276693
referrer: http://62.210.188.81:8181/
key: pk_test_PDKRbkqjxrxlZTUjwse2zIjP00LWdXNtdL
*/
