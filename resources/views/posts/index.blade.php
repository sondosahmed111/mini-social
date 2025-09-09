@extends('layouts.app')

@section('title', 'المنشورات - Mini Social')

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

.modal-body img {
    max-height: 80vh;
    width: 100%;
    object-fit: contain;
}

.glass-card .modal-content {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}
</style>
@endpush

@section('content')
<div class="container">
    @auth
        <div class="text-center mb-4">
            <a href="{{ route('posts.create') }}" class="neo-btn">إنشاء منشور جديد</a>
        </div>
    @endauth

    @guest
        <div class="hero-section glass-card float-animation mb-4">
            <h1 class="display-4 fw-bold mb-3 glow-text animate__animated animate__fadeInDown">مرحبًا بك في MiniSocial</h1>
            <p class="lead mb-4 animate__animated animate__fadeInUp">منصة التواصل الاجتماعي العربية المستقبلية</p>
            <div class="animate__animated animate__fadeIn">
                <a href="/register" class="neo-btn me-2">انضم إلينا</a>
                <a href="/login" class="neo-btn" style="background: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)); border: 1px solid var(--glass-border);">تسجيل الدخول</a>
            </div>
        </div>
    @endguest

    @forelse ($posts as $post)
        <div class="glass-card fade-in mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="user-avatar glow-animation">{{ substr($post->user->name ?? 'م', 0, 1) }}</div>
                    <div>
                        <h6 class="mb-0">{{ $post->user->name ?? 'مستخدم' }}</h6>
                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
                    @if(auth()->check() && auth()->id() === $post->user_id)
                        <div class="ms-auto">
                            <div class="dropdown">
                                <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a href="{{ route('posts.edit', $post->id) }}" class="dropdown-item">
                                            <i class="bi bi-pencil me-2"></i>تعديل
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنشور؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash me-2"></i>حذف
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
                <h5>{{ $post->title }}</h5>
                <p>{{ $post->description }}</p>
                @if($post->image)
                    <div class="post-image mb-3">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="صورة المنشور" class="img-fluid rounded" loading="lazy">
                    </div>
                @endif
                <div class="post-actions">
                    <button class="neo-btn like-btn">
                        <i class="bi bi-heart me-1"></i>إعجاب <span class="like-count">{{ $post->likes_count ?? 0 }}</span>
                    </button>
                    <button class="neo-btn toggle-comments" data-bs-toggle="modal" data-bs-target="#comments-{{ $post->id }}">
                        تعليقات <span class="comment-count">{{ $post->comments_count ?? 0 }}</span>
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center">
            <p>لا توجد منشورات حالياً</p>
        </div>
    @endforelse
               
    
@endsection