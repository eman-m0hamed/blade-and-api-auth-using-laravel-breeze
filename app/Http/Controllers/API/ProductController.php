<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try{
            // $products = Product::get();
            $products = Product::with('orders.user.orders')->get();

            // orders
            // orders.user => user
            // orders.user.orders => user.orders

            return response(['products'=>$products, 'message'=>'all products retrieved successfully', 'success'=>true]);
        }catch(\Exception $e){
            return response(['error'=>'server error, please try again', 'success'=>false],500);
        }


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
    public function show( $id)
    {
        //

       $product= Product::find($id);

       if($product){
           return response()->json(['success'=>true, 'product'=>$product, 'message'=>'get product successfully']);
       }else{
            return response()->json(['success' => false, 'error' => 'product not found'],404);
       }
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
}
