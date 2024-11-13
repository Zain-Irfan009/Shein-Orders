<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLineItem extends Model
{
    use HasFactory;
    public function order(){
        return $this->hasOne(Order::class, 'order_id','order_id');
    }
    public function product(){
        return $this->hasOne(Product::class, 'shopify_id','shopify_product_id');
    }

    public function product_varient(){
        return $this->hasOne(ProductVariant::class, 'shopify_id', 'shopify_variant_id');
    }
}
