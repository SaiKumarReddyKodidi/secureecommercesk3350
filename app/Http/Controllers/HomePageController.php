<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

class HomePageController extends Controller
{
    public function about()
    {
        $cartvalue = 0;

        // Check if the user is authenticated
        if (Auth::check()) {
            $cartvalue = Cart::where('user_id', Auth::user()->id)->count();
        }
        return view ("home.about", compact('cartvalue'));
    }

    public function shop()
    {
        $cartvalue = 0;

        // Eager load categories with products
        $products = Products::with('category')->get();
        // Check if the user is authenticated
        if (Auth::check()) {
            $cartvalue = Cart::where('user_id', Auth::user()->id)->count();
        }
        $categories = Category::all();

        return view("home.shop", compact('categories','products','cartvalue'));
    }
    public function shopByCategory(Request $request)
    {
        $cartvalue = 0;

        $categories = Category::all();
        $categoryName = $request->query('category');
        $category = Category::where('name', $categoryName)->firstOrFail(); // Find category by name

//         Fetch products based on category if needed
         $products = Products::where('category_id', $category->id)->get();
        // Check if the user is authenticated
        if (Auth::check()) {
            $cartvalue = Cart::where('user_id', Auth::user()->id)->count();
        }


        return view("home.categoryshop", compact('category','products','categories','cartvalue')); // Pass category to view
    }


    public function contact()
    {
        $cartvalue = 0;

        // Check if the user is authenticated
        if (Auth::check()) {
            $cartvalue = Cart::where('user_id', Auth::user()->id)->count();
        }        $cartvalue = 0;


        return view ("home.contact", compact('cartvalue'));
    }
    public function cart(Request $request)
    {
        // Get the product id from the query parameter
        $id = $request->query('id');

        // Get the current user's ID
        $user_id = Auth::user()->id;

        // Check if the product is already in the cart
        $cartItem = Cart::where('product_id', $id)->where('user_id', $user_id)->first();

        if ($cartItem) {
            // Product exists, increment the quantity
            $cartItem->quantity += 1; // Assuming you have a 'quantity' column
            $cartItem->save();
        } else {
            // Product does not exist, create a new entry with quantity 1
            $cart = new Cart();
            $cart->product_id = $id;
            $cart->user_id = $user_id;
            $cart->quantity = 1; // Set initial quantity to 1

            // Encrypt the cart data (e.g., product_id and quantity)
            $cartData = [
                'product_id' => $id,
                'quantity' => 1
            ];

            // Encrypt the cart data before saving it
            $cart->encrypted_data = Crypt::encryptString(json_encode($cartData));  // Encrypt and store data

            $cart->save();
        }

        // Redirect to the cart view with a success message
        return redirect()->route('viewcart')->with('success', 'Product added to cart successfully!');
    }

    public function shopsingle(Request $request)
    {
        // Get the product ID from the query string
        $id = $request->query('id');

        // Retrieve the product using the ID (using `find()` instead of `get()`)
        $product = Products::find($id);  // Use find() to get a single product by its ID
        $cartvalue = 0;

        // Check if the user is authenticated
        if (Auth::check()) {
            $cartvalue = Cart::where('user_id', Auth::user()->id)->count();
        }

        // Pass the single product to the view
        return view('home.shopsingle', compact('product','cartvalue'));
    }


    public function viewcart()
    {
        // Retrieve cart items for the current user
        $cartItems = Cart::where('user_id', Auth::user()->id)->get();

        // Initialize subtotal
        $subtotal = 0;

        // Retrieve products and calculate subtotal
        $products = [];
        foreach ($cartItems as $cartItem) {
            // Decrypt the encrypted data
            $decryptedData = Crypt::decryptString($cartItem->encrypted_data);
            $cartData = json_decode($decryptedData, true); // Decode the JSON string

            // Retrieve the product using the decrypted product_id
            $product = Products::find($cartData['product_id']);
            if ($product) {
                $product->quantity = $cartData['quantity']; // Add quantity to the product object
                $products[] = $product;
                $subtotal += $product->price * $cartData['quantity']; // Calculate subtotal
            }
        }

        // Assuming no additional fees for simplicity
        $total = $subtotal; // You can add taxes or discounts here if needed
        $cartvalue = 0;

        // Check if the user is authenticated
        if (Auth::check()) {
            $cartvalue = Cart::where('user_id', Auth::user()->id)->count();
        }

        return view("home.cart", compact('products', 'cartvalue', 'subtotal', 'total'));
    }

    public function updateCart(Request $request)
    {
        // Get the product ID and new quantity from the request
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Update the cart item for the current user
        $cartItem = Cart::where('user_id', Auth::user()->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // Assuming you want to update the quantity in the Cart model
            $cartItem->quantity = $quantity; // Make sure to have a quantity column in your Cart model
            $cartItem->save();
        }

        return redirect()->route('viewcart')->with('success', 'Cart updated successfully!');
    }


    public function removeFromCart(Request $request)
    {
        $productId = $request->input('product_id');
        $userId = auth()->id(); // Get the logged-in user's ID

        // Find the cart entry for the user and product
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->delete(); // Delete the cart item
            return redirect()->back()->with('success', 'Product removed from cart.');
        }


        return redirect()->back()->with('error', 'Product not found in cart.');
    }

    public function processCheckout(Request $request)
    {
        $cartvalue = 0;

        // Check if the user is authenticated
        if (Auth::check()) {
            $cartvalue = Cart::where('user_id', Auth::user()->id)->count();
        }

        // Retrieve submitted products
        $products = $request->input('products'); // This will be an associative array

        $subtotal = 0; // Initialize the subtotal
        $productDetails = []; // To store the product details in session

        // Debugging: Check if products are received correctly
        if ($products) {
            foreach ($products as $productId => $productData) {
                // Accessing individual product details
                $name = $productData['name'];
                $price = $productData['price'];
                $quantity = $productData['quantity'];

                // Calculate total for each product and add to the subtotal
                $total = $price * $quantity;
                $subtotal += $total;

                // Store product details
                $productDetails[] = [
                    'product_id' => $productId,
                    'name' => $name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'total' => $total
                ];
            }
        }

        // Store subtotal and product details in session
        session(['subtotal' => $subtotal, 'products' => $productDetails]);

        $publishableKey = env('STRIPE_KEY');  // Fetch the publishable key from .env

        return view('home.checkout', compact('cartvalue', 'products', 'publishableKey'));
    }
    public function order()
    {
        if (Auth::check()) {
            // Get the count of items in the user's cart
            $cartvalue = Cart::where('user_id', Auth::user()->id)->count();

            // Get the payments and their associated product details for the authenticated user
            $payments = Payment::with('product') // Eager load the 'product' relationship
            ->where('user_id', Auth::user()->id)
                ->get();
        }



        // Pass the cart count and the payments data to the order view
        return view('home.order', compact('cartvalue', 'payments'));
    }





}
