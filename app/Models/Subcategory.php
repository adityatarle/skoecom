<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'category_id', 'parent_subcategory_id'];

    /**
     * A subcategory belongs to a category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * A subcategory can have a parent subcategory.
     */
    public function parentSubcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'parent_subcategory_id');
    }

    /**
     * A subcategory can have many child subcategories.
     */
    public function childSubcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class, 'parent_subcategory_id');
    }

    /**
     * Get all products for this subcategory.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'sub_category_id');
    }
}
