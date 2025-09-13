@extends('layouts.app')

@section('title', 'الرئيسية - MiniSocial')

@section('content')
<div class="container">
<meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- زرار إنشاء منشور --}}
    @auth
    <div class="text-center mb-4 d-flex justify-content-center gap-2">
        <a href="{{ route('posts.create') }}" class="btn btn-primary">+ إنشاء منشور جديد</a>
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
        <div class="post-actions d-flex align-items-center gap-3 border-top pt-3">
            {{-- Post Actions with Facebook-style Reactions --}}
            <div class="fb-reaction-container" data-post-id="{{ $post->id }}">
                @php $userReaction = $post->reactions->where('user_id', auth()->id())->first(); @endphp
                
                {{-- Main Reaction Button --}}
                <div class="fb-main-reaction @if($userReaction) active reaction-{{ $userReaction->type }} @endif" id="main-reaction-{{ $post->id }}">
                    @if($userReaction)
                        @switch($userReaction->type)
                            @case('like') 
                                <span style="font-size: 16px;">👍</span>
                                <span>إعجاب</span> 
                                @break
                            @case('love') 
                                <span style="font-size: 16px;">❤️</span>
                                <span>حب</span> 
                                @break
                            @case('haha') 
                                <span style="font-size: 16px;">😄</span>
                                <span>ضحك</span> 
                                @break
                            @case('wow') 
                                <span style="font-size: 16px;">😯</span>
                                <span>دهشة</span> 
                                @break
                            @case('sad') 
                                <span style="font-size: 16px;">😢</span>
                                <span>حزن</span> 
                                @break
                            @case('angry') 
                                <span style="font-size: 16px;">😡</span>
                                <span>غضب</span> 
                                @break
                        @endswitch
                    @else
                        <i class="bi bi-hand-thumbs-up"></i>
                        <span>إعجاب</span>
                    @endif
                </div>
                
                {{-- Reactions Box --}}
                <div class="fb-reactions-box">
                    @foreach (['like'=>'👍','love'=>'❤️','haha'=>'😄','wow'=>'😯','sad'=>'😢','angry'=>'😡'] as $type=>$emoji)
                        @php 
                            $titles = [
                                'like' => 'إعجاب',
                                'love' => 'حب', 
                                'haha' => 'ضحك',
                                'wow' => 'دهشة',
                                'sad' => 'حزن',
                                'angry' => 'غضب'
                            ];
                        @endphp
                        <div class="fb-reaction {{ $type }}" title="{{ $titles[$type] }}" data-reaction="{{ $type }}" data-emoji="{{ $emoji }}" data-title="{{ $titles[$type] }}">
                            {{ $emoji }}
                        </div>
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

{{-- JavaScript للتعامل مع الـ Reactions --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // التأكد من وجود CSRF token
    const tokenElement = document.querySelector('meta[name="csrf-token"]');
    if (!tokenElement) {
        console.error('CSRF token not found');
        return;
    }
    const token = tokenElement.getAttribute('content');
    
    // التعامل مع كلick على الريأكشنات
    document.querySelectorAll('.fb-reaction').forEach(function(reactionBtn) {
        reactionBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Reaction clicked:', this.getAttribute('data-reaction'));
            
            const container = this.closest('.fb-reaction-container');
            const postId = container.getAttribute('data-post-id');
            const reactionType = this.getAttribute('data-reaction');
            const emoji = this.getAttribute('data-emoji');
            const title = this.getAttribute('data-title');
            
            console.log('Data:', { postId, reactionType, emoji, title });
            
            // إرسال الـ AJAX request
            fetch('{{ route("reactions.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    reactable_type: 'App\\Models\\Post',
                    reactable_id: parseInt(postId),
                    type: reactionType
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // تحديث الزر الرئيسي
                    const mainReaction = document.getElementById('main-reaction-' + postId);
                    
                    if (!mainReaction) {
                        console.error('Main reaction button not found');
                        return;
                    }
                    
                    // إزالة كل الكلاسات القديمة
                    mainReaction.className = mainReaction.className.replace(/active|reaction-\w+/g, '');
                    
                    if (data.reaction) {
                        // إضافة الكلاسات الجديدة
                        mainReaction.classList.add('active', 'reaction-' + data.reaction.type);
                        
                        // تحديث المحتوى
                        mainReaction.innerHTML = '<span style="font-size: 16px;">' + emoji + '</span><span>' + title + '</span>';
                    } else {
                        // العودة للحالة الافتراضية
                        mainReaction.innerHTML = '<i class="bi bi-hand-thumbs-up"></i><span>إعجاب</span>';
                    }
                    
                    console.log('Reaction updated successfully');
                } else {
                    console.error('Error from server:', data.message);
                    alert('حدث خطأ: ' + (data.message || 'خطأ غير معروف'));
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('حدث خطأ أثناء إضافة التفاعل: ' + error.message);
            });
        });
    });
});
</script>
@endsection