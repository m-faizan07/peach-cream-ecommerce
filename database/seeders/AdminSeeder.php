<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAccordion;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@peachcream.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        $product = Product::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Peach Cream',
                'description' => 'Skincare-first comfort and hydration.',
                'quantity' => 100,
                'price' => 60,
                'discount' => 10,
                'main_image' => 'products/default-main.png',
            ]
        );

        if ($product->images()->count() === 0) {
            ProductImage::create(['product_id' => $product->id, 'image_path' => 'products/default-main.png']);
        }

        if ($product->accordions()->count() === 0) {
            ProductAccordion::create([
                'product_id' => $product->id,
                'title' => 'Description',
                'content' => 'Daily skincare support for delicate skin.',
                'background_color' => '#fff5f8',
            ]);
        }
    }
}
