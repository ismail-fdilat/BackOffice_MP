<?php
//
 namespace App\Http\Controllers;

//
// use Illuminate\Support\Facades\Auth;
//
 use Illuminate\Http\Request;
//
 use Illuminate\Http\Response;
//
 use App\Models\Model\Product;
 use Cookie;

//
// class CartController extends Controller
// {
    // public function add(Request $request, $product)
    // {
        // $header = $request->header('Authorization');
//
        // $Product =Product::findOrFail($product);
        // \Cart::session($header)->add(array(
        //  'id' => $Product->id,
        //  'name' => $Product->name,
        //  'price' => $Product->price,
        //  'quantity' => $Product->stock,
//         'attributes' => array(),
        //  'associatedModel' => $Product
        //  ));
      //   return \Cart::session($header)->getContent();
//
        // return redirect()->route('cart.show', ['cart'=> $header]);
    // }
    // public function show($id)
    // {
        // $items = \Cart::session($id)->getContent();
        // return $items;
    // }
// }
//<?php
/**
 * Created by PhpStorm.
 * User: darryl
 * Date: 4/30/2017
 * Time: 10:58 AM
 */

use App\Models\Coupon;
use Darryldecode\Cart\CartCondition;

class CartController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:sanctum')->except('index', 'show');
        $this->middleware('cors');
    }

    public function index(Request $request)
    {
        $val = $request->cookie('Cart_Hash');
        if (!$val) {
            return 0;
        }

        $userId = $val; // get this from session or wherever it came from


        $items = [];

        \Cart::session($userId)->getContent()->each(function ($item) use (&$items) {
            $items[] = $item;
        });

        return response(array(
            'cart_Hash'=> $val,
                'success' => true,
                'data' => $items,
                'message' => 'cart get items success'
            ), 200, []);
    }



    // add to cart

    public function add(Request $request, $shop, $product)
    {
        $Product =Product::findOrFail($product);

        $id = $Product->id;
        $name = $Product->name;
        $price = $Product->price;
        $qty = $Product->stock;

        $customAttributes = [
            'color_attr' => [
                'label' => 'red',
                'price' => 10.00,
            ],
            'size_attr' => [
                'label' => 'xxl',
                'price' => 15.00,
            ]
        ];
        $token = openssl_random_pseudo_bytes(16);

        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);
        //$token=uniqid('token');
        $response= new Response();
        $val = $request->cookie('Cart_Hash');
        if (!$val) {
            $val = $token;
        }

        $userId = $val; // get this from session or wherever it came from



        $item = \Cart::session($userId)->add($id, $name, $price, $qty, $customAttributes);


        $response= new Response(array(
            'success' => true,
            'data' => $Product,
            'cookie'=> $val,
            'message' => "item added."
        ), 201, []);
        if (!$request->cookie('Cart_Hash')) {
            $response->withCookie(cookie('Cart_Hash', $token, 120));
        }

        return $response;
    }



    public function delete(Request $request, $id)
    {
        $val = $request->cookie('Cart_Hash');

        if (!$val) {
            return 0;
        }

        $userId = $val; // get this from session or wherever it came from

        \Cart::session($userId)->remove($id);

        return response(array(
            'success' => true,
            'data' => $id,
            'message' => "cart item {$id} removed."
        ), 200, []);
    }
    private function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring = $characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }
    public function applyCoupon(Request $request, $id)
    {
        $couponCode = $request->coupon_code;

        $couponData = Coupon::where('shop-id', $id)->where('code', $couponCode)->first();

        if (!$couponData) {
            return  response(array(
            'message' => "coupon not found",
        ), 201, []);
        }


        //coupon logic
        $condition = new \Darryldecode\Cart\CartCondition(array(
            'name' => $couponData->name,
            'type' => $couponData->type,
            'target' => 'total',
            'value' => $couponData->value,
        ));

        $val = $request->cookie('Cart_Hash');

        if (!$val) {
            return 0;
        }



        Cart::session($val)->condition($condition); // for a speicifc user's cart


        return response(array(
            'message' => "coupon applied",
        ), 200, []);
    }
}
