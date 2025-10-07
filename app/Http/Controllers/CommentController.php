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

    public function edit(Comment $comment)
    {
        // Проверка прав
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        $request->validate([
            'content' => 'required|max:1000'
        ]);

        $comment->update([
            'content' => $request->content
        ]);

        return redirect()->back()->with('success', 'Комментарий обновлён!');
    }

    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Комментарий удалён!');
    }
}
