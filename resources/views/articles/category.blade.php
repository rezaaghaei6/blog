@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-primary">دسته‌بندی: {{ $category->name }}</h1>
            @if ($category->description)
                <p class="lead text-muted">{{ $category->description }}</p>
            @endif
        </div>

        <!-- Articles -->
        <div class="row g-4">
            @forelse ($articles as $article)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
                        @if ($article->featured_image)
                            <img src="{{ Storage::url($article->featured_image) }}" class="card-img-top" alt="{{ $article->title }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="تصویر پیش‌فرض" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $article->title }}</h5>
                            @if ($article->excerpt)
                                <p class="card-text text-muted">{{ Str::limit($article->excerpt, 100) }}</p>
                            @endif
                            <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-primary btn-sm">ادامه مطلب</a>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <small class="text-muted">منتشر شده در: {{ $article->published_at->format('d M Y') }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">هیچ مقاله‌ای در این دسته‌بندی یافت نشد.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($articles->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $articles->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
