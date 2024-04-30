<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Delete_UserController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'Admin') {
            if ($request->has('user_id')) {
                $userIdToDelete = $request->user_id;

                if ($userIdToDelete != $user->id) {
                    $userToDelete = User::find($userIdToDelete);

                    if ($userToDelete && $userToDelete->role !== 'Admin') {
                        $userToDelete->delete();

                        return $this->handleResponse(
                            status: true,
                            message: 'User deleted successfully.'
                        );
                    } else {
                        return $this->handleResponse(
                            status: false,
                            message: 'User not found or cannot be deleted.',
                            code : 422
                        );
                    }
                } else {
                    return $this->handleResponse(
                        status: false,
                        message: 'Admin cannot delete themselves.',
                        code : 422
                    );
                }
            } else {
                return $this->handleResponse(
                    status: false,
                    message: 'User ID parameter is missing.',
                    code : 422
                );
            }
        } else {
            return $this->handleResponse(
                status: false,
                message: 'Unauthorized.',
                code : 401
            );
        }
    }
}

