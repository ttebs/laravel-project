<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'seller', 'image'];

    public function seller()
    {
        // return $this->belongsTo(UserStore::class, 'seller');
        return $this->belongsTo(UserStore::class, 'seller', 'user_id');
    }

}