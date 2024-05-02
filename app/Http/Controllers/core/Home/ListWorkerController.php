<?php

namespace App\Http\Controllers\core\Home;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListWorkerController extends Controller
{
    public function __invoke()
    {
        $user_id = Auth::id();
        $users = User::where('role', 'worker')
        ->where('id','!=' ,$user_id)
        ->with('informationWorker')->get();

        return $this->handleResponse(data: [
            'List_workers' => $users,

        ]);
    }
}
