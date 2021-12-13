<?php

namespace App\Http\Controllers;

use App\Models\Model\Product;

use App\Models\Shop;

use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductResource;
use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Resources\Product\ProductCollection;

use App\Http\Requests\ProductRequest;
use App\Models\Categories;

class ProductController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:sanctum')->except('index', 'show');
        $this->middleware('cors');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Shop $shop)
    {
        //return $shop->products;
        return ProductResource::collection($shop->products);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request, $shop_id)
    {
        $product = new Product;

        $product->name = $request->name;

        $product->detail = $request->description;

        $product->stock = $request->stock;

        $product->price = $request->price;

        $product->discount = $request->discount;

        $product->min_stock = $request->min_stock;

        $product->status = $request->status;

        $product->shop_id = $shop_id;
        $product->save();

        if ($request->category) {
            $category = Categories::findOrFail($request->category);
            //saving product by category

            $product->category()->attach($category);
        }
        //return 'ok';
        return response([
            "data"=> new ProductResource($product)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($shop, $id)
    {
        //return 'ok';
        return Product::findOrFail($id);
        //return new ProductResource(Product::findOrFail($product));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $shop, $id)
    {
        $product = Product::where('id', '=', $id)->first();

        $request['detail']= $request->description;
        unset($request['description']);
        $product->update($request->all());

        return response([
            "data"=> new ProductResource($product)
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($shop, $id)
    {
        $product = Product::where('id', '=', $id)->first();


        Product::destroy($id);
        return response(
            null,
            204
        );
    }
    public function search($shop, $name)
    {
        return Product::where('shop_id', '=', $shop->id)->where('name', 'like', '%'.$name.'%')->get();
    }
}
