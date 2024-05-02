<?php

namespace App\Http\Controllers\core\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class recommendedController extends Controller
{
    public function __invoke()
    {
        // Get the distinct types of workers available in the database
        $types = User::where('role', 'worker')->distinct()->pluck('type');

        // Initialize a collection to store recommended workers
        $recommended = collect();

        // Loop through each type of workers
        foreach ($types as $type) {
            // Query for the worker with the minimum price for the current type
            $recommendedWorker = User::where('role', 'worker')
                ->where('type', $type)
                ->whereHas('informationWorker', function ($query) {
                    $query->whereNotNull('price_from');
                })
                ->first(); // Get the worker with the minimum price

            // If a recommended worker is found, add it to the collection
            if ($recommendedWorker) {
                $recommended->push($recommendedWorker);
            }
        }

        // Transform the recommended workers to include image URLs
        $formattedRecommended = $recommended->map(function ($worker) {
            $defaultImage = asset('Default/profile.jpeg');
            $profileImage = $worker->getFirstMedia('user_profile_image');
            $profileImageUrl = $profileImage ? $profileImage->getUrl() : $defaultImage;

            return [
                'id' => $worker->id,
                'name' => $worker->name,
                'type' => $worker->type,
                'profile_image_url' => $profileImageUrl,
                'informationWorker' => $worker->informationWorker,
            ];
        });

        // Return the response with recommended workers
        return $this->handleResponse(data: [
            'recommended' => $formattedRecommended,
        ]);
    }
}
