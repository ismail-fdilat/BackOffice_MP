<?php
namespace App\Factories\Manager;

use App\Factories\Services\IExternProductFactory;

use App\Factories\Services\WoocommerceFactory;

use App\Factories\Services\ShopifyFactory;

use Illuminate\Support\Arr;

class ProductManager implements IProductManager
{
    private $shops = [];
    private $app;
    public function __construct($app)
    {
        $this->app = $app;
    }
    public function make($name): IExternProductFactory
    {
        $service = Arr::get($this->shops, $name);
        // No need to create the service every time
        if ($service) {
            return $service;
        }
        $createMethod = 'create' . ucfirst($name) . 'ShopService';
        if (!method_exists($this, $createMethod)) {
            throw new \Exception("CMS $name is not supported");
        }
        $service = $this->{$createMethod}();
        $this->shops[$name] = $service;
        return $service;
    }
    private function createWoocommerceShopService(): WoocommerceFactory
    {
        // dump("Creating WoocommerceFactory...");
        $config = $this->app['config']['shops.Woocommerce'];
        $service = new WoocommerceFactory($config);
        // Do the necessary configuration to use the Woocommerce service
        return $service;
    }
    private function createShopifyShopService(): ShopifyFactory
    {
        //dump("Creating ShopifyFactory...");
       
        $config = $this->app['config']['shops.Shopify'];
        $service = new ShopifyFactory($config);
        // Do the necessary configuration to use theShopify service
        return $service;
    }
}
