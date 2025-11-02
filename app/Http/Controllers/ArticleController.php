<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function show($id)
    {
        $article = Article::with(['user', 'category', 'comments.user'])->findOrFail($id);
        return view('articles.show', compact('article'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|max:255',
            'content'       => 'required',
            'category_id'   => 'nullable|exists:categories,id',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['title', 'content', 'category_id']);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($data);
        return redirect()->route('index')->with('success', 'Статья добавлена!');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        if (auth()->id() !== $article->user_id && !auth()->user()->is_admin) abort(403);

        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        if (auth()->id() !== $article->user_id && !auth()->user()->is_admin) abort(403);

        $request->validate([
            'title'       => 'required|max:255',
            'content'     => 'required',
            'category_id' => 'nullable|exists:categories,id',
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

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        if (auth()->id() !== $article->user_id && !auth()->user()->is_admin) abort(403);

        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();

        return redirect()->route('index')->with('success', 'Статья удалена!');
    }

    public function like($id)
    {
        $article = Article::findOrFail($id);

        if (!auth()->check()) {
            return redirect()->route('login.show');
        }

        // Получаем массив лайкнутых статей из сессии
        $likedArticles = session()->get('liked_articles', []);

        if (in_array($article->id, $likedArticles)) {
            // Уже лайкнуто → убираем лайк
            $article->decrement('likes_count');

            // Удаляем из сессии
            $likedArticles = array_diff($likedArticles, [$article->id]);
            session()->put('liked_articles', $likedArticles);
        } else {
            // Ещё не лайкнуто → ставим лайк
            $article->increment('likes_count');

            // Добавляем в сессию
            session()->push('liked_articles', $article->id);
        }

        return redirect()->back();
}

}

