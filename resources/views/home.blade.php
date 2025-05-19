@extends('layouts.front')

@section('title', 'صفحه اصلی')

@section('content')
    <!-- اسلایدر -->
    <div class="swiper hero-slider">
        <div class="swiper-wrapper">
            @forelse($featuredArticles as $article)
                <div class="swiper-slide hero-slide" style="background-image: url('{{ $article->image ? asset('storage/' . $article->image) : 'https://via.placeholder.com/1200x500' }}')">
                    <div class="hero-slide-overlay">
                        <div class="hero-slide-content">
                            <h1 class="hero-slide-title">{{ $article->title }}</h1>
                            <p class="hero-slide-excerpt">{{ $article->excerpt }}</p>
                            <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-primary">ادامه مطلب</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="swiper-slide hero-slide" style="background-image: url('https://via.placeholder.com/1200x500')">
                    <div class="hero-slide-overlay">
                        <div class="hero-slide-content">
                            <h1 class="hero-slide-title">به سایت مقالات خوش آمدید</h1>
                            <p class="hero-slide-excerpt">مرجع مقالات تخصصی و آموزشی در زمینه‌های مختلف</p>
                            <a href="{{ route('articles.search') }}" class="btn btn-primary">مشاهده مقالات</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>

    <!-- بخش دسته‌بندی‌ها -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">دسته‌بندی‌های محبوب</h2>
            
            <div class="row">
                @forelse($categories as $category)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('articles.category', $category->slug) }}" class="text-decoration-none">
                            <div class="category-box" style="background-image: url('{{ $category->image ? asset('storage/' . $category->image) : 'https://via.placeholder.com/400x200' }}')">
                                <div class="category-overlay">
                                    <div class="category-name">{{ $category->name }}</div>
                                    <div class="category-count">{{ $category->articles_count }} مقاله</div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            در حال حاضر دسته‌بندی‌ای وجود ندارد.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- بخش آخرین مقالات -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0">آخرین مقالات</h2>
                <a href="{{ route('articles.search') }}" class="btn btn-outline-primary">مشاهده همه مقالات</a>
            </div>
            
            <div class="row">
                @forelse($latestArticles as $article)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card article-card h-100">
                            <img src="{{ $article->image ? asset('storage/' . $article->image) : 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $article->title }}">
                            <div class="card-body">
                                <span class="badge bg-primary mb-2">{{ $article->category->name }}</span>
                                <h5 class="card-title">{{ $article->title }}</h5>
                                <p class="card-text">{{ Str::limit($article->excerpt, 100) }}</p>
                                <div class="article-meta">
                                    <span><i class="far fa-user me-1"></i> {{ $article->user->name }}</span>
                                    <span><i class="far fa-clock me-1"></i> {{ $article->published_at->diffForHumans() }}</span>
                                </div>
                                <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-primary mt-3">ادامه مطلب</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            در حال حاضر مقاله‌ای وجود ندارد.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- بخش آمار و ارقام -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <div class="display-4 fw-bold">{{ \App\Models\Article::published()->count() }}+</div>
                    <p class="h5">مقالات منتشر شده</p>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <div class="display-4 fw-bold">{{ \App\Models\Category::count() }}+</div>
                    <p class="h5">دسته‌بندی‌ها</p>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <div class="display-4 fw-bold">{{ \App\Models\User::count() }}+</div>
                    <p class="h5">نویسندگان</p>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <div class="display-4 fw-bold">5000+</div>
                    <p class="h5">بازدیدکنندگان ماهانه</p>
                </div>
            </div>
        </div>
    </section>

    <!-- بخش درباره ما -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="https://via.placeholder.com/600x400" alt="درباره ما" class="img-fluid rounded">
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title">درباره ما</h2>
                    <p>سایت مقالات، مرجعی برای انتشار مقالات تخصصی و آموزشی در زمینه‌های مختلف است. هدف ما ارائه محتوای با کیفیت و کاربردی برای مخاطبان است.</p>
                    <p>تیم ما متشکل از متخصصان و نویسندگان با تجربه در حوزه‌های مختلف است که با دقت و وسواس محتوای با کیفیت تولید می‌کنند.</p>
                    <p>ما به دنبال ارائه بهترین مقالات در زمینه‌های مختلف هستیم و همواره سعی داریم با به‌روزرسانی مداوم، جدیدترین اطلاعات را در اختیار مخاطبان قرار دهیم.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- بخش تماس با ما -->
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="section-title">تماس با ما</h2>
                    <p>برای ارتباط با ما می‌توانید از فرم زیر استفاده کنید یا از طریق اطلاعات تماس با ما در ارتباط باشید.</p>
                    
                    <div class="mt-4">
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-primary fs-4"></i>
                            </div>
                            <div class="ms-3">
                                <h5>آدرس</h5>
                                <p>تهران، خیابان ولیعصر</p>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-phone text-primary fs-4"></i>
                            </div>
                            <div class="ms-3">
                                <h5>تلفن</h5>
                                <p>۰۲۱-۱۲۳۴۵۶۷۸</p>
                            </div>
                        </div>
                        
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-envelope text-primary fs-4"></i>
                            </div>
                            <div class="ms-3">
                                <h5>ایمیل</h5>
                                <p>info@example.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">ارسال پیام</h5>
                            <form action="{{ route('home') }}#contact" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">نام</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">ایمیل</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">موضوع</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">پیام</label>
                                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">ارسال پیام</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection