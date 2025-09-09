@extends('layouts.app')

@section('title', 'تعديل المنشور - Mini Social')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="glass-card fade-in p-4">
                <h4 class="text-center mb-4">تعديل المنشور</h4>
                
                <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">العنوان</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">المحتوى</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $post->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">صورة</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($post->image)
                            <div class="mt-2">
                                <p class="mb-2">الصورة الحالية:</p>
                                <img src="{{ asset('storage/' . $post->image) }}" alt="صورة المنشور" class="img-fluid rounded mb-2" style="max-height: 200px">
                            </div>
                        @endif
                        <div id="imagePreview" class="mt-2 d-none">
                            <p class="mb-2">الصورة الجديدة:</p>
                            <img src="#" alt="معاينة" class="img-fluid rounded">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary">رجوع</a>
                        <div>
                            <button type="submit" class="neo-btn">حفظ التغييرات</button>
                        </div>
                    </div>
                </form>

                <form method="POST" action="{{ route('posts.destroy', $post->id) }}" class="mt-4 text-center" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنشور؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="neo-btn-danger">حذف المنشور</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('image').addEventListener('change', function(event) {
    const preview = document.getElementById('imagePreview');
    const image = preview.querySelector('img');
    
    if (event.target.files && event.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            image.src = e.target.result;
            preview.classList.remove('d-none');
        }
        reader.readAsDataURL(event.target.files[0]);
    } else {
        preview.classList.add('d-none');
    }
});
</script>
@endpush