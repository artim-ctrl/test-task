<?php

namespace App\Http\Requests\Video;

use Illuminate\Foundation\Http\FormRequest;

class IndexVideoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search.user_id' => 'sometimes|required|int',
            'search.name' => 'sometimes|required|string',
            'limit' => 'sometimes|required|int',
            'page' => 'sometimes|required|int',
        ];
    }
}
