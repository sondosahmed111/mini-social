@extends('layouts.app')

@section('title', 'الإشعارات - Mini Social')

@section('content')
<div class="container mt-4 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="glass-card animate__animated animate__fadeIn">
                <div class="card-body">
                    <h3 class="card-title mb-4 glow-text">الإشعارات</h3>
                    
                    <div class="glass-card p-3 mb-3 notification-item">
                        <div class="d-flex align-items-center">
                            <div class="user-avatar me-3 glow-animation" style="width: 45px; height: 45px; font-size: 1rem;">A</div>
                            <div class="flex-grow-1">
                                <strong>أحمد</strong> أعجب بمنشورك
                                <small class="text-muted d-block">قبل ساعة</small>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu glass-card">
                                    <li><a class="dropdown-item mark-as-read" href="#">وضع علامة كمقروء</a></li>
                                    <li><a class="dropdown-item delete-notification" href="#">إخفاء الإشعار</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="glass-card p-3 mb-3 notification-item">
                        <div class="d-flex align-items-center">
                            <div class="user-avatar me-3 glow-animation" style="width: 45px; height: 45px; font-size: 1rem;">S</div>
                            <div class="flex-grow-1">
                                <strong>سارة</strong> علقت على منشورك
                                <small class="text-muted d-block">قبل يومين</small>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu glass-card">
                                    <li><a class="dropdown-item mark-as-read" href="#">وضع علامة كمقروء</a></li>
                                    <li><a class="dropdown-item delete-notification" href="#">إخفاء الإشعار</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="glass-card p-3 mb-3 notification-item">
                        <div class="d-flex align-items-center">
                            <div class="user-avatar me-3 glow-animation" style="width: 45px; height: 45px; font-size: 1rem;">M</div>
                            <div class="flex-grow-1">
                                <strong>محمد</strong> بدأ متابعة حسابك
                                <small class="text-muted d-block">قبل 3 أيام</small>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu glass-card">
                                    <li><a class="dropdown-item mark-as-read" href="#">وضع علامة كمقروء</a></li>
                                    <li><a class="dropdown-item delete-notification" href="#">إخفاء الإشعار</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button class="neo-btn" id="load-more">تحميل المزيد</button>
                        <button class="neo-btn" id="clear-all" style="background: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));">مسح الكل</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // وضع علامة كمقروء
    document.querySelectorAll('.mark-as-read').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const notification = this.closest('.notification-item');
            notification.style.opacity = '0.6';
            alert('تم وضع علامة كمقروء');
        });
    });

    // حذف الإشعار
    document.querySelectorAll('.delete-notification').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const notification = this.closest('.notification-item');
            notification.style.transition = 'all 0.5s ease';
            notification.style.transform = 'translateX(100%)';
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.remove();
            }, 500);
        });
    });

    // تحميل المزيد
    document.getElementById('load-more').addEventListener('click', function() {
        alert('جاري تحميل المزيد من الإشعارات...');
    });

    // مسح الكل
    document.getElementById('clear-all').addEventListener('click', function() {
        if (confirm('هل تريد مسح جميع الإشعارات؟')) {
            document.querySelectorAll('.notification-item').forEach(item => {
                item.style.transition = 'all 0.5s ease';
                item.style.transform = 'translateX(100%)';
                item.style.opacity = '0';
                setTimeout(() => {
                    item.remove();
                }, 500);
            });
        }
    });
});
</script>
@endsection