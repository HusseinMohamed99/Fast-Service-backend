<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class All_UserController extends Controller
{

    public function __invoke()
    {
        $user = Auth::user();

        if ($user->role == 'Admin') {
            $users = User::whereIn('role', ['Customer', 'Worker'])->get();

            return response()->json([
                'success' => true,
                'data' => $users,
                'message' => 'All users retrieved successfully.'
            ]);
        }
        elseif ($user->role !== 'Admin') {
            return $this->handleResponse(
                status : false,
                message: 'Unauthorized',
                code: 422
            );
        }
    }
}
