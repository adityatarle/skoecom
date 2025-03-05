<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInquiry extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'product_id',
        'quantity', // Add the 'quantity' here.
    ];

    public function product() // Correct relationship name is 'product'
    {
        return $this->belongsTo(Product::class);
    }
}