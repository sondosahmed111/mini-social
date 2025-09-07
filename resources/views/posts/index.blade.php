@extends('layouts.app')

@section('title', 'المنشورات - Mini Social')

@section('content')
    <!-- قسم البطل -->
    <div class="hero-section glass-card float-animation">
        <h1 class="display-4 fw-bold mb-3 glow-text animate__animated animate__fadeInDown">مرحبًا بك في MiniSocial</h1>
        <p class="lead mb-4 animate__animated animate__fadeInUp">منصة التواصل الاجتماعي العربية المستقبلية</p>
        <div class="animate__animated animate__fadeIn">
            <a href="/register" class="neo-btn me-2">انضم إلينا</a>
            <a href="/login" class="neo-btn" style="background: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)); border: 1px solid var(--glass-border);">تسجيل الدخول</a>
        </div>
    </div>

    <!-- بوست 1 -->
    <div class="glass-card fade-in">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
                <div class="user-avatar glow-animation">م</div>
                <div>
                    <h6 class="mb-0">محمد أحمد</h6>
                    <small class="text-muted">منذ 3 ساعات</small>
                </div>
            </div>
            <h5>عنوان المنشور الأول</h5>
            <p>هذا مثال لمنشور. يمكن للمستخدمين الإعجاب والتعليق ومشاركة المنشورات هنا.</p>

            <div class="post-actions">
                <button class="neo-btn like-btn">
                    <i class="bi bi-heart me-1"></i>إعجاب <span class="like-count">0</span>
                </button>
                <button class="neo-btn toggle-comments" data-bs-toggle="modal" data-bs-target="#commentsModal1">
                    تعليقات <span class="comment-count">0</span>
                </button>
            </div>
        </div>
    </div>

    <!-- بوست 2 -->
    <div class="glass-card fade-in">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
                <div class="user-avatar glow-animation">س</div>
                <div>
                    <h6 class="mb-0">سارة محمد</h6>
                    <small class="text-muted">منذ 6 ساعات</small>
                </div>
            </div>
            <h5>عنوان منشور ثاني</h5>
            <p>منشور مثال آخر. يمكنك إضافة المزيد من المنشورات ديناميكيًا لاحقًا.</p>

            <div class="post-actions">
                <button class="neo-btn like-btn">
                    <i class="bi bi-heart me-1"></i>إعجاب <span class="like-count">0</span>
                </button>
                <button class="neo-btn toggle-comments" data-bs-toggle="modal" data-bs-target="#commentsModal2">
                    تعليقات <span class="comment-count">0</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal for Comments 1 -->
    <div class="modal fade" id="commentsModal1" tabindex="-1" aria-labelledby="commentsModal1Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content glass-card">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentsModal1Label">التعليقات</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush comment-list mb-2"></ul>
                    <div class="input-group mt-3">
                        <input type="text" class="form-control comment-text" placeholder="اكتب تعليقًا...">
                        <button class="neo-btn add-comment">إرسال</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Comments 2 -->
    <div class="modal fade" id="commentsModal2" tabindex="-1" aria-labelledby="commentsModal2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content glass-card">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentsModal2Label">التعليقات</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush comment-list mb-2"></ul>
                    <div class="input-group mt-3">
                        <input type="text" class="form-control comment-text" placeholder="اكتب تعليقًا...">
                        <button class="neo-btn add-comment">إرسال</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // تهيئة جسيمات الخلفية
    document.addEventListener('DOMContentLoaded', function() {
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#4a6cfa" },
                shape: { type: "circle" },
                opacity: { value: 0.5, random: true },
                size: { value: 3, random: true },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: "#4a6cfa",
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: "none",
                    random: true,
                    straight: false,
                    out_mode: "out",
                    bounce: false
                }
            },
            interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: { enable: true, mode: "repulse" },
                    onclick: { enable: true, mode: "push" },
                    resize: true
                }
            },
            retina_detect: true
        });

        // تأثيرات التمرير
        const fadeElements = document.querySelectorAll('.fade-in');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        fadeElements.forEach(el => observer.observe(el));

        // تفعيل أزرار الإعجاب
        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const countSpan = btn.querySelector('.like-count');
                countSpan.textContent = parseInt(countSpan.textContent) + 1;

                // تأثير مرئي للإعجاب
                btn.style.background = 'linear-gradient(145deg, rgba(220, 53, 69, 0.8), rgba(255, 193, 7, 0.8))';
                setTimeout(() => {
                    btn.style.background = '';
                }, 500);
            });
        });

        // إضافة تعليقات جديدة
        document.querySelectorAll('.add-comment').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = btn.previousElementSibling;
                const text = input.value.trim();
                if(text === '') return;

                const commentList = btn.closest('.modal-body').querySelector('.comment-list');
                const li = document.createElement('li');
                li.className = 'list-group-item comment-item bg-transparent border-0';
                li.innerHTML = `
                    <div class="d-flex align-items-start">
                        <div class="user-avatar me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">أ</div>
                        <div>
                            <strong>أنت</strong>
                            <p class="mb-0">${text}</p>
                            <small class="text-muted">الآن</small>
                        </div>
                    </div>
                `;
                commentList.appendChild(li);
                input.value = '';

                // تحديث عدد التعليقات
                const countSpan = document.querySelector('.comment-count');
                if (countSpan) {
                    countSpan.textContent = parseInt(countSpan.textContent) + 1;
                }

                // تأثير عند الإضافة
                li.classList.add('animate__animated', 'animate__fadeIn');
            });
        });

        // تفعيل النقر على اسم المستخدم
        document.querySelectorAll('.user-avatar, .username').forEach(el => {
            el.style.cursor = 'pointer';
            el.addEventListener('click', () => {
                const username = el.closest('.glass-card').querySelector('h6').textContent;
                alert(`هنا يمكنك الذهاب إلى صفحة الملف الشخصي لـ: ${username}`);
            });
        });
    });
</script>
@endpush
