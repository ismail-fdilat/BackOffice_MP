<?php

namespace App\Models;

use App\Models\Model\Product;

use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function items()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id')->withPivot('quantity', 'price');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    use HasFactory;
}
