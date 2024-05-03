<?php

namespace App\Http\Controllers\core\Home;

use App\Http\Controllers\Controller;
use App\Models\SavedWorker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListWorkerController extends Controller
{
    public function __invoke()
    {
        $user_id = Auth::id();

        // Retrieve users with their informationWorker and profile image URL
        $users = User::where('role', 'worker')
            ->where('id', '!=', $user_id)
            ->with('informationWorker')
            ->get()
            ->map(function ($user) use ($user_id) { // Use $user_id in the closure
                // Get the URL of the user's profile image from the 'user_profile_image' collection
                $defaultImage = asset('Default/profile.jpeg');
                $profileImage = $user->getFirstMedia('user_profile_image');
                $profileImageUrl = $profileImage ? $profileImage->getUrl() : $defaultImage;

                // Check if the user is saved by the authenticated user
                $saved = SavedWorker::where('user_id', $user_id)
                    ->where('worker_id', $user->id)
                    ->exists();

                // Return user data with image URL and saved flag
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'type' => $user->type,
                    'image' => $profileImageUrl,
                    'saved' => $saved, // Boolean flag indicating whether the user is saved or not
                    'informationWorker' => $user->informationWorker,
                ];
            });

        return $this->handleResponse(data: [
            'List_workers' => $users,
        ]);
    }
}
