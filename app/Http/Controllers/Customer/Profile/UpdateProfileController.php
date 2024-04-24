<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Profile\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Customer\UpdateprofileResources;


class UpdateProfileController extends Controller
{
    public function __invoke(UpdateProfileRequest $request)
    {
            // Retrieve the authenticated user
            $userId = Auth::id();
            $user = User::find($userId);

            $validatedData = $request->validated();

            if ($request->hasFile('image') ) {
                // Delete the old media if it exists
                $user->clearMediaCollection('user_profile_image');
                // Store the new image
                $user->addMediaFromRequest('image')->toMediaCollection('user_profile_image');
            } else {
                // If there's an existing image, get its URL
                 $user->getFirstMediaUrl('user_profile_image');
            }

            // Update the seeker with validated data
            $user->update($validatedData);

            return $this->handleResponse(status:true, message:'Successfully updated profile for '. $user->email , data: new UpdateprofileResources($user) );


}
}
