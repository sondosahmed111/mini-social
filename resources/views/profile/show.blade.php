@extends('layouts.app')

@section('title', $user->name . ' - Mini Social')

@section('content')
    <div class="container d-flex flex-column align-items-center mt-5 pt-5 pb-5">
        <!-- كارت البروفايل -->
        <div class="glass-card p-4 mb-5 animate__animated animate__fadeIn" style="max-width: 800px; width: 100%;">
            <div class="row align-items-center">
                <!-- صورة البروفايل -->
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

                <!-- بيانات البروفايل -->
                <div class="col-md-9">
                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                        <div>
                            <h3 class="glow-text">{{ $user->name }}</h3>
                            <p class="text-muted mb-1">{{ $user->username }}</p>
                            <p class="text-muted mb-2">{{ $user->email }}</p>

                            @if($user->bio)
                                <p class="mb-3">{{ $user->bio }}</p>
                            @endif
                        </div>

                        @if(Auth::id())
                            <div class="d-flex gap-2">
                                <a href="{{ route('profile.edit') }}" class="neo-btn">
                                    <i class="bi bi-pencil"></i> تعديل الملف
                                </a>
                                <a href="{{ route('posts.create') }}" class="neo-btn">
                                    <i class="bi bi-plus-circle"></i> إنشاء منشور
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- إحصائيات -->
                   <div class="d-flex gap-4 mb-3 mt-3">
    <div class="text-center">
        <h5 class="mb-0 glow-text">{{ $user->posts->count() }}</h5>
        <small>المنشورات</small>
    </div>

    <div class="text-center">
        <h5 class="mb-0 glow-text">{{ $user->following->count() }}</h5>
        <small>
            <a href="{{ route('profile.following') }}">المتابَعين</a>
        </small>
    </div>
</div>

                </div>
            </div>
        </div>

        <!-- منشورات -->
        <h4 class="mb-4 glow-text text-center">منشورات {{ $user->name }}:</h4>

        @if($user->posts->count() > 0)
            <div class="d-flex flex-column align-items-center w-100">
                @foreach($user->posts as $post)
                    <div class="glass-card p-4 mb-4 animate__animated animate__fadeInUp" style="max-width: 700px; width: 100%;">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="fw-bold">{{ $post->title }}</h5>
                            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                        </div>

                        <p class="mb-3">{{ $post->description }}</p>

                      @if ($post->image)
                    <div class="post-image mb-3">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="صورة المنشور"
                            class="img-fluid rounded hover-shadow" loading="lazy">
                    </div>
                @endif

                        @if(Auth::id() == $user->id)
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square"></i> تعديل
                                </a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('متأكد إنك عايز تحذف البوست ده؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> حذف
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="glass-card p-4 text-center" style="max-width: 600px; width: 100%;">
                <p class="text-muted mb-0">لا توجد منشورات حتى الآن</p>
            </div>
        @endif
    </div>
@endsection
