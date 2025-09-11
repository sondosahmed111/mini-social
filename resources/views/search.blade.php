@extends('layouts.app')

@section('title', 'البحث - Mini Social')

@section('content')

<div class="d-flex justify-content-center align-items-center" 
     style="min-height: calc(100vh - 80px);">
    <!-- الكارت الأساسي -->
    <div class="glass-card animate__animated animate__fadeIn" 
         style="max-width: 700px; width: 100%; border-radius: 20px; 
                backdrop-filter: blur(15px); 
                background: rgba(255,255,255,0.15); /* شفاف مع أي خلفية */
                box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
        <div class="card-body p-4 text-center">
            <h3 class="card-title mb-4 glow-text" style="font-weight: 700; letter-spacing: 1px;">البحث عن المستخدمين</h3>
            
            <!-- فورم البحث -->
            <form action="{{ route('search') }}" method="GET" class="input-group mb-4">
                <input type="text" name="q" class="form-control text-center"
                       placeholder="ابحث عن مستخدم..." 
                       value="{{ $query ?? '' }}"
                       style="border-top-right-radius: 12px; border-bottom-right-radius: 12px; box-shadow: inset 0 2px 6px rgba(0,0,0,0.1);">
                <button type="submit" class="neo-btn" 
                        style="border-top-left-radius: 12px; border-bottom-left-radius: 12px; background: #0d6efd; color: #fff; font-weight: 600; transition: all 0.3s;">
                    بحث
                </button>
            </form>
            
            @if(isset($query))
                <h5 class="mb-3 glow-text" style="font-weight: 600; letter-spacing: 0.5px;">نتائج البحث</h5>
                
                <div class="search-results text-start">
                    @if(isset($users) && $users->count() > 0)
                        @foreach($users as $user)
                            <div class="glass-card p-3 mb-3 user-card" 
                                 style="border-radius: 15px; backdrop-filter: blur(10px); 
                                        background: rgba(255,255,255,0.1); /* شفاف مع أي خلفية */
                                        box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: transform 0.3s;">
                                <div class="d-flex align-items-center">
                                    <!-- صورة البروفايل -->
                                    <div class="user-avatar me-3 glow-animation" 
                                         style="width: 50px; height: 50px; font-size: 1.2rem; flex-shrink: 0;">
                                        @if($user->profile_image && $user->profile_image !== 'default.png')
                                            <img src="{{ asset('storage/profiles/' . $user->profile_image) }}" 
                                                 alt="{{ $user->name }}" 
                                                 style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                                        @else
                                            <span style="display:flex; justify-content:center; align-items:center; width:100%; height:100%; background:#0d6efd; color:#fff; border-radius:50%;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- بيانات المستخدم -->
                                    <div class="flex-grow-1">
                                        <a href="{{ route('profile.view', $user->id) }}" 
                                           class="text-decoration-none"
                                           style="color:#0d6efd; transition: color 0.3s ease;"
                                           onmouseover="this.style.color='#0a58ca'" 
                                           onmouseout="this.style.color='#0d6efd'">
                                            <strong>{{ $user->name }}</strong>
                                        </a>
                                        @if($user->bio)
                                            <p class="mb-0 text-muted">{{ $user->bio }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">لا يوجد مستخدمين مطابقين</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
