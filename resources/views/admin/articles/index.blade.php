@extends('layouts.admin')

@section('title', 'مدیریت مقالات')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">مدیریت مقالات</h1>
            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> ایجاد مقاله جدید
            </a>
        </div>
        
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('admin.articles.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control" placeholder="جستجو..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary ms-2">جستجو</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            <div class="dropdown me-2">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    وضعیت: {{ request('status') == 'published' ? 'منتشر شده' : (request('status') == 'draft' ? 'پیش‌نویس' : (request('status') == 'scheduled' ? 'زمان‌بندی شده' : 'همه')) }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.articles.index') }}">همه</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.articles.index', ['status' => 'published']) }}">منتشر شده</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.articles.index', ['status' => 'draft']) }}">پیش‌نویس</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.articles.index', ['status' => 'scheduled']) }}">زمان‌بندی شده</a></li>
                                </ul>
                            </div>
                            
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    مرتب‌سازی بر اساس
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.articles.index', ['sort' => 'newest']) }}">جدیدترین</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.articles.index', ['sort' => 'popular']) }}">محبوب‌ترین</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.articles.index', ['sort' => 'oldest']) }}">قدیمی‌ترین</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>تصویر</th>
                                <th>عنوان</th>
                                <th>دسته‌بندی</th>
                                <th>نویسنده</th>
                                <th>وضعیت</th>
                                <th>تاریخ انتشار</th>
                                <th>بازدید</th>
                                <th width="150">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $article)
                                <tr>
                                    <td>{{ $article->id }}</td>
                                    <td>
                                        <img src="{{ $article->image ? asset('storage/' . $article->image) : 'https://via.placeholder.com/50x50' }}" width="50" height="50" class="rounded" alt="{{ $article->title }}">
                                    </td>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->category->name ?? 'بدون دسته‌بندی' }}</td>
                                    <td>{{ $article->user->name ?? 'ناشناس' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $article->status == 'published' ? 'success' : ($article->status == 'draft' ? 'warning' : 'info') }}">
                                            {{ $article->status == 'published' ? 'منتشر شده' : ($article->status == 'draft' ? 'پیش‌نویس' : 'زمان‌بندی شده') }}
                                        </span>
                                    </td>
                                    <td>{{ $article->published_at ? $article->published_at->format('Y/m/d H:i') : '-' }}</td>
                                    <td>{{ $article->views ?? 0 }}</td>
                                    <td>
                                        <div class="action-btns">
                                            <a href="{{ route('admin.articles.show', $article) }}" class="btn btn-sm btn-info" target="_blank" title="نمایش">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm btn-primary" title="ویرایش">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('آیا از حذف این مقاله اطمینان دارید؟')" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">هیچ مقاله‌ای یافت نشد.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
@endsection