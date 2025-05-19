@extends('layouts.front')

@section('title', $article->title)
@section('meta_description', $article->excerpt)
@section('meta_keywords', $article->tags->pluck('name')->join(', '))

@section('content')
    <!-- هدر مقاله -->
    <div class="bg-dark text-white py-5" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ $article->image ? asset('storage/' . $article->image) : 'https://via.placeholder.com/1200x600' }}') no-repeat center center; background-size: cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <span class="badge bg-primary mb-3">{{ $article->category->name }}</span>
                    <h1 class="display-4 fw-bold">{{ $article->title }}</h1>
                    <div class="d-flex justify-content-center mt-4">
                        <div class="mx-3">
                            <i class="far fa-user me-1"></i> {{ $article->user->name }}
                        </div>
                        <div class="mx-3">
                            <i class="far fa-calendar me-1"></i> {{ $article->published_at->format('d F Y') }}
                        </div>
                        <div class="mx-3">
                            <i class="far fa-eye me-1"></i> {{ $article->views }} بازدید
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- محتوای مقاله -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- ستون اصلی -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="article-content">
                                <p class="lead">{{ $article->excerpt }}</p>
                                
                                {!! $article->content !!}
                            </div>
                            
                            <!-- برچسب‌ها -->
                            <div class="mt-4 pt-4 border-top">
                                <h5>برچسب‌ها:</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($article->tags as $tag)
                                        <a href="{{ route('articles.tag', $tag->slug) }}" class="badge bg-light text-dark text-decoration-none p-2">{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- اشتراک‌گذاری -->
                            <div class="mt-4 pt-4 border-top">
                                <h5>اشتراک‌گذاری:</h5>
                                <div class="d-flex gap-2">
                                    <a href="https://t.me/share/url?url={{ urlencode(route('articles.show', $article->slug)) }}&text={{ urlencode($article->title) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fab fa-telegram"></i> تلگرام</a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('articles.show', $article->slug)) }}&text={{ urlencode($article->title) }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fab fa-twitter"></i> توییتر</a>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('articles.show', $article->slug)) }}&title={{ urlencode($article->title) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fab fa-linkedin"></i> لینکدین</a>
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . route('articles.show', $article->slug)) }}" target="_blank" class="btn btn-sm btn-outline-success"><i class="fab fa-whatsapp"></i> واتساپ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- نویسنده -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="https://via.placeholder.com/100x100" class="rounded-circle" width="80" height="80" alt="تصویر نویسنده">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5>{{ $article->user->name }}</h5>
                                    <p class="text-muted mb-2">نویسنده و کارشناس حوزه {{ $article->category->name }}</p>
                                    <p class="mb-0">{{ $article->user->bio ?? 'این نویسنده هنوز بیوگرافی برای خود ثبت نکرده است.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- مقالات مرتبط -->
                    @if($relatedArticles->count() > 0)
                        <h4 class="mb-4">مقالات مرتبط</h4>
                        <div class="row">
                            @foreach($relatedArticles as $relatedArticle)
                                <div class="col-md-6 mb-4">
                                    <div class="card article-card h-100">
                                        <img src="{{ $relatedArticle->image ? asset('storage/' . $relatedArticle->image) : 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $relatedArticle->title }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $relatedArticle->title }}</h5>
                                            <div class="article-meta">
                                                <span><i class="far fa-user me-1"></i> {{ $relatedArticle->user->name }}</span>
                                                <span><i class="far fa-clock me-1"></i> {{ $relatedArticle->published_at->diffForHumans() }}</span>
                                            </div>
                                            <a href="{{ route('articles.show', $relatedArticle->slug) }}" class="btn btn-primary mt-3">ادامه مطلب</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- سایدبار -->
                <div class="col-lg-4">
                    <!-- جستجو -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">جستجو</h5>
                            <form action="{{ route('articles.search') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="query" placeholder="جستجو در مقالات...">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- دسته‌بندی‌ها -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">دسته‌بندی‌ها</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach(\App\Models\Category::withCount('articles')->get() as $category)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{ route('articles.category', $category->slug) }}" class="text-decoration-none text-dark">{{ $category->name }}</a>
                                        <span class="badge bg-primary rounded-pill">{{ $category->articles_count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    
                    <!-- مقالات محبوب -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">مقالات محبوب</h5>
                        </div>
                        <div class="card-body">
                            @foreach(\App\Models\Article::published()->orderByDesc('views')->limit(3)->get() as $popularArticle)
                                <div class="mb-3">
                                    <div class="row g-0">
                                        <div class="col-4">
                                            <img src="{{ $popularArticle->image ? asset('storage/' . $popularArticle->image) : 'https://via.placeholder.com/100x100' }}" class="img-fluid rounded" alt="{{ $popularArticle->title }}">
                                        </div>
                                        <div class="col-8">
                                            <div class="ps-3">
                                                <h6 class="mb-1"><a href="{{ route('articles.show', $popularArticle->slug) }}" class="text-decoration-none text-dark">{{ $popularArticle->title }}</a></h6>
                                                <small class="text-muted"><i class="far fa-clock me-1"></i> {{ $popularArticle->published_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- برچسب‌ها -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">برچسب‌ها</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(\App\Models\Tag::withCount('articles')->orderByDesc('articles_count')->limit(10)->get() as $tag)
                                    <a href="{{ route('articles.tag', $tag->slug) }}" class="badge bg-light text-dark text-decoration-none p-2">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- خبرنامه -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">عضویت در خبرنامه</h5>
                        </div>
                        <div class="card-body">
                            <p>برای دریافت آخرین مقالات و اخبار، در خبرنامه ما عضو شوید.</p>
                            <form>
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="ایمیل خود را وارد کنید...">
                                    <button class="btn btn-primary" type="submit">عضویت</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection