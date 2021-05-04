<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $fillable = [
        "images"
    ];
    public function product()
    {
        return $this->belongsTo(Product::class) ;
    }
}
