<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
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
    public function index($id)
    {
        $category = Categories::where('shop_id', $id)->get();
        return $category;
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
    public function store(Request $request, $shop_id)
    {
        $category = new Categories;

        $category->name = $request->name;

        $category->slug = $request->slug;

        $category->shop_id = $shop_id;
        //saving linked to the parent category
        if ($request->parent_id != null) {
            $pcategory = Categories::findOrFail($request->parent_id);
            $category->order = $pcategory->order +1;
            $pcategory->children()->save($category);
        } else {

        //saving as the root parent category

            $category->order = 0;
            $category->save();
        }

        //return 'ok';
        return response([
            "data"=> $category
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show($shop_id, $cid)
    {
        $category= Categories::findOrFail($cid);


        return response([
                'category' => $category,
               // 'childrenofthecategory'=>$category->children,
                'Allproducts'=>$category->getallProducts()
            ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $shop_id, $id)
    {
        $categories = Categories::where('id', '=', $id)->first();

        $categories->update($request->all());

        return response([
            "data"=> $categories
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($shop_id, $categories)
    {
        Shop::destroy($categories);
        return response(
            null,
            204
        );
    }
}
