<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingStoreUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'posting_point_id' => 'required|exists:posting_points,id',
            'sender.name' => 'required|string|max:255',
            'sender.cpf' => 'required|string|size:11',
            'sender.phone' => 'required|string|max:15',
            'sender.street' => 'required|string|max:255',
            'sender.number' => 'required|string|max:10',
            'sender.neighborhood' => 'required|string|max:255',
            'sender.complement' => 'nullable|string|max:255',
            'sender.email' => 'required|email|max:255',
            'sender.city' => 'required|string|max:255',
            'sender.state_id' => 'required|exists:states,id',
            'sender.zip_code' => 'required|string|max:10',
            'recipient.name' => 'required|string|max:255',
            'recipient.cpf' => 'required|string|size:11',
            'recipient.phone' => 'required|string|max:15',
            'recipient.street' => 'required|string|max:255',
            'recipient.number' => 'required|string|max:10',
            'recipient.neighborhood' => 'required|string|max:255',
            'recipient.complement' => 'nullable|string|max:255',
            'recipient.instructions' => 'nullable|string',
            'recipient.city' => 'required|string|max:255',
            'recipient.state_id' => 'required|exists:states,id',
            'recipient.zip_code' => 'required|string|max:10',
            'packages' => 'required|array|min:1',
            'packages.*.width' => 'required|numeric|min:0',
            'packages.*.height' => 'required|numeric|min:0',
            'packages.*.length' => 'required|numeric|min:0',
            'packages.*.weight' => 'required|numeric|min:0',
            'packages.*.value' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'posting_point_id.required' => 'The posting point is required.',
            'posting_point_id.exists' => 'The selected posting point does not exist.',
            'sender.name.required' => 'The sender name is required.',
            'sender.cpf.required' => 'The sender CPF is required.',
            'sender.phone.required' => 'The sender phone is required.',
            'recipient.name.required' => 'The recipient name is required.',
            'recipient.cpf.required' => 'The recipient CPF is required.',
            'packages.required' => 'At least one package is required.',
            'packages.*.width.required' => 'Package width is required.',
            'packages.*.height.required' => 'Package height is required.',
            'packages.*.length.required' => 'Package length is required.',
            'packages.*.weight.required' => 'Package weight is required.',
            'packages.*.value.required' => 'Package value is required.',
        ];
    }
}