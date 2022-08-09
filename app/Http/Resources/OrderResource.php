<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderItemResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'status' => $this->status_translated,
            'order_date' => $this->order_date,
            'first_order_item' => [
                'product_name' => $this->orderItems->first()->productVariant->product->name,
                'product_quantity' => $this->orderItems->first()->quantity
            ],
            'order_items_count' => $this->orderItems->sum('quantity'),
            'total_price' => $this->total_price
        ];
    }
}
