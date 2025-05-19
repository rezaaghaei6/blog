@extends('layouts.admin')

@section('title', 'مدیریت دسته‌بندی‌ها')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="content-title">مدیریت دسته‌بندی‌ها</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i>
            افزودن دسته‌بندی جدید
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($categories->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-1"></i>
                هیچ دسته‌بندی‌ای یافت نشد.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>نامک</th>
                            <th>تعداد مقالات</th>
                            <th>تاریخ ایجاد</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <code>{{ $category->slug }}</code>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $category->articles_count }}</span>
                                </td>
                                <td>{{ $category->created_at->format('Y/m/d H:i') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" 
                                                    onclick="return confirm('آیا از حذف این دسته‌بندی اطمینان دارید؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
