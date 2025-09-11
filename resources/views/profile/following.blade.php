@extends('layouts.app')

@section('title', 'الناس اللي أنا متابعهم - MiniSocial')

@section('content')
<div class="container mx-auto mt-8 max-w-3xl">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">الناس اللي أنا متابعهم</h2>

    @if($followingUsers->count() > 0)
        <div class="bg-white rounded-xl shadow-md divide-y divide-gray-200">
            @foreach($followingUsers as $user)
                <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition duration-200">
                    <div class="flex items-center gap-4">
                        {{-- صورة البروفايل --}}
                        <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-gray-300 flex items-center justify-center bg-gray-100 text-gray-700 font-bold text-lg">
                            @if($user->profile_image && $user->profile_image !== 'default.png')
                                <img src="{{ asset('storage/profiles/' . $user->profile_image) }}" alt="{{ $user->name }}" class="w-full h-full object-cover rounded-full">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                        </div>

                        {{-- اسم المستخدم --}}
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg hover:underline">
                                <a href="{{ route('profile.view', $user->id) }}">{{ $user->name }}</a>
                            </h3>
                            <p class="text-gray-500 text-sm">{{ '@' . $user->username }}</p>
                        </div>
                    </div>

                    {{-- زر متابعة / إلغاء متابعة --}}
                    @if(auth()->id() !== $user->id)
                        <form action="{{ auth()->user()->following->contains($user->id) ? route('profile.unfollow', $user->id) : route('profile.follow', $user->id) }}" method="POST">
                            @csrf
                            @if(auth()->user()->following->contains($user->id))
                                @method('DELETE')
                                <button type="submit" class="px-4 py-1 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition duration-200">إلغاء المتابعة</button>
                            @else
                                <button type="submit" class="px-4 py-1 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition duration-200">متابعة</button>
                            @endif
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-500 mt-10 text-lg">لم تقم بمتابعة أي شخص بعد.</p>
    @endif
</div>
@endsection
