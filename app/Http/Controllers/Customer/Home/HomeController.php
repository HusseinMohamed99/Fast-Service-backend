<?php

namespace App\Http\Controllers\Customer\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __invoke()
    {


        $user_id = Auth::id();
        $types = User::select('type')->distinct()->pluck('type');

        $recommended = collect();

        foreach ($types as $type) {
            $recommendedOfType = User::where('role', 'worker')
                ->where('id', '!=', $user_id)
                ->where('type', $type)
                ->whereHas('informationWorker', function ($query) {
                    $query->whereNotNull('price_from');
                })
                ->with(['informationWorker' => function ($query) {
                    $query->orderBy('price_from', 'asc');
                }])
                ->take(1)
                ->get();

            $recommended = $recommended->merge($recommendedOfType);
        }




        $users = User::where('role', 'worker')
        ->where('id','!=' ,$user_id)
        ->with('informationWorker')->get();


    $skills = Category::pluck('name', 'id');

    return $this->handleResponse(data: [
        'Category' => $skills,
        'recommended '=>$recommended ,
        'List_workers' => $users

    ]);

    }

}
