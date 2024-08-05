<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function create(): View
    {

        return view('categories.create');
    }

    public function store(Request $request)
    {
        return $request->all();
    }
}
