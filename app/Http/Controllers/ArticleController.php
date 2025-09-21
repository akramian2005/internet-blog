<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ArticleController extends Controller
{
    // public function index() {
    //     $articles = Article::with('user')->latest()->get();
    //     return view('index', compact('articles'));
    // }

    public function show($id) {
        $article = Article::with('user')->findOrFail($id);
        return view('articles.show', compact('article'));
    }

    public function create() {
        return view('articles.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title'   => 'required|max:255',
            'content' => 'required',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['title', 'content']);
        $data['user_id'] = Auth::id(); // ← сохраняем автора

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('index')->with('success', 'Статья добавлена!');
    }

        // Редактирование
    public function edit($id)
    {
        $article = Article::findOrFail($id);

        // Только автор может редактировать
        if (auth()->id() !== $article->user_id) {
            abort(403);
        }

        return view('articles.edit', compact('article'));
    }

    // Обновление
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        if (auth()->id() !== $article->user_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['title', 'content']);

        if ($request->hasFile('image')) {
            // удаляем старую картинку если была
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

        // удалить картинку
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('index')->with('success', 'Статья удалена!');
    }

}


