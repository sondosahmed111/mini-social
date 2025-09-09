@extends('layouts.app')

@section('title', 'تسجيل الدخول - Mini Social')

@section('content')
    <div class="container mt-4 pb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="glass-card animate__animated animate__fadeInUp float-animation"
                    style="background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2);">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <div class="user-avatar mx-auto mb-4 glow-animation"
                                style="width: 100px; height: 100px; font-size: 2.5rem; background: linear-gradient(135deg, rgba(74, 108, 250, 0.3), rgba(138, 43, 226, 0.3)); border: 2px solid rgba(255,255,255,0.3);">
                                <i class="bi bi-box-arrow-in-right"></i>
                            </div>
                            <h2 class="card-title glow-text mb-3" style="font-weight: 700; font-size: 2rem;">تسجيل الدخول
                            </h2>
                            <p class="text-muted lead">مرحبًا بعودتك! يرجى تسجيل الدخول إلى حسابك</p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success glass-card mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- عرض رسائل errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger glass-card mb-4" role="alert">
                                @foreach ($errors->all() as $error)
                                    <div><i class="bi bi-exclamation-circle me-2"></i> {{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form id="loginForm" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="email" class="form-label glow-text mb-2" style="font-weight: 600;">البريد
                                    الإلكتروني</label>
                                <div class="input-group">
                                    <span class="input-group-text glass-card"
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                        <i class="bi bi-envelope text-primary"></i>
                                    </span>
                                    <input type="email"
                                        class="form-control glass-input @error('email') is-invalid @enderror" id="email"
                                        name="email" placeholder="أدخل بريدك الإلكتروني" required
                                        value="{{ $rememberedEmail ?? old('email') }}"
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: var(--text-primary);">
                                </div>
                                <div id="emailError" class="text-danger mt-1 small d-none">البريد الإلكتروني غير صالح</div>
                                @error('email')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label glow-text mb-2" style="font-weight: 600;">كلمة
                                    المرور</label>
                                <div class="input-group">
                                    <span class="input-group-text glass-card"
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                        <i class="bi bi-lock text-primary"></i>
                                    </span>
                                    <input type="password"
                                        class="form-control glass-input @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="أدخل كلمة المرور" required
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: var(--text-primary);">
                                    <button class="btn glass-card toggle-password" type="button"
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div id="passwordError" class="text-danger mt-1 small d-none">كلمة المرور يجب أن تحتوي على 8
                                    أحرف على الأقل</div>
                                @error('password')
                                    <div class="text-danger mt-1 small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember"
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);"
                                        {{ $rememberedEmail ? 'checked' : (old('remember') ? 'checked' : '') }}>
                                    <label class="form-check-label text-muted" for="remember">تذكرني</label>
                                </div>
                            </div>
                            <button type="submit" class="futuristic-btn w-100 py-3 mb-4"
                                style="font-weight: 600; font-size: 1.1rem; background: linear-gradient(135deg, rgba(74, 108, 250, 0.8), rgba(138, 43, 226, 0.8)); border: none; border-radius: 15px; position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 8px 32px rgba(74, 108, 250, 0.3);">
                                <span class="btn-text">تسجيل الدخول</span>
                                <div class="btn-glow"></div>
                            </button>
                        </form>

                        <div class="text-center">
                            <div class="glass-card p-3"
                                style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                                <p class="mb-0">ليس لديك حساب؟ <a href="{{ route('register.view') }}"
                                        class="text-decoration-none glow-text fw-bold">إنشاء حساب جديد</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .glass-input:focus {
            background: rgba(255, 255, 255, 0.15) !important;
            border-color: rgba(74, 108, 250, 0.5) !important;
            box-shadow: 0 0 20px rgba(74, 108, 250, 0.3) !important;
            color: var(--text-primary) !important;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        .input-group-text {
            color: var(--text-primary) !important;
        }

        .alert {
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .is-invalid:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .form-check-input:checked {
            background-color: rgba(74, 108, 250, 0.8);
            border-color: rgba(74, 108, 250, 0.8);
        }

        .form-check-input {
            cursor: pointer;
        }
    </style>

    <style>
        .futuristic-btn {
            cursor: pointer;
            background: linear-gradient(135deg, rgba(74, 108, 250, 0.8), rgba(138, 43, 226, 0.8));
            border-radius: 15px;
            border: none;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 32px rgba(74, 108, 250, 0.3);
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .futuristic-btn .btn-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(255, 255, 255, 0.4), transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }

        .futuristic-btn:hover .btn-glow {
            opacity: 1;
        }

        .futuristic-btn:hover {
            box-shadow: 0 0 30px rgba(74, 108, 250, 0.7);
            transform: scale(1.05);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const rememberCheckbox = document.getElementById('remember');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            const toggleButtons = document.querySelectorAll('.toggle-password');

            // إظهار/إخفاء كلمة المرور
            toggleButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const input = this.parentElement.querySelector('input');
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                });
            });

            // التحقق من صحة البريد الإلكتروني
            emailInput.addEventListener('blur', function () {
                validateField(this, patterns.email, emailError, 'البريد الإلكتروني غير صالح');
            });

            // التحقق من صحة كلمة المرور
            passwordInput.addEventListener('blur', function () {
                validateField(this, patterns.password, passwordError, 'كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل');
            });

            // أنماط regex للتحقق
            const patterns = {
                email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                password: /^.{8,}$/ // على الأقل 8 أحرف
            };

            // التحقق قبل إرسال النموذج
            form.addEventListener('submit', function (e) {
                let isValid = true;

                // التحقق من جميع الحقول
                isValid = validateField(emailInput, patterns.email, emailError, 'البريد الإلكتروني غير صالح') && isValid;
                isValid = validateField(passwordInput, patterns.password, passwordError, 'كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل') && isValid;

                if (!isValid) {
                    e.preventDefault();
                    // عرض رسالة عامة في حال وجود أخطاء
                    alert('يرجى تصحيح الأخطاء في النموذج قبل المتابعة');
                }
            });

            // دالة التحقق من الحقل
            function validateField(field, pattern, errorElement, errorMessage) {
                if (!pattern.test(field.value.trim())) {
                    errorElement.textContent = errorMessage;
                    errorElement.classList.remove('d-none');
                    field.classList.add('is-invalid');
                    field.style.borderColor = '#dc3545';
                    return false;
                } else {
                    errorElement.classList.add('d-none');
                    field.classList.remove('is-invalid');
                    field.style.borderColor = '';
                    return true;
                }
            }

            // تذكر البريد الإلكتروني عند تفعيل "تذكرني"
            rememberCheckbox.addEventListener('change', function () {
                if (this.checked && emailInput.value) {
                    console.log('سيتم تذكر البريد الإلكتروني:', emailInput.value);
                }
            });
        });
    </script>
@endsection