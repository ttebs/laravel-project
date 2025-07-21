<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    protected $fillable = ['user_id', 'document_type', 'document_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}