<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class ForgetPasswordRequest extends Request
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'email'=>['required','email','exists:users,email']
        ];
    }


}
