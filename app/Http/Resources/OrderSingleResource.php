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
            'status' => $this->status_translated,
            'order_date' => $this->order_date,
            'order_items' => OrderItemResource::collection($this->orderItems),
            'shipping_info' => [
                'courier' => config('constants.shipping.courier'),
                'fullname' => $this->shipping->fullname,
                'phone' => $this->shipping->phone,
                'address' => $this->shipping->address,
                'shipping_cost' => $this->shipping->shipping_cost
            ],
            'total_price' => $this->total_price,
            'total_weight' => $this->orderItems->reduce(
                                function ($carry, $item) {
                                    return $carry + $item->productVariant->weight;
                                }, 0
                            ),
            'total_payment' => $this->orderItems->sum('subtotal_price') + $this->shipping->shipping_cost
        ];
    }
}
