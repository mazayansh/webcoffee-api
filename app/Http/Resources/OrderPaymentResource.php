<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderPaymentResource extends JsonResource
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
            'bank' => $this->bank,
            'payment_method' => $this->payment_method,
            'va_number' => $this->va_number,
            'bill_key' => $this->bill_key,
            'biller_code' => $this->biller_code,
            'total_payment' => $this->order->total_price
        ];
    }
}
