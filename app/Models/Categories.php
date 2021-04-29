<?php

namespace App\Models;

use App\Models\Categories;
use App\Models\Model\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{
    public function children()
    {
        return $this->hasMany(Categories::class, 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }

    public function allProducts()
    {
        $allProducts = collect([]);

        $mainCategoryProducts = $this->products;

        $allProducts = $allProducts->concat($mainCategoryProducts);

        if ($this->children->isNotEmpty()) {
            foreach ($this->children as $child) {
                $allProducts = $allProducts->concat($child->products);
            }
        }

        return $allProducts;
    }
    use HasFactory;
}
