@extends('layouts.app')

@section('title', 'الرئيسية - MiniSocial')

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
            {{-- الصورة / الحرف الأول --}}
            <a href="{{ route('profile.view', $post->user->id) }}" class="user-avatar text-decoration-none">
                {{ substr($post->user->name ?? 'م', 0, 1) }}
            </a>
            <div class="ms-2">
                <h6 class="mb-0">
                    <a href="{{ route('profile.view', $post->user->id) }}" class="text-decoration-none">
                        {{ $post->user->name ?? 'مستخدم' }}
                    </a>
                </h6>
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
            <img src="{{ asset('storage/' . $post->image) }}" alt="صورة المنشور" class="img-fluid rounded">
        </div>
        @endif

        {{-- أزرار الريأكشن والتعليق --}}
        <div class="post-actions d-flex align-items-center gap-3">
            {{-- زر الريأكشنات --}}
            <div class="reactions-wrapper">
                @php $userReaction = $post->reactions->where('user_id', auth()->id())->first(); @endphp

                <button class="btn btn-outline-primary btn-sm">
                    @if($userReaction)
                        {{ $userReaction->type === 'like' ? '👍' : '' }}
                        {{ $userReaction->type === 'love' ? '❤' : '' }}
                        {{ $userReaction->type === 'haha' ? '😄' : '' }}
                        {{ $userReaction->type === 'wow' ? '😯' : '' }}
                        {{ $userReaction->type === 'sad' ? '😢' : '' }}
                        {{ $userReaction->type === 'angry' ? '😡' : '' }}
                        {{ ucfirst($userReaction->type) }}
                    @else
                        <i class="bi bi-hand-thumbs-up"></i> إعجاب
                    @endif
                </button>

                {{-- كل الريأكشنز تبان جنب بعض --}}
                <div class="d-flex gap-2 mt-2">
                    @foreach (['like'=>'👍','love'=>'❤','haha'=>'😄','wow'=>'😯','sad'=>'😢','angry'=>'😡'] as $type=>$emoji)
                    <form method="POST" action="{{ route('reactions.store') }}">
                        @csrf
                        <input type="hidden" name="reactable_type" value="App\Models\Post">
                        <input type="hidden" name="reactable_id" value="{{ $post->id }}">
                        <input type="hidden" name="type" value="{{ $type }}">
                        <button type="submit" class="btn btn-light btn-sm">
                            {{ $emoji }} ({{ $post->reactions->where('type',$type)->count() }})
                        </button>
                    </form>
                    @endforeach
                </div>
            </div>

            {{-- زر تعليق --}}
            <button class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-chat"></i> تعليق
            </button>

            {{-- زر مشاركة --}}
            <button class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-share"></i> مشاركة
            </button>
        </div>

        {{-- قسم التعليقات --}}
        <div class="comments mt-3">
            @foreach ($post->comments as $comment)
                <div class="comment-box mb-2 p-2 border rounded bg-light">
                    @if(session('edit_comment_id') == $comment->id)
                        <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="d-flex flex-column gap-2">
                            @csrf
                            @method('PUT')
                            <textarea name="body" class="form-control" rows="2" required>{{ old('body', $comment->body) }}</textarea>
                            <div class="d-flex gap-2 justify-content-end">
                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check2-circle"></i></button>
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x-lg"></i></a>
                            </div>
                        </form>
                    @else
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="mb-1">
                                <strong>
                                    <a href="{{ route('profile.view', $comment->user->id) }}" class="text-decoration-none">
                                        {{ $comment->user->name }}
                                    </a>
                                </strong> 
                                {{ $comment->body }}
                            </p>
                            @if(auth()->id() == $comment->user_id)
                                <div class="btn-group">
                                    <form action="{{ route('comments.edit', $comment->id) }}" method="GET" class="me-1">
                                        <button type="submit" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></button>
                                    </form>
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
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
