<div class="row">
    @forelse($articles as $article)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                @if($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" 
                         class="card-img-top article-img" 
                         alt="{{ $article->title }}">
                @else
                    <div class="card-img-top article-img bg-secondary d-flex align-items-center justify-content-center text-white">
                        Нет изображения
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <p class="card-text">{{ Str::limit($article->content, 100) }}</p>
                    <p class="text-muted">Автор: {{ $article->user->name }}</p>
                    <a href="{{ route('articles.show', $article->id) }}" class="btn btn-outline-primary">Читать</a>

                    @auth
                        @if(auth()->id() === $article->user_id)
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary mt-2 d-block">Редактировать</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Пока нет статей</p>
    @endforelse
</div>

<style>
.article-img {
    height: {{ $imgHeight ?? 300 }}px;
    object-fit: cover;
    object-position: center;
}
</style>
