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
                <h3>{{ $totalServices ?? 0 }}</h3>
                <span class="percent-badge badge-{{ isset($totalServices) && $totalServices > 0 ? 'success' : 'secondary' }} ms-2">
                    <i class="bi bi-{{ isset($totalServices) && $totalServices > 0 ? 'arrow-up' : 'dash' }}"></i>{{ isset($totalServices) && isset($activeServices) && $totalServices > 0 ? number_format(($activeServices / $totalServices) * 100, 0) : 0 }}%
                </span>
            </div>
            <p>Total de Serviços</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="stats-icon icon-cyan">
                <i class="bi bi-collection-play"></i>
            </div>
            <div class="d-flex align-items-center">
                <h3>{{ $totalPortfolios ?? 0 }}</h3>
                <span class="percent-badge badge-{{ isset($totalPortfolios) && $totalPortfolios > 0 ? 'success' : 'secondary' }} ms-2">
                    <i class="bi bi-{{ isset($totalPortfolios) && $totalPortfolios > 0 ? 'arrow-up' : 'dash' }}"></i>{{ isset($totalPortfolios) && isset($activePortfolios) && $totalPortfolios > 0 ? number_format(($activePortfolios / $totalPortfolios) * 100, 0) : 0 }}%
                </span>
            </div>
            <p>Itens de Portfólio</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="stats-icon icon-green">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div class="d-flex align-items-center">
                <h3>{{ $totalContents ?? 0 }}</h3>
            </div>
            <p>Campos de Conteúdo</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="stats-icon icon-orange">
                <i class="bi bi-star"></i>
            </div>
            <div class="d-flex align-items-center">
                <h3>{{ $highlightedServices ?? 0 }}</h3>
            </div>
            <p>Serviços Destacados</p>
            <div style="width: 100%; height: 40px; margin-top: 10px;">
                <canvas id="mini-chart" data-active="{{ $activeServices ?? 0 }}" data-total="{{ $totalServices ?? 0 }}"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Market Overview Chart -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title">Distribuição de Conteúdo por Seções</h5>
                    <div>
                        <span class="badge bg-primary me-2">Total</span>
                        <span class="badge bg-info">Ativos</span>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="sectionsChart" data-sections="{{ isset($contentsBySections) ? json_encode(array_keys($contentsBySections)) : '[]' }}" data-values="{{ isset($contentsBySections) ? json_encode(array_values($contentsBySections)) : '[]' }}"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title">Status dos Serviços</h5>
                </div>
                <div class="chart-container">
                    <canvas id="servicesChart" data-active="{{ $servicesBySection['ativos'] ?? 0 }}" data-inactive="{{ $servicesBySection['inativos'] ?? 0 }}" data-highlighted="{{ $servicesBySection['destacados'] ?? 0 }}"></canvas>
                </div>
            </div>
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
                    <h5 class="card-title">Serviços Mais Procurados</h5>
                </div>
                <div class="chart-container">
                    <canvas id="servicesChart"></canvas>
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

    .chart-container {
        height: 250px;
        position: relative;
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

    .project-item {
        margin-bottom: 15px;
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico miniatura para serviços ativos vs. total
        const miniChartCanvas = document.getElementById('mini-chart');
        if (miniChartCanvas) {
            try {
                const activeServices = parseInt(miniChartCanvas.dataset.active) || 0;
                const totalServices = parseInt(miniChartCanvas.dataset.total) || 0;
                
                new Chart(miniChartCanvas, {
                    type: 'bar',
                    data: {
                        labels: ['Ativos', 'Total'],
                        datasets: [{
                            label: 'Serviços',
                            data: [activeServices, totalServices],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.5)',
                                'rgba(255, 99, 132, 0.5)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                display: false
                            },
                            x: {
                                display: false
                            }
                        }
                    }
                });
            } catch (e) {
                console.error('Erro ao renderizar mini-chart:', e);
            }
        }
        
        // Gráfico de distribuição de conteúdo por seções
        const sectionsChartCanvas = document.getElementById('sectionsChart');
        if (sectionsChartCanvas) {
            try {
                const sections = JSON.parse(sectionsChartCanvas.dataset.sections || '[]');
                const values = JSON.parse(sectionsChartCanvas.dataset.values || '[]');
                
                if (sections.length > 0 && values.length > 0) {
                    const sectionLabels = sections.map(section => {
                        switch(section) {
                            case 'hero': return 'Início';
                            case 'about': return 'Sobre Nós';
                            case 'services': return 'Serviços';
                            case 'portfolio': return 'Portfólio';
                            case 'testimonials': return 'Depoimentos';
                            case 'clients': return 'Clientes';
                            case 'contact': return 'Contato';
                            default: return section;
                        }
                    });
                    
                    new Chart(sectionsChartCanvas, {
                        type: 'bar',
                        data: {
                            labels: sectionLabels,
                            datasets: [{
                                label: 'Campos de Conteúdo',
                                data: values,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            } catch (e) {
                console.error('Erro ao renderizar sectionsChart:', e);
            }
        }
        
        // Gráfico do status dos serviços
        const servicesChartCanvas = document.getElementById('servicesChart');
        if (servicesChartCanvas) {
            try {
                const activeServices = parseInt(servicesChartCanvas.dataset.active) || 0;
                const inactiveServices = parseInt(servicesChartCanvas.dataset.inactive) || 0;
                const highlightedServices = parseInt(servicesChartCanvas.dataset.highlighted) || 0;
                
                new Chart(servicesChartCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: ['Ativos', 'Inativos', 'Destacados'],
                        datasets: [{
                            label: 'Serviços',
                            data: [activeServices, inactiveServices, highlightedServices],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.5)',
                                'rgba(255, 99, 132, 0.5)',
                                'rgba(255, 206, 86, 0.5)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(255, 206, 86, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            } catch (e) {
                console.error('Erro ao renderizar servicesChart:', e);
            }
        }
    });
</script>
@endpush 