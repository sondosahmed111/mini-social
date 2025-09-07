@extends('layouts.app')

@section('content')
<div class="container mt-4 pb-5">
    <div class="glass-card p-4 mb-4 animate__animated animate__fadeIn">
        <div class="text-center">
            <div class="user-avatar mx-auto mb-3" style="width: 100px; height: 100px; font-size: 2.5rem;">
                {{ substr($user->name, 0, 1) }}
            </div>
            <h3>{{ $user->name }}</h3>
            <p class="text-muted">Email: {{ $user->email }}</p>
            
            <div class="d-flex justify-content-center mb-3">
                <div class="mx-3 text-center">
                    <h5 class="mb-0 glow-text">{{ $user->posts->count() }}</h5>
                    <small>المنشورات</small>
                </div>
                <div class="mx-3 text-center">
                    <h5 class="mb-0 glow-text">1.2K</h5>
                    <small>المتابعون</small>
                </div>
                <div class="mx-3 text-center">
                    <h5 class="mb-0 glow-text">856</h5>
                    <small>المتابَعون</small>
                </div>
            </div>
            
            <button class="neo-btn me-2">متابعة</button>
            <button class="neo-btn" style="background: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));">رسالة</button>
        </div>
    </div>

    <h4 class="mb-4 glow-text">منشورات المستخدم:</h4>
    
    @foreach($user->posts as $post)
    <div class="glass-card mb-4 p-4 animate__animated animate__fadeInUp">
        <h5>{{ $post->title }}</h5>
        <p>{{ $post->body }}</p>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                <button class="btn btn-link text-decoration-none p-0 me-3">
                    <i class="bi bi-heart text-danger"></i> 125
                </button>
                <button class="btn btn-link text-decoration-none p-0">
                    <i class="bi bi-chat text-primary"></i> 34
                </button>
            </div>
            <small class="text-muted">منذ يومين</small>
        </div>
    </div>
    @endforeach
</div>
@endsection