<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'nama', 'deskripsi', 'harga', 'kategori_id', 'stock'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function cartItems() {
        return $this->hasMany(CartItem::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
