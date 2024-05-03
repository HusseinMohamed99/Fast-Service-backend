<?php

namespace App\Http\Controllers\Customer\Saved;

use App\Http\Controllers\Controller;
use App\Models\SavedWorker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Search_SaveWorkerController extends Controller
{
    public function __invoke(Request $request)
    {
        // Check if the search text is empty
        $searchText = $request->input('search');
        if (empty($searchText)) {
            return $this->handleResponse(message: 'Please Enter Text');
        }

        // Search for users with the specified name
        $users = User::where('name', 'LIKE', '%' . $searchText . '%')
                    ->with('informationWorker')
                    ->get();

        // Find saved workers for the current user
        $savedWorkers = SavedWorker::where('user_id', auth()->id())
                                    ->whereIn('worker_id', $users->pluck('id'))
                                    ->get();

        // Filter users to include only saved workers
        $savedUsers = $users->filter(function ($user) use ($savedWorkers) {
            return $savedWorkers->contains('worker_id', $user->id);
        });
                // Map users to include image URLs
                $formattedUsers = $savedUsers->map(function ($user) {
                    // Get the URL of the user's profile image from the 'profile_image' column
                    $defaultImage = asset('Default/profile.jpeg');
                    $profileImageUrl = $user->profile_image ? asset('path/to/images/' . $user->profile_image) : $defaultImage;

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
                    'List_search' => $formattedUsers->values(),
                ]);
            }
        }
