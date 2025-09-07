@extends('layouts.app')

@section('title', 'الرئيسية - Mini Social')

@section('content')
<div class="hero-section text-center mb-5 glass-card float-animation" style="background: linear-gradient(135deg, rgba(74, 108, 250, 0.2), rgba(138, 43, 226, 0.2)); padding: 3rem; border-radius: 20px;">
    <h1 class="display-4 fw-bold mb-3 glow-text animate__animated animate__fadeInDown">مرحبًا بك في MiniSocial</h1>
    <p class="lead mb-4 animate__animated animate__fadeInUp">شارك أفكارك، تواصل مع الأصدقاء، واستكشف محتوى جديد</p>
    <div class="animate__animated animate__fadeIn">
        <a href="{{ route('register.view') }}" class="neo-btn me-2">انضم إلينا</a>
        <a href="{{ route('login.view') }}" class="neo-btn" style="background: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)); border: 1px solid var(--glass-border);">تسجيل الدخول</a>
        <a href="/posts" class="neo-btn me-2 mt-2 mt-md-0">عرض المنشورات</a>
    </div>
</div>

<div class="glass-card mb-4 p-4 fade-in">
    <form id="create-post-form" action="/posts" method="POST">
        @csrf
        <textarea name="body" class="form-control mb-3" rows="3" placeholder="اكتب منشورًا جديدًا..." required></textarea>
        <button type="submit" class="neo-btn">نشر</button>
    </form>
</div>

<h2 class="text-center mb-4 fade-in glow-text">منشورات حديثة</h2>

@php
$posts = [
    ['id'=>1,'user'=>'محمد أحمد','title'=>'عنوان المنشور الأول','body'=>'هذا مثال لمنشور. يمكن للمستخدمين الإعجاب والتعليق ومشاركة المنشورات هنا.','likes'=>3,'comments'=>[
        ['user'=>'سارة','body'=>'جميل جداً','time'=>'قبل ساعة'],
        ['user'=>'أحمد','body'=>'أتفق معك','time'=>'قبل 30 دقيقة'],
        ['user'=>'فاطمة','body'=>'رائع!','time'=>'قبل 15 دقيقة'],
        ['user'=>'علي','body'=>'شكراً للمشاركة','time'=>'الآن']
    ]],
    ['id'=>2,'user'=>'سارة محمد','title'=>'عنوان منشور ثاني','body'=>'منشور مثال آخر. يمكنك إضافة المزيد من المنشورات ديناميكيًا لاحقًا.','likes'=>2,'comments'=>[]],
    ['id'=>3,'user'=>'علي حسين','title'=>'منشور تجريبي ثالث','body'=>'هذا المنشور يظهر كيف سيبدو المحتوى','likes'=>0,'comments'=>[]]
];
@endphp

@foreach($posts as $post)
<div class="glass-card mb-4 fade-in" data-post-id="{{ $post['id'] }}">
    <div class="card-body p-4">
        <div class="d-flex align-items-center mb-3">
            <div class="user-avatar" onclick="visitProfile('{{ $post['user'] }}')">{{ substr($post['user'],0,1) }}</div>
            <div>
                <h6 class="mb-0 username" onclick="visitProfile('{{ $post['user'] }}')">{{ $post['user'] }}</h6>
                <small class="text-muted">منذ وقت قصير</small>
            </div>
        </div>
        <h5 class="card-title">{{ $post['title'] }}</h5>
        <p class="card-text">{{ $post['body'] }}</p>

        <div class="post-actions d-flex align-items-center">
            <div class="reaction-container me-3">
                <button class="reaction-btn main-reaction like-button" title="إعجاب" data-reaction="like" data-post-id="{{ $post['id'] }}">
                    <i class="bi bi-heart"></i>
                </button>
                <div class="extra-reactions">
                    <button class="reaction-btn" title="اضحك" data-reaction="laugh">😂</button>
                    <button class="reaction-btn" title="غضب" data-reaction="angry">😡</button>
                    <button class="reaction-btn" title="حزن" data-reaction="sad">😢</button>
                    <button class="reaction-btn" title="حب" data-reaction="love">❤️</button>
                </div>
            </div>
            <span class="text-muted small ms-2">
                <span class="like-count">{{ $post['likes'] }}</span> إعجابات
            </span>
            <span class="text-muted small ms-3">
                <i class="bi bi-chat me-1"></i><span class="comment-count">{{ count($post['comments']) }}</span> تعليقات
            </span>
        </div>

        @if(count($post['comments']) > 0)
        <div class="comments-section mt-3">
            <ul class="list-group list-group-flush" id="comments-{{ $post['id'] }}">
                @php $commentCount = 0; @endphp
                @foreach($post['comments'] as $comment)
                    <li class="list-group-item bg-transparent mb-2 rounded comment-item" style="{{ $commentCount >= 3 ? 'display: none;' : '' }}">
                        <div class="d-flex align-items-start">
                            <div class="user-avatar me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">{{ substr($comment['user'],0,1) }}</div>
                            <div>
                                <strong class="username" onclick="visitProfile('{{ $comment['user'] }}')">{{ $comment['user'] }}:</strong> {{ $comment['body'] }}
                                <small class="text-muted d-block mt-1">{{ $comment['time'] }}</small>
                            </div>
                        </div>
                    </li>
                    @php $commentCount++; @endphp
                @endforeach
                @if(count($post['comments']) > 3)
                <li class="list-group-item text-center bg-transparent">
                    <button class="btn btn-link text-decoration-none glow-text" onclick="showMoreComments({{ $post['id'] }})">
                        عرض المزيد من التعليقات ({{ count($post['comments']) - 3 }})
                    </button>
                </li>
                @endif
            </ul>
            <div class="input-group mt-3">
                <input type="text" class="form-control comment-input" placeholder="اكتب تعليقًا..." data-post-id="{{ $post['id'] }}">
                <button class="neo-btn btn-add-comment" data-post-id="{{ $post['id'] }}">إرسال</button>
            </div>
        </div>
        @else
        <div class="comments-section mt-3">
            <div class="input-group">
                <input type="text" class="form-control comment-input" placeholder="اكتب تعليقًا..." data-post-id="{{ $post['id'] }}">
                <button class="neo-btn btn-add-comment" data-post-id="{{ $post['id'] }}">إرسال</button>
            </div>
        </div>
        @endif
    </div>
</div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {
    // منع إرسال النموذج الافتراضي
    document.getElementById('create-post-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const textarea = this.querySelector('textarea');
        if (textarea.value.trim() !== '') {
            alert('تم نشر المنشور بنجاح!');
            textarea.value = '';
        }
    });

    // تفعيل أزرار الإعجاب
    document.querySelectorAll('.like-button').forEach(btn => {
        btn.addEventListener('click', function() {
            const postId = this.dataset.postId;
            const likeCount = this.closest('.post-actions').querySelector('.like-count');
            const icon = this.querySelector('i');
            
            if (this.classList.contains('liked')) {
                likeCount.textContent = parseInt(likeCount.textContent) - 1;
                this.classList.remove('liked');
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
                this.style.background = '';
            } else {
                likeCount.textContent = parseInt(likeCount.textContent) + 1;
                this.classList.add('liked');
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                this.style.background = 'linear-gradient(145deg, rgba(220, 53, 69, 0.8), rgba(255, 193, 7, 0.8))';
            }
        });
    });

    // إضافة تعليقات جديدة
    document.querySelectorAll('.btn-add-comment').forEach(btn => {
        btn.addEventListener('click', function() {
            const postId = this.dataset.postId;
            const input = document.querySelector(`.comment-input[data-post-id="${postId}"]`);
            const text = input.value.trim();
            
            if(text !== ''){
                const commentsSection = this.closest('.comments-section');
                let ul = commentsSection.querySelector('ul');
                
                if (!ul) {
                    ul = document.createElement('ul');
                    ul.className = 'list-group list-group-flush';
                    commentsSection.insertBefore(ul, commentsSection.firstChild);
                }
                
                const li = document.createElement('li');
                li.className = 'list-group-item bg-transparent mb-2 rounded comment-item';
                li.innerHTML = `
                    <div class="d-flex align-items-start">
                        <div class="user-avatar me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">أ</div>
                        <div>
                            <strong>أنت:</strong> ${text}
                            <small class="text-muted d-block mt-1">الآن</small>
                        </div>
                    </div>
                `;
                ul.appendChild(li);
                input.value = '';
                
                // تحديث عدد التعليقات
                const commentCount = this.closest('.glass-card').querySelector('.comment-count');
                commentCount.textContent = parseInt(commentCount.textContent) + 1;
                
                // إخفاء زر "عرض المزيد" إذا كان موجودًا
                const showMoreBtn = commentsSection.querySelector('.btn-link');
                if (showMoreBtn) {
                    showMoreBtn.style.display = 'none';
                }
            }
        });
    });

    // تفعيل إدخال التعليقات بالضغط على Enter
    document.querySelectorAll('.comment-input').forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const postId = this.dataset.postId;
                document.querySelector(`.btn-add-comment[data-post-id="${postId}"]`).click();
            }
        });
    });
});

// عرض المزيد من التعليقات
function showMoreComments(postId) {
    const post = document.querySelector(`.glass-card[data-post-id="${postId}"]`);
    if (post) {
        const hiddenComments = post.querySelectorAll('li[style*="display: none"]');
        hiddenComments.forEach(li => {
            li.style.display = 'block';
            li.classList.add('animate__animated', 'animate__fadeIn');
        });
        const showMoreBtn = post.querySelector('.btn-link');
        if (showMoreBtn) showMoreBtn.style.display = 'none';
    }
}

// زيارة الملف الشخصي
function visitProfile(username) {
    alert(`انتقال إلى صفحة الملف الشخصي لـ: ${username}`);
    // في التطبيق الحقيقي: window.location.href = `/profile/${username}`;
}
</script>
@endsection