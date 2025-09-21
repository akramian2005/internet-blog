<h3>Все статьи</h3>

<div class="row">
    @forelse($articles as $article)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" alt="{{ $article->title }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <p class="card-text">{{ Str::limit($article->content, 100) }}</p>
                    <p class="text-muted">Автор: {{ $article->user->name }}</p>
                    <a href="{{ route('articles.show', $article->id) }}" class="btn btn-outline-primary">Читать</a>
                </div>
            </div>
        </div>
    @empty
        <p>Пока нет статей</p>
    @endforelse
</div>
