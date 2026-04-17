<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'quantity',
        'price',
        'discount',
        'main_image',
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
