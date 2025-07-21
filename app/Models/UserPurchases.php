<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPurchases extends Model
{
    protected $fillable = ['user_id', 'product_id', 'quantity', 'payment_method', 'delivery_address'];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}