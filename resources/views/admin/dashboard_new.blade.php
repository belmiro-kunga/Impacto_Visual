@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="row">
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="stats-icon icon-purple">
                <i class="bi bi-clipboard-data"></i>
            </div>
            <div class="d-flex align-items-center">
                <h3>3450</h3>
                <span class="percent-badge badge-success ms-2">
                    <i class="bi bi-arrow-up"></i>25%
                </span>
            </div>
            <p>Total de Projetos</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="stats-icon icon-cyan">
                <i class="bi bi-bar-chart"></i>
            </div>
            <div class="d-flex align-items-center">
                <h3>R$35.256</h3>
                <span class="percent-badge badge-success ms-2">
                    <i class="bi bi-arrow-up"></i>15%
                </span>
            </div>
            <p>Faturamento</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="stats-icon icon-green">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="d-flex align-items-center">
                <h3>R$35.256</h3>
                <span class="percent-badge badge-danger ms-2">
                    <i class="bi bi-arrow-down"></i>15%
                </span>
            </div>
            <p>Preço Médio</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="stats-icon icon-orange">
                <i class="bi bi-activity"></i>
            </div>
            <div class="d-flex align-items-center">
                <h3>15.893</h3>
            </div>
            <p>Operações</p>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title">Atividades Recentes</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">Ver Todas</a>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon bg-primary">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="activity-content">
                            <p class="mb-0">Novo cliente cadastrado: <strong>TechSolutions</strong></p>
                            <small class="text-muted">Há 2 horas</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-success">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="activity-content">
                            <p class="mb-0">Projeto <strong>Website E-commerce</strong> finalizado</p>
                            <small class="text-muted">Há 5 horas</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-warning">
                            <i class="bi bi-bell"></i>
                        </div>
                        <div class="activity-content">
                            <p class="mb-0">Reunião agendada com <strong>Marketing Digital Inc</strong></p>
                            <small class="text-muted">Há 1 dia</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon bg-info">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <div class="activity-content">
                            <p class="mb-0">Novo comentário no projeto <strong>Vídeo Institucional</strong></p>
                            <small class="text-muted">Há 2 dias</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title">Acesso Rápido</h5>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.services') }}" class="card text-decoration-none">
                            <div class="card-body text-center py-4">
                                <i class="bi bi-journal-richtext text-primary" style="font-size: 2rem;"></i>
                                <h5 class="mt-3">Gerenciar Serviços</h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.content.sections') }}" class="card text-decoration-none">
                            <div class="card-body text-center py-4">
                                <i class="bi bi-file-earmark-text text-success" style="font-size: 2rem;"></i>
                                <h5 class="mt-3">Editar Conteúdo</h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="card text-decoration-none">
                            <div class="card-body text-center py-4">
                                <i class="bi bi-collection-play text-info" style="font-size: 2rem;"></i>
                                <h5 class="mt-3">Portfólio</h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#" class="card text-decoration-none">
                            <div class="card-body text-center py-4">
                                <i class="bi bi-people-fill text-warning" style="font-size: 2rem;"></i>
                                <h5 class="mt-3">Contatos</h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .stats-card {
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .stats-card h3 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 0;
    }

    .stats-card p {
        color: #6c757d;
        margin-bottom: 0;
    }

    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    .percent-badge {
        font-size: 0.8rem;
        padding: 5px 10px;
        border-radius: 20px;
        margin-left: 10px;
        display: flex;
        align-items: center;
    }

    .percent-badge i {
        margin-right: 5px;
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: white;
    }

    /* Icons and Badges Colors */
    .icon-purple, .bg-purple {
        background-color: rgba(79, 70, 229, 0.1);
        color: var(--secondary-color);
    }

    .icon-cyan, .bg-cyan {
        background-color: rgba(6, 182, 212, 0.1);
        color: var(--accent-color);
    }

    .icon-green, .bg-green {
        background-color: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .icon-orange, .bg-orange {
        background-color: rgba(249, 115, 22, 0.1);
        color: #f97316;
    }

    .badge-success {
        background-color: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .badge-danger {
        background-color: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
</style>
@endpush 