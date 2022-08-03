<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'id' => $this->id,
            'cart_id' => $this->cart_id,
            'product_id' => $this->productVariant->product->id,
            'product_name' => $this->productVariant->product->name,
            'grind_size' => $this->grind_size,
            'weight' => $this->productVariant->weight,
            'quantity' => $this->quantity,
            'price' => $this->productVariant->price * $this->quantity,
            'featured_image_url' => $this->productVariant->product->medias->where('is_featured',true)->first()->path
        ];
    }
}
