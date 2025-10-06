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
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['title', 'content', 'category_id']);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($data);

        return redirect()->route('index')->with('success', 'Статья добавлена!');
    }

    public function like($id)
    {
        $article = Article::findOrFail($id);

        if (!auth()->check()) {
            return redirect()->route('login.show');
        }

        // Один лайк за сессию
        $likedArticles = session()->get('liked_articles', []);
        if (!in_array($article->id, $likedArticles)) {
            $article->increment('likes_count');
            session()->push('liked_articles', $article->id);
        }

        return redirect()->back();
    }
}

