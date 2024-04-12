<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductImageController extends Controller
{
    public function index(int $productId)
    {
        $product = Product::findOrFail($productId);

        $productImages = ProductImage::where('product_id', $productId)->get();

        return view('product-image.index', compact('product', 'productImages'));
    }
    public function store(Request $request, int $productId)
    {
        // Convert $productId to integer
        $productId = (int)$productId;

        // Validate data
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,jpg,png,gif|max:5120'
        ]);

        // Find the product by ID or throw a 404 error if not found
        $product = Product::findOrFail($productId);

        $imageData = [];
        if ($files = $request->file('images')) { 
            foreach ($files as $key => $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = $key . '_' . time() . '_' . $extension; 
                $path = "MultiUploadsImage/productsImage/";
                $file->move($path, $filename);
                $imageData[] = [
                    'product_id' => $product->id,
                    'image' => $path . $filename,
                ];
            }
        }
        // Insert image data into the database
        ProductImage::insert($imageData);

        return redirect()->back()->with('status', 'Uploaded Successfully'); 
    }
    public function destroy(int $productImageId)
    {
        $productImage = ProductImage::findOrFail($productImageId);
        if (File::exists($productImage->image)) {
            File::delete($productImage->image);
        }
        $productImage->delete();
        return redirect()->back()->with('status', 'Image Deleted');
    }
}
