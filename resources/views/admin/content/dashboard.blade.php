@extends('admin.layouts.app')

@section('title', 'Gerenciador de Conteúdo')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 mb-2">Gerenciador de Conteúdo</h1>
                    <p class="text-muted">Gerencie facilmente o conteúdo do seu site por seção.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Seção Início/Hero -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center py-5">
                    <i class="bi bi-house-door text-primary" style="font-size: 3rem;"></i>
                    <h3 class="mt-4">Início</h3>
                    <p class="text-muted">Edite o banner principal, títulos e botões da página inicial.</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-4">
                    <a href="{{ route('admin.content.sections.edit', 'hero') }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Editar Seção
                    </a>
                </div>
            </div>
        </div>

        <!-- Seção Sobre Nós -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center py-5">
                    <i class="bi bi-info-circle text-success" style="font-size: 3rem;"></i>
                    <h3 class="mt-4">Sobre Nós</h3>
                    <p class="text-muted">Atualize informações da empresa, missão, visão e valores.</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-4">
                    <a href="{{ route('admin.content.sections.edit', 'sobre') }}" class="btn btn-success">
                        <i class="bi bi-pencil-square"></i> Editar Seção
                    </a>
                </div>
            </div>
        </div>

        <!-- Seção Serviços -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center py-5">
                    <i class="bi bi-briefcase text-info" style="font-size: 3rem;"></i>
                    <h3 class="mt-4">Serviços</h3>
                    <p class="text-muted">Gerencie os serviços oferecidos pela empresa.</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-4">
                    <a href="{{ route('admin.services') }}" class="btn btn-info">
                        <i class="bi bi-pencil-square"></i> Editar Serviços
                    </a>
                </div>
            </div>
        </div>

        <!-- Seção Portfólio -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center py-5">
                    <i class="bi bi-collection-play text-warning" style="font-size: 3rem;"></i>
                    <h3 class="mt-4">Portfólio</h3>
                    <p class="text-muted">Adicione ou edite trabalhos no portfólio da empresa.</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-4">
                    <a href="{{ route('admin.portfolio.index') }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Gerenciar Portfólio
                    </a>
                </div>
            </div>
        </div>

        <!-- Seção Depoimentos -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center py-5">
                    <i class="bi bi-chat-quote text-danger" style="font-size: 3rem;"></i>
                    <h3 class="mt-4">Depoimentos</h3>
                    <p class="text-muted">Gerencie depoimentos de clientes satisfeitos.</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-4">
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-danger">
                        <i class="bi bi-pencil-square"></i> Gerenciar Depoimentos
                    </a>
                </div>
            </div>
        </div>

        <!-- Seção Clientes -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center py-5">
                    <i class="bi bi-building text-secondary" style="font-size: 3rem;"></i>
                    <h3 class="mt-4">Clientes</h3>
                    <p class="text-muted">Adicione ou edite logos de clientes e parceiros.</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-4">
                    <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary">
                        <i class="bi bi-pencil-square"></i> Gerenciar Clientes
                    </a>
                </div>
            </div>
        </div>

        <!-- Seção Contato -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center py-5">
                    <i class="bi bi-envelope text-primary" style="font-size: 3rem;"></i>
                    <h3 class="mt-4">Contato</h3>
                    <p class="text-muted">Configure informações de contato e formulário.</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-4">
                    <a href="{{ route('admin.content.sections.edit', 'contato') }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Editar Contato
                    </a>
                </div>
            </div>
        </div>

        <!-- Configurações Gerais -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center py-5">
                    <i class="bi bi-gear text-dark" style="font-size: 3rem;"></i>
                    <h3 class="mt-4">Configurações</h3>
                    <p class="text-muted">Configurações gerais do site, logo, cores, etc.</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-4">
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-dark">
                        <i class="bi bi-pencil-square"></i> Configurações
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
