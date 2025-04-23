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

    public function index(Request $request)
    {
        $query = Category::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }
        
        // Filter functionality (example: by creation date)
        if ($request->has('date_filter') && !empty($request->date_filter)) {
            switch($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', now()->month);
                    break;
            }
        }
        
        // Order and paginate
        $categories = $query->orderBy('id', 'desc')
                          ->paginate($request->per_page ?? 5)
                          ->appends($request->except('page'));

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
        return response()->json($category);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,'.$request->id,
        ]);

        $category = Category::findOrFail($request->id);
        $category->name = $request->name;
        $category->save();

        return redirect()->back()->with('message', 'Category updated successfully.');
    }
}