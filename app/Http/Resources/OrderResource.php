<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $data
        = [
            'orderId' => $this->id,
            'totalPrice' => $this->total_price . "$",
            'products' => $this->products->map(function ($product) {
                return [
                    'productName' => $product->name,
                    'productDesciption' => $product->desciption,
                    'productPrice' => $product->price,
                    'productQuantity' => $product->pivot->quantity
                ];
            }),
            'test'=>'test order'

        ];

        if(auth()->user()->role=='admin'){
            $data['createdBy']= [
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
            ];
        }

        return $data;
    }
}
