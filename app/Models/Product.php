<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function has_variant(){
        return $this->hasMany(ProductVariant::class,'shopify_product_id','shopify_id');
    }
}
