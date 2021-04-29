<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factories\Manager\IProductManager;

class ExternPoductController extends Controller
{
    public function store(Request $request)
    {
        $output = shell_exec('node ./ExternProduct/wappalyser.js '. $request->Url);
        $factory = app(IProductManager::class);
        $service = $factory->make(trim($output));
        $product = $service->getProducts($request->Url);
        //$productinfo = trim($product);
        // $productinfo =implode(",", $productinfo);

        //dump($product);

        // dump($productinfo);
        return response([
            "Url"=> $request->Url,
            "output"=> trim($output),
            "productinfo"=> json_decode($product)

            

        ], 201);
    }
}
