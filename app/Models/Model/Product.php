<?php

namespace App\Models\Model;

use App\Models\Shop;

use App\Models\Categories;

use App\Models\Model\Review;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    protected $fillable = [
           "name","detail","stock","price","discount","user_id"
    ];
    public function reviews()
    {
        return $this->hasMany(Review::class) ;
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function categorie()
    {
        return $this->belongsTo(Categories::class);
    }
    use HasFactory;
}
