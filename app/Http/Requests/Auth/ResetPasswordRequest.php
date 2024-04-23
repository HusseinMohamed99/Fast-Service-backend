<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;
use Illuminate\Validation\Rules;

class ResetPasswordRequest extends Request
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'email'=>['required','string','lowercase','email','exists:users,email'],
            'otp'=>['required','max:4'],
            'password' => ['required',Rules\Password::defaults(), new \App\Rules\StrongPassword

],        ];
    }



}
