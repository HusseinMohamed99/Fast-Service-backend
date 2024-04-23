<?php

namespace App\Http\Controllers\core\authantication;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Traits\AuthResponse;

class ResetPasswordController extends Controller
{    use AuthResponse;

    private $otp;
    public function __construct()
    {
        $this->otp = new Otp;
    }
    public function __invoke(ResetPasswordRequest $request)
    {

        $validatedData = $request->validated();

        // reset password logic
        $otp2 = $this->otp->validate($validatedData['email'], $validatedData['otp']);
        if (!$otp2->status) {
            return $this->OTP_Error_Response();
        }
        $user = User::where('email', $validatedData['email'])->first();
        $user->update(['password' => Hash::make($validatedData['password'])]);
        $user->tokens()->delete();

        return $this->OKResponse('Password Reset Successfully');
    }
}
