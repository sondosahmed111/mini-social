@extends('layouts.app')

@section('title', 'البحث - Mini Social')

@section('content')

<div class="d-flex justify-content-center align-items-center" 
     style="min-height: calc(100vh - 80px);"> <!-- 80px عشان يسيب مسافة من الناف بار -->
    
    <div class="glass-card animate__animated animate__fadeIn" style="max-width: 700px; width: 100%;">
        <div class="card-body p-4 text-center">
            <h3 class="card-title mb-4 glow-text">البحث عن المستخدمين</h3>
            
            <!-- فورم البحث -->
            <form action="{{ route('search') }}" method="GET" class="input-group mb-4">
                <input type="text" name="q" class="form-control text-center"
                       placeholder="ابحث عن مستخدم..." 
                       value="{{ $query ?? '' }}"
                       style="border-top-right-radius: 12px; border-bottom-right-radius: 12px;">
                <button type="submit" class="neo-btn" 
                        style="border-top-left-radius: 12px; border-bottom-left-radius: 12px;">
                    بحث
                </button>
            </form>
            
            @if(isset($query))
                <h5 class="mb-3 glow-text">نتائج البحث</h5>
                
                <div class="search-results text-start">
                    @if(isset($users) && $users->count() > 0)
                        @foreach($users as $user)
                            <div class="glass-card p-3 mb-3 user-card">
                                <div class="d-flex align-items-center">
                                    <!-- صورة البروفايل -->
                                    <div class="user-avatar me-3 glow-animation" 
                                         style="width: 50px; height: 50px; font-size: 1.2rem;">
                                        @if($user->profile_image && $user->profile_image !== 'default.png')
                                            <img src="{{ asset('storage/profiles/' . $user->profile_image) }}" 
                                                 alt="{{ $user->name }}" 
                                                 style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                        @else
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        @endif
                                    </div>

                                    <!-- بيانات المستخدم -->
                                    <div class="flex-grow-1">
                                        <a href="{{ route('profile.view', $user->id) }}" 
                                           class="text-decoration-none"
                                           style="color:#0d6efd; transition:color 0.3s ease;"
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
