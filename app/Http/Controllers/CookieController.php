<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//
 use Illuminate\Http\Response;
//
 use App\Models\Model\Product;

 class CookieController extends Controller
 {
     public function setcookie(Request $request, $content)
     {
         $response =new Response($content);
     }
     public function getcookie(Request $request)
     {
     }
 }
