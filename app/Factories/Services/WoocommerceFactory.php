<?php
namespace App\Factories\Services;

class Woocommercefactory implements IExternProductFactory
{
    private $config;
    public function __construct($config)
    {
        //   dump("Woocommerce config was set in constructor...");
        $this->config = $config;
        // dump($this->config);
    }
    public function getProducts($url): string
    {
        $output = shell_exec('node ./ExternProduct/cms/woocommerce/getproductinfo.js '. $url);
        $productinfo = trim($output);

        return $productinfo;
    }
}
