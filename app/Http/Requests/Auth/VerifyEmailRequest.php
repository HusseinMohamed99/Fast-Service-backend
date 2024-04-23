<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;


class VerifyEmailRequest extends Request
{
    public function authorize(): bool
    {
        return auth()->user() ? true : false;
    }
    public function rules(): array
    {
        return [

            'otp'=>['required','max:4']
        ];
    }


}
