<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Shop;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Auth;

class AuthController extends Controller
{
    // protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    // {
    //     throw new \Illuminate\Validation\ValidationException(response()->json($validator->errors(), 422));
    // }
    public function register(Request $request, Shop $shop)
    {
        $fields = validate($request, [
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
          //      'Shop' => $shop,
            'token' => $token
        //      'Request'=>$request->name

        ];

        return response($response, 201);
    }

    public function login(Request $request, Shop $shop)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();
        $Stores = Shop::where('user_id', $user->id)->get();
        foreach ($Stores as $store) {
            // Check Store
            if ($store->id != $shop->id) {
                return response([
                'message' => 'No user found'
            ], 401);
            }
        }

        // Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }







    public function Adminlogin(Request $request, Shop $shop)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();
        $Stores = Shop::where('user_id', $user->id)->get();
        foreach ($Stores as $store) {
            // Check Store
            if ($store->id != $shop->id) {
                return response([
                'message' => 'No user found'
            ], 401);
            }
        }

        // Check password

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }
        if ($user->role !='admin') {
            return response([
                'message' => 'you are not allowed to access as administrator'
            ], 401);
        }

        // $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'shop'=> $shop,
         //   'token' => $token
        ];

        return response($response, 201);
    }
    public function logout(Request $request, Shop $shop)
    {
        auth()->user()->tokens()->delete();
        $request->user()->currentAccessToken()->delete();

        return [
            'message' =>$request->user()->name .' is disconnected'
        ];
    }
}
