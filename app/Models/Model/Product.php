<?php

namespace App\Models\Model;

use App\Models\Shop;

use App\Models\Categories;

use App\Models\Model\Review;
use App\Models\ProductImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    protected $fillable = [
           "name","detail","stock","price","discount","shop_id","min-stock","status"
    ];
    public function reviews()
    {
        return $this->hasMany(Review::class) ;
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function category()
    {
        return $this->belongsToMany(Categories::class, "product_categories", "product_id", "categorie_id");
    }
    public function images()
    {
        return $this->hasMany(ProductImages::class) ;
    }
    use HasFactory;
}
