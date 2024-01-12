<?php

namespace App\Http\Requests;

use App\Models\Store;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'title' => ['string', 'required', Rule::unique('stores')->ignore($this->user()->id, 'user_id')],
            'description' => ['string', 'required'],
            'email' => ['string', 'required', 'email', Rule::unique('stores')->ignore($this->user()->id, 'user_id')],
            'phone' => ['string', 'regex:/^0[1-9][0-9]{6,12}$/', 'required', Rule::unique('stores')->ignore($this->user()->id, 'user_id')],
            // 'photo' => [],
            // 'cover' => [],
            'address' => ['string', 'required'],
            'active' => ['boolean', 'required'],
        ];
    }
}
