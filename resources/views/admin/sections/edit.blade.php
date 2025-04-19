@extends('admin.layouts.app')

@section('title', 'Editar Seção - ' . $sectionTitle)
@section('page_title', 'Editar Seção - ' . $sectionTitle)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Seções do Site</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        @foreach($sections as $key => $title)
                            <li class="nav-item">
                                <a href="{{ route('admin.sections.edit', $key) }}" class="nav-link {{ $section == $key ? 'active' : '' }}">
                                    <i class="bi {{ 
                                        $key == 'hero' ? 'bi-house-fill' : 
                                        ($key == 'about' ? 'bi-info-circle-fill' : 
                                        ($key == 'services' ? 'bi-gear-fill' : 
                                        ($key == 'portfolio' ? 'bi-collection-play-fill' : 
                                        ($key == 'testimonials' ? 'bi-chat-quote-fill' : 
                                        ($key == 'clients' ? 'bi-building-fill' : 
                                        ($key == 'contact' ? 'bi-envelope-fill' : 'bi-card-text')))))) 
                                    }} me-2"></i> {{ $title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">Adicionar novo campo</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sections.update', $section) }}" method="POST" enctype="multipart/form-data" id="add-new-field-form">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="new_label">Nome do campo</label>
                            <input type="text" name="new_content[label]" id="new_label" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="new_type">Tipo</label>
                            <select name="new_content[type]" id="new_type" class="form-control">
                                <option value="text">Texto</option>
                                <option value="textarea">Texto longo</option>
                                <option value="html">HTML</option>
                                <option value="image">Imagem</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm w-100" id="btn-add-field">
                                <i class="bi bi-plus-circle"></i> Adicionar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Conteúdo da Seção: {{ $sectionTitle }}</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($section == 'hero' && isset($data['hero_info']))
                    <div class="alert alert-info mb-4">
                        <h4 class="alert-heading">{{ $data['hero_info']['title'] }}</h4>
                        <p>{{ $data['hero_info']['description'] }}</p>
                        <hr>
                        <p class="mb-0">Dicas:</p>
                        <ul>
                            <li>Para alterar o vídeo de fundo, você precisa substituir o arquivo <code>public/videos/Coca-Col.mp4</code> mantendo o mesmo nome.</li>
                            <li>Os contadores são atualizados automaticamente em tempo real no frontend.</li>
                            <li>O número do WhatsApp deve ser inserido no formato internacional, sem espaços ou caracteres especiais (exemplo: 5511999999999).</li>
                            <li>Todas as alterações são aplicadas imediatamente após salvar.</li>
                        </ul>
                    </div>
                    @endif
                    
                    @if($section == 'hero' && isset($data['menu_info']))
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h4 class="mb-0">{{ $data['menu_info']['title'] }}</h4>
                        </div>
                        <div class="card-body">
                            <p>{{ $data['menu_info']['description'] }}</p>
                            <div class="alert alert-warning">
                                <i class="bi bi-info-circle me-2"></i> {{ $data['menu_info']['help'] }}
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nome do Item</th>
                                            <th>Link</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for($i = 1; $i <= 7; $i++)
                                            @php
                                                $menuField = "menu-item-{$i}";
                                                $menuLinkField = "menu-item-{$i}-link";
                                                $titleContent = $contents->firstWhere('key', $menuField);
                                                $linkContent = $contents->firstWhere('key', $menuLinkField);
                                            @endphp
                                            @if($titleContent && $linkContent)
                                            <tr>
                                                <td>
                                                    <input type="text" name="contents[{{ $titleContent->id }}]" class="form-control" value="{{ $titleContent->value }}" placeholder="Nome do item">
                                                </td>
                                                <td>
                                                    <input type="text" name="contents[{{ $linkContent->id }}]" class="form-control" value="{{ $linkContent->value }}" placeholder="Link (ex: #sobre)">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-outline-danger menu-clear-btn" data-menu-id="{{ $i }}">
                                                        <i class="bi bi-x-lg"></i> Limpar
                                                    </button>
                                                </td>
                                            </tr>
                                            @endif
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-muted mt-2">Nota: Para remover um item do menu, deixe o campo de nome em branco.</p>
                            
                            <!-- Botão para adicionar item de menu -->
                            <div class="mt-3">
                                <button type="button" class="btn btn-success btn-sm" id="add-menu-item">
                                    <i class="bi bi-plus-circle"></i> Adicionar Novo Item de Menu
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($section == 'about' && isset($data['about_info']))
                    <div class="alert alert-info mb-4">
                        <h4 class="alert-heading">{{ $data['about_info']['title'] }}</h4>
                        <p>{{ $data['about_info']['description'] }}</p>
                        <hr>
                        <p class="mb-0"><strong>Importante:</strong> A seção de Serviços agora é gerenciada aqui na página Sobre Nós.</p>
                        <ul>
                            <li>Para o ID do vídeo, use apenas o código do YouTube (ex: "dQw4w9WgXcQ" para o link https://www.youtube.com/watch?v=dQw4w9WgXcQ)</li>
                            <li>Os ícones dos cards usam Bootstrap Icons. Consulte <a href="https://icons.getbootstrap.com/" target="_blank">a biblioteca de ícones</a> para escolher.</li>
                            <li>Para a lista de valores, separe cada item com uma nova linha.</li>
                            <li>Você pode gerenciar os cards individuais de serviços na seção "Gerenciar Serviços" abaixo.</li>
                        </ul>
                    </div>
                    @endif
                    
                    @if($section == 'services' && isset($data['services_info']))
                    <div class="alert alert-info mb-4">
                        <h4 class="alert-heading">{{ $data['services_info']['title'] }}</h4>
                        <p>{{ $data['services_info']['description'] }}</p>
                        <hr>
                        <p class="mb-0"><strong>Essa é uma visualização filtrada da seção Serviços</strong></p>
                        <ul>
                            <li>Aqui você pode editar somente os textos específicos da seção de serviços.</li>
                            <li>Para gerenciar os cards individuais de serviços, use a tabela abaixo.</li>
                            <li>Todos os campos aqui também estão disponíveis na seção "Sobre Nós".</li>
                        </ul>
                    </div>
                    @endif
                    
                    <!-- Gerenciamento de Serviços -->
                    @if($section == 'about' || $section == 'services')
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Gerenciar Serviços</h4>
                        </div>
                        <div class="card-body">
                            <p>Aqui você pode gerenciar os serviços que aparecem na seção de serviços do site.</p>
                            
                            <div class="d-flex justify-content-between mb-4">
                                <h5>Lista de Serviços</h5>
                                <a href="{{ route('admin.services.create') }}" class="btn btn-success">
                                    <i class="bi bi-plus-circle"></i> Novo Serviço
                                </a>
                            </div>
                            
                            @if(isset($data['services']) && count($data['services']) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Ordem</th>
                                            <th>Título</th>
                                            <th>Ícone</th>
                                            <th>Destacado</th>
                                            <th>Ativo</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data['services'] as $service)
                                        <tr>
                                            <td>{{ $service->order }}</td>
                                            <td>{{ $service->title }}</td>
                                            <td><i class="bi {{ $service->icon }}"></i> {{ $service->icon }}</td>
                                            <td>
                                                @if($service->is_highlighted)
                                                <span class="badge bg-success">Sim</span>
                                                @else
                                                <span class="badge bg-secondary">Não</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($service->active)
                                                <span class="badge bg-success">Sim</span>
                                                @else
                                                <span class="badge bg-danger">Não</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger delete-service-btn" data-id="{{ $service->id }}" data-title="{{ $service->title }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i> Nenhum serviço cadastrado. <a href="{{ route('admin.services.create') }}" class="alert-link">Adicione seu primeiro serviço</a>.
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <form action="{{ route('admin.sections.update', $section) }}" method="POST" enctype="multipart/form-data" id="update-content-form">
                        @csrf
                        
                        @if($contents->isEmpty())
                            <div class="alert alert-info">
                                Nenhum conteúdo cadastrado para esta seção. Use o formulário ao lado para adicionar novos campos.
                            </div>
                        @else
                            @foreach($contents as $content)
                                <div class="card mb-3">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">{{ $content->label }}</h5>
                                        <form action="{{ route('admin.sections.content.destroy', $content->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este campo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        @if($content->type == 'text')
                                            <input type="text" name="contents[{{ $content->id }}]" class="form-control" value="{{ $content->value }}">
                                        
                                        @elseif($content->type == 'textarea')
                                            <textarea name="contents[{{ $content->id }}]" rows="3" class="form-control">{{ $content->value }}</textarea>
                                        
                                        @elseif($content->type == 'html')
                                            <textarea name="contents[{{ $content->id }}]" rows="5" class="form-control html-editor" data-content-id="{{ $content->id }}">{{ $content->value }}</textarea>
                                        
                                        @elseif($content->type == 'image')
                                            <div class="input-group mb-3">
                                                <input type="file" name="contents_file[{{ $content->id }}]" class="form-control">
                                                <input type="hidden" name="contents[{{ $content->id }}]" value="{{ $content->value }}">
                                            </div>
                                            
                                            @if($content->value)
                                                <div class="mt-2">
                                                    <img src="{{ asset($content->value) }}" alt="{{ $content->label }}" class="img-thumbnail" style="max-height: 100px;">
                                                </div>
                                            @endif
                                        @endif
                                        
                                        <div class="form-text text-muted">
                                            Chave: <code>{{ $content->key }}</code> - Tipo: {{ ucfirst($content->type) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg" id="btn-save-changes" style="font-size: 1.2rem; padding: 0.75rem 2rem; font-weight: bold;">
                                    <i class="bi bi-save"></i> Salvar Alterações
                                </button>
                                <div id="save-feedback" class="mt-3" style="display: none;"></div>
                            </div>
                        @endif
                    </form>
                    
                    <div id="global-feedback" class="mt-4 mb-4">
                        <!-- Feedback global sobre a operação -->
                    </div>
                    
                    <!-- Solução Alternativa para o problema de salvamento -->
                    @if($section == 'hero')
                    <div class="card mt-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Método alternativo de salvamento</h4>
                        </div>
                        <div class="card-body">
                            <p class="text-danger">Se o botão "Salvar Alterações" acima não está funcionando, use este método alternativo:</p>
                            <form action="{{ route('admin.sections.update', $section) }}" method="POST" id="hero-direct-form">
                                @csrf
                                @foreach($contents as $content)
                                <div class="mb-3">
                                    <label class="fw-bold">{{ $content->label }}</label>
                                    @if($content->type == 'text')
                                    <input type="text" name="contents[{{ $content->id }}]" class="form-control" value="{{ $content->value }}">
                                    @elseif($content->type == 'textarea')
                                    <textarea name="contents[{{ $content->id }}]" rows="3" class="form-control">{{ $content->value }}</textarea>
                                    @elseif($content->type == 'html')
                                    <textarea name="contents[{{ $content->id }}]" rows="5" class="form-control">{{ $content->value }}</textarea>
                                    @endif
                                    <div class="form-text">Chave: {{ $content->key }}</div>
                                </div>
                                @endforeach
                                <button type="submit" class="btn btn-danger btn-lg">
                                    <i class="bi bi-save"></i> Salvar usando método alternativo
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                    
                    @if($section == 'portfolio' && isset($data['portfolios']))
                        <div class="mt-4">
                            <h4>Gerenciar Portfólio</h4>
                            <p>
                                <a href="{{ route('admin.portfolio.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-collection-play"></i> Ir para Gerenciamento de Portfólio
                                </a>
                            </p>
                        </div>
                    @endif
                    
                    @if($section == 'contact' && isset($data['settings']))
                        <div class="mt-4">
                            <h4>Configurações de Contato</h4>
                            <p>
                                <a href="{{ route('admin.settings.index', 'contact') }}" class="btn btn-secondary">
                                    <i class="bi bi-envelope"></i> Ir para Configurações de Contato
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/debug-form.js') }}"></script>
<script src="{{ asset('js/section-editor.js') }}"></script>
<script src="{{ asset('js/admin.js') }}"></script>
<script>
    // Inicializar configurações do Toastr
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };
    
    // Verificar se há mensagens de sucesso ou erro
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif
    
    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
    
    @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif
</script>
@if($section == 'hero')
<script src="{{ asset('js/hero-section-fix.js') }}"></script>
@endif
@endpush 