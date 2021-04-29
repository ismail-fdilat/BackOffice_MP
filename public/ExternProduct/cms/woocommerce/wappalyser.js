const Wappalyzer = require("wappalyzer");
const urls = ["http://62.210.188.81:8181/"];

const wappalyzer = new Wappalyzer();

(async function () {
  try {
    await wappalyzer.init();

    const results = await Promise.all(
      urls.map(async url => ({
        url,
        results: await wappalyzer.open(url).analyze()
      }))
    );
    //console.log(JSON.stringify(results, null, 2));
    techs = results[0].results.technologies;
    const cms = await Promise.all(techs.map(async tech => tech.slug));
    console.log(cms);
  } catch (error) {
    console.error(error);
  }

  await wappalyzer.destroy();
})();
