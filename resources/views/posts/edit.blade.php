@extends('layouts.app')

@section('title', 'تعديل المنشور - Mini Social')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            @if ($errors->any())
                <div class="alert alert-danger shadow-sm rounded-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="glass-card fade-in p-5 rounded-4 shadow-lg">
                <h3 class="text-center fw-bold mb-2 text-primary">
                    <i class="bi bi-pencil-square me-2"></i> تعديل المنشور
                </h3>
                <hr class="mb-4">

                <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- العنوان --}}
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">
                            <i class="bi bi-type-h1 me-1"></i> العنوان
                        </label>
                        <input type="text" name="title" id="title"
                               class="form-control rounded-3 shadow-sm @error('title') is-invalid @enderror"
                               value="{{ old('title', $post->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- المحتوى --}}
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">
                            <i class="bi bi-pencil me-1"></i> المحتوى
                        </label>
                        <textarea name="description" id="description"
                                  class="form-control rounded-3 shadow-sm @error('description') is-invalid @enderror"
                                  rows="4">{{ old('description', $post->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- صورة المنشور --}}
                    <div class="mb-4">
                        <label for="image" class="form-label fw-semibold">
                            <i class="bi bi-image me-1"></i> صورة المنشور
                        </label>

                        <input type="file" name="image" id="image"
                               class="form-control rounded-3 shadow-sm @error('image') is-invalid @enderror"
                               accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- الصورة الحالية --}}
                        @if($post->image)
                            <div class="mt-3">
                                <p class="mb-2 fw-semibold">الصورة الحالية:</p>
                                <div class="card shadow-sm border-0 rounded-3 overflow-hidden" style="max-width: 300px;">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="صورة المنشور" class="img-fluid">
                                </div>
                            </div>
                        @endif

                        {{-- معاينة الصورة الجديدة --}}
                        <div id="imagePreview" class="mt-3 d-none">
                            <p class="mb-2 fw-semibold">الصورة الجديدة:</p>
                            <div class="card shadow-sm border-0 rounded-3 overflow-hidden" style="max-width: 300px;">
                                <img src="#" alt="معاينة" class="img-fluid">
                            </div>
                        </div>
                    </div>

                    {{-- الأزرار --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('posts.index') }}"
                           class="btn px-4 py-2 fw-semibold shadow-sm"
                           style="border-radius: 12px;
                                  background: rgba(255, 255, 255, 0.1);
                                  border: 1px solid rgba(200,200,200,0.3);
                                  color: #555;
                                  transition: all 0.3s ease;">
                            <i class="bi bi-arrow-right-circle me-1"></i> رجوع
                        </a>

                        <button type="submit"
                                class="btn px-4 py-2 fw-semibold text-white shadow-sm"
                                style="border-radius: 12px;
                                       background: linear-gradient(135deg, #4a6cfa, #8a2be2);
                                       border: none;
                                       transition: all 0.3s ease;
                                       box-shadow: 0 4px 12px rgba(74, 108, 250, 0.4);">
                            <i class="bi bi-save me-1"></i> حفظ التغييرات
                        </button>
                    </div>
                </form>

                {{-- زر الحذف --}}
                <form method="POST" action="{{ route('posts.destroy', $post->id) }}"
                      class="mt-4 text-center"
                      onsubmit="return confirm('هل أنت متأكد من حذف هذا المنشور؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="btn px-4 py-2 fw-semibold text-white shadow-sm"
                            style="border-radius: 12px;
                                   background: linear-gradient(135deg, #e74c3c, #c0392b);
                                   border: none;
                                   transition: all 0.3s ease;
                                   box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);">
                        <i class="bi bi-trash me-1"></i> حذف المنشور
                    </button>
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
