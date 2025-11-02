@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="d-flex align-items-center gap-2 mt-3">
    <a href="{{ route('index') }}" class="btn btn-secondary">Назад к списку</a>

    @auth
        @if(auth()->id() === $article->user_id || auth()->user()->is_admin)
            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary">Редактировать</a>

            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Удалить</button>
            </form>
        @endif
    @endauth
</div>


<div class="card mb-3">
    @if($article->image)
        <div style="width: 100%; max-width: 1300px; height: 500px; overflow: hidden; margin: 0 auto;">
            <img src="{{ asset('storage/' . $article->image) }}" 
                 alt="{{ $article->title }}"
                 style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
        </div>
    @endif
    <div class="card-body">
        <h2>{{ $article->title }}</h2>
        <p class="text-muted">
           Автор: <a href="{{ route('users.show', $article->user) }}">
                {{ $article->user->name }}
            </a> |

            Категория: <strong>{{ optional($article->category)->name }}</strong>
        </p>
        <p>{{ $article->content }}</p>

        <!-- Лайки -->
        <div class="mb-3">
            @auth
                @php
                    $liked = session('liked_articles', []) && in_array($article->id, session('liked_articles'));
                @endphp

                <form action="{{ route('articles.like', $article->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn {{ $liked ? 'btn-danger' : 'btn-outline-danger' }}">
                        ❤️ Лайки ({{ $article->likes_count }})
                    </button>
                </form>
            @else
                <button type="button" class="btn btn-outline-danger" disabled>
                    ❤️ Лайки ({{ $article->likes_count }})
                </button>
                <small class="text-muted ms-2">Войдите, чтобы поставить лайк</small>
            @endauth
        </div>


    </div>
</div>



<!-- Комментарии -->
<div class="card mt-4">
    <div class="card-body">
        <h4>Комментарии ({{ $article->comments->count() }})</h4>

        <!-- Форма добавления корневого комментария -->
        @auth
        <form action="{{ route('comments.store', $article->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <textarea name="content" class="form-control" rows="3" placeholder="Оставьте комментарий" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Отправить</button>
        </form>
        @else
        <p class="text-muted">
            Чтобы оставить комментарий, <a href="{{ route('login.show') }}">войдите в систему</a>.
        </p>
        @endauth

        <hr>

        <!-- Рекурсивный вывод комментариев -->
        @php
        function renderComments($comments, $level = 0) {
            foreach ($comments as $comment) {
                $margin = $level * 30;
                echo '<div class="mb-3" style="margin-left: '.$margin.'px; border-left: 2px solid #ccc; padding-left:10px;">';
                echo '<strong>'.$comment->user->name.':</strong>';
                
                // Текст комментария
                echo '<div id="comment-text-'.$comment->id.'" class="mt-1">';
                echo '<p>'.nl2br(e($comment->content)).'</p>';
                echo '</div>';

                // Форма редактирования (только автор)
                if(auth()->check() && auth()->id() === $comment->user_id) {
                    echo '<form action="'.route('comments.update', $comment->id).'" method="POST" class="d-none" id="edit-form-'.$comment->id.'">';
                    echo csrf_field();
                    echo method_field('PUT');
                    echo '<textarea name="content" class="form-control mb-2" rows="2" required>'.$comment->content.'</textarea>';
                    echo '<button type="submit" class="btn btn-sm btn-success">💾 Сохранить</button>';
                    echo '<button type="button" class="btn btn-sm btn-secondary" onclick="cancelEdit('.$comment->id.')">Отмена</button>';
                    echo '</form>';
                }

                echo '<small class="text-muted">'.$comment->created_at->format('d.m.Y H:i').'</small>';

                // Кнопки "Ответить" и "Показать ответы"
                if(auth()->check()) {
                    echo '<div class="mt-2 d-flex gap-2">';
                    echo '<button type="button" class="btn btn-sm btn-secondary" id="reply-btn-'.$comment->id.'" onclick="showReplyForm('.$comment->id.')">Ответить</button>';
                    if($comment->replies && count($comment->replies) > 0) {
                        echo '<button type="button" class="btn btn-sm btn-outline-info" id="toggle-replies-btn-'.$comment->id.'" onclick="toggleReplies('.$comment->id.')">Показать ответы ('.count($comment->replies).')</button>';
                    }
                    echo '</div>';
                }

                // Форма ответа
                if(auth()->check()) {
                    echo '<form action="'.route('comments.store', $comment->article_id).'" method="POST" class="mt-2 d-none" id="reply-form-'.$comment->id.'">';
                    echo csrf_field();
                    echo '<input type="hidden" name="parent_id" value="'.$comment->id.'">';
                    echo '<textarea name="content" class="form-control mb-1" rows="2" placeholder="Ваш ответ..." required></textarea>';
                    echo '<button type="submit" class="btn btn-sm btn-primary">Отправить</button>';
                    echo '</form>';
                }

                // Кнопки редактирования и удаления
                if(auth()->check() && auth()->id() === $comment->user_id) {
                    echo '<div class="mt-2">';
                    echo '<button type="button" class="btn btn-sm btn-primary" onclick="editComment('.$comment->id.')">✏️ Редактировать</button>';
                    echo '<form action="'.route('comments.destroy', $comment->id).'" method="POST" class="d-inline">';
                    echo csrf_field();
                    echo method_field('DELETE');
                    echo '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Удалить комментарий?\')">🗑️ Удалить</button>';
                    echo '</form>';
                    echo '</div>';
                }

                // Рекурсивные ответы (по умолчанию скрыты)
                if($comment->replies && count($comment->replies) > 0) {
                    echo '<div id="replies-'.$comment->id.'" class="mt-3 d-none">';
                    renderComments($comment->replies, $level + 1);
                    echo '</div>';
                }

                echo '</div>'; // конец комментария
            }
        }
        @endphp

        @php
            renderComments($article->comments()->whereNull('parent_id')->get());
        @endphp

    </div>
</div>

<!-- Скрипт -->
<script>
function editComment(id) {
    document.getElementById('comment-text-' + id).classList.add('d-none');
    document.getElementById('edit-form-' + id).classList.remove('d-none');
}

function cancelEdit(id) {
    document.getElementById('comment-text-' + id).classList.remove('d-none');
    document.getElementById('edit-form-' + id).classList.add('d-none');
}

function showReplyForm(id) {
    const btn = document.getElementById('reply-btn-' + id);
    const form = document.getElementById('reply-form-' + id);
    btn.classList.add('d-none');
    form.classList.remove('d-none');
}

function toggleReplies(id) {
    const replies = document.getElementById('replies-' + id);
    const btn = document.getElementById('toggle-replies-btn-' + id);

    if (replies.classList.contains('d-none')) {
        replies.classList.remove('d-none');
        btn.textContent = 'Скрыть ответы';
    } else {
        replies.classList.add('d-none');
        btn.textContent = 'Показать ответы';
    }
}
</script>


@endsection


