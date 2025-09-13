@extends('layouts.app')

@section('title', 'المستخدمين')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 80vh; flex-direction: column;">
    <h3 style="font-size:36px; font-weight:700; text-align:center; margin-bottom:30px;">
        اختر مستخدم لبدء المحادثة 💬
    </h3>
    <ul class="list-group w-100">
        @foreach($users as $user)
            <li class="list-group-item d-flex align-items-center justify-content-between mb-3 p-3" 
                style="border-radius:12px; background:#f1f1f1; box-shadow:0 4px 8px rgba(0,0,0,0.1);">
                
                <!-- معلومات المستخدم -->
                <div class="d-flex align-items-center">
                    <img src="{{ $user->avatar ?? 'https://via.placeholder.com/60' }}" 
                         alt="Avatar" 
                         style="width:60px; height:60px; border-radius:50%; margin-right:15px; object-fit:cover;">
                    <span style="font-size:22px; font-weight:600;">{{ $user->name }}</span>
                </div>
                
                <!-- زر بدء المحادثة -->
                <a href="{{ route('chat.show', $user->id) }}" 
                   class="btn btn-primary btn-lg" 
                   style="font-size:18px; padding:10px 25px;">
                    بدء المحادثة
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
