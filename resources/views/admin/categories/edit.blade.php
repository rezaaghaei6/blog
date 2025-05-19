@extends('layouts.admin')

@section('title', 'ویرایش دسته‌بندی')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="content-title">ویرایش دسته‌بندی: {{ $category->name }}</h2>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-right me-1"></i>
            بازگشت
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">نام دسته‌بندی</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="slug" class="form-label">نامک</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                       id="slug" name="slug" value="{{ old('slug', $category->slug) }}">
                <div class="form-text">اگر خالی بماند، به صورت خودکار از نام دسته‌بندی ساخته می‌شود.</div>
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">توضیحات (اختیاری)</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>
                    بروزرسانی
                </button>
            </div>
        </form>
    </div>
</div>

@if($category->articles_count > 0)
<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">مقالات این دسته‌بندی</h5>
    </div>
    <div class="card-body">
        <p>این دسته‌بندی دارای {{ $category->articles_count }} مقاله است.</p>
        <a href="{{ route('admin.articles.index', ['category_id' => $category->id]) }}" class="btn btn-info btn-sm">
            <i class="fas fa-eye me-1"></i>
            مشاهده مقالات
        </a>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
    // اسکریپت تبدیل نام به نامک
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        
        nameInput.addEventListener('blur', function() {
            if (slugInput.value === '') {
                const slug = nameInput.value
                    .toLowerCase()
                    .replace(/[^a-z0-9آ-ی]/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
                
                slugInput.value = slug;
            }
        });
    });
</script>
@endsection
