<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CartItem;

class User extends Authenticatable
{
    use HasFactory;

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
