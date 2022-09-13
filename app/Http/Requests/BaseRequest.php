<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException($validator, response()->json([
            'status' => 'error',
            'data' => $validator->errors(),
        ]));
    }
}
