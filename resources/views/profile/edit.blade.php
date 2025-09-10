@extends('layouts.app')

@section('title', 'تعديل الملف الشخصي - Mini Social')

@section('content')
    <div class="d-flex justify-content-center" style="margin-top: 100px; margin-bottom: 50px;">
        <div class="glass-card p-4 animate__animated animate__fadeIn" style="max-width: 900px; width: 100%;">
            <h3 class="mb-4 glow-text text-center">تعديل الملف الشخصي</h3>

            <!-- رسائل التنبيه -->
            @if(session('success'))
                <div class="alert alert-success glass-card mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger glass-card mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-3 text-center">
                        <div class="user-avatar mx-auto mb-3 glow-animation"
                            style="width: 120px; height: 120px; font-size: 3rem; background: linear-gradient(135deg, rgba(74, 108, 250, 0.3), rgba(138, 43, 226, 0.3));">
                            @if($user->profile_image && $user->profile_image !== 'default.png')
                                <img src="{{ asset('storage/profiles/' . $user->profile_image) }}" 
                                     alt="{{ $user->name }}"
                                     style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                        </div>
                        <input type="file" name="profile_image" class="form-control mt-2">
                    </div>

                    <div class="col-md-9">
                        <div class="mb-3">
                            <label for="name" class="form-label">الاسم</label>
                            <input type="text" id="name" name="name" class="form-control" 
                                   value="{{ old('name', $user->name) }}">
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">اسم المستخدم</label>
                            <input type="text" id="username" name="username" class="form-control" 
                                   value="{{ old('username', $user->username) }}">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" id="email" name="email" class="form-control" 
                                   value="{{ old('email', $user->email) }}">
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">نبذة</label>
                            <textarea id="bio" name="bio" rows="3" class="form-control">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="neo-btn">
                                <i class="bi bi-save"></i> حفظ التعديلات
                            </button>
                            <a href="{{ route('profile.view', $user->id) }}" class="btn btn-secondary ms-2">إلغاء</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .glass-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
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

        .neo-btn {
            background: linear-gradient(145deg, rgba(74, 108, 250, 0.8), rgba(138, 43, 226, 0.8));
            border: none;
            border-radius: 10px;
            padding: 8px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .neo-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 108, 250, 0.3);
        }
    </style>
@endsection
