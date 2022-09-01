<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\FormRequest;


class UpdateUserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email',
            'phone_number' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'phone_number.required' => 'Phone number is required',
            'email.unique' => 'Email already exists',
            'phone_number.unique' => 'Phone number already exists',
        ];
    }
}
