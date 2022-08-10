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
        $featured_image_url = optional($this->orderItems->first()->productVariant->product->medias->where('is_featured', 1)->first())->path;
        $firstProductQuantity = $this->orderItems->first()->quantity;
        $orderItemQuantity = $this->orderItems->sum('quantity');

        return [
            'order_id' => $this->id,
            'order_status' => $this->status_translated,
            'order_date' => $this->order_date,
            'first_order_item' => [
                'product_name' => $this->orderItems->first()->productVariant->product->name,
                'product_quantity' => $firstProductQuantity,
                'product_featured_image_url' => isset($featured_image_url) ? $featured_image_url : ''
            ],
            'order_items_count' => $orderItemQuantity,
            'other_order_items_quantity' => $orderItemQuantity - $firstProductQuantity,
            'total_price' => $this->total_price
        ];
    }
}
