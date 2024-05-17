<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Models\Order;

use App\Http\Controllers\Controller;

use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index2()
    {
        //

        $orders = Order::with(['user', 'products'])->get();

        $data = [];
        foreach ($orders as $order) {
            $newOrder = [];
            $newOrder['id'] = $order->id;
            $newOrder['total_price'] = $order->total_price;
            $newOrder['user'] = [
                'name' => $order->user->name,
                'email' => $order->user->email
            ];

            $newOrder['products'] = [];
            foreach ($order->products as $product) {
                array_push($newOrder['products'], [
                    'name' => $product->name,
                    'desciption' => $product->desciption,
                    'price' => $product->price,
                    'quantity' => $product->pivot->quantity
                ]);
            }

            array_push($data, $newOrder);
        }

        return response()->json(['orders' => $data]);
    }
    public function index()
    {
        //

        $authUser = auth()->user();
        $orders = Order::where('user_id', $authUser->id)->get();

        // return response()->json(['orders' => $orders]);
        return response()->json(['orders' => OrderResource::collection($orders), 'success' => true, 'message' => 'all orders retrieved successfully']);

        // return OrderResource::collection($orders);

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
    public function show($id)
    {
        //


        try {
            $order = Order::with(['user', 'products'])->find($id);

            // return response()->json(['order' => $order]);
            // return new OrderResource($order);

            if ($order) {
                return response()->json(['success' => true, 'message' => 'order returned successfully', 'order' => new OrderResource($order)]);
            } else {
                throw new Exception('order not found');
            }
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
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
}
