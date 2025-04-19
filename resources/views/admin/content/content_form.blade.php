@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ isset($content) ? 'Editar' : 'Adicionar' }} Conteúdo</h3>
                    <div class="card-tools">
                        @if(isset($content))
                            <a href="{{ route('admin.content.sections.edit', $content->section) }}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-left"></i> Voltar
                            </a>
                        @else
                            <a href="{{ route('admin.content.sections') }}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-left"></i> Voltar
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ isset($content) ? route('admin.content.update', $content->id) : route('admin.content.store') }}" method="POST">
                        @csrf
                        @if(isset($content))
                            @method('PUT')
                        @endif

                        <div class="form-group mb-3">
                            <label for="section">Seção</label>
                            <select name="section" id="section" class="form-control" required>
                                <option value="">Selecione uma seção</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section }}" {{ (isset($content) && $content->section == $section) ? 'selected' : '' }}>
                                        {{ $section }}
                                    </option>
                                @endforeach
                                <option value="nova_secao">Criar Nova Seção</option>
                            </select>
                        </div>

                        <div class="form-group mb-3" id="new-section-group" style="display: none;">
                            <label for="new_section">Nome da Nova Seção</label>
                            <input type="text" name="new_section" id="new_section" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="label">Rótulo</label>
                            <input type="text" name="label" id="label" class="form-control" value="{{ $content->label ?? old('label') }}" required>
                            <small class="form-text text-muted">Um nome descritivo para este conteúdo</small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="type">Tipo de Conteúdo</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="text" {{ (isset($content) && $content->type == 'text') ? 'selected' : '' }}>Texto Curto</option>
                                <option value="textarea" {{ (isset($content) && $content->type == 'textarea') ? 'selected' : '' }}>Texto Longo</option>
                                <option value="html" {{ (isset($content) && $content->type == 'html') ? 'selected' : '' }}>HTML</option>
                                <option value="image" {{ (isset($content) && $content->type == 'image') ? 'selected' : '' }}>Imagem</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="value">Conteúdo</label>
                            <div id="text-value-container">
                                <input type="text" name="value" id="value-text" class="form-control" value="{{ $content->value ?? old('value') }}">
                            </div>
                            <div id="textarea-value-container" style="display: none;">
                                <textarea name="value" id="value-textarea" class="form-control" rows="5">{{ $content->value ?? old('value') }}</textarea>
                            </div>
                            <div id="html-value-container" style="display: none;">
                                <textarea name="value" id="value-html" class="form-control html-editor" rows="10">{{ $content->value ?? old('value') }}</textarea>
                            </div>
                            <div id="image-value-container" style="display: none;">
                                @if(isset($content) && $content->type == 'image' && $content->value)
                                <div class="mb-2">
                                    <img src="{{ asset($content->value) }}" class="img-thumbnail" style="max-height: 200px">
                                </div>
                                @endif
                                <input type="text" name="value" id="value-image" class="form-control" value="{{ $content->value ?? old('value') }}" placeholder="Caminho da imagem (ex: images/foto.jpg)">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="order">Ordem</label>
                            <input type="number" name="order" id="order" class="form-control" value="{{ $content->order ?? 0 }}">
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> {{ isset($content) ? 'Atualizar' : 'Salvar' }}
                            </button>
                            
                            @if(isset($content))
                            <a href="#" class="btn btn-danger" onclick="if(confirm('Tem certeza que deseja excluir este conteúdo? Esta ação não pode ser desfeita.')) { document.getElementById('delete-form').submit(); }">
                                <i class="bi bi-trash"></i> Excluir
                            </a>
                            
                            <form id="delete-form" action="{{ route('admin.content.destroy', $content->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sectionSelect = document.getElementById('section');
        const newSectionGroup = document.getElementById('new-section-group');
        const typeSelect = document.getElementById('type');
        const textContainer = document.getElementById('text-value-container');
        const textareaContainer = document.getElementById('textarea-value-container');
        const htmlContainer = document.getElementById('html-value-container');
        const imageContainer = document.getElementById('image-value-container');
        
        // Handle section selection
        sectionSelect.addEventListener('change', function() {
            if (this.value === 'nova_secao') {
                newSectionGroup.style.display = 'block';
            } else {
                newSectionGroup.style.display = 'none';
            }
        });
        
        // Handle content type selection
        function updateContentType() {
            textContainer.style.display = 'none';
            textareaContainer.style.display = 'none';
            htmlContainer.style.display = 'none';
            imageContainer.style.display = 'none';
            
            switch(typeSelect.value) {
                case 'text':
                    textContainer.style.display = 'block';
                    break;
                case 'textarea':
                    textareaContainer.style.display = 'block';
                    break;
                case 'html':
                    htmlContainer.style.display = 'block';
                    break;
                case 'image':
                    imageContainer.style.display = 'block';
                    break;
            }
        }
        
        typeSelect.addEventListener('change', updateContentType);
        
        // Initialize correct content type container
        updateContentType();
        
        // Initialize WYSIWYG editor if available
        if (typeof ClassicEditor !== 'undefined') {
            ClassicEditor
                .create(document.querySelector('#value-html'))
                .catch(error => {
                    console.error(error);
                });
        }
    });
</script>
@endpush 