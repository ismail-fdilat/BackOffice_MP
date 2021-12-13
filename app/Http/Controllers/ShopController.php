<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use App\Mail\ShopCreated;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ShopController extends Controller
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
    public function index()
    {
        return Shop::All();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'shops.create';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function newStore(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'shop_name' => 'required'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'role'=>'admin'
        ]);


        $shop = $user->shop()->create([
            'name'        => $request->shop_name,
            'description' => $request->shop_description,
        ]);


        //send mail to admin
        Mail::to($user->email)->send(new ShopCreated($shop, $user));

        $response = [
            'user' => $user,
            'Shop' => $shop,
            'domainName'=> $user->name.'.'.$shop->name.'.enjoy.com'
        ];

        return response($response, 201);
    }
    public function store(Request $request)
    {
        //add validation
        $request->validate([
            'name' => 'required'
        ]);

        //save db
        $user = Auth::user();

        $shop = $user->shop()->create([
            'name'        => $request->input('name'),
            'description' => $request->input('description'),
        ]);


        //send mail to admin

        $admins = User::whereHas('role', function ($q) {
            $q->where('name', 'admin');
        })->get();

        //Mail::to($admins)->send(new ShopActivationRequest($shop));
        $response = [
            'user' => $user,
            'Shop' => $shop,
            'domainName'=> $user->name.'.'.$shop->name.'.enjoy.com'
        ];
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shop= Shop::findOrFail($id);
        $users=User::where('shop_id', '=', $shop->id)->get();

        return response(["owner"=>$shop->owner->name,
                         "shopname"=>$shop->name,
                          "users"=>$users ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shop = Shop::where('id', '=', $id)->first();

        $shop->update($request->all());

        return response([
            "data"=> $shop
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Shop $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy($shop)
    {
        Shop::destroy($shop);
        return response(
            null,
            204
        );
    }
}
