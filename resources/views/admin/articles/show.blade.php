@extends('layouts.admin')

@section('title', 'نمایش مقاله')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">{{ $article->title }}</h3>
                    <div class="card-tools">
                        <button id="copy-article-link" class="btn btn-info btn-sm" title="کپی لینک">
                            <i class="fas fa-link me-1"></i>
                        </button>
                        <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-1"></i> ویرایش
                        </a>
                        @if($article->status !== 'published')
                            <button id="publish-article" 
                                    class="btn btn-success btn-sm" 
                                    data-article-id="{{ $article->id }}">
                                <i class="fas fa-check me-1"></i> انتشار
                            </button>
                        @else
                            <button id="unpublish-article" 
                                    class="btn btn-warning btn-sm" 
                                    data-article-id="{{ $article->id }}">
                                <i class="fas fa-times me-1"></i> لغو انتشار
                            </button>
                        @endif
                        <form action="{{ route('admin.articles.destroy', $article) }}" 
                              method="POST" 
                              class="d-inline" 
                              id="delete-article-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    id="delete-article" 
                                    class="btn btn-danger btn-sm">
                                <i class="fas fa-trash me-1"></i> حذف
                            </button>
                        </form>
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> بازگشت
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>اطلاعات مقاله</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="150">عنوان</th>
                                    <td>{{ $article->title }}</td>
                                </tr>
                                <tr>
                                    <th>نامک (Slug)</th>
                                    <td>{{ $article->slug }}</td>
                                </tr>
                                <tr>
                                    <th>خلاصه</th>
                                    <td>{{ $article->excerpt }}</td>
                                </tr>
                                <tr>
                                    <th>وضعیت</th>
                                    <td>
                                        <span class="badge bg-{{ $article->status === 'published' ? 'success' : ($article->status === 'draft' ? 'warning' : 'secondary') }}">
                                            {{ $article->status === 'published' ? 'منتشر شده' : ($article->status === 'draft' ? 'پیش‌نویس' : 'نامشخص') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>نویسنده</th>
                                    <td>{{ $article->user->name ?? 'نامشخص' }}</td>
                                </tr>
                                <tr>
                                    <th>دسته‌بندی</th>
                                    <td>{{ $article->category->name ?? 'بدون دسته‌بندی' }}</td>
                                </tr>
                                <tr>
                                    <th>تاریخ انتشار</th>
                                    <td>{{ $article->published_at ? $article->published_at->format('Y/m/d H:i:s') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>بازدید</th>
                                    <td>{{ $article->views ?? 0 }}</td>
                                </tr>
                            </table>

                            <h4 class="mt-4">محتوای مقاله</h4>
                            <div class="article-content border rounded p-3">
                                {!! $article->content !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h4>تصویر شاخص</h4>
                            @if($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                     class="img-fluid rounded" 
                                     alt="{{ $article->title }}">
                            @else
                                <div class="alert alert-info">
                                    تصویر شاخص آپلود نشده است
                                </div>
                            @endif

                            <h4 class="mt-4">برچسب‌ها</h4>
                            <div class="tags">
                                @forelse($article->tags as $tag)
                                    <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
                                @empty
                                    <span class="text-muted">برچسبی وجود ندارد</span>
                                @endforelse
                            </div>

                            <h4 class="mt-4">آمار</h4>
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    تعداد بازدید
                                    <span class="badge bg-primary rounded-pill">{{ $article->views ?? 0 }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    تعداد نظرات
                                    <span class="badge bg-primary rounded-pill">{{ $article->comments->count() }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    تعداد لایک‌ها
                                    <span class="badge bg-primary rounded-pill">{{ $article->likes_count ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted">
                                <i class="far fa-clock me-1"></i>
                                ایجاد شده در: {{ $article->created_at->format('Y/m/d H:i:s') }}
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="text-muted">
                                <i class="far fa-edit me-1"></i>
                                آخرین بروزرسانی: {{ $article->updated_at->format('Y/m/d H:i:s') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($article->comments->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="card-title">نظرات ({{ $article->comments->count() }})</h4>
                </div>
                <div class="card-body">
                    <div class="comments-list">
                        @foreach($article->comments as $comment)
                            <div class="comment mb-3 p-3 border rounded">
                                <div class="comment-header d-flex justify-content-between">
                                    <h5 class="comment-author">
                                        {{ $comment->name }}
                                        @if($comment->user_id)
                                            <small class="text-muted">(کاربر ثبت شده)</small>
                                        @endif
                                    </h5>
                                    <small class="text-muted">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div class="comment-body mt-2">
                                    <p>{{ $comment->content }}</p>
                                </div>
                                <div class="comment-footer">
                                    <span class="badge bg-{{ $comment->status === 'approved' ? 'success' : 'warning' }}">
                                        {{ $comment->status === 'approved' ? 'تأیید شده' : 'در انتظار بررسی' }}
                                    </span>
                                </div>
                            </div>
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
    .article-content {
        line-height: 1.8;
    }
    .article-content img {
        max-width: 100%;
        height: auto;
    }
    .tags .badge {
        margin-bottom: 5px;
    }
    .comment {
        background-color: #f8f9fa;
    }
    .comment-author {
        margin-bottom: 0;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // کپی کردن لینک مقاله
        const copyArticleLink = document.getElementById('copy-article-link');
        if (copyArticleLink) {
            copyArticleLink.addEventListener('click', function() {
                const articleLink = window.location.href;
                navigator.clipboard.writeText(articleLink).then(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'لینک کپی شد!',
                        text: 'لینک مقاله با موفقیت کپی شد.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }, function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا',
                        text: 'کپی لینک با مشکل مواجه شد.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
            });
        }

        // مدیریت اقدامات مقاله
        const articleActions = {
            publish: document.getElementById('publish-article'),
            unpublish: document.getElementById('unpublish-article'),
            delete: document.getElementById('delete-article')
        };

        // انتشار مقاله
        if (articleActions.publish) {
            articleActions.publish.addEventListener('click', function() {
                Swal.fire({
                    title: 'انتشار مقاله',
                    text: 'آیا از انتشار این مقاله اطمینان دارید؟',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله، منتشر شود',
                    cancelButtonText: 'انصراف'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post(`/admin/articles/${this.dataset.articleId}/publish`)
                            .then(response => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'انتشار موفق',
                                    text: response.data.message
                                }).then(() => {
                                    location.reload();
                                });
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'خطا',
                                    text: error.response.data.message || 'خطا در انتشار مقاله'
                                });
                            });
                    }
                });
            });
        }

        // لغو انتشار مقاله
        if (articleActions.unpublish) {
            articleActions.unpublish.addEventListener('click', function() {
                Swal.fire({
                    title: 'لغو انتشار مقاله',
                    text: 'آیا از لغو انتشار این مقاله اطمینان دارید؟',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله، لغو شود',
                    cancelButtonText: 'انصراف'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post(`/admin/articles/${this.dataset.articleId}/unpublish`)
                            .then(response => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'لغو انتشار موفق',
                                    text: response.data.message
                                }).then(() => {
                                    location.reload();
                                });
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'خطا',
                                    text: error.response.data.message || 'خطا در لغو انتشار مقاله'
                                });
                            });
                    }
                });
            });
        }

        // حذف مقاله
        if (articleActions.delete) {
            articleActions.delete.addEventListener('click', function() {
                Swal.fire({
                    title: 'حذف مقاله',
                    text: 'آیا از حذف این مقاله اطمینان دارید؟ این عمل غیرقابل بازگشت است!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'بله، حذف شود',
                    cancelButtonText: 'انصراف'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-article-form').submit();
                    }
                });
            });
        }
    });
</script>
@endsection
