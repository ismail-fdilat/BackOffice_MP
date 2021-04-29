<?php

namespace App\Models\Model;

use App\Models\Model\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        "customer","star","review"
    ];
    public function product()
    {
        return $this->belongsTo(Product::class) ;
    }
    use HasFactory;
}
