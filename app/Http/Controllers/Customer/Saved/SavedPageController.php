<?php

namespace App\Http\Controllers\Customer\Saved;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\SavedWorkerResources;
use App\Models\SavedWorker;
use Illuminate\Http\Request;

class SavedPageController extends Controller
{
    public function __invoke(Request $request)
    {

        $user_id = $request->user()->id;

        $SavedWorkers = SavedWorker::with('users')->where('user_id', $user_id)->get();

        $SavedWorkerResources = SavedWorkerResources::collection($SavedWorkers);

        return response()->json(['saved_Worker' => $SavedWorkerResources]);
    }

}
