<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // category list
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.category.index', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('message', 'Category created successfully.');
    }
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('message', 'Category deleted successfully.');
    }
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return redirect()->back()->with('category', $category);
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $request->id,
        ]);

        $category = Category::findOrFail($request->id);
        $category->name = $request->name;
        $category->save();

        return redirect()->back()->with('message', 'Category updated successfully.');
    }
}
