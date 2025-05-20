@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <div class="container-fluid px-0">
        <!-- Hero Header with Featured Image -->
        <section class="hero-section position-relative text-center text-white d-flex align-items-center" 
                 style="height: 60vh; background: url('{{ $article->featured_image ? asset('storage/' . $article->featured_image) : 'https://via.placeholder.com/1920x1080' }}'); background-size: cover; background-position: center;">
            <div class="container position-relative">
                <h1 class="fs-1 fw-bold mb-3 text-shadow" aria-label="عنوان مقاله">{{ $article->title }}</h1>
                <div class="d-flex justify-content-center gap-3 text-light mb-3">
                    <span><i class="bi bi-person me-1"></i>{{ $article->user->name }}</span>
                    <span><i class="bi bi-calendar me-1"></i>{{ $article->published_at->format('d M Y') }}</span>
                    <span><i class="bi bi-eye me-1"></i>{{ $article->views }}</span>
                </div>
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    @if ($article->category)
                        <a href="{{ route('articles.category', $article->category->slug) }}" class="badge bg-blue text-white text-decoration-none px-3 py-2">{{ $article->category->name }}</a>
                    @endif
                    @foreach ($article->tags as $tag)
                        <a href="{{ route('articles.tag', $tag->slug) }}" class="badge bg-secondary text-white text-decoration-none px-3 py-2">{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <div class="container my-5">
            <div class="row justify-content-center">
                <!-- Article Content -->
                <div class="col-12 col-lg-10">
                    <!-- Article Meta -->
                    <div class="d-flex justify-content-between text-muted mb-4">
                        <span>زمان مطالعه: {{ ceil(str_word_count(strip_tags($article->content)) / 200) }} دقیقه</span>
                        <span>{{ str_word_count(strip_tags($article->content)) }} کلمه</span>
                    </div>
                    @if ($article->excerpt)
                        <div class="alert alert-blue mb-4" role="alert">
                            {{ $article->excerpt }}
                        </div>
                    @endif
                    <article class="card p-5 border-0 bg-white shadow-sm animate-fade-in">
                        {!! $article->content !!}
                    </article>
                    <!-- Publisher Info -->
                    <div class="mt-4 text-muted d-flex justify-content-between align-items-center border-top pt-3">
                        <span class="fw-bold">منتشرکننده: {{ $article->user->name }}</span>
                        <span>{{ $article->published_at->format('d M Y') }}</span>
                    </div>
                    <!-- Share Buttons -->
                    <div class="text-center mt-5">
                        <h6 class="fw-bold mb-3">اشتراک‌گذاری</h6>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" 
                               class="btn btn-blue btn-sm px-4 py-2 share-btn" 
                               aria-label="اشتراک در توییتر">
                                <i class="bi bi-twitter me-1"></i> توییتر
                            </a>
                            <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" 
                               class="btn btn-blue btn-sm px-4 py-2 share-btn" 
                               aria-label="اشتراک در تلگرام">
                                <i class="bi bi-telegram me-1"></i> تلگرام
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                               class="btn btn-blue btn-sm px-4 py-2 share-btn" 
                               aria-label="اشتراک در لینکدین">
                                <i class="bi bi-linkedin me-1"></i> لینکدین
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Articles -->
        @if ($relatedArticles->isNotEmpty())
            <section class="container my-5">
                <h6 class="fw-bold text-center mb-4">مقالات مرتبط</h6>
                <div class="row g-4">
                    @foreach ($relatedArticles as $related)
                        <div class="col-md-4">
                            <article class="card h-100 border-0 bg-white shadow-sm animate-fade-in">
                                <div class="image-container position-relative">
                                    <img src="{{ $related->featured_image ? asset('storage/' . $related->featured_image) : 'https://via.placeholder.com/1200x900' }}" 
                                         class="card-img-top img-fluid" 
                                         alt="{{ $related->title }}"
                                         loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">{{ $related->title }}</h6>
                                    @if ($related->excerpt)
                                        <p class="card-text text-muted small">{{ Str::limit($related->excerpt, 80) }}</p>
                                    @endif
                                    <a href="{{ route('admin.articles.show', $related->id) }}" class="btn btn-outline-blue btn-sm px-3 py-1">ادامه مطلب</a>
                                </div>
                                <div class="card-footer bg-transparent border-0">
                                    <small class="text-muted">{{ $related->published_at->format('d M Y') }}</small>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection

@section('styles')
    <style>
        :root {
            --blue: #38bdf8;
            --light-blue: #e0f2fe;
            --secondary: #9ca3af;
            --white: #ffffff;
            --text: #1e293b;
        }
        body {
            background-color: var(--light-blue);
            color: var(--text);
        }
        .hero-section {
            min-height: 400px;
        }
        .text-shadow {
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }
        .card {
            border-radius: 12px;
            transition: box-shadow 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }
        .image-container {
            aspect-ratio: 4/3;
            overflow: hidden;
            border-radius: 12px 12px 0 0;
        }
        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .card:hover .image-container img {
            transform: scale(1.03);
        }
        .btn-blue {
            background-color: var(--blue);
            border-color: var(--blue);
            border-radius: 8px;
            transition: transform 0.2s ease;
        }
        .btn-blue:hover {
            transform: scale(1.05);
        }
        .btn-outline-blue {
            border-color: var(--blue);
            color: var(--blue);
            border-radius: 8px;
        }
        .btn-outline-blue:hover {
            background-color: var(--blue);
            color: var(--white);
        }
        .alert-blue {
            background-color: rgba(56, 189, 248, 0.1);
            border-color: var(--blue);
            color: var(--text);
        }
        .bg-blue {
            background-color: var(--blue);
        }
        .badge {
            font-size: 0.85rem;
            font-weight: 500;
        }
        .share-btn {
            transition: transform 0.2s ease;
        }
        .share-btn:hover {
            transform: scale(1.1);
        }
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endsection
