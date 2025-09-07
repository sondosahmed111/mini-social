@extends('layouts.app')

@section('title', 'الملف الشخصي - Mini Social')

@section('content')
<div class="container mt-4 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="glass-card animate__animated animate__fadeIn">
                <div class="card-body text-center p-5">
                    <div class="user-avatar mx-auto mb-4 float-animation" style="width: 120px; height: 120px; font-size: 3rem;">
                        U
                    </div>
                    <h3 class="card-title glow-text">الملف الشخصي</h3>
                    <p class="card-text">مرحبًا بك في صفحة الملف الشخصي الخاصة بك.</p>
                    <p class="text-muted">هنا يمكنك عرض وتحديث معلوماتك الشخصية.</p>

                    <!-- User Stats -->
                    <div class="d-flex justify-content-around my-4 py-4 stats-container glass-card" style="background: rgba(255,255,255,0.05);">
                        <div class="stat-item">
                            <h5 class="mb-0 glow-text">123</h5>
                            <p class="text-muted mb-0">المتابعون</p>
                        </div>
                        <div class="stat-item">
                            <h5 class="mb-0 glow-text">456</h5>
                            <p class="text-muted mb-0">المتابَعون</p>
                        </div>
                        <div class="stat-item">
                            <h5 class="mb-0 glow-text">789</h5>
                            <p class="text-muted mb-0">المنشورات</p>
                        </div>
                    </div>

                    <!-- Edit Profile Button -->
                    <a href="#" class="neo-btn mb-4" onclick="editProfile()">تعديل الملف الشخصي</a>

                    <!-- Activity Feed -->
                    <h5 class="mb-3 text-start glow-text">نشاطاتك الأخيرة</h5>
                    <ul class="list-group text-start glass-card" style="background: rgba(255,255,255,0.03);">
                        <li class="list-group-item d-flex align-items-center bg-transparent">
                            <i class="bi bi-plus-circle-fill text-success me-2"></i>
                            نشرت منشورًا جديدًا
                            <span class="text-muted ms-auto">قبل ساعتين</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center bg-transparent">
                            <i class="bi bi-chat-dots-fill text-primary me-2"></i>
                            علقت على منشور
                            <span class="text-muted ms-auto">قبل يوم</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center bg-transparent">
                            <i class="bi bi-person-badge-fill text-warning me-2"></i>
                            غيرت صورة الملف الشخصي
                            <span class="text-muted ms-auto">قبل 3 أيام</span>
                        </li>
                    </ul>

                    <a href="/" class="neo-btn mt-4">العودة إلى الرئيسية</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function editProfile() {
    alert('فتح نموذج تعديل الملف الشخصي');
    // في التطبيق الحقيقي: window.location.href = '/profile/edit';
}
</script>

<style>
.stats-container {
    border-radius: 16px;
    padding: 20px 0;
}

.stat-item {
    padding: 0 20px;
    position: relative;
}

.stat-item:not(:last-child)::after {
    content: '';
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    height: 40px;
    width: 1px;
    background: var(--glass-border);
}

.stat-item h5 {
    font-weight: bold;
}
</style>
@endsection