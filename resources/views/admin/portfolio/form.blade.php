@extends('admin.layouts.app')

@section('title', isset($portfolio) ? 'Editar Vídeo' : 'Novo Vídeo')
@section('page_title', isset($portfolio) ? 'Editar Vídeo' : 'Novo Vídeo')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ isset($portfolio) ? 'Editar Vídeo' : 'Novo Vídeo' }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.portfolio.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
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

                    <form action="{{ isset($portfolio) ? route('admin.portfolio.update', $portfolio->id) : route('admin.portfolio.store') }}" method="POST">
                        @csrf
                        @if(isset($portfolio))
                            @method('PUT')
                        @endif

                        <div class="form-group mb-3">
                            <label for="title">Título</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $portfolio->title ?? old('title') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Descrição (opcional)</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ $portfolio->description ?? old('description') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="youtube_id">ID do YouTube</label>
                            <div class="input-group">
                                <span class="input-group-text">youtube.com/watch?v=</span>
                                <input type="text" name="youtube_id" id="youtube_id" class="form-control" value="{{ $portfolio->youtube_id ?? old('youtube_id') }}" required>
                            </div>
                            <small class="form-text text-muted">
                                Ex: para o vídeo https://www.youtube.com/watch?v=dQw4w9WgXcQ, o ID é <strong>dQw4w9WgXcQ</strong>
                            </small>
                        </div>

                        <div class="form-group mb-3">
                            <label for="thumbnail">URL da Thumbnail (opcional)</label>
                            <input type="text" name="thumbnail" id="thumbnail" class="form-control" value="{{ $portfolio->thumbnail ?? old('thumbnail') }}" placeholder="Deixe em branco para usar a thumbnail padrão do YouTube">
                            <small class="form-text text-muted">
                                Se deixado em branco, será usada a thumbnail padrão do YouTube.
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="order">Ordem</label>
                                    <input type="number" name="order" id="order" class="form-control" value="{{ $portfolio->order ?? old('order', 0) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Status</label>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="active" id="active" class="form-check-input" value="1" {{ (isset($portfolio) && $portfolio->active) || old('active', true) ? 'checked' : '' }}>
                                        <label for="active" class="form-check-label">Ativo</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(isset($portfolio) && $portfolio->youtube_id)
                        <div class="form-group mb-4">
                            <label>Preview</label>
                            <div class="ratio ratio-16x9 mt-2">
                                <iframe src="{{ $portfolio->youtube_embed_url }}" allowfullscreen></iframe>
                            </div>
                        </div>
                        @endif

                        <div class="form-group d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> {{ isset($portfolio) ? 'Atualizar' : 'Salvar' }}
                            </button>
                            
                            @if(isset($portfolio))
                            <a href="#" class="btn btn-danger" onclick="if(confirm('Tem certeza que deseja excluir este vídeo? Esta ação não pode ser desfeita.')) { document.getElementById('delete-form').submit(); }">
                                <i class="bi bi-trash"></i> Excluir
                            </a>
                            
                            <form id="delete-form" action="{{ route('admin.portfolio.destroy', $portfolio->id) }}" method="POST" style="display: none;">
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
        const youtubeInput = document.getElementById('youtube_id');
        
        youtubeInput.addEventListener('input', function() {
            // Detecta se o usuário colou uma URL completa e extrai apenas o ID
            const value = this.value;
            
            if (value.includes('youtube.com/watch?v=')) {
                const url = new URL(value);
                const id = url.searchParams.get('v');
                if (id) {
                    this.value = id;
                }
            } else if (value.includes('youtu.be/')) {
                const parts = value.split('youtu.be/');
                if (parts.length > 1) {
                    const id = parts[1].split('?')[0];
                    this.value = id;
                }
            }
        });
    });
</script>
@endpush 