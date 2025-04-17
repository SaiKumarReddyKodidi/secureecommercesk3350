<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function update()
    {
        $categories =Category::all();
        return view ('admin.update', compact('categories'));
    }
    public function view()
    {
        // Eager load categories with products
        $products = Products::with('category')->get();
        $categories = Category::all();


        return view('admin.view', compact('categories', 'products'));
    }



    public function storeProduct(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        // Create a new product
        $product = new Products();

        // Assign form input to product fields
        $product->name = $request->input('name');
        $product->category_id = $request->input('category');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        // Handle image upload if a file is provided
        if ($request->hasFile('image')) {
            // Get the uploaded image file
            $image = $request->file('image');

            // Create a unique filename for the image
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();

            // Define the destination path where the image will be stored
            $destinationPath = public_path('storage/products'); // This is public/storage/products

            // Ensure the directory exists, create it if not
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Move the uploaded image to the destination folder
            $image->move($destinationPath, $filename);

            // Store the relative path in the database
            $product->image = 'storage/products/' . $filename;  // This is the URL path
        }

        // Save the new product to the database
        $product->save();

        // Return a JSON response
        return response()->json([
            'message' => 'Product added successfully!',
            'product' => $product,  // Optionally include the updated product data in the response
        ], 200);
    }


}
