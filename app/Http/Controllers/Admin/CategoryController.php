<?php
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
 
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('iCategoryId', 'desc')->paginate(10);
        return view('admin.category.index', compact('categories'));
    }
 
    public function create()
    {
        return view('admin.category.create');
    }
 
    public function store(Request $request)
    {
        $validated = $request->validate([
            'strCategoryName' => 'required|string|max:50|unique:category,strCategoryName',
            // 'strSlug' => 'required|string|max:50|unique:category,strSlug',
        ]);
 
        $validated['iStatus'] = 1;
        $validated['isDelete'] = 0;
        $validated['strIP'] = $request->ip();
 
        Category::create($validated);
 
        return redirect()->route('admin.category.index')
            ->with('success', 'Category created successfully!');
    }
 
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }
 
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
 
        $validated = $request->validate([
            'strCategoryName' => 'required|string|max:50|unique:category,strCategoryName,' . $id . ',iCategoryId',
            // 'strSlug' => 'required|string|max:50|unique:category,strSlug,' . $id . ',iCategoryId',
        ]);
 
        $validated['strIP'] = $request->ip();
 
        $category->update($validated);
 
        return redirect()->route('admin.category.index')
            ->with('success', 'Category updated successfully!');
    }
 
    public function destroy($id)
    {
       
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.category.index')
            ->with('success', 'Category deleted successfully!');
    }
    public function show($id)
    {
        $categories = Category::where('iCategoryId', $id)
            ->where('isDelete', 0)
            ->orderBy('iCategoryId', 'desc')
            ->paginate(10);
     
        return view('admin.category.index', [
            'categories' => $categories,
            'iCategoryId' => $id
        ]);
    }
    public function bulkDelete(Request $request)
    {      
      $ids = $request->input('ids', []);
     
        if (!empty($ids)) {
            Category::whereIn('iCategoryId', $ids)
                ->delete();
 
            return redirect()->route('admin.category.index')
                ->with('success', 'Selected categories deleted successfully!');
        }
 
        return redirect()->route('admin.category.index')
            ->with('error', 'No categories selected for deletion.');
    }
}
 
 