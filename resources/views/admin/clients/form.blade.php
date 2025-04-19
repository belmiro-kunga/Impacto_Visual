@extends('admin.layouts.app')

@section('title', isset($client) ? 'Editar Cliente' : 'Novo Cliente')

@section('content')
<style>
    .logo-preview {
        max-width: 200px;
        max-height: 100px;
        object-fit: contain;
        margin-top: 10px;
        border: 2px dashed #ddd;
        padding: 10px;
        border-radius: 5px;
    }
    .logo-preview-container {
        text-align: center;
        margin-bottom: 20px;
    }
    .logo-preview-text {
        color: #666;
        font-size: 0.9rem;
        margin-top: 5px;
    }
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    .required-field::after {
        content: "*";
        color: #e74a3b;
        margin-left: 4px;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            {{ isset($client) ? 'Editar Cliente' : 'Novo Cliente' }}
        </h1>
        <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ isset($client) ? route('admin.clients.update', $client) : route('admin.clients.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @if(isset($client))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="required-field">Nome da Empresa</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $client->name ?? '') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="url" 
                                   class="form-control @error('website') is-invalid @enderror" 
                                   id="website" 
                                   name="website" 
                                   value="{{ old('website', $client->website ?? '') }}"
                                   placeholder="https://exemplo.com">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo" class="{{ isset($client) ? '' : 'required-field' }}">Logo</label>
                            <input type="file" 
                                   class="form-control @error('logo') is-invalid @enderror" 
                                   id="logo" 
                                   name="logo" 
                                   accept="image/*"
                                   {{ isset($client) ? '' : 'required' }}>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Formatos aceitos: JPG, JPEG, PNG, GIF, WebP. Tamanho máximo: 2MB
                            </small>
                            <div class="logo-preview-container">
                                <img src="{{ isset($client) && $client->logo ? Storage::url($client->logo) : '' }}" 
                                     alt="Preview" 
                                     class="logo-preview" 
                                     id="logoPreview"
                                     style="{{ isset($client) && $client->logo ? '' : 'display: none;' }}">
                                <div class="logo-preview-text" id="logoPreviewText">
                                    {{ isset($client) && $client->logo ? '' : 'Nenhuma imagem selecionada' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="order">Ordem</label>
                            <input type="number" 
                                   class="form-control @error('order') is-invalid @enderror" 
                                   id="order" 
                                   name="order" 
                                   value="{{ old('order', $client->order ?? 0) }}" 
                                   min="0">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" 
                                       class="custom-control-input" 
                                       id="active" 
                                       name="active" 
                                       value="1"
                                       {{ old('active', $client->active ?? true) ? 'checked' : '' }}>
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
$(document).ready(function() {
    // Image preview
    $('#logo').change(function() {
        const file = this.files[0];
        const reader = new FileReader();
        const $preview = $('#logoPreview');
        const $previewText = $('#logoPreviewText');
        
        if (file) {
            reader.onload = function(e) {
                $preview.attr('src', e.target.result).show();
                $previewText.text('');
            }
            reader.readAsDataURL(file);
        } else {
            $preview.attr('src', '').hide();
            $previewText.text('Nenhuma imagem selecionada');
        }
    });
});
</script>
@endpush 