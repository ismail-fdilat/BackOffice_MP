<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
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
        return $shop->Orders;
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
    public function store(Request $request, $shop)
    {
        $val = $request->cookie('Cart_Hash');

        if (!$val) {
            return 0;
        }

        $request->validate([
            'shipping_fullname' => 'required',
            'shipping_state' => 'required',
            'shipping_city' => 'required',
            'shipping_address' => 'required',
            'shipping_phone' => 'required',
            'shipping_zipcode' => 'required',
            'payment_method' => 'required',
        ]);

        $order = new Order();

        $order->order_number = uniqid('OrderNumber-');

        $order->shipping_fullname = $request->shipping_fullname;
        $order->shipping_state = $request->shipping_state;
        $order->shipping_city = $request->shipping_city;
        $order->shipping_address = $request->shipping_address;
        $order->shipping_phone = $request->shipping_phone;
        $order->shipping_zipcode = $request->shipping_zipcode;

        if (!$request->has('billing_fullname')) {
            $order->billing_fullname = $request->shipping_fullname;
            $order->billing_state = $request->shipping_state;
            $order->billing_city = $request->shipping_city;
            $order->billing_address = $request->shipping_address;
            $order->billing_phone = $request->shipping_phone;
            $order->billing_zipcode = $request->shipping_zipcode;
        } else {
            $order->billing_fullname = $request->billing_fullname;
            $order->billing_state = $request->billing_state;
            $order->billing_city = $request->billing_city;
            $order->billing_address = $request->billing_address;
            $order->billing_phone = $request->billing_phone;
            $order->billing_zipcode = $request->billing_zipcode;
        }
        $order->grand_total = \Cart::session($val)->getTotal();
        $order->item_count = \Cart::session($val)->getContent()->count();
        // id of the Client ;
        $order->user_id = $request->user_id;
        //Shop id to add
        $order->shop_id = $shop;

        if (request('payment_method') == 'paypal') {
            $order->payment_method = 'paypal';
        }

        $order->save();

        $cartItems = \Cart::session($val)->getContent();

        foreach ($cartItems as $item) {
            $order->items()->attach($item->id, ['price'=> $item->price, 'quantity'=> $item->quantity]);
        }

        // $order->generateSubOrders();

        if (request('payment_method') == 'paypal') {
            return "paypal";
            // return redirect()->route('paypal.checkout', $order->id);
        }

        \Cart::session($val)->clear();

        return $order;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
