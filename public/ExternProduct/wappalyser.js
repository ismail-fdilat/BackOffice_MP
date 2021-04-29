const Wappalyzer = require("wappalyzer");
const process = require("process");

// Printing process.argv property value
var args = process.argv;

const urls = [args[2]];
//["http://62.210.188.81:8181/"];
//console.log(args[2]);
const wappalyzer = new Wappalyzer();

(async function () {
    try {
        await wappalyzer.init();

        const results = await Promise.all(
            urls.map(async (url) => ({
                url,
                results: await wappalyzer.open(url).analyze(),
            }))
        );
        //console.log(JSON.stringify(results, null, 2));
        techs = results[0].results.technologies;
        const cms = await Promise.all(techs.map(async (tech) => tech.slug));
        //console.log(cms);
        if (cms.includes("woocommerce")) {
            console.log("Woocommerce");
        } else if (cms.includes("shopify")) {
            console.log("Shopify");
        } else if (cms.includes("prestashop")) {
            console.log("Prestashop");
        } else if (cms.includes("magento")) {
            console.log("Magento");
        }
    } catch (error) {
        console.error(error);
    }

    await wappalyzer.destroy();
})();
