<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function index()
    {
        $products = Products::take(3)->get();
        $cartvalue = 0;

        // Check if the user is authenticated
        if (Auth::check()) {
            $cartvalue = Cart::where('user_id', Auth::user()->id)->count();
        }

        return view('welcome', compact('products','cartvalue'));
    }
    public function dashboard()
    {
        $user_type = Auth::user()->user_type; // Get the user type

        if ($user_type == 1) {
            // Fetch the total number of products
            $productcount = Products::all()->count();

            // Fetch all categories with their respective products
            $categories = Category::with(['products' => function ($query) {
                $query->select('category_id', 'price', 'id'); // Assuming you have these fields
            }])->get();

            // Prepare the sales data for each category
            $category_sales = $categories->map(function ($category) {
                $total_revenue = $category->products->sum('price');
                $product_count = $category->products->count();
                $percentage = ($total_revenue / Products::sum('price')) * 100; // Calculate percentage of total revenue

                return [
                    'category_name' => $category->name,
                    'product_count' => $product_count,
                    'total_revenue' => $total_revenue,
                    'percentage' => round($percentage, 2),
                ];
            });

            // Inventory Stats
            $total_products = Products::count();
            $average_price = Products::avg('price');
            $total_revenue = Products::sum('price');
            $low_stock_count = Products::where('id', '<', 5)->count(); // Assuming low stock threshold is 5

            return view('admin.index', compact('category_sales', 'productcount', 'total_products', 'average_price', 'total_revenue', 'low_stock_count'));
        }
        else {
            $products = Products::take(3)->get();
            $cartvalue = 0;

            // Check if the user is
            if (Auth::check()) {
                $cartvalue = Cart::where('user_id', Auth::user()->id)->count();
            }


            return view('welcome', compact('products','cartvalue')); // Load the welcome view for regular users
        }
    }

}
