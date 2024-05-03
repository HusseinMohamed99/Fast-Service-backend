<?php

namespace App\Http\Controllers\core\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class GetCategoryController extends Controller
{
    public function __invoke()
    {
        $Categories = Category::all('name', 'id');
        return $this->handleResponse(data: [
            'Category' => $Categories,

        ]);
    }
}
