@extends('admin.layouts.app')

@section('title', 'Editar Seu00e7u00e3o: Sobre Nu00f3s')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb e tu00edtulo -->
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.content.sections') }}">Conteu00fado</a></li>
                    <li class="breadcrumb-item active">Sobre Nu00f3s</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0">Editar Seu00e7u00e3o: Sobre Nu00f3s</h1>
            <p class="text-muted">Atualize as informau00e7u00f5es sobre sua empresa</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Formulu00e1rio principal -->
    <form action="{{ route('admin.content.sections.update', 'sobre') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Abas de navegau00e7u00e3o -->
        <ul class="nav nav-tabs mb-4" id="sobreTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="geral-tab" data-bs-toggle="tab" data-bs-target="#geral" type="button" role="tab" aria-controls="geral" aria-selected="true">
                    <i class="bi bi-info-circle me-2"></i>Informau00e7u00f5es Gerais
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="missao-tab" data-bs-toggle="tab" data-bs-target="#missao" type="button" role="tab" aria-controls="missao" aria-selected="false">
                    <i class="bi bi-bullseye me-2"></i>Missu00e3o, Visu00e3o e Valores
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="diferenciais-tab" data-bs-toggle="tab" data-bs-target="#diferenciais" type="button" role="tab" aria-controls="diferenciais" aria-selected="false">
                    <i class="bi bi-trophy me-2"></i>Diferenciais
                </button>
            </li>
        </ul>

        <!-- Conteu00fado das abas -->
        <div class="tab-content" id="sobreTabContent">
            <!-- Aba Informau00e7u00f5es Gerais -->
            <div class="tab-pane fade show active" id="geral" role="tabpanel" aria-labelledby="geral-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @foreach($contents as $content)
                                @if(Str::contains($content->key, ['sobre-titulo', 'sobre-video', 'sobre-historia-titulo', 'sobre-historia-texto']))
                                <div class="col-md-{{ $content->type == 'textarea' || $content->type == 'html' ? '12' : '6' }} mb-3">
                                    <div class="form-group">
                                        <label for="content_{{ $content->id }}" class="form-label fw-bold">
                                            {{ $content->label }}
                                            @if(Str::contains($content->key, 'sobre-video'))
                                                <small class="text-muted">(ID do vu00eddeo do YouTube)</small>
                                            @endif
                                        </label>
                                        
                                        @if($content->type == 'text')
                                            <input type="text" id="content_{{ $content->id }}" name="contents[{{ $content->id }}]" class="form-control" value="{{ $content->value }}">
                                        @elseif($content->type == 'textarea')
                                            <textarea id="content_{{ $content->id }}" name="contents[{{ $content->id }}]" class="form-control" rows="5">{{ $content->value }}</textarea>
                                        @elseif($content->type == 'html')
                                            <textarea id="content_{{ $content->id }}" name="contents[{{ $content->id }}]" class="form-control html-editor" rows="8">{{ $content->value }}</textarea>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aba Missu00e3o, Visu00e3o e Valores -->
            <div class="tab-pane fade" id="missao" role="tabpanel" aria-labelledby="missao-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @foreach($contents as $content)
                                @if(Str::contains($content->key, ['missao-titulo', 'missao-texto', 'visao-titulo', 'visao-texto', 'valores-titulo', 'valores-texto']))
                                <div class="col-md-{{ Str::contains($content->key, '-texto') ? '12' : '6' }} mb-3">
                                    <div class="form-group">
                                        <label for="content_{{ $content->id }}" class="form-label fw-bold">{{ $content->label }}</label>
                                        
                                        @if($content->type == 'text')
                                            <input type="text" id="content_{{ $content->id }}" name="contents[{{ $content->id }}]" class="form-control" value="{{ $content->value }}">
                                        @elseif($content->type == 'textarea')
                                            <textarea id="content_{{ $content->id }}" name="contents[{{ $content->id }}]" class="form-control" rows="5">{{ $content->value }}</textarea>
                                            @if(Str::contains($content->key, 'valores-texto'))
                                            <small class="form-text text-muted">Insira um valor por linha. Eles seru00e3o exibidos como uma lista.</small>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aba Diferenciais -->
            <div class="tab-pane fade" id="diferenciais" role="tabpanel" aria-labelledby="diferenciais-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @foreach($contents as $content)
                                @if(Str::contains($content->key, ['diferencial-card']))
                                <div class="col-md-{{ Str::contains($content->key, '-texto') ? '12' : '6' }} mb-3">
                                    <div class="form-group">
                                        <label for="content_{{ $content->id }}" class="form-label fw-bold">{{ $content->label }}</label>
                                        
                                        @if($content->type == 'text')
                                            @if(Str::contains($content->key, '-icone'))
                                            <div class="input-group">
                                                <span class="input-group-text icon-preview" id="preview_content_{{ $content->id }}">
                                                    <i class="bi {{ $content->value }} fs-3"></i>
                                                </span>
                                                <input type="text" id="content_{{ $content->id }}" name="contents[{{ $content->id }}]" class="form-control" value="{{ $content->value }}" readonly>
                                                <button type="button" class="btn btn-outline-primary icon-picker-trigger" data-target="content_{{ $content->id }}">
                                                    <i class="bi bi-grid"></i> Escolher Ícone
                                                </button>
                                            </div>
                                            <div class="form-text text-muted mt-2">
                                                Clique no botão acima para escolher um ícone da biblioteca Bootstrap Icons.
                                            </div>
                                            @else
                                            <input type="text" id="content_{{ $content->id }}" name="contents[{{ $content->id }}]" class="form-control" value="{{ $content->value }}">
                                            @endif
                                        @elseif($content->type == 'textarea')
                                            <textarea id="content_{{ $content->id }}" name="contents[{{ $content->id }}]" class="form-control" rows="4">{{ $content->value }}</textarea>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botu00f5es de au00e7u00e3o -->
        <div class="row mt-4 mb-5">
            <div class="col-md-12 d-flex justify-content-between">
                <a href="{{ route('admin.content.sections') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Voltar
                </a>
                <button type="submit" class="btn btn-primary btn-lg px-5">
                    <i class="bi bi-save me-1"></i> Salvar Alterau00e7u00f5es
                </button>
            </div>
        </div>
    </form>

    <!-- Visualizau00e7u00e3o ru00e1pida -->
    <div class="card mt-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Pru00e9-visualizau00e7u00e3o</h5>
        </div>
        <div class="card-body">
            <p class="text-center mb-4">Veja como a seu00e7u00e3o "Sobre Nu00f3s" estu00e1 sendo exibida no site:</p>
            <div class="text-center">
                <a href="/#sobre" target="_blank" class="btn btn-outline-primary">
                    <i class="bi bi-eye me-1"></i> Visualizar no site
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize WYSIWYG editors for HTML content
        if (typeof ClassicEditor !== 'undefined') {
            document.querySelectorAll('.html-editor').forEach(editor => {
                ClassicEditor
                    .create(editor)
                    .catch(error => {
                        console.error(error);
                    });
            });
        }

        // Mostrar a aba correta com base no hash da URL
        let hash = window.location.hash;
        if (hash) {
            const triggerEl = document.querySelector(`button[data-bs-target="${hash}"]`);
            if (triggerEl) {
                new bootstrap.Tab(triggerEl).show();
            }
        }

        // Atualizar hash na URL quando mudar de aba
        const tabEls = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabEls.forEach(tabEl => {
            tabEl.addEventListener('shown.bs.tab', event => {
                const target = event.target.getAttribute('data-bs-target');
                window.location.hash = target;
            });
        });
    });
</script>
@endpush

{{-- Include the icon picker modal --}}
@include('admin.content.icon_picker')
