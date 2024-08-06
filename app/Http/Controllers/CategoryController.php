<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
// use Illuminate\Support\Facades\Log;


class CategoryController extends Controller
{

    public function index(Request $request)
    {

        $categories = Category::select(['id', 'name', 'type']);

        if ($request->ajax()) {
            return DataTables::of($categories)
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" class="btn btn-info editButton" data-id="' . $row->id . '">Edit</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function create(): View
    {

        return view('categories.create');
    }

    public function store(Request $request)
    {
        // Log::info('store request data: ' . json_encode($request->all()));   
        // Log::info('store request data: ', $request->only(['name', 'type']));
        $request->validate([
            'name' => 'required|min:2|max:30',
            'type' => 'required'
        ]);

        Category::create([
            'name' => $request->input('name'),
            'type' => $request->input('type')
        ]);

        return response()->json([
            'success' => 'Category saved successfully'
        ], 201);
    }

    public function edit($id)
    {
        $categories = Category::find($id);

        if (!$categories) {
            abort(404);
        }

        return $categories;
    }
}
