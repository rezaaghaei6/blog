<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'سایت مقالات - آخرین مقالات در موضوعات مختلف')">
    <meta name="keywords" content="@yield('meta_keywords', 'مقالات، آموزش، اخبار، تکنولوژی')">
    <title>@yield('title', 'سایت مقالات') - مرجع مقالات تخصصی</title>
    
    <!-- فونت‌آوسم -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- بوت‌استرپ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- فونت وزیر -->
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    
    <!-- اسلایدر Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    
    <!-- استایل‌های سفارشی -->
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #4b5563;
            --accent-color: #f59e0b;
            --light-color: #f3f4f6;
            --dark-color: #1f2937;
        }
        
        body {
            font-family: 'Vazirmatn', Tahoma, Arial, sans-serif;
            line-height: 1.7;
            background-color: #f8f9fa;
            color: #333;
        }
        
        /* هدر */
        .site-header {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color);
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark-color);
            margin: 0 5px;
            transition: all 0.3s;
        }
        
        .nav-link:hover {
            color: var(--primary-color);
        }
        
        .nav-link.active {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
        }
        
        /* اسلایدر */
        .hero-slider {
            height: 500px;
        }
        
        .hero-slide {
            position: relative;
            height: 100%;
            background-size: cover;
            background-position: center;
            color: white;
        }
        
        .hero-slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7));
            display: flex;
            align-items: center;
            padding: 2rem;
        }
        
        .hero-slide-content {
            max-width: 600px;
        }
        
        .hero-slide-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .hero-slide-excerpt {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }
        
        /* کارت مقالات */
        .article-card {
            height: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        
        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .article-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        .article-card .card-body {
            padding: 1.5rem;
        }
        
        .article-card .card-title {
            font-weight: 700;
            margin-bottom: 0.75rem;
        }
        
        .article-card .card-text {
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }
        
        .article-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: var(--secondary-color);
            margin-top: 1rem;
        }
        
        /* بخش دسته‌بندی‌ها */
        .category-box {
            position: relative;
            height: 150px;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 1.5rem;
            background-size: cover;
            background-position: center;
        }
        
        .category-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0.7));
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .category-box:hover .category-overlay {
            background: linear-gradient(to bottom, rgba(0,0,0,0.6), rgba(0,0,0,0.8));
        }
        
        .category-name {
            color: white;
            font-weight: 700;
            font-size: 1.3rem;
            text-align: center;
        }
        
        .category-count {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: var(--primary-color);
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        
        /* بخش‌های صفحه */
        .section-title {
            position: relative;
            margin-bottom: 2rem;
            font-weight: 700;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            right: 0;
            width: 50px;
            height: 3px;
            background-color: var(--primary-color);
        }
        
        /* فوتر */
        .site-footer {
            background-color: var(--dark-color);
            color: white;
            padding: 3rem 0 0;
        }
        
        .footer-heading {
            color: white;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.5rem;
        }
        
        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .footer-bottom {
            background-color: rgba(0,0,0,0.2);
            padding: 1rem 0;
            margin-top: 3rem;
        }
        
        .social-icons a {
            color: white;
            margin-left: 15px;
            font-size: 1.2rem;
            transition: color 0.3s;
        }
        
        .social-icons a:hover {
            color: var(--accent-color);
        }
        
        /* نوار جستجو */
        .search-form .form-control {
            border-radius: 50px 0 0 50px;
            border: none;
            padding-right: 20px;
        }
        
        .search-form .btn {
            border-radius: 0 50px 50px 0;
            padding-left: 20px;
        }
        
        /* دکمه‌ها */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #1e40af;
            border-color: #1e40af;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        /* بخش خبرنامه */
        .newsletter-box {
            background-color: var(--primary-color);
            padding: 3rem 0;
            color: white;
            margin: 4rem 0;
        }
        
        .newsletter-form .form-control {
            border-radius: 50px 0 0 50px;
            border: none;
            height: 50px;
            padding-right: 20px;
        }
        
        .newsletter-form .btn {
            border-radius: 0 50px 50px 0;
            background-color: var(--dark-color);
            border-color: var(--dark-color);
            height: 50px;
            padding-left: 25px;
            padding-right: 25px;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- هدر -->
    <header class="site-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">سایت مقالات</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">صفحه اصلی</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                دسته‌بندی‌ها
                            </a>
                            <ul class="dropdown-menu">
                                @foreach(\App\Models\Category::take(6)->get() as $category)
                                    <li><a class="dropdown-item" href="{{ route('articles.category', $category->slug) }}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('articles.search') }}">جستجوی مقالات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}#about">درباره ما</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}#contact">تماس با ما</a>
                        </li>
                    </ul>
                    
                    <div class="d-flex">
                        <form class="search-form d-flex" action="{{ route('articles.search') }}" method="GET">
                            <input class="form-control" type="search" name="query" placeholder="جستجو..." aria-label="Search">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </form>
                        
                        @auth
                            <div class="dropdown ms-3">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">پنل مدیریت</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">خروج</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- محتوای اصلی -->
    <main>
        @yield('content')
    </main>

    <!-- بخش خبرنامه -->
    <section class="newsletter-box">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h3 class="mb-3">عضویت در خبرنامه</h3>
                    <p class="mb-4">برای دریافت آخرین مقالات و اخبار، در خبرنامه ما عضو شوید.</p>
                    <form class="newsletter-form d-flex justify-content-center">
                        <input type="email" class="form-control" placeholder="ایمیل خود را وارد کنید...">
                        <button class="btn" type="submit">عضویت</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- فوتر -->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5">
                    <h4 class="footer-heading">درباره ما</h4>
                    <p>سایت مقالات، مرجعی برای انتشار مقالات تخصصی و آموزشی در زمینه‌های مختلف است. هدف ما ارائه محتوای با کیفیت و کاربردی برای مخاطبان است.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-telegram"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-5">
                    <h4 class="footer-heading">دسترسی سریع</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">صفحه اصلی</a></li>
                        <li><a href="{{ route('articles.search') }}">جستجوی مقالات</a></li>
                        <li><a href="{{ route('home') }}#about">درباره ما</a></li>
                        <li><a href="{{ route('home') }}#contact">تماس با ما</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-5">
                    <h4 class="footer-heading">دسته‌بندی‌ها</h4>
                    <ul class="footer-links">
                        @foreach(\App\Models\Category::take(5)->get() as $category)
                            <li><a href="{{ route('articles.category', $category->slug) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-5">
                    <h4 class="footer-heading">تماس با ما</h4>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt me-2"></i> تهران، خیابان ولیعصر</li>
                        <li><i class="fas fa-phone me-2"></i> ۰۲۱-۱۲۳۴۵۶۷۸</li>
                        <li><i class="fas fa-envelope me-2"></i> info@example.com</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom text-center">
            <div class="container">
                <p class="mb-0">© تمامی حقوق برای سایت مقالات محفوظ است. {{ date('Y') }}</p>
            </div>
        </div>
    </footer>

    <!-- اسکریپت‌ها -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // راه‌اندازی اسلایدر
            if (document.querySelector('.swiper')) {
                new Swiper('.swiper', {
                    loop: true,
                    autoplay: {
                        delay: 5000,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                });
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>