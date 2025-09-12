@extends('layouts.app')

@section('title', 'الإشعارات - MiniSocial')

@section('content')
    <div class="container py-4">
        <h3 class="mb-3">🔔 الإشعارات</h3>

        @if ($notifications->count())
            <ul class="list-group">
                @foreach ($notifications as $notification)
                    <li class="list-group-item d-flex justify-content-between align-items-center">

                        @if (isset($notification->data['type']) && $notification->data['type'] === 'comment')
                            <a href="#" class="text-decoration-none text-black">
                                {{ $notification->data['user_name'] }} علق على منشورك:
                                "{{ $notification->data['comment'] }}"
                            </a>
                        @elseif(isset($notification->data['post_id']))
                            <a href="{{ route('posts.show', $notification->data['post_id']) }}" class="text-decoration-none">
                                {{ $notification->data['message'] ?? 'إشعار' }}
                            </a>
                        @else
                            {{ $notification->data['message'] ?? 'إشعار' }}
                        @endif
                        {{-- زر المسح --}}
                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">مسح</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="alert alert-info mt-3">
                لا توجد إشعارات بعد 🎉
            </div>
        @endif

        <div class="mt-3">
            <form action="{{ route('notifications.readAll') }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-primary btn-sm">تعليم الكل كمقروء</button>
            </form>

            <form action="{{ route('notifications.clearAll') }}" method="POST" class="d-inline ms-2">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">مسح الكل</button>
            </form>
        </div>
    </div>
@endsection
