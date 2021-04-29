<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCollection extends JsonResource
{
    /**

     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // implode(" ", array_splice((explode(" ", $this->detail))));
        return[
            'name'=> $this->name,

            'price' => $this->price,

            'TotalPrice'=> round($this->price-$this->price*$this->discount/100, 2),
            
            'stock'=> $this->stock >0 ?$this->stock : "out of stock",

            'rating'=> $this->reviews->count()>0 ? round($this->reviews->sum('star')/$this->reviews->count()):'no rating found',

            'images'=> "https://source.unsplash.com/3000x3000/?product",

            'href'=>[
                'link'=> route('Products.show', $this->id)
            ]
        ];
    }
}
