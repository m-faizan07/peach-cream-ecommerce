<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAccordion;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function edit()
    {
        $product = Product::with(['images', 'accordions'])->firstOrCreate(
            ['id' => 1],
            ['title' => 'Peach Cream', 'description' => 'Default product', 'quantity' => 0, 'price' => 0, 'discount' => 0]
        );

        return view('admin-backend.products-edit', compact('product'));
    }

    public function update(Request $request)
    {
        $product = Product::firstOrFail();
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'main_image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('main_image')) {
            $data['main_image'] = $request->file('main_image')->store('products', 'public');
        }

        $product->update($data);
        return back()->with('status', 'Product updated.');
    }

    public function addImage(Request $request)
    {
        $request->validate(['image' => ['required', 'image', 'max:2048']]);
        $product = Product::firstOrFail();
        $path = $request->file('image')->store('products', 'public');
        ProductImage::create(['product_id' => $product->id, 'image_path' => $path]);
        return back()->with('status', 'Sub image added.');
    }

    public function deleteImage(ProductImage $image)
    {
        $image->delete();
        return back()->with('status', 'Sub image removed.');
    }

    public function addAccordion(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'background_color' => ['nullable', 'string', 'max:50'],
        ]);
        $product = Product::firstOrFail();
        ProductAccordion::create($data + ['product_id' => $product->id]);
        return back()->with('status', 'Accordion added.');
    }

    public function deleteAccordion(ProductAccordion $accordion)
    {
        $accordion->delete();
        return back()->with('status', 'Accordion removed.');
    }
}
