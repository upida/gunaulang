<?php

namespace App\Http\Requests;

use App\Models\Order;
use App\Models\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DonatorOrderUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $store = Store::where('user_id', $this->user()->id)->first();
        if (!$store) return false;

        $this->request->set('store', $store->toArray());

        $order = Order::where('id', $this->route('order_id'))->where('store_id', $store->id)->first();
        if (!$order) return false;

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['string', 'required'],
        ];
    }
}
