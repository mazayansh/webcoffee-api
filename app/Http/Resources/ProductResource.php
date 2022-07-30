<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $original = parent::toArray($request);
        return array_merge($original, [
            'featured_image_url' => isset($original['featured_image_url']) ? env('APP_URL').'/storage'.$original['featured_image_url'] : '',
        ]);
    }
}
