<?php

namespace App\Http\Requests;


use App\Http\Requests\Api\FormRequest;

class CreateUserFormRequest extends FormRequest
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
            'name' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'phone_number' => 'required|string|unique:users',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.unique' => 'Name is already taken',
            'email.required' => 'Email is required',
            'email.unique' => 'Email is already taken',
            'phone_number.required' => 'Phone number is required',
            'phone_number.unique' => 'Phone number is already taken',
        ];
    }
}
