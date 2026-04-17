<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'tagline',
        'description',
        'quantity',
        'price',
        'original_price',
        'discount',
        'review_count',
        'main_image',
        'badges_json',
        'gallery_images_json',
        'tabs_json',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'badges_json' => 'array',
        'gallery_images_json' => 'array',
        'tabs_json' => 'array',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function accordions()
    {
        return $this->hasMany(ProductAccordion::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }
}
