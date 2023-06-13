<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $this->authorize('isAdmin', User::class);
        $categories = Category::orderByDesc('created_at')->paginate(30);
        return view('admin.category.index', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->save();
        return redirect()->route('admin.category.index')->with('status', 'Categorie is aangemaakt');
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->name = $request->input('name' . $category->id);
        $category->save();
        return redirect()->route('admin.category.index')->with('status', 'Categorie is bijgewerkt');
    }

    public function destroy(Category $category)
    {
        $this->authorize('isAdmin', User::class);
        $category->delete();
        return redirect()->route('admin.category.index')->with('status', 'Categorie is verwijderd');
    }
}
