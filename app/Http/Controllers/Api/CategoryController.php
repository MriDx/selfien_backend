<?php

namespace App\Http\Controllers\Api;


use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('title', 'desc')->paginate(config('constants.paginate_per_page'));
        return response()->json($categories);
    }
}
