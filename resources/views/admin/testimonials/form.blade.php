@extends('admin.layouts.app')

@section('title', isset($testimonial) ? 'Editar Depoimento' : 'Novo Depoimento')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            {{ isset($testimonial) ? 'Editar Depoimento' : 'Novo Depoimento' }}
        </h1>
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ isset($testimonial) ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @if(isset($testimonial))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nome <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $testimonial->name ?? '') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="position">Cargo <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('position') is-invalid @enderror" 
                                   id="position" 
                                   name="position" 
                                   value="{{ old('position', $testimonial->position ?? '') }}" 
                                   required>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company">Empresa <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('company') is-invalid @enderror" 
                                   id="company" 
                                   name="company" 
                                   value="{{ old('company', $testimonial->company ?? '') }}" 
                                   required>
                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rating">Avaliação <span class="text-danger">*</span></label>
                            <select class="form-control @error('rating') is-invalid @enderror" 
                                    id="rating" 
                                    name="rating" 
                                    required>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" 
                                            {{ old('rating', $testimonial->rating ?? '') == $i ? 'selected' : '' }}>
                                        {{ $i }} {{ $i == 1 ? 'Estrela' : 'Estrelas' }}
                                    </option>
                                @endfor
                            </select>
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="testimonial">Depoimento <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('testimonial') is-invalid @enderror" 
                                      id="testimonial" 
                                      name="testimonial" 
                                      rows="4" 
                                      required>{{ old('testimonial', $testimonial->testimonial ?? '') }}</textarea>
                            @error('testimonial')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="order">Ordem</label>
                            <input type="number" 
                                   class="form-control @error('order') is-invalid @enderror" 
                                   id="order" 
                                   name="order" 
                                   value="{{ old('order', $testimonial->order ?? '') }}" 
                                   min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">Imagem do Cliente</label>
                            <div class="custom-file">
                                <input type="file" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       id="image" 
                                       name="image" 
                                       accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                       onchange="previewImage(this);">
                                <small class="form-text text-muted">
                                    Formatos aceitos: JPG, JPEG, PNG, GIF, WebP. Tamanho máximo: 2MB
                                </small>
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if(isset($testimonial) && $testimonial->image)
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($testimonial->image) }}" 
                                             alt="{{ $testimonial->name }}" 
                                             class="img-thumbnail preview-image" 
                                             style="max-height: 100px">
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <img id="preview" src="#" alt="Preview" class="img-thumbnail preview-image" style="max-height: 100px; display: none;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" 
                                       class="custom-control-input" 
                                       id="active" 
                                       name="active" 
                                       value="1" 
                                       {{ old('active', $testimonial->active ?? true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="active">Ativo</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
}
</script>
@endpush 