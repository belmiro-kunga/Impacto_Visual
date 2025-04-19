@extends('admin.layouts.app')

@section('title', isset($service) ? 'Editar Serviço' : 'Novo Serviço')
@section('page_title', isset($service) ? 'Editar Serviço' : 'Novo Serviço')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ isset($service) ? 'Editar Serviço' : 'Novo Serviço' }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.services') }}" class="btn btn-secondary btn-sm">
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

                    <form action="{{ isset($service) ? route('admin.services.update', $service->id) : route('admin.services.store') }}" method="POST">
                        @csrf
                        @if(isset($service))
                            @method('PUT')
                        @endif

                        <div class="form-group mb-3">
                            <label for="title">Título</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $service->title ?? old('title') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Descrição</label>
                            <textarea name="description" id="description" class="form-control" rows="4" required>{{ $service->description ?? old('description') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="icon">Ícone (Bootstrap Icons)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi {{ $service->icon ?? 'bi-stars' }}"></i></span>
                                <input type="text" name="icon" id="icon" class="form-control" value="{{ $service->icon ?? old('icon', 'bi-stars') }}">
                            </div>
                            <small class="form-text text-muted">
                                Escolha um ícone da biblioteca <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a> e insira o código (ex: bi-people-fill, bi-star, etc).
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="order">Ordem</label>
                                    <input type="number" name="order" id="order" class="form-control" value="{{ $service->order ?? old('order', 0) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Destaque</label>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="is_highlighted" id="is_highlighted" class="form-check-input" value="1" {{ (isset($service) && $service->is_highlighted) || old('is_highlighted') ? 'checked' : '' }}>
                                        <label for="is_highlighted" class="form-check-label">Destacar este serviço</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Status</label>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="active" id="active" class="form-check-input" value="1" {{ (isset($service) && $service->active) || old('active', true) ? 'checked' : '' }}>
                                        <label for="active" class="form-check-label">Ativo</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> {{ isset($service) ? 'Atualizar' : 'Salvar' }}
                            </button>
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
        const iconInput = document.getElementById('icon');
        const iconPreview = iconInput.parentElement.querySelector('.input-group-text i');

        iconInput.addEventListener('input', function() {
            // Atualiza o preview do ícone
            const iconClass = this.value;
            
            // Remove todas as classes de ícones
            iconPreview.className = '';
            
            // Adiciona a classe bi e a nova classe de ícone
            iconPreview.classList.add('bi', iconClass);
        });
    });
</script>
@endpush 