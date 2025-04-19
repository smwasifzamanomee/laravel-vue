<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'image',
        'category_id',
        'discount_price',
        'status',
        'featured',
        'popular'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }
}
