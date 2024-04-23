<?php

namespace App\Http\Controllers\core\authantication;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\changePasswordRequest;
use App\Traits\ResponseTrait;


class ChangePasswordController extends Controller
{
    use ResponseTrait;

    public function __invoke(changePasswordRequest $request)
    {
    $validatedData = $request->validated();



    // Get the authenticated user
    $user = Auth::user();

    // Check if the current password matches the one in the database
    if (!Hash::check($request->current_password, $user->password)) {
        return $this->handleResponse(message:'Current password is incorrect', code:401 , status:false  );

    }

    // Hash the new password
    $newPassword = Hash::make($request->new_password);

    // Update the user's password
    $user->password = $newPassword;
    $user->save();

    //updated successfully
    return $this->handleResponse(message:'Password updated successfully');

}
}
