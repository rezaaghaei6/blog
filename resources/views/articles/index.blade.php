@extends('layouts.app')

@section('title', 'مجله تخصصی | آخرین مقالات')

@section('content')
<!-- Hero Section -->
<section class="hero-section d-flex align-items-center text-center text-white" style="background: linear-gradient(135deg, #6a82fb 0%, #fc5c7d 100%); height: 60vh;">
    <div class="container">
        <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInUp">مجله تخصصی</h1>
        <p class="lead mb-4 animate__animated animate__fadeInUp animate__delay-1s">آخرین مقالات و مطالب تخصصی در حوزه‌های مختلف را در اینجا دنبال کنید</p>
        <form action="{{ route('articles.search') }}" method="GET" class="d-flex justify-content-center">
            <input type="search" name="q" class="form-control w-50 me-2" placeholder="جستجو در مقالات..." value="{{ request('q') }}">
            <button type="submit" class="btn btn-light">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</section>

<!-- Categories Section -->
<div class="container mt-5">
    <h2 class="text-center mb-4">دسته‌بندی‌ها</h2>
    <div class="row">
        @if(isset($categories) && $categories->count() > 0)
            @foreach($categories as $category)
            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <a href="{{ route('articles.category', $category->slug) }}" class="btn btn-outline-primary">مشاهده مقالات</a>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    <span>هیچ دسته‌بندی‌ای برای نمایش وجود ندارد.</span>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row">
        <!-- Articles List -->
        <div class="col-lg-8 mb-4">
            <!-- Filters -->
            <div class="card shadow-lg mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <span class="text-muted">مرتب‌سازی:</span>
                    <select class="form-select w-auto" aria-label="مرتب‌سازی مقالات">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>جدیدترین</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>محبوب‌ترین</option>
                        <option value="trending" {{ request('sort') == 'trending' ? 'selected' : '' }}>پربازدیدترین</option>
                    </select>
                </div>
            </div>

            <!-- Articles Grid -->
            <div class="row g-4">
                @forelse($articles as $article)
                <div class="col-md-6">
                    <article class="card h-100 border-0 shadow-lg hover-shadow">
                        <div class="position-relative">
                            @if($article->is_featured)
                            <div class="featured-badge">
                                <i class="fas fa-star"></i>
                            </div>
                            @endif
                            <img src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : 'https://via.placeholder.com/400x250' }}" 
                                 class="card-img-top" 
                                 alt="{{ $article->title }}" 
                                 loading="lazy">
                            @if($article->category)
                            <a href="{{ route('articles.category', $article->category->slug) }}" class="category-badge">
                                {{ $article->category->name }}
                            </a>
                            @endif
                        </div>
                        <div class="card-body">
                            <h3 class="card-title h5 mb-3">
                                <a href="{{ route('articles.show', $article->slug) }}" class="text-dark text-decoration-none">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            <p class="card-text text-muted">{{ Str::limit($article->excerpt, 120) }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <div class="d-flex justify-content-between align-items-center">
                                @if($article->user)
                                <div class="author d-flex align-items-center">
                                    <img src="{{ $article->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($article->user->name) }}" 
                                         class="rounded-circle me-2" width="30" alt="{{ $article->user->name }}">
                                    <span class="small text-muted">{{ $article->user->name }}</span>
                                </div>
                                @endif
                                <div class="meta d-flex align-items-center">
                                    @if($article->published_at)
                                    <span class="small text-muted">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $article->published_at->diffForHumans() }}
                                    </span>
                                    @endif
                                    @if(isset($article->views))
                                    <span class="small text-muted">
                                        <i class="far fa-eye me-1"></i>
                                        {{ number_format($article->views) }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <span>در حال حاضر مقاله‌ای برای نمایش وجود ندارد.</span>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($articles->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $articles->withQueryString()->links() }}
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Popular Tags Widget -->
            @if(isset($tags) && $tags->count() > 0)
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tags me-2"></i>
                        برچسب‌های محبوب
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        @foreach($tags as $tag)
                        <a href="{{ route('articles.tag', $tag->slug) }}" class="btn btn-outline-primary btn-sm me-2 mb-2">
                            {{ $tag->name }}
                            <span class="badge bg-primary ms-1">{{ number_format($tag->articles_count) }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Hero Section */
.hero-section {
    height: 60vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

/* Categories Section */
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Featured Badge */
.featured-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #ffd700;
    color: #000;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Category Badge */
.category-badge {
    position: absolute;
    bottom: 15px;
    left: 15px;
    background: rgba(255, 255, 255, 0.9);
    color: #6a82fb;
    padding: 5px 15px;
    border-radius: 20px;
}

/* Button Styles */
.btn-light {
    background-color: #fff;
    color: #6a82fb;
    border: none;
}

.btn-light:hover {
    background-color: #f8f9fa;
}

/* List Group Styles */
.list-group-item {
    transition: background-color 0.3s;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sort Articles
    const sortSelect = document.querySelector('.sorting select');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('sort', this.value);
            window.location.href = currentUrl.toString();
        });
    }
});
</script>
@endsection