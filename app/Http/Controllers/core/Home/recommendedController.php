<?php

namespace App\Http\Controllers\core\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class recommendedController extends Controller
{
    public function __invoke()
    {
        // Get the current user's ID
        $user_id = Auth::id();

        // Get distinct types of workers available in the database
        $types = User::select('type')->distinct()->pluck('type');

        // Initialize a collection to store recommended workers
        $recommended = collect();

        // Loop through each type of workers
        foreach ($types as $type) {
            // Query for recommended workers of a specific type
            $recommendedOfType = User::where('role', 'worker')
                ->where('id', '!=', $user_id) // Exclude the current user
                ->where('type', $type) // Filter by type
                ->whereHas('informationWorker', function ($query) {
                    // Ensure workers have a valid starting price
                    $query->whereNotNull('price_from');
                })
                ->with(['informationWorker' => function ($query) {
                    // Order the results by starting price in ascending order
                    $query->orderBy('price_from', 'asc');
                }])
                ->take(1) // Take only one worker
                ->get(); // Execute the query

            // Merge the recommended workers into the collection
            $recommended = $recommended->merge($recommendedOfType);
        }

        // Return the response with recommended workers
        return $this->handleResponse(data: [
            'recommended' => $recommended,
        ]);
    }
}
