@extends('layouts.admin')

@section('title', 'ویرایش مقاله')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .ck-editor__editable {
        min-height: 400px;
    }
    .select2-container {
        width: 100% !important;
    }
    .featured-image-preview {
        max-height: 200px;
        object-fit: cover;
    }
</style>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>ویرایش مقاله</h1>
        <div>
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-right"></i> بازگشت به لیست مقالات
            </a>
            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> مقاله جدید
            </a>
        </div>
    </div>
    
    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- ستون اصلی -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">عنوان مقاله <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $article->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="excerpt" class="form-label">خلاصه مقاله</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $article->excerpt) }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">محتوای مقاله <span class="text-danger">*</span></label>
                            <textarea class="form-control editor @error('content') is-invalid @enderror" id="content" name="content">{{ old('content', $article->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- ستون کناری -->
            <div class="col-md-4">
                <!-- کارت وضعیت انتشار -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">انتشار</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">وضعیت</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>پیش‌نویس</option>
                                <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>انتشار</option>
                                <option value="scheduled" {{ old('status', $article->status) == 'scheduled' ? 'selected' : '' }}>زمان‌بندی شده</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 publish-date-container" style="{{ old('status', $article->status) == 'scheduled' ? 'display: block;' : 'display: none;' }}">
                            <label for="published_at" class="form-label">تاریخ انتشار</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at" value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}">
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">بروزرسانی مقاله</button>
                        </div>
                    </div>
                </div>
                
                <!-- کارت دسته‌بندی -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">دسته‌بندی</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                <option value="">بدون دسته‌بندی</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- کارت برچسب‌ها -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">برچسب‌ها</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <select class="form-control tags-select @error('tags') is-invalid @enderror" id="tags" name="tags[]" multiple>
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $article->tags->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- کارت تصویر شاخص -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">تصویر شاخص</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="file" class="form-control @error('featured_image') is-invalid @enderror" id="featured_image" name="featured_image" accept="image/*">
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mt-2 text-center featured-image-container" style="{{ $article->featured_image ? 'display: block;' : 'display: none;' }}">
                            <img src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : '' }}" alt="تصویر شاخص" class="img-fluid featured-image-preview mb-2">
                            
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                <label class="form-check-label" for="remove_image">
                                    حذف تصویر فعلی
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- کارت اطلاعات مقاله -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">اطلاعات مقاله</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>نویسنده:</span>
                                <strong>{{ $article->user->name }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>تاریخ ایجاد:</span>
                                <strong>{{ $article->created_at->format('Y/m/d H:i') }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>آخرین بروزرسانی:</span>
                                <strong>{{ $article->updated_at->format('Y/m/d H:i') }}</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // راه‌اندازی CKEditor
        ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo']
            })
            .catch(error => {
                console.error(error);
            });
        
        // راه‌اندازی Select2 برای برچسب‌ها
        $('.tags-select').select2({
            placeholder: "برچسب‌ها را انتخاب کنید",
            allowClear: true,
            dir: "rtl"
        });
        
        // نمایش فیلد تاریخ انتشار در صورت انتخاب وضعیت زمان‌بندی شده
        const statusSelect = document.getElementById('status');
        const publishDateContainer = document.querySelector('.publish-date-container');
        
        function togglePublishDateField() {
            if (statusSelect.value === 'scheduled') {
                publishDateContainer.style.display = 'block';
            } else {
                publishDateContainer.style.display = 'none';
            }
        }
        
        statusSelect.addEventListener('change', togglePublishDateField);
        
        // پیش‌نمایش تصویر شاخص
        const featuredImageInput = document.getElementById('featured_image');
        const featuredImagePreview = document.querySelector('.featured-image-preview');
        const featuredImageContainer = document.querySelector('.featured-image-container');
        const removeImageCheckbox = document.getElementById('remove_image');
        
        featuredImageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    featuredImagePreview.src = e.target.result;
                    featuredImageContainer.style.display = 'block';
                    if (removeImageCheckbox) {
                        removeImageCheckbox.checked = false;
                    }
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        if (removeImageCheckbox) {
            removeImageCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    featuredImageInput.value = '';
                    featuredImageContainer.style.display = this.checked ? 'block' : 'none';
                }
            });
        }
    });
</script>
@endsection