<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQrRequest extends FormRequest
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
            'part_number' => ['required'],
            'date_code' => ['required'],
            'vendor_code' => ['required'],
            'qr_code' => ['unique:qr_details,qr_code']
        ];
    }

    public function messages()
    {
        return [
            'qr_code' => 'QR Code already exists'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'qr_code' => request('part_number').'-'.request('date_code').'-'.request('vendor_code')
        ]);
    }
}
