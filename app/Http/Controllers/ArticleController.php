<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    // Просмотр статьи
    public function show($id)
    {
        $article = Article::with(['user', 'category'])->findOrFail($id);
        return view('articles.show', compact('article'));
    }

    // Форма создания
    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }


    // Сохранение новой статьи
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'content'     => 'required',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['title', 'content', 'category_id']);
        $data['user_id'] = Auth::id(); // автор

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('index')->with('success', 'Статья добавлена!');
    }

    // Форма редактирования
    public function edit($id)
    {
        $article = Article::findOrFail($id);

        if (auth()->id() !== $article->user_id) {
            abort(403);
        }

        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    // Обновление
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        if (auth()->id() !== $article->user_id) {
            abort(403);
        }

        $request->validate([
            'title'       => 'required|max:255',
            'content'     => 'required',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['title', 'content', 'category_id']);

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('articles.show', $article->id)->with('success', 'Статья обновлена!');
    }

    // Удаление
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if (auth()->id() !== $article->user_id) {
            abort(403);
        }

        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('index')->with('success', 'Статья удалена!');
    }
}
