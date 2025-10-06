<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $articleId)
    {
        $request->validate([
            'content' => 'required|max:1000'
        ]);

        $article = Article::findOrFail($articleId);

        Comment::create([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'article_id' => $article->id
        ]);

        return redirect()->back()->with('success', 'Комментарий добавлен!');
    }
}
