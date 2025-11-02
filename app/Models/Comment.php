<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'user_id', 'article_id', 'parent_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function article() {
        return $this->belongsTo(Article::class);
    }

    // Родительский комментарий (если это ответ)
    public function parent() {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Ответы на этот комментарий
    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
