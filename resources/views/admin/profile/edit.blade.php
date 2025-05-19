@extends('layouts.admin')

@section('title', 'ویرایش پروفایل')

@section('content')
<div class="content-header">
    <h2 class="content-title">ویرایش پروفایل</h2>
</div>

<div class="card">
    <div class="card-body">
        <form method="post" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="name" class="form-label">نام</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">ایمیل</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>
                    ذخیره تغییرات
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4 border-danger">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">حذف حساب کاربری</h5>
    </div>
    <div class="card-body">
        <p class="text-muted">پس از حذف حساب کاربری، تمام اطلاعات شما به طور دائمی حذف خواهند شد.</p>
        
        <form method="post" action="{{ route('admin.profile.destroy') }}" class="mt-3">
            @csrf
            @method('delete')

            <div class="mb-3">
                <label for="password" class="form-label">رمز عبور</label>
                <input type="password" class="form-control" id="password" name="password" required>
                @error('password', 'userDeletion')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-danger" 
                    onclick="return confirm('آیا از حذف حساب کاربری خود اطمینان دارید؟ این عمل غیرقابل بازگشت است.')">
                <i class="fas fa-trash-alt me-1"></i>
                حذف حساب کاربری
            </button>
        </form>
    </div>
</div>
@endsection
