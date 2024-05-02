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



                // Check if the search text is empty
                $searchText = $request->input('search');
                if (empty($searchText)) {
                    return $this->handleResponse(message: 'Please Enter Text');
                }

                // Search for users with the specified type
                $users = User::where('type', 'LIKE', '%' . $searchText . '%')->with('informationWorker')->get();


                return response()->json($users);

    }

}
