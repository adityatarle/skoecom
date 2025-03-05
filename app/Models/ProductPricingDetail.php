<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPricingDetail extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'component', 'weight', 'rate', 'total_value'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
