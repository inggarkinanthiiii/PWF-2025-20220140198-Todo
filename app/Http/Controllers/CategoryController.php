<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Eager load 'todos' dan hitung jumlahnya menggunakan withCount
        $categories = Category::withCount('todos')->get();

        // Pastikan Anda mengirimkan data yang benar ke view
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
        ]);

         // Tidak perlu membuat Todo baru di sini.  Ini biasanya dilakukan di TodoController.

        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $category->update([
            'title' => $request->title,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted.');
    }
}