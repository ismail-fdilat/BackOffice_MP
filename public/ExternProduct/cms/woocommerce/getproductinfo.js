const puppeteer = require("puppeteer");
const process = require("process");

// Printing process.argv property value
var args = process.argv;
var producturl = args[2];
// "http://62.210.188.81:8181/product/uncategorized/boite-la-scintillante-ouverte/";
//"https://barefootbuttons.com/product/v1-mini-black/";

//"https://porterandyork.com/product/buy-flat-iron/";

(async () => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.setRequestInterception(true);
    page.on("request", (request) => {
        if (request.resourceType() === "document") {
            request.continue();
        } else {
            request.abort();
        }
    });
    await page.goto(producturl, {
        timeout: 0,
    });

    var Puredata = await page.evaluate(() => {
        var objectdata = document.querySelectorAll(
            "script[type='application/ld+json']"
        );
        var tempdata = [];
        Object.entries(objectdata).forEach(([key, value]) =>
            tempdata.push(objectdata[key].innerText)
        );
        return tempdata;
    });
    var productdata = {};

    // Puredata.forEach(data => {
    //   data = JSON.parse(data);

    //   data["@graph"].forEach(x => {
    //     x["@type"] == "Product" ? (productdata = x) : null;
    //   });
    Puredata.forEach((data) => {
        data = JSON.parse(data);
        //console.log("\n\n" + data["@graph"]);
        if (data["@type"] == "Product") {
            productdata = data;
        } else if (data["@graph"]) {
            data["@graph"].forEach((x) => {
                x["@type"] == "Product" ? (productdata = x) : null;
            });
        }
    });

    //console.log(data);

    //// get short link ofthe product
    const shortlink = await page.evaluate(() =>
        document.querySelector("link[rel='shortlink']").getAttribute("href")
    );
    //// adding the shortlink of the  product to the product object

    productdata.shortlink = shortlink;
    //// adding the id of the  product to the product object

    const idProduct = shortlink.split("=")[1];
    productdata.idProduct = idProduct;

    console.log(JSON.stringify(productdata));
    // console.log(idProduct);
    browser.close();
})();
