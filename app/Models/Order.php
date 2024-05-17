<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price'];

    function user(){
        return $this->belongsTo(User::class);
    }

    function products(){ //order_product
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}


//user create more than order
// order belongs to one user
// order has many products
// product belongs to many order

