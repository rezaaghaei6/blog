@extends('layouts.app')

@section('title', 'ورود به پنل مدیریت')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card admin-login-card border-0 shadow-lg">
                <!-- Logo Header -->
                <div class="card-header text-center bg-white border-0 pt-4 pb-2">
                    <div class="admin-logo mb-3">
                        <i class="fas fa-solar-panel fa-3x text-gradient"></i>
                    </div>
                    <h4 class="fw-bold">ورود به پنل مدیریت</h4>
                    <p class="text-muted small">لطفاً برای دسترسی به پنل مدیریت وارد شوید</p>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">ایمیل</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="email" 
                                       autofocus>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label">رمز عبور</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    مرا به خاطر بسپار
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                ورود به پنل مدیریت
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-white border-0 text-center pb-4">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <i class="fas fa-arrow-left me-1"></i>
                        بازگشت به سایت
                    </a>
                </div>
            </div>
            
            <!-- Admin Contact -->
            <div class="text-center mt-4">
                <p class="text-muted small">
                    مشکلی در ورود دارید؟ با مدیر سیستم تماس بگیرید
                    <br>
                    <a href="mailto:admin@example.com" class="text-decoration-none">
                        <i class="fas fa-envelope me-1"></i>
                        admin@example.com
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
    }

    .admin-login-card {
        border-radius: 0.75rem;
        overflow: hidden;
        margin-top: 3rem;
    }

    .text-gradient {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .admin-logo {
        display: inline-block;
        padding: 1.25rem;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,1) 0%, rgba(240,242,245,1) 100%);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
    }

    .input-group-text {
        border-right: 0;
    }

    .input-group .form-control {
        border-left: 0;
    }

    .input-group .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }

    .input-group .form-control:focus + .input-group-text {
        border-color: #ced4da;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        padding: 0.75rem;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        transform: translateY(-1px);
    }

    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    /* Animation */
    .admin-login-card {
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle Password Visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle icon
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
});
</script>
@endsection