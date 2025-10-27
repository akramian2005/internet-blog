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
                <form action="{{ route('articles.like', $article->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
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

        <!-- Форма добавления комментария -->
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

        <!-- Вывод комментариев -->
        @foreach($article->comments as $comment)
            <div class="mb-3 border-bottom pb-2">
                <strong>{{ $comment->user->name }}:</strong>

                <!-- Текст комментария -->
                <div id="comment-text-{{ $comment->id }}">
                    <p>{!! nl2br(e($comment->content)) !!}</p>
                </div>

                <!-- Форма редактирования (скрыта по умолчанию) -->
                <form action="{{ route('comments.update', $comment->id) }}" method="POST"
                      class="d-none" id="edit-form-{{ $comment->id }}">
                    @csrf
                    @method('PUT')
                    <textarea name="content" class="form-control mb-2" rows="3" required>{{ $comment->content }}</textarea>
                    <button type="submit" class="btn btn-sm btn-success">💾 Сохранить</button>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="cancelEdit({{ $comment->id }})">Отмена</button>
                </form>

                <small class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</small>

                @auth
                    @if(auth()->id() === $comment->user_id)
                        <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-primary" onclick="editComment({{ $comment->id }})">
                                ✏️ Редактировать
                            </button>

                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Удалить комментарий?')">
                                    🗑️ Удалить
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        @endforeach
    </div>
</div>

<!-- Скрипт для показа/скрытия формы редактирования -->
<script>
function editComment(id) {
    document.getElementById('comment-text-' + id).classList.add('d-none');
    document.getElementById('edit-form-' + id).classList.remove('d-none');
}

function cancelEdit(id) {
    document.getElementById('comment-text-' + id).classList.remove('d-none');
    document.getElementById('edit-form-' + id).classList.add('d-none');
}
</script>
@endsection


