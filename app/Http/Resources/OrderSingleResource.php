<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderSingleResource extends JsonResource
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
            'order_id' => $this->id,
            'order_status' => $this->status_translated,
            'order_date' => $this->order_date,
            'order_items' => OrderItemResource::collection($this->orderItems),
            'order_quantity' => $this->orderItems->sum('quantity'),
            'shipping_info' => [
                'courier' => strtoupper(config('constants.shipping.courier')),
                'fullname' => $this->shipping->fullname,
                'phone' => $this->shipping->phone,
                'address' => $this->shipping->address,
                'shipping_cost' => $this->shipping->shipping_cost
            ],
            'payment_method' => $this->payment->payment_method,
            'total_price' => $this->orderItems->sum('subtotal_price'),
            'total_weight' => $this->orderItems->reduce(
                                function ($carry, $item) {
                                    return $carry + $item->productVariant->weight;
                                }, 0
                            ),
            'total_payment' => $this->total_price
        ];
    }
}
