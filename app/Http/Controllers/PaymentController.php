<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe\StripeClient;


use App\Models\Product;
use App\Models\Order;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function checkout(Request $request)
    {

        $order = $this->createOrder($request);

        $data = [];
        foreach ($order->products as $product) {
            array_push($data, [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->name,
                        'description' => $product->description
                    ],
                    'unit_amount' => $product->price * 100 // price*100
                ],
                'quantity' => $product->pivot->quantity // order_product

            ]);
        }
        $stripe = new StripeClient(config('stripe.api_key.secret'));

        $checkout_session = $stripe->checkout->sessions->create(
            [
                'mode' => 'payment',
                'line_items' => [
                    ...$data
                ],

                'success_url' => env('APP_URL') . '/success', // http://localhost:8000/sucess
                'cancel_url' => env('APP_URL') . '/cancel',
            ]
        );


        return redirect($checkout_session->url);
    }
    public function createOrder(Request $request)
    {

        $user = auth()->user();
        // $user = $request->user();

        $order = Order::create(['user_id' => $user->id]);

        foreach ($request->products as $productid){
            $product = Product::find($productid);
            $order->products()->attach($product, ['quantity' => $request->amount]);
            $product->amount= $product->amount - $request->amount;
            $product->save();
            $order->total_price+=$product->price * $request->amount;
            $order->save();
        }
        return $order;
    }
}
