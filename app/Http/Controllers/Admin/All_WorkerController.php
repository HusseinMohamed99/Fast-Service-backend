<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class All_WorkerController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        if ($user->role == 'Admin') {
            $admin_id = Auth::id();

            // Retrieve workers with their informationWorker and profile image URL
            $workers = User::where('role', 'worker')
                ->where('id', '!=', $admin_id)
                ->with('informationWorker')
                ->get()
                ->map(function ($worker) use ($admin_id) {
                    // Get the URL of the worker's profile image from the 'user_profile_image' collection
                    $defaultImage = asset('Default/profile.jpeg');
                    $profileImage = $worker->getFirstMedia('user_profile_image');
                    $profileImageUrl = $profileImage ? $profileImage->getUrl() : $defaultImage;


                    // Return worker data with image URL and saved flag
                    return [
                        'id' => $worker->id,
                        'name' => $worker->name,
                        'email' => $worker->email,
                        'type' => $worker->type,
                        'image' => $profileImageUrl,
                        'informationWorker' => $worker->informationWorker,
                    ];
                });

                return $this->handleResponse(
                    data : $workers,

            );
        } else {
            return $this->handleResponse(
                status : false,
                message : 'Unauthorized',
                code: 422
            );
        }
    }
}
