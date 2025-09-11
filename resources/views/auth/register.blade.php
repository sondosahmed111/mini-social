@extends('layouts.app')

@section('title', 'إنشاء حساب - Mini Social')

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
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <h2 class="card-title glow-text mb-3" style="font-weight: 700; font-size: 2rem;">إنشاء حساب جديد
                            </h2>
                            <p class="text-muted lead">انضم إلى مجتمعنا وابدأ رحلتك الاجتماعية</p>
                        </div>

                        <form id="registerForm" action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="form-label glow-text mb-2" style="font-weight: 600;">الاسم
                                    الكامل</label>
                                <div class="input-group">
                                    <span class="input-group-text glass-card"
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                        <i class="bi bi-person text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control glass-input" id="name" name="name"
                                        placeholder="أدخل اسمك الكامل" required value="{{ old('name') }}"
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: var(--text-primary);">
                                </div>
                                <div id="nameError" class="text-danger mt-1 small d-none">يجب أن يحتوي الاسم على أحرف عربية
                                    أو إنجليزية فقط</div>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="username"
                                 class="form-label glow-text mb-2" style="font-weight: 600;">اسم
                                    المستخدم</label>
                                <div class="input-group">
                                    <span class="input-group-text glass-card"
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                        <i class="bi bi-at text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control glass-input" id="username" name="username"
                                        placeholder="أدخل اسم المستخدم" required value="{{ old('username') }}"
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: var(--text-primary);">
                                </div>
                                <div id="usernameError" class="text-danger mt-1 small d-none">اسم المستخدم يجب أن يحتوي على
                                    أحرف إنجليزية وأرقام و underscores فقط</div>
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label glow-text mb-2" style="font-weight: 600;">البريد
                                    الإلكتروني</label>
                                <div class="input-group">
                                    <span class="input-group-text glass-card"
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                        <i class="bi bi-envelope text-primary"></i>
                                    </span>
                                    <input type="email" class="form-control glass-input" id="email" name="email"
                                        placeholder="أدخل بريدك الإلكتروني" required value="{{ old('email') }}"
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: var(--text-primary);">
                                </div>
                                <div id="emailError" class="text-danger mt-1 small d-none">البريد الإلكتروني غير صالح</div>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
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
                                    <input type="password" class="form-control glass-input" id="password" name="password"
                                        placeholder="أدخل كلمة مرور قوية" required
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: var(--text-primary);">
                                    <button class="btn glass-card toggle-password" type="button"
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>

                                <!-- مؤشر قوة كلمة المرور -->
                                <div class="password-strength mt-2">
                                    <div class="progress"
                                        style="height: 6px; border-radius: 3px; background: rgba(255,255,255,0.1);">
                                        <div id="password-strength-bar" class="progress-bar" role="progressbar"
                                            style="width: 0%; border-radius: 3px; transition: all 0.3s ease;"></div>
                                    </div>
                                    <div id="password-strength-text" class="small mt-1"></div>
                                </div>

                                <div id="passwordError" class="text-danger mt-1 small d-none">كلمة المرور يجب أن تحتوي على 8
                                    أحرف على الأقل، وتشمل حرف كبير، حرف صغير، رقم، ورمز خاص</div>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label glow-text mb-2"
                                    style="font-weight: 600;">تأكيد كلمة المرور</label>
                                <div class="input-group">
                                    <span class="input-group-text glass-card"
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                        <i class="bi bi-lock-fill text-primary"></i>
                                    </span>
                                    <input type="password" class="form-control glass-input" id="password_confirmation"
                                        name="password_confirmation" placeholder="أعد إدخال كلمة المرور" required
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: var(--text-primary);">
                                    <button class="btn glass-card toggle-password" type="button"
                                        style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div id="passwordConfirmError" class="text-danger mt-1 small d-none">كلمة المرور غير متطابقة
                                </div>
                                @error('password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="futuristic-btn w-100 py-3 mb-4"
                                style="font-weight: 600; font-size: 1.1rem; background: linear-gradient(135deg, rgba(74, 108, 250, 0.8), rgba(138, 43, 226, 0.8)); border: none; border-radius: 15px; position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 8px 32px rgba(74, 108, 250, 0.3);">
                                <span class="btn-text">إنشاء الحساب</span>
                                <div class="btn-glow"></div>
                            </button>
                        </form>

                        <div class="text-center">
                            <div class="glass-card p-3"
                                style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                                <p class="mb-0">هل لديك حساب؟ <a href="{{ route('login.view') }}"
                                        class="text-decoration-none glow-text fw-bold">تسجيل الدخول</a></p>
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

        .password-strength {
            margin-top: 8px;
        }

        .progress {
            overflow: hidden;
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

        .futuristic-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
            box-shadow: 0 4px 16px rgba(74, 108, 250, 0.2);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('registerForm');
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const passwordStrengthBar = document.getElementById('password-strength-bar');
            const passwordStrengthText = document.getElementById('password-strength-text');
            const toggleButtons = document.querySelectorAll('.toggle-password');

            // أنماط regex للتحقق
            const patterns = {
                name: /^[\p{L} ]+$/u,
                username: /^[a-zA-Z0-9_]+$/,
                email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
            };

            // عناصر الأخطاء
            const errorElements = {
                name: document.getElementById('nameError'),
                username: document.getElementById('usernameError'),
                email: document.getElementById('emailError'),
                password: document.getElementById('passwordError'),
                passwordConfirm: document.getElementById('passwordConfirmError')
            };

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

            // التحقق من صحة الاسم
            document.getElementById('name').addEventListener('blur', function () {
                validateField(this, patterns.name, errorElements.name, 'يجب أن يحتوي الاسم على أحرف عربية أو إنجليزية فقط');
            });

            // التحقق من صحة اسم المستخدم
            document.getElementById('username').addEventListener('blur', function () {
                validateField(this, patterns.username, errorElements.username, 'اسم المستخدم يجب أن يحتوي على أحرف إنجليزية وأرقام و underscores فقط');
            });

            // التحقق من صحة البريد الإلكتروني
            document.getElementById('email').addEventListener('blur', function () {
                validateField(this, patterns.email, errorElements.email, 'البريد الإلكتروني غير صالح');
            });

            // التحقق من قوة كلمة المرور
            passwordInput.addEventListener('input', function () {
                validatePasswordStrength(this.value);
                validateField(this, patterns.password, errorElements.password, 'كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل، وتشمل حرف كبير، حرف صغير، رقم، ورمز خاص');

                // التحقق من تطابق كلمة المرور عند التغيير
                if (passwordConfirmInput.value) {
                    validatePasswordMatch();
                }
            });

            // التحقق من تطابق كلمة المرور
            passwordConfirmInput.addEventListener('blur', validatePasswordMatch);

            // التحقق قبل إرسال النموذج
            form.addEventListener('submit', function (e) {
                let isValid = true;

                // التحقق من جميع الحقول
                isValid = validateField(document.getElementById('name'), patterns.name, errorElements.name, 'يجب أن يحتوي الاسم على أحرف عربية أو إنجليزية فقط') && isValid;
                isValid = validateField(document.getElementById('username'), patterns.username, errorElements.username, 'اسم المستخدم يجب أن يحتوي على أحرف إنجليزية وأرقام و underscores فقط') && isValid;
                isValid = validateField(document.getElementById('email'), patterns.email, errorElements.email, 'البريد الإلكتروني غير صالح') && isValid;
                isValid = validateField(passwordInput, patterns.password, errorElements.password, 'كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل، وتشمل حرف كبير، حرف صغير، رقم، ورمز خاص') && isValid;
                isValid = validatePasswordMatch() && isValid;

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
                    field.style.borderColor = 'red';
                    return false;
                } else {
                    errorElement.classList.add('d-none');
                    field.style.borderColor = '';
                    return true;
                }
            }

            // دالة التحقق من قوة كلمة المرور
            function validatePasswordStrength(password) {
                let strength = 0;
                let messages = [];

                // التحقق من طول كلمة المرور
                if (password.length >= 8) strength += 20;
                else messages.push('8 أحرف على الأقل');

                // التحقق من وجود أحرف صغيرة
                if (/[a-z]/.test(password)) strength += 20;
                else messages.push('حرف صغير على الأقل (a-z)');

                // التحقق من وجود أحرف كبيرة
                if (/[A-Z]/.test(password)) strength += 20;
                else messages.push('حرف كبير على الأقل (A-Z)');

                // التحقق من وجود أرقام
                if (/\d/.test(password)) strength += 20;
                else messages.push('رقم على الأقل (0-9)');

                // التحقق من وجود رموز خاصة
                if (/[@$!%*?&]/.test(password)) strength += 20;
                else messages.push('رمز خاص على الأقل (@$!%*?&)');

                // تحديث شريط القوة
                passwordStrengthBar.style.width = strength + '%';

                // تحديد لون الشريط بناء على القوة
                if (strength < 40) {
                    passwordStrengthBar.style.backgroundColor = '#dc3545'; // ضعيف - أحمر
                    passwordStrengthText.textContent = 'كلمة مرور ضعيفة: ' + messages.join('، ');
                    passwordStrengthText.style.color = '#dc3545';
                } else if (strength < 80) {
                    passwordStrengthBar.style.backgroundColor = '#ffc107'; // متوسط - أصفر
                    passwordStrengthText.textContent = 'كلمة مرور متوسطة: ' + messages.join('، ');
                    passwordStrengthText.style.color = '#ffc107';
                } else {
                    passwordStrengthBar.style.backgroundColor = '#28a745'; // قوي - أخضر
                    passwordStrengthText.textContent = 'كلمة مرور قوية';
                    passwordStrengthText.style.color = '#28a745';
                }

                return strength;
            }

            // دالة التحقق من تطابق كلمة المرور
            function validatePasswordMatch() {
                if (passwordInput.value !== passwordConfirmInput.value) {
                    errorElements.passwordConfirm.textContent = 'كلمة المرور غير متطابقة';
                    errorElements.passwordConfirm.classList.remove('d-none');
                    passwordConfirmInput.style.borderColor = 'red';
                    return false;
                } else {
                    errorElements.passwordConfirm.classList.add('d-none');
                    passwordConfirmInput.style.borderColor = '';
                    return true;
                }
            }
        });
    </script>

@endsection