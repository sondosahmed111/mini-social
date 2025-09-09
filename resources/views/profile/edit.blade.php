@extends('layouts.app')

@section('title', $user->name . ' - Mini Social')

@section('content')
    <div class="container mt-4 pb-5">
        <!-- رسائل التنبيه -->
        @if(session('success'))
            <div class="alert alert-success glass-card mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger glass-card mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="glass-card p-4 mb-4 animate__animated animate__fadeIn">
            <div class="row align-items-center">
                <div class="col-md-3 text-center">
                    <div class="user-avatar mx-auto mb-3 glow-animation"
                        style="width: 120px; height: 120px; font-size: 3rem; background: linear-gradient(135deg, rgba(74, 108, 250, 0.3), rgba(138, 43, 226, 0.3));">
                        @if($user->profile_image && $user->profile_image !== 'default.png')
                            <img src="{{ asset('storage/profiles/' . $user->profile_image) }}" alt="{{ $user->name }}"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="glow-text">{{ $user->name }}</h3>
                            <p class="text-muted mb-1">@{{ $user->username }}</p>
                            <p class="text-muted mb-2">{{ $user->email }}</p>

                            @if($user->bio)
                                <p class="mb-3">{{ $user->bio }}</p>
                            @endif
                        </div>

                        @if(Auth::id() == $user->id)
                            <a href="{{ route('profile.edit', $user->id) }}" class="neo-btn">
                                <i class="bi bi-pencil"></i> تعديل الملف
                            </a>
                        @endif
                    </div>

                    <div class="d-flex justify-content-start mb-3">
                        <div class="mx-3 text-center">
                            <h5 class="mb-0 glow-text">{{ $user->posts->count() }}</h5>
                            <small>المنشورات</small>
                        </div>
                        <div class="mx-3 text-center">
                            <h5 class="mb-0 glow-text">{{ $user->followers()->count() }}</h5>
                            <small>المتابعون</small>
                        </div>
                        <div class="mx-3 text-center">
                            <h5 class="mb-0 glow-text">{{ $user->followings()->count() }}</h5>
                            <small>المتابَعون</small>
                        </div>
                    </div>

                    @if(Auth::id() != $user->id)
                        <div class="d-flex gap-2">
                            <button class="neo-btn me-2">متابعة</button>
                            <button class="neo-btn"
                                style="background: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05));">رسالة</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <h4 class="mb-4 glow-text">منشورات المستخدم:</h4>

        @if($user->posts->count() > 0)
            @foreach($user->posts as $post)
                <div class="glass-card mb-4 p-4 animate__animated animate__fadeInUp">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5>{{ $post->title }}</h5>
                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
                    <p>{{ $post->body }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <button class="btn btn-link text-decoration-none p-0 me-3">
                                <i class="bi bi-heart text-danger"></i> {{ $post->likes->count() }}
                            </button>
                            <button class="btn btn-link text-decoration-none p-0">
                                <i class="bi bi-chat text-primary"></i> {{ $post->comments->count() }}
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="glass-card p-4 text-center">
                <p class="text-muted mb-0">لا توجد منشورات حتى الآن</p>
            </div>
        @endif
    </div>

    <style>
        .glass-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
        }

        .user-avatar {
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255, 255, 255, 0.3);
            font-weight: bold;
        }

        .glow-text {
            color: var(--text-primary);
            text-shadow: 0 0 10px rgba(74, 108, 250, 0.5);
        }

        .neo-btn {
            background: linear-gradient(145deg, rgba(74, 108, 250, 0.8), rgba(138, 43, 226, 0.8));
            border: none;
            border-radius: 10px;
            padding: 8px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .neo-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 108, 250, 0.3);
        }
    </style>
@endsection