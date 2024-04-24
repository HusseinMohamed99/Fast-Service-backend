<?php

namespace App\Http\Controllers\Customer\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {






    $skills = Category::pluck('name', 'id');

    return $this->handleResponse(data: [
        'Category' => $skills,
    ]);

    }

}
