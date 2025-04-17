<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{


    public function checkout(Request $request)
    {
        // Log Stripe keys for debugging
        Log::info('STRIPE_SECRET: ' . env('STRIPE_SECRET'));
        Log::info('STRIPE_KEY: ' . env('STRIPE_KEY'));

        // Set the Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Retrieve the amount from the session
        $amount = session('subtotal') * 100; // Convert to cents

        // Log the amount to confirm it's being retrieved correctly
        Log::info('Amount retrieved from session: ' . $amount);

        try {
            // Create a payment intent with the retrieved amount
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,  // The amount in cents
                'currency' => 'usd',  // Currency can be customized
            ]);

            // Send the client secret to the front-end for Stripe's client-side processing
            return response()->json(['clientSecret' => $paymentIntent->client_secret]);
        } catch (ApiErrorException $e) {
            // Log Stripe error message if something goes wrong
            Log::error('Stripe API error: ' . $e->getMessage());

            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function processPayment(Request $request)
    {
        // Log Stripe keys for debugging (optional)
        Log::info('STRIPE_SECRET: ' . env('STRIPE_SECRET'));
        Log::info('STRIPE_KEY: ' . env('STRIPE_KEY'));

        // Set the Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Retrieve payment method ID and payment intent ID from the request
        $paymentMethodId = $request->input('payment_method_id');
        $paymentIntentId = $request->input('payment_intent_id');

        try {
            // Confirm the payment intent on the server side
            $paymentIntent = PaymentIntent::confirm(
                $paymentIntentId,
                ['payment_method' => $paymentMethodId]
            );

            // Check the payment status
            if ($paymentIntent->status == 'succeeded') {
                // The payment was successful

                // Retrieve the product details from the session
                $products = session('products'); // Session stores the product details
                $userId = Auth::id(); // Assuming the user is logged in

                // Loop through the products and insert each record into the 'payments' table
                foreach ($products as $product) {
                    Payment::create([
                        'user_id' => $userId,
                        'product_id' => $product['product_id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'quantity' => $product['quantity'],
                        'total' => $product['total'],
                        'purchase_status' => 'success',  // Mark as success if payment is successful
                    ]);
                }

                // Check if the user has any items in the Cart table and delete them
                $cartItems = Cart::where('user_id', $userId)->get();
                if ($cartItems->count() > 0) {
                    // Clear the user's cart after the payment is successful
                    Cart::where('user_id', $userId)->delete();
                }

                // Clear the session data after successful payment
                session()->forget('products');
                session()->forget('subtotal');

                // Return a success message view
                return view('home.alert')->with('status', 'Payment successful!');
            } else {
                // The payment failed
                return view('home.alert')->with('status', 'Payment failed!');
            }
        } catch (ApiErrorException $e) {
            // Log the error if something goes wrong
            Log::error('Stripe API error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function handleSuccess(Request $request)
    {
        // Assuming the user is logged in and products are in session
        $userId = Auth::id(); // Get the logged-in user's ID
        $products = session('products'); // Retrieve the products from session (if stored earlier)

        // Update the payments table and mark order as successful
        foreach ($products as $product) {
            Payment::create([
                'user_id' => $userId,
                'product_id' => $product['product_id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
                'total' => $product['total'],
                'purchase_status' => 'success',  // Mark as success
            ]);
        }

        // Clear cart and session data after successful payment
        Cart::where('user_id', $userId)->delete(); // Clear the cart
        session()->forget('products'); // Forget the session products
        session()->forget('subtotal'); // Forget the subtotal
        $cartvalue = 0;

        // Check if the user is authenticated
        if (Auth::check()) {
            $cartvalue = Cart::where('user_id', Auth::user()->id)->count();
        }
        // Return a success view or redirect to a confirmation page
        return view('home.alert', ['status' => 'Payment successful!'], compact('cartvalue'));
    }



}
