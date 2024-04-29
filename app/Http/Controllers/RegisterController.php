<?php

namespace App\Http\Controllers;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use App\Emails\EmailVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\UserResources;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\RateLimiter;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request) {

        $validatedData = $request->validated();

        if ($validatedData['role'] === 'Worker') {
            // إذا كان دور المستخدم "Worker" يجب التحقق من وجود نوع المستخدم
            if (!isset($validatedData['type'])) {
                // إذا لم يتم تقديم نوع المستخدم، فقم بإرجاع استجابة الخطأ
                return $this->handleResponse(message: 'Type is required for Worker role.', code: 422);
            }
        }
        elseif ($validatedData['role'] !== 'Worker') {
            // If the user's role is not "Worker", check if the type is provided
            if (isset($validatedData['type'])) {
                // If the type is provided, return an error response
                return $this->handleResponse(message: 'Type is not required.', code: 422);
            }
        }
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'type' => $validatedData['type'] ?? null,
            'phone_number' => $validatedData['phone_number'],
            'whatsapp_number' => isset($validatedData['whatsapp_number']) ? $validatedData['whatsapp_number'] : null,
            'password' => Hash::make($validatedData['password']),
            'password_confirme' => Hash::make($validatedData['password_confirme']),
        ]);


        RateLimiter::hit('send-message:'.auth()->user());

        if ($request->hasFile('image')) {
            $user->addMediaFromRequest('image')->toMediaCollection('user_profile_image');
        }

        // after register operation
        // 1- send email verification notification contains OTP
        $otp = new Otp;
        $code = $otp->generate($validatedData['email'],'numeric',4, 5);

        Mail::to($validatedData['email'])->send(new EmailVerification($user,$code->token));

        // 2- send api response to front
        return $this->handleResponse(message:'Successfully Created Account , Verify Your Email please',data:new UserResources($user));


    }

}
