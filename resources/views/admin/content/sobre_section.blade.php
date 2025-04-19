@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Gerenciar Seção: Sobre Nós</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.content.sections') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <a href="{{ route('admin.content.create') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-plus-circle"></i> Novo Conteúdo
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($contents->count() > 0)
                        <form action="{{ route('admin.content.sections.update', $section) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <h4 class="mb-0">Informações Principais</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($contents as $content)
                                                    @if(Str::contains($content->key, ['sobre-titulo', 'sobre-video', 'sobre-historia-titulo', 'sobre-historia-texto']))
                                                    <div class="col-md-{{ $content->type == 'textarea' || $content->type == 'html' ? '12' : '6' }} mb-3">
                                                        <div class="form-group">
                                                            <label for="content_{{ $content->id }}" class="form-label fw-bold">
                                                                {{ $content->label }}
                                                                @if(Str::contains($content->key, 'sobre-video'))
                                                                    <small class="text-muted">(ID do vídeo do YouTube)</small>
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
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <h4 class="mb-0">Missão, Visão e Valores</h4>
                                        </div>
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
                                                                <small class="form-text text-muted">Insira um valor por linha. Eles serão exibidos como uma lista.</small>
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
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <h4 class="mb-0">Nossos Diferenciais</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($contents as $content)
                                                    @if(Str::contains($content->key, ['diferencial-card']))
                                                    <div class="col-md-{{ Str::contains($content->key, '-texto') ? '12' : '6' }} mb-3">
                                                        <div class="form-group">
                                                            <label for="content_{{ $content->id }}" class="form-label fw-bold">{{ $content->label }}</label>
                                                            
                                                            @if($content->type == 'text')
                                                                <input type="text" id="content_{{ $content->id }}" name="contents[{{ $content->id }}]" class="form-control" value="{{ $content->value }}">
                                                                @if(Str::contains($content->key, '-icone'))
                                                                <small class="form-text text-muted">Classe do ícone Bootstrap (ex: bi-person-check, bi-lightning-charge, bi-graph-up)</small>
                                                                <div class="mt-2">
                                                                    <i class="bi {{ $content->value }} fs-3"></i> <span class="ms-2">Visualização do ícone</span>
                                                                </div>
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

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <h4 class="mb-0">Estatísticas</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($contents as $content)
                                                    @if(Str::contains($content->key, ['contador-']))
                                                    <div class="col-md-4 mb-3">
                                                        <div class="form-group">
                                                            <label for="content_{{ $content->id }}" class="form-label fw-bold">{{ $content->label }}</label>
                                                            <input type="text" id="content_{{ $content->id }}" name="contents[{{ $content->id }}]" class="form-control" value="{{ $content->value }}">
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle"></i> Dica: Para ver como suas alterações ficarão no site, salve as mudanças e visite a <a href="/" target="_blank">página inicial</a>.
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 d-flex justify-content-between">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-save"></i> Salvar Alterações
                                </button>
                                
                                <a href="{{ route('admin.content.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Adicionar Novo Campo
                                </a>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info">
                            <p>Nenhum conteúdo encontrado para a seção "Sobre Nós".</p>
                            <p>Para criar o conteúdo desta seção, clique no botão abaixo:</p>
                            <a href="{{ route('admin.content.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Adicionar Conteúdo
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize any WYSIWYG editors for HTML content
        if (typeof ClassicEditor !== 'undefined') {
            document.querySelectorAll('.html-editor').forEach(editor => {
                ClassicEditor
                    .create(editor)
                    .catch(error => {
                        console.error(error);
                    });
            });
        }
    });
</script>
@endpush
