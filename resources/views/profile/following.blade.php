@extends('layouts.app')

@section('title', 'الأشخاص الذين تتابعهم - MiniSocial')

@section('content')
<div class="container mx-auto mt-10 max-w-3xl">
    <h2 class="text-2xl font-bold text-center mb-8 text-gray-800">
        الأشخاص الذين تتابعهم
    </h2>

    @if($followingUsers->count() > 0)
        <div class="grid gap-5">
            @foreach($followingUsers as $user)
                <div class="glass-card p-5 flex items-center justify-between transition duration-200 hover:scale-[1.01]">
                    
                    {{-- صورة + اسم --}}
                    <a href="{{ route('profile.view', $user->id) }}" class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-white/40 bg-white/20 backdrop-blur-sm flex items-center justify-center text-gray-700 font-bold text-lg shadow-inner">
                            @if($user->profile_image && $user->profile_image !== 'default.png')
                                <img src="{{ asset('storage/profiles/' . $user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover rounded-full">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg hover:underline">
                                {{ $user->name }}
                            </h3>
                            <p class="text-gray-600 text-sm">{{ $user->username }}</p>
                        </div>
                    </a>

                    {{-- زر --}}
                    @if(auth()->id() !== $user->id)
                        <form action="{{ auth()->user()->following->contains($user->id) ? route('profile.unfollow', $user->id) : route('profile.follow', $user->id) }}" method="POST">
                            @csrf
                            @if(auth()->user()->following->contains($user->id))
                                @method('DELETE')
                                <button type="submit" class="px-4 py-1 rounded-full bg-white/30 text-gray-800 hover:bg-white/50 backdrop-blur-sm shadow-md">
                                    إلغاء
                                </button>
                            @else
                                <button type="submit" class="px-4 py-1 rounded-full bg-blue-600/80 text-white hover:bg-blue-700 backdrop-blur-sm shadow-md">
                                    متابعة
                                </button>
                            @endif
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-500 mt-10 text-lg">
            لم تقم بمتابعة أي شخص بعد.
        </p>
    @endif
</div>
@endsection
