<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class All_CustomerController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        if ($user->role == 'Admin') {
            $users = User::whereIn('role', ['Customer'])->get();


            $usersWithImages = $users->map(function ($user) {
                $defaultImage = asset('Default/profile.jpeg');


                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    "email_verified_at"=>$user->email_verified_at,
                    'phone_number' => $user->phone_number ?? null,
                    'whatsapp_number' => $user->whatsapp_number ?? null,
                    'role' => $user->role ,
                    'email' => $user->email,
                    'profile_image' =>  $user->getFirstMediaUrl('user_profile_image') ?: $defaultImage,
                ];
                });

                return $this->handleResponse(
                data : $usersWithImages,
                message : 'All users Customer retrieved successfully.'
            );
        } elseif ($user->role !== 'Admin') {
            return $this->handleResponse(
                status: false,
                message: 'Unauthorized',
                code: 422
            );
        }
    }
}
