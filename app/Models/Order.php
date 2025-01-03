<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function line_items(){
        return $this->hasMany(OrderLineItem::class, 'shopify_order_id','shopify_id');
    }

    public function session_order_items(){
        return $this->hasOne(SessionOrderItem::class, 'order_id','id');
    }
}
