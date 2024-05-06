<?php

namespace App\Http\Controllers\core\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        // Check if the search text is empty
        $searchText = $request->input('search');
        if (empty($searchText)) {
            return $this->handleResponse(message: 'Please Enter Text');
        }


                // Search for users with the specified type
        $users = User::where('type', 'LIKE', '%' . $searchText . '%')->with('informationWorker')->get();


        // Map users to include image URLs
        $formattedUsers = $users->map(function ($user) {
            // Get the URL of the user's profile image from the 'profile_image' column
            $defaultImage = asset('Default/profile.jpeg');
            $profileImage = $user->getFirstMedia('user_profile_image');
            $profileImageUrl = $profileImage ? $profileImage->getUrl() : $defaultImage;
            // Return user data with image URL
            return [
                'id' => $user->id,
                'name' => $user->name,
                'type' => $user->type,
                'profile_image_url' => $profileImageUrl,
                'informationWorker' => $user->informationWorker,
            ];
        });

        return $this->handleResponse(data: [
            'List_search' => $formattedUsers,
        ]);
    }
}

