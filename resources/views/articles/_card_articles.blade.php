<div class="row">
    @forelse($articles as $article)
        <div class="col-md-4 mb-4">
            <div class="card h-100 d-flex flex-column">
                @if($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" 
                         class="card-img-top article-img" 
                         alt="{{ $article->title }}">
                @else
                    <div class="card-img-top article-img bg-secondary d-flex align-items-center justify-content-center text-white">
                        Нет изображения
                    </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <p class="card-text">{{ Str::limit($article->content, 100) }}</p>
                    <p class="text-muted">Автор: {{ $article->user->name }}</p>
                    <div class="mt-auto">
                        <a href="{{ route('articles.show', $article->id) }}" class="btn btn-outline-primary w-100">Читать</a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Пока нет статей</p>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $articles->links() }}
</div>

<style>
.article-img {
    height: {{ $imgHeight ?? 300 }}px;
    object-fit: cover;
    object-position: center;
}
</style>
