<?php
namespace App\Factories\Services;

use Illuminate\Support\Facades\Http;

class Shopifyfactory implements IExternProductFactory
{
    private $config;
    public function __construct($config)
    {
        //dump("Shopify config was set in constructor...");
        $this->config = $config;
        //dump($this->config);
    }
    public function getProducts($url): string
    {
        $response = Http::get($url.".json");

        $output= $response->body();
      
        //  dump($output);
        return  $output;
    }
}
