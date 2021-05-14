<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Model\Product;
use App\Models\ProductImages;
use Illuminate\Support\Facades\File;

class ProductImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $imgurl=[];
        foreach ($product->images as $image) {
            array_push($imgurl, ['id'=>$image->id, 'image'=>$image->images]);
        } ;
        return response([
            'images'=>$imgurl
        ], 200);
        //return $product->images;
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
    public function store(Request $request, Product $product)
    {
        $imageName = time().'.'.$product->id.'.'.$request->images->extension();

        $request->images->move(public_path('images/products'), $imageName);

        $PI = new ProductImages($request->all());

        $PI->images='images/products/'.$imageName;

        $product->images()->save($PI) ;
        return response([
            'data'=> 'images/products/'.$imageName
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductImages  $productImages
     * @return \Illuminate\Http\Response
     */
    public function show($product, $id)
    {
        $Image = ProductImages::findOrFail($id);
        return response(["data"=>$Image], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductImages  $productImages
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductImages $productImages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductImages  $productImages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductImages $productImages)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductImages  $productImages
     * @return \Illuminate\Http\Response
     */
    public function destroy($product, $id)
    {
        $Image = ProductImages::findOrFail($id);
        File::delete(public_path('/').$Image->images);
        ProductImages::destroy($id);
        return response(["data"=>$Image], 201);
    }
}
