<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequirementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // adjust if you gate this behind auth/partner roles
    }

    public function rules(): array
    {
        return [
            'requester_name'  => ['required', 'string', 'max:120'],
            'requester_phone' => ['nullable', 'string', 'max:30'],
            'requester_email' => ['nullable', 'email', 'max:150'],

            'listing_type'    => ['required', 'in:sale,rent'],
            'bhk'             => ['nullable', 'string', 'max:5'],
            'city'            => ['nullable', 'string', 'max:100'],
            'locality'        => ['nullable', 'string', 'max:100'],

            'min_price'       => ['nullable', 'integer', 'min:0'],
            'max_price'       => ['nullable', 'integer', 'min:0', 'gte:min_price'],

            'min_area_sqft'   => ['nullable', 'integer', 'min:0'],
            'max_area_sqft'   => ['nullable', 'integer', 'min:0', 'gte:min_area_sqft'],

            'furnishing'      => ['nullable', 'string', 'in:furnished,semi-furnished,unfurnished'],

            'notes'           => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'max_price.gte'     => 'Max budget should not be less than min budget.',
            'max_area_sqft.gte' => 'Max area should not be less than min area.',
        ];
    }
}