@extends('layouts.admin')

@section('title', 'داشبورد')

@section('content')
<div class="content-header">
    <h2 class="content-title">داشبورد</h2>
</div>

<div class="row g-4">
    <!-- Articles Stats -->
    <div class="col-md-3">
        <div class="stats-card bg-primary bg-gradient text-white">
            <div class="stats-icon">
                <i class="fas fa-newspaper fa-2x"></i>
            </div>
            <div class="stats-info">
                <div class="stats-value">{{ number_format($stats['articles_count']) }}</div>
                <div class="stats-label">مقالات</div>
            </div>
        </div>
    </div>

    <!-- Published Articles Stats -->
    <div class="col-md-3">
        <div class="stats-card bg-success bg-gradient text-white">
            <div class="stats-icon">
                <i class="fas fa-check-circle fa-2x"></i>
            </div>
            <div class="stats-info">
                <div class="stats-value">{{ number_format($stats['published_articles_count']) }}</div>
                <div class="stats-label">مقالات منتشر شده</div>
            </div>
        </div>
    </div>

    <!-- Categories Stats -->
    <div class="col-md-3">
        <div class="stats-card bg-info bg-gradient text-white">
            <div class="stats-icon">
                <i class="fas fa-folder fa-2x"></i>
            </div>
            <div class="stats-info">
                <div class="stats-value">{{ number_format($stats['categories_count']) }}</div>
                <div class="stats-label">دسته‌بندی‌ها</div>
            </div>
        </div>
    </div>

    <!-- Tags Stats -->
    <div class="col-md-3">
        <div class="stats-card bg-warning bg-gradient text-white">
            <div class="stats-icon">
                <i class="fas fa-tags fa-2x"></i>
            </div>
            <div class="stats-info">
                <div class="stats-value">{{ number_format($stats['tags_count']) }}</div>
                <div class="stats-label">برچسب‌ها</div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Articles -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">آخرین مقالات</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>دسته‌بندی</th>
                        <th>وضعیت</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_articles as $article)
                    <tr>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->category->name ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $article->status === 'published' ? 'success' : 'warning' }}">
                                {{ $article->status === 'published' ? 'منتشر شده' : 'پیش‌نویس' }}
                            </span>
                        </td>
                        <td>{{ $article->created_at->format('Y/m/d H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">مقاله‌ای یافت نشد.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.stats-card {
    padding: 1.5rem;
    border-radius: 1rem;
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.stats-icon {
    margin-bottom: 1rem;
}

.stats-value {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.stats-label {
    font-size: 0.875rem;
    opacity: 0.9;
}
</style>
@endsection