<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\Core\GetProfileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetProfileController extends Controller
{
    public function __invoke(){
        $user = Auth::user();
        return $this->handleResponse(status:true, message:'welcomn'. $user->name , data: new GetProfileResource($user) );

    }

}
