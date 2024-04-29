<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeWorkerController extends Controller
{
    public function __invoke()
    {
        $currentUser = Auth::user();

        $currentUserProfile = $currentUser->load('informationWorker');

        $user_id = Auth::id();

        $users = User::where('role', 'worker')
        ->where('id','!=' ,$user_id)
        ->with('informationWorker')->get();
        return response()->json([
            'current_user_profile' => $currentUserProfile,
            'other_workers' => $users
        ]);
    }

}
