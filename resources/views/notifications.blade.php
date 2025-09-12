@extends('layouts.app')

@section('title', 'الإشعارات - Mini Social')

@section('content')
<div class="container mt-4 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="glass-card animate__animated animate__fadeIn">
                <div class="card-body">
                    <h3 class="card-title mb-4 glow-text">الإشعارات</h3>
                    
                    @forelse($notifications as $notification)
                        <div class="glass-card p-3 mb-3 notification-item {{ $notification->read_at ? 'opacity-50' : '' }}">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3 glow-animation" 
                                     style="width: 45px; height: 45px; font-size: 1rem;">
                                    {{ substr($notification->data['message'], 0, 1) }}
                                </div>
                                <div class="flex-grow-1">
                                    {!! $notification->data['message'] !!}
                                    <small class="text-muted d-block">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu glass-card">
                                        @if(!$notification->read_at)
                                        <li>
                                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item">وضع علامة كمقروء</button>
                                            </form>
                                        </li>
                                        @endif
                                        <li>
                                            <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">إخفاء الإشعار</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">لا توجد إشعارات حالياً</p>
                    @endforelse

                    @if($notifications->count())
                        <div class="text-center mt-4">
                            <form method="POST" action="{{ route('notifications.clear') }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="neo-btn">مسح الكل</button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
