<?php
namespace App\Http\Controllers;

use Exception;
use Ichtrojan\Otp\Otp;
use App\Emails\EmailVerification;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\LoginResource;
use Illuminate\Support\Facades\RateLimiter;
use App\Traits\ResponseTrait; // استيراد Trait




class LoginController extends Controller
{
    use ResponseTrait;
    public function __invoke(LoginRequest $request , Exception $e)
    {

        $validatedData = $request->validated();

        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {

            $user = Auth::user();
            // to retuen message to send many requests login email
            if (RateLimiter::tooManyAttempts('send-message:'.auth()->user(), $perMinute = 3)) {
                $seconds = RateLimiter::availableIn('send-message:'.auth()->user());


                return $this->handleResponse(status:false,message:'too Many Attempts , You may try again in '.$seconds.' seconds.' , code:429);


            }

            RateLimiter::hit('send-message:'.auth()->user());



            if (!auth()->user()->email_verified_at) {
                $otp = new Otp;
                $code = $otp->generate($validatedData['email'],'numeric',4, 5);

                Mail::to($validatedData['email'])->send(new EmailVerification($user,$code->token));

                return $this->handleResponse(status:false, code:200 ,message:'Email not verified! Please verify your email.',data: new LoginResource($user));
            }

            return $this->handleResponse(status:true,message:'Welcome Back '. $user->name , data: new LoginResource($user));
        }
        // to retuen message to send many requests when wrong password

        if (RateLimiter::tooManyAttempts('send-message:'.auth()->user(), $perMinute = 3)) {
            $seconds = RateLimiter::availableIn('send-message:'.auth()->user());


            return $this->handleResponse(status:false,message:'too Many Attempts , You may try again in '.$seconds.'seconds.' , code:429);


        }

        RateLimiter::hit('send-message:'.auth()->user());


        return $this->handleResponse( code:401 ,status: false, message: 'Wrong Email Or Password!');



    }
}

