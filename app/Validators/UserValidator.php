<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class UserValidator.
 *
 * @package namespace App\Validators;
 */
class UserValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'phone_number' => 'required|string|unique:users',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];

    protected $messages = [
        'name.required' => 'Name is required',
        'name.unique' => 'Name is already taken',
        'email.required' => 'Email is required',
        'email.unique' => 'Email is already taken',
        'phone_number.required' => 'Phone number is required',
        'phone_number.unique' => 'Phone number is already taken',
    ];
}
