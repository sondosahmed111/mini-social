@extends('layouts.app')

@section('content')
<div class="container mt-4 pb-5">
    <div class="create-post-container fade-in">
        <div class="post-header">
            <div class="user-avatar glow-animation">م</div>
            <div class="post-info">
                <h6>محمد أحمد</h6>
            </div>
        </div>

        <textarea class="post-input" placeholder="ماذا يدور في ذهنك؟"></textarea>

        <div class="media-preview" id="mediaPreview"></div>

        <div class="media-actions">
            <label for="imageUpload" class="media-btn">
                <i class="bi bi-image"></i> صورة
            </label>
            <label for="videoUpload" class="media-btn">
                <i class="bi bi-camera-video"></i> فيديو
            </label>
            <input type="file" id="imageUpload" accept="image/*" style="display: none;">
            <input type="file" id="videoUpload" accept="video/*" style="display: none;">
        </div>

        <button class="post-submit">نشر</button>
    </div>

    @php
    $posts = [
        ['id'=>1,'user'=>'محمد أحمد','title'=>'عنوان المنشور الأول','body'=>'هذا مثال لمنشور','likes'=>3,'comments'=>[['user'=>'سارة','body'=>'جميل','time'=>'قبل ساعة']]],

        ['id'=>2,'user'=>'سارة محمد','title'=>'عنوان منشور ثاني','body'=>'منشور مثال آخر','likes'=>2,'comments'=>[]]
    ];
    @endphp

    @foreach($posts as $post)
    <div class="glass-card mb-4 animate__animated animate__fadeInUp" data-post-id="{{ $post['id'] }}">
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

            <div class="post-actions">
                <button class="neo-btn btn-sm like-button" data-post-id="{{ $post['id'] }}">
                    <i class="bi bi-heart me-1"></i>إعجاب <span class="badge bg-light text-dark like-count">{{ $post['likes'] }}</span>
                </button>
                <button class="neo-btn btn-sm toggle-comments" data-bs-toggle="collapse" data-bs-target="#comments-{{ $post['id'] }}">
                    <i class="bi bi-chat me-1"></i>تعليق <span class="badge bg-primary rounded-pill comment-count">{{ count($post['comments']) }}</span>
                </button>
            </div>

            <div class="collapse comments-section mt-3" id="comments-{{ $post['id'] }}">
                <ul class="list-group list-group-flush">
                    @foreach($post['comments'] as $comment)
                    <li class="list-group-item bg-transparent mb-2 rounded comment-item">
                        <div class="d-flex align-items-start">
                            <div class="user-avatar me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">{{ substr($comment['user'],0,1) }}</div>
                            <div>
                                <strong class="username" onclick="visitProfile('{{ $comment['user'] }}')">{{ $comment['user'] }}:</strong> {{ $comment['body'] }}
                                <small class="text-muted d-block mt-1">{{ $comment['time'] }}</small>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div class="input-group mt-2">
                    <input type="text" class="form-control comment-input" placeholder="اكتب تعليقًا..." data-post-id="{{ $post['id'] }}">
                    <button class="neo-btn btn-add-comment" data-post-id="{{ $post['id'] }}">إرسال</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

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
            const likeCount = this.querySelector('.like-count');
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
                const ul = commentsSection.querySelector('ul');

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
            }
        });
    })

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

// زيارة الملف الشخصي
function visitProfile(username) {
    alert(`انتقال إلى صفحة الملف الشخصي لـ: ${username}`);
    // في التطبيق الحقيقي: window.location.href = `/profile/${username}`;
}
</script>
@endsection
