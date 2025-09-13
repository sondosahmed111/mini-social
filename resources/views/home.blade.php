@extends('layouts.app')

@section('title', 'الرئيسية - MiniSocial')

@push('styles')
<style>
    .post-image img {
        max-height: 400px;
        width: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .hover-shadow:hover {
        transform: scale(1.02);
        cursor: pointer;
    }
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #6c5ce7;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
    }
    .comments-section {
        border-top: 1px solid #ddd;
        padding-top: 10px;
        margin-top: 10px;
    }
    .comment {
        margin-bottom: 8px;
    }
    .post-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
    }
    .fb-reaction-container {
        position: relative;
    }
    .fb-main-reaction {
        display: flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
    }
    .fb-reactions-box {
        display: flex;
        gap: 5px;
        position: absolute;
        top: -40px;
        left: 0;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s;
    }
    .fb-main-reaction:hover .fb-reactions-box {
        opacity: 1;
        pointer-events: auto;
    }
    .fb-reaction {
        font-size: 16px;
        padding: 4px 6px;
        border-radius: 50%;
        background: white;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.6;
        transition: opacity 0.2s;
    }
    .fb-reaction.selected {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div class="container">

    @guest
    <div class="hero-section text-center mb-5 glass-card float-animation"
        style="background: linear-gradient(135deg, rgba(74, 108, 250, 0.2), rgba(138, 43, 226, 0.2)); padding: 3rem; border-radius: 20px;">
        <h1 class="display-4 fw-bold mb-3 glow-text animate__animated animate__fadeInDown">مرحبًا بك في MiniSocial</h1>
        <p class="lead mb-4 animate__animated animate__fadeInUp">
            شارك أفكارك، تواصل مع الأصدقاء، واستكشف محتوى جديد
        </p>
        <div class="animate__animated animate__fadeIn">
            <a href="{{ route('register.view') }}" class="neo-btn me-2">انضم إلينا</a>
            <a href="{{ route('login.view') }}" class="neo-btn"
                style="background: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)); border: 1px solid var(--glass-border);">
                تسجيل الدخول
            </a>
        </div>
    </div>
    @endguest

    @auth
    <div class="text-center mb-4 d-flex justify-content-center gap-2">
        <a href="{{ route('posts.create') }}" class="neo-btn">+ إنشاء منشور جديد</a>
    </div>
    @endauth

    {{-- عرض المنشورات --}}
    @forelse ($posts as $post)
    <div class="glass-card fade-in post-card mb-4 p-4" data-post-id="{{ $post->id }}">
        {{-- رأس البوست --}}
        <div class="d-flex align-items-center mb-3">
            <div class="user-avatar glow-animation">
                {{ substr($post->user->name ?? 'م', 0, 1) }}
            </div>
            <div class="ms-2">
                <h6 class="mb-0">{{ $post->user->name ?? 'مستخدم' }}</h6>
                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
            </div>

            @if (auth()->check() && auth()->id() === $post->user_id)
            <div class="ms-auto dropdown">
                <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a href="{{ route('posts.edit', $post->id) }}" class="dropdown-item"><i class="bi bi-pencil me-2"></i>تعديل</a></li>
                    <li>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>حذف</button>
                        </form>
                    </li>
                </ul>
            </div>
            @endif
        </div>

        {{-- محتوى البوست --}}
        <h5>{{ $post->title }}</h5>
        <p>{{ $post->description }}</p>

        {{-- صورة البوست --}}
        @if ($post->image)
        <div class="post-image mb-3">
            <img src="{{ asset('storage/' . $post->image) }}" alt="صورة المنشور" class="img-fluid rounded hover-shadow" loading="lazy">
        </div>
        @endif

        {{-- أزرار الإعجاب والتعليق --}}
        <div class="post-actions">
            <div class="fb-reaction-container">
                <div class="fb-main-reaction">
                    <i class="bi bi-hand-thumbs-up"></i>
                    <span>إعجاب</span>
                    <div class="fb-reactions-box">
                        @php
                            $types = ['like'=>'👍','love'=>'❤️','haha'=>'😄','wow'=>'😯','sad'=>'😢','angry'=>'😡'];
                        @endphp
                        @foreach($types as $key => $emoji)
                        <div class="fb-reaction {{ $post->reactions->where('user_id', auth()->id())->first()?->type === $key ? 'selected' : '' }}" data-reaction="{{ $key }}">
                            {!! $emoji !!} <span class="reaction-count">{{ $post->reactions->where('type',$key)->count() }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="action-btn" onclick="toggleComments(this)">
                <i class="bi bi-chat"></i><span>تعليق</span>
            </div>
            <div class="action-btn">
                <i class="bi bi-share"></i><span>مشاركة</span>
            </div>
        </div>

        {{-- قسم التعليقات --}}
        <div class="comments mt-3">
            @foreach ($post->comments as $comment)
            <div class="comment p-2 mb-2 border rounded">
                <strong>{{ $comment->user->name ?? 'مستخدم' }}:</strong>
                <p>{{ $comment->body }}</p>
            </div>
            @endforeach

            @auth
            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="d-flex gap-2 mt-2">
                @csrf
                <input type="text" name="body" class="form-control form-control-sm" placeholder="اكتب تعليقًا..." required>
                <button type="submit" class="btn btn-primary btn-sm">نشر</button>
            </form>
            @endauth
        </div>
    </div>
    @empty
    <div class="text-center">
        <p>لا توجد منشورات حالياً</p>
    </div>
    @endforelse

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const reactions = document.querySelectorAll('.fb-reaction');

    reactions.forEach(reaction => {
        reaction.addEventListener('click', function() {
            const postCard = this.closest('.post-card');
            const postId = postCard.getAttribute('data-post-id');
            const type = this.getAttribute('data-reaction');

            fetch(`/posts/${postId}/react`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ type })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status){
                    // تحديث العدادات
                    postCard.querySelectorAll('.fb-reaction').forEach(r => {
                        const rType = r.getAttribute('data-reaction');
                        r.querySelector('.reaction-count').textContent = data.counts[rType] || 0;
                        r.classList.remove('selected');
                    });
                    // تمييز الريأكشن الخاص بالمستخدم
                    const selected = postCard.querySelector(`.fb-reaction[data-reaction="${data.user_reaction}"]`);
                    if(selected) selected.classList.add('selected');
                }
            })
            .catch(err => console.error(err));
        });
    });
});
</script>
@endpush
