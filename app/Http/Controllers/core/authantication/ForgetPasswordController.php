<?php

namespace App\Http\Controllers\core\authantication;

use Ichtrojan\Otp\Otp;
use Illuminate\Http\Response;
use App\Emails\ForgetPasswordEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Models\User;

class ForgetPasswordController extends Controller
{


    public function __invoke(ForgetPasswordRequest $request)
    {
        // validate the data from request
        $validatedData = $request->validated();
        $user = User::where('email', $validatedData['email'])->first();

        //creat a new OTP
        $otp = new Otp;
        $code = $otp->generate($validatedData['email'], 'numeric', 4, 5);


        //otp send email to user
        try {
            Mail::to($user->email)->send(new ForgetPasswordEmail($user, $code->token));
        } catch (\Throwable $th) {
            return $this->handleResponse(status: false, message: 'OTP Mail Service Error', code: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $user->tokens()->delete();
        return $this->handleResponse(status: true, message: 'OTP Code Sent Successfully.');
    }
}
