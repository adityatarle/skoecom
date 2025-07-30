<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'image', 
        'parent_id', 
        'level', 
        'slug', 
        'description', 
        'is_active', 
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'level' => 'integer',
        'sort_order' => 'integer'
    ];

    // Level constants
    const LEVEL_TOP = 1;
    const LEVEL_PARENT = 2;
    const LEVEL_CHILD = 3;

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
        
        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get the parent category
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    /**
     * Get child categories
     */
    public function children(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Get all descendants (children, grandchildren, etc.)
     */
    public function descendants(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id')->with('descendants');
    }

    /**
     * Get all products for this category
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * Get subcategories (legacy support)
     */
    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class, 'category_id');
    }

    /**
     * Scope for top level categories
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id')->where('level', self::LEVEL_TOP);
    }

    /**
     * Scope for active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the full category path
     */
    public function getFullPathAttribute()
    {
        $path = collect([$this->name]);
        $parent = $this->parent;
        
        while ($parent) {
            $path->prepend($parent->name);
            $parent = $parent->parent;
        }
        
        return $path->implode(' > ');
    }

    /**
     * Get level name
     */
    public function getLevelNameAttribute()
    {
        return match($this->level) {
            self::LEVEL_TOP => 'Top Level',
            self::LEVEL_PARENT => 'Parent Category',
            self::LEVEL_CHILD => 'Child Category',
            default => 'Unknown'
        };
    }

    /**
     * Check if category has children
     */
    public function hasChildren()
    {
        return $this->children()->exists();
    }

    /**
     * Get all products including from child categories
     */
    public function allProducts()
    {
        $productIds = collect([$this->id]);
        
        // Add all descendant category IDs
        $this->descendants->each(function ($descendant) use ($productIds) {
            $productIds->push($descendant->id);
        });
        
        return Product::whereIn('category_id', $productIds);
    }
}
