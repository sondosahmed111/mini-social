@extends('layouts.app')

@section('title', 'الإعدادات - Mini Social')

@section('content')
<div class="container mt-4 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="glass-card animate__animated animate__fadeIn">
                <div class="card-body p-5">
                    <h3 class="card-title mb-4 glow-text">الإعدادات</h3>
                    
                    <div class="glass-card p-4 mb-4">
                        <h5 class="mb-3"><i class="bi bi-bell me-2"></i>إعدادات الإشعارات</h5>
                        <select class="form-select mb-3" id="notification-settings">
                            <option value="all" selected>جميع الإشعارات</option>
                            <option value="mentions">الإشعارات عند الذكر فقط</option>
                            <option value="none">عدم تلقي إشعارات</option>
                        </select>
                    </div>
                    
                    <div class="glass-card p-4 mb-4">
                        <h5 class="mb-3"><i class="bi bi-palette me-2"></i>المظهر</h5>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="darkModeToggle" checked>
                            <label class="form-check-label" for="darkModeToggle">تفعيل الوضع الداكن</label>
                        </div>
                    </div>
                    
                    <div class="glass-card p-4 mb-4">
                        <h5 class="mb-3"><i class="bi bi-shield me-2"></i>الخصوصية</h5>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="privateAccount">
                            <label class="form-check-label" for="privateAccount">حساب خاص</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="activityStatus" checked>
                            <label class="form-check-label" for="activityStatus">إظهار حالة النشاط</label>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button class="neo-btn" id="save-settings">حفظ التغييرات</button>
                        <button class="neo-btn" id="reset-settings" style="background: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));">استعادة الإعدادات الافتراضية</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // حفظ الإعدادات
    document.getElementById('save-settings').addEventListener('click', function() {
        const notificationSettings = document.getElementById('notification-settings').value;
        const darkMode = document.getElementById('darkModeToggle').checked;
        const privateAccount = document.getElementById('privateAccount').checked;
        const activityStatus = document.getElementById('activityStatus').checked;
        
        alert('تم حفظ الإعدادات بنجاح!');
        console.log('الإعدادات المحفوظة:', {
            notificationSettings,
            darkMode,
            privateAccount,
            activityStatus
        });
    });

    // استعادة الإعدادات الافتراضية
    document.getElementById('reset-settings').addEventListener('click', function() {
        if (confirm('هل تريد استعادة الإعدادات الافتراضية؟')) {
            document.getElementById('notification-settings').value = 'all';
            document.getElementById('darkModeToggle').checked = true;
            document.getElementById('privateAccount').checked = false;
            document.getElementById('activityStatus').checked = true;
            alert('تم استعادة الإعدادات الافتراضية');
        }
    });

    // تفعيل/تعطيل الوضع الداكن
    document.getElementById('darkModeToggle').addEventListener('change', function() {
        if (this.checked) {
            document.body.classList.add('dark');
            alert('تم تفعيل الوضع الداكن');
        } else {
            document.body.classList.remove('dark');
            alert('تم تعطيل الوضع الداكن');
        }
    });
});
</script>
@endsection