 @extends('layouts.app')

@section('title', 'إنشاء حساب - Mini Social')

@section('content')
<div class="container mt-4 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="glass-card animate__animated animate__fadeInUp float-animation" style="background: linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <div class="user-avatar mx-auto mb-4 glow-animation" style="width: 100px; height: 100px; font-size: 2.5rem; background: linear-gradient(135deg, rgba(74, 108, 250, 0.3), rgba(138, 43, 226, 0.3)); border: 2px solid rgba(255,255,255,0.3);">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <h2 class="card-title glow-text mb-3" style="font-weight: 700; font-size: 2rem;">إنشاء حساب جديد</h2>
                        <p class="text-muted lead">انضم إلى مجتمعنا وابدأ رحلتك الاجتماعية</p>
                    </div>
                    
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label glow-text mb-2" style="font-weight: 600;">الاسم الكامل</label>
                            <div class="input-group">
                                <span class="input-group-text glass-card" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="bi bi-person text-primary"></i>
                                </span>
                                <input type="text" class="form-control glass-input" id="name" name="name" placeholder="أدخل اسمك الكامل" required style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: var(--text-primary);">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="form-label glow-text mb-2" style="font-weight: 600;">البريد الإلكتروني</label>
                            <div class="input-group">
                                <span class="input-group-text glass-card" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="bi bi-envelope text-primary"></i>
                                </span>
                                <input type="email" class="form-control glass-input" id="email" name="email" placeholder="أدخل بريدك الإلكتروني" required style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: var(--text-primary);">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label glow-text mb-2" style="font-weight: 600;">كلمة المرور</label>
                            <div class="input-group">
                                <span class="input-group-text glass-card" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="bi bi-lock text-primary"></i>
                                </span>
                                <input type="password" class="form-control glass-input" id="password" name="password" placeholder="أدخل كلمة مرور قوية" required style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: var(--text-primary);">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label glow-text mb-2" style="font-weight: 600;">تأكيد كلمة المرور</label>
                            <div class="input-group">
                                <span class="input-group-text glass-card" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                    <i class="bi bi-lock-fill text-primary"></i>
                                </span>
                                <input type="password" class="form-control glass-input" id="password_confirmation" name="password_confirmation" placeholder="أعد إدخال كلمة المرور" required style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: var(--text-primary);">
                            </div>
                        </div>
                        <button type="submit" class="futuristic-btn w-100 py-3 mb-4" style="font-weight: 600; font-size: 1.1rem; background: linear-gradient(135deg, rgba(74, 108, 250, 0.8), rgba(138, 43, 226, 0.8)); border: none; border-radius: 15px; position: relative; overflow: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 8px 32px rgba(74, 108, 250, 0.3);">
                            <span class="btn-text">إنشاء الحساب</span>
                            <div class="btn-glow"></div>
                        </button>
                    </form>

                    <div class="text-center">
                        <div class="glass-card p-3" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                            <p class="mb-0">هل لديك حساب؟ <a href="{{ route('login.view') }}" class="text-decoration-none glow-text fw-bold">تسجيل الدخول</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.glass-input:focus {
    background: rgba(255,255,255,0.15) !important;
    border-color: rgba(74, 108, 250, 0.5) !important;
    box-shadow: 0 0 20px rgba(74, 108, 250, 0.3) !important;
    color: var(--text-primary) !important;
}

.form-control::placeholder {
    color: rgba(255,255,255,0.6) !important;
}

.input-group-text {
    color: var(--text-primary) !important;
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

@endsection
