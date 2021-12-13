<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getImages($link)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
              CURLOPT_URL => $link,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
            ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    // to array =>

    public function toArray($request)
    {
        return[
            'id'=> $this->id,

            'name'=>$this->name,

            'detail'=>$this->detail,

            'price' =>$this->price,

            'TotalPrice'=>round($this->price-$this->price*$this->discount/100, 2),

            'stock'=>$this->stock >0 ?$this->stock : "out of stock",

            'discount'=>$this->discount,
            'status'=>$this->status,
            'rating'=>$this->reviews->count()>0 ? round($this->reviews->sum('star')/$this->reviews->count()):'no rating found',

            'min_stock'=>$this->min_stock,

            'href'=>[
                'reviews'=> route('reviews.index', $this->id),
                'images'=>  $this->images
            ]

        ];
    }
}
