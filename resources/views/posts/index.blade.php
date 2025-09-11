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
    .hover-shadow:hover { transform: scale(1.02); cursor: pointer; }
    .user-avatar {
        width: 40px; height: 40px; border-radius: 50%;
        background: #6c5ce7; color: white;
        display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 18px;
    }
    .comment { margin-bottom: 8px; }
    .post-actions { display: flex; align-items: center; gap: 10px; position: relative; }
    .fb-reaction-container { position: relative; }
    .fb-main-reaction { display: flex; align-items: center; gap: 4px; cursor: pointer; }
    .fb-reactions-box {
        display: flex; gap: 5px; position: absolute; top: -40px; left: 0;
        opacity: 0; pointer-events: none; transition: opacity 0.2s;
    }
    .fb-main-reaction:hover .fb-reactions-box { opacity: 1; pointer-events: auto; }
    .fb-reaction {
        font-size: 16px; padding: 4px 6px; border-radius: 50%;
        background: white; box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        opacity: 0.6; transition: opacity 0.2s;
    }
    .fb-reaction.selected { opacity: 1; }
</style>
@endpush

@section('content')
<div class="container">
<meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- زرار إنشاء منشور --}}
    @auth
    <div class="text-center mb-4 d-flex justify-content-center gap-2">
        <a href="{{ route('posts.create') }}" class="btn btn-success">+ إنشاء منشور جديد</a>
    </div>
    @endauth

    {{-- عرض المنشورات --}}
    @forelse ($posts as $post)
    <div class="glass-card mb-4 p-4 post-card" data-post-id="{{ $post->id }}">
        {{-- رأس البوست --}}
        <div class="d-flex align-items-center mb-3">
            <div class="user-avatar">{{ substr($post->user->name ?? 'م', 0, 1) }}</div>
            <div class="ms-2">
                <h6 class="mb-0">{{ $post->user->name ?? 'مستخدم' }}</h6>
                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
            </div>

            {{-- زر تعديل وحذف للبوست --}}
            @if (auth()->check() && auth()->id() === $post->user_id)
            <div class="ms-auto dropdown">
                <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a href="{{ route('posts.edit', $post->id) }}" class="dropdown-item"><i class="bi bi-pencil me-2"></i>تعديل</a></li>
                    <li>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                            @csrf @method('DELETE')
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
                    <i class="bi bi-hand-thumbs-up"></i> <span>إعجاب</span>
                    <div class="fb-reactions-box">
                        @php $types = ['like'=>'👍','love'=>'❤','haha'=>'😄','wow'=>'😯','sad'=>'😢','angry'=>'😡']; @endphp
                        @foreach($types as $key => $emoji)
                        <div class="fb-reaction {{ $post->reactions->where('user_id', auth()->id())->first()?->type === $key ? 'selected' : '' }}" data-reaction="{{ $key }}" title="{{ $key }}">
                            {!! $emoji !!} <span class="reaction-count">{{ $post->reactions->where('type',$key)->count() }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="action-btn"><i class="bi bi-chat"></i><span>تعليق</span></div>
            <div class="action-btn"><i class="bi bi-share"></i><span>مشاركة</span></div>
        </div>

{{-- قسم التعليقات --}}
<div class="comments mt-3">
    @foreach ($post->comments as $comment)
        <div class="comment-box mb-2 p-2 border rounded bg-light">
            {{-- لو المستخدم بيدوس تعديل --}}
            @if(session('edit_comment_id') == $comment->id)
                <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="d-flex flex-column gap-2">
                    @csrf
                    @method('PUT')
                    <textarea name="body" class="form-control" rows="2" required>{{ old('body', $comment->body) }}</textarea>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success btn-sm px-3">
                            <i class="bi bi-check2"></i> حفظ
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm px-3">
                            <i class="bi bi-x"></i> إلغاء
                        </a>
                    </div>

                </form>
            @else
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-1">
                        <strong>{{ $comment->user->name }}:</strong> {{ $comment->body }}
                    </p>
                    @if(auth()->id() == $comment->user_id)
                        <div class="btn-group">
                            {{-- زر تعديل --}}
                            <form action="{{ route('comments.edit', $comment->id) }}" method="GET">
                                <button type="submit" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i> تعديل
                                </button>
                            </form>
                            {{-- زر حذف --}}
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> حذف
                                </button>
                            </form>
             {{ $post->user->name ?? 'مستخدم' }}

                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endforeach

    {{-- إضافة تعليق --}}
    @auth
    <form action="{{ route('comments.store', $post->id) }}" method="POST" class="d-flex gap-2 mt-2">
        @csrf
        <input type="text" name="body" class="form-control form-control-sm rounded-pill" placeholder="اكتب تعليقًا..." required>
        <button type="submit" class="btn btn-primary btn-sm px-3 rounded-pill">نشر</button>
    </form>
    @endauth
</div>
    </div>
    @empty
    <div class="text-center"><p>لا توجد منشورات حالياً</p></div>
    @endforelse
</div>
@endsection