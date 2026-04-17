<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAccordion extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'title', 'content', 'background_color'];
}
