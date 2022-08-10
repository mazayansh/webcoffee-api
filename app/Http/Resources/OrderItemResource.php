<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $featured_image_url = optional($this->productVariant->product->medias->where('is_featured', 1)->first())->path;

        return [
            'id' => $this->id,
            'product_id' => $this->productVariant->product_id,
            'product_name' => $this->productVariant->product->name,
            'product_featured_image_url'  => isset($featured_image_url) ? $featured_image_url : '',
            'product_quantity' => $this->quantity,
            'product_price' => $this->productVariant->price,
            'subtotal_price' => $this->subtotal_price
        ];
    }
}
