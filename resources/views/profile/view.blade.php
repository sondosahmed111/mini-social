@extends('layouts.app')

@section('title', $user->name . ' - Mini Social')

@section('content')
    <div class="profile-container">
        <div class="glass-card p-4 animate__animated animate__fadeIn text-center" style="max-width: 600px; width: 100%;">
            <div class="user-avatar mx-auto mb-3 glow-animation"
                style="width: 120px; height: 120px; font-size: 3rem; background: linear-gradient(135deg, rgba(74, 108, 250, 0.3), rgba(138, 43, 226, 0.3));">
                @if($user->profile_image && $user->profile_image !== 'default.png')
                    <img src="{{ asset('storage/profiles/' . $user->profile_image) }}" alt="{{ $user->name }}"
                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
            </div>

            <h3 class="glow-text">{{ $user->name }}</h3>
            <p class="text-muted mb-1">{{ $user->username }}</p>
            <p class="text-muted mb-2">{{ $user->email }}</p>

            @if($user->bio)
                <p class="mb-3">{{ $user->bio }}</p>
            @endif
        </div>
    </div>

    <style>
        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 70px); /* اطرح ارتفاع الناف بار لو عندك */
            padding: 20px;
        }

        .glass-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
    </style>
@endsection
