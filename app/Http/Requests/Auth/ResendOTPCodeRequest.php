<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;


class ResendOTPCodeRequest extends Request
{
    public function authorize(): bool
    {
        return true;

        //return auth()->user() ? true :false;
    }
    public function rules(): array
    {
        return [
            'email'=>['required','string','email','exists:users,email']
        ];
    }


}
