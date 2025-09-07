@extends('layouts.app')

@section('title', 'البحث - Mini Social')

@section('content')
<div class="container mt-4 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="glass-card animate__animated animate__fadeIn">
                <div class="card-body p-4">
                    <h3 class="card-title mb-4 glow-text">البحث عن المستخدمين</h3>
                    
                    <div class="input-group mb-4">
                        <input type="text" class="form-control" id="search-input" placeholder="ابحث عن مستخدم..." style="border-top-right-radius: 12px; border-bottom-right-radius: 12px;">
                        <button class="neo-btn" id="search-button" style="border-top-left-radius: 12px; border-bottom-left-radius: 12px;">بحث</button>
                    </div>
                    
                    <h5 class="mb-3 glow-text">نتائج البحث</h5>
                    
                    <div class="search-results">
                        <div class="glass-card p-3 mb-3 user-card">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3 glow-animation" style="width: 50px; height: 50px; font-size: 1.2rem;">A</div>
                                <div class="flex-grow-1">
                                    <strong>أحمد محمد</strong>
                                    <p class="mb-0 text-muted">مطور برمجيات</p>
                                    <small class="text-muted">125 متابع · 45 منشور</small>
                                </div>
                                <button class="neo-btn follow-btn" data-user-id="1">متابعة</button>
                            </div>
                        </div>
                        
                        <div class="glass-card p-3 mb-3 user-card">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3 glow-animation" style="width: 50px; height: 50px; font-size: 1.2rem;">S</div>
                                <div class="flex-grow-1">
                                    <strong>سارة أحمد</strong>
                                    <p class="mb-0 text-muted">مصممة جرافيك</p>
                                    <small class="text-muted">342 متابع · 89 منشور</small>
                                </div>
                                <button class="neo-btn follow-btn" data-user-id="2">متابعة</button>
                            </div>
                        </div>
                        
                        <div class="glass-card p-3 mb-3 user-card">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3 glow-animation" style="width: 50px; height: 50px; font-size: 1.2rem;">M</div>
                                <div class="flex-grow-1">
                                    <strong>محمد علي</strong>
                                    <p class="mb-0 text-muted">كاتب محتوى</p>
                                    <small class="text-muted">78 متابع · 23 منشور</small>
                                </div>
                                <button class="neo-btn follow-btn" data-user-id="3">متابعة</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button class="neo-btn" id="load-more-results">تحميل المزيد</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // البحث عن المستخدمين
    document.getElementById('search-button').addEventListener('click', function() {
        const searchTerm = document.getElementById('search-input').value.trim();
        if (searchTerm !== '') {
            alert(`جاري البحث عن: ${searchTerm}`);
            // في التطبيق الحقيقي: إجراء طلب AJAX للبحث
        }
    });

    // تفعيل إدخال البحث بالضغط على Enter
    document.getElementById('search-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('search-button').click();
        }
    });

    // متابعة المستخدمين
    document.querySelectorAll('.follow-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.dataset.userId;
            if (this.textContent === 'متابعة') {
                this.textContent = 'متابَع';
                this.style.background = 'linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05))';
                alert(`بدأت متابعة المستخدم رقم: ${userId}`);
            } else {
                this.textContent = 'متابعة';
                this.style.background = '';
                alert(`أوقفت متابعة المستخدم رقم: ${userId}`);
            }
        });
    });

    // تحميل المزيد من النتائج
    document.getElementById('load-more-results').addEventListener('click', function() {
        alert('جاري تحميل المزيد من النتائج...');
    });
});
</script>
@endsection