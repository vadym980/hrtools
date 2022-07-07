<?php

declare(strict_types=1);

namespace App\Http\Request\Api\Auth;

use App\Http\Request\ApiFormRequest;

class RegisterHttpRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|string',
            'name' => 'required|string|min:2',
            'lastname' => 'required|string|min:2',
            'phone' => 'required|string|min:2'
        ];
    }
}
