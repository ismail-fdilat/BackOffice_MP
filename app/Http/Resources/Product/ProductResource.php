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
    public function toArray($request)
    {
        return[
            'name'=>$this->name,

            'detail'=>$this->detail,

            'price' =>$this->price,

            'TotalPrice'=>round($this->price-$this->price*$this->discount/100, 2),

            'stock'=>$this->stock >0 ?$this->stock : "out of stock",

            'discount'=>$this->discount,

            'rating'=>$this->reviews->count()>0 ? round($this->reviews->sum('star')/$this->reviews->count()):'no rating found',

            'hero_image'=> $this->hero_image,


            'href'=>[
                'reviews'=> route('Reviews.index', $this->id),
                'images'=>route('Images.index', $this->id)
            ]

        ];
    }
}
