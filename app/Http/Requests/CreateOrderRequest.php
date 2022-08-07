<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\PaymentMethodEnum;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'payment_method' => [new Enum(PaymentMethodEnum::class)],
            'same_as_shipping_address' => 'required|boolean',
            'first_name' => 'required_if:same_as_shipping_address,false|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:100',
            'address' => 'required_if:same_as_shipping_address,false|string',
            'city' => 'required_if:same_as_shipping_address,false|string|max:50',
            'state' => 'required_if:same_as_shipping_address,false|string|max:50',
            'postcode' => 'required_if:same_as_shipping_address,false|string|max:12',
        ];
    }
}
