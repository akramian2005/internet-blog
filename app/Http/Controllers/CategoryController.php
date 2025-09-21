<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Список всех категорий (только для админа)
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Форма создания категории (только для админа)
    public function create()
    {
        return view('categories.create');
    }

    // Сохранение новой категории (только для админа)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('categories.index')->with('success', 'Категория создана!');
    }

    // Форма редактирования категории
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    // Обновление категории
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update(['name' => $request->name]);

        return redirect()->route('categories.index')->with('success', 'Категория обновлена!');
    }

    // Просмотр одной категории
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.show', compact('category'));
    }

}
