<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Painel de Controle') | Impacto Visual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Include CKEditor if you have it installed -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <!-- SweetAlert2 for better alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Toastr notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        :root {
            --primary-color: #0a0f1c;
            --secondary-color: #4f46e5;
            --accent-color: #06b6d4;
            --text-color: #ffffff;
            --text-secondary: #94a3b8;
            --dark-color: #111827;
            --light-color: #f3f4f6;
            --card-border-radius: 1.25rem;
        }

        body {
            background-color: #f5f5f9;
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            background-color: var(--primary-color);
            color: var(--text-color);
            height: 100vh;
            position: fixed;
            width: 240px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .sidebar-logo {
            padding: 20px;
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo i {
            color: var(--secondary-color);
            margin-right: 10px;
        }

        .nav-link {
            color: var(--text-secondary);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            border-radius: 0;
            margin: 2px 0;
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-color);
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 240px;
            padding: 20px;
        }

        .top-navbar {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-left: 10px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        
        .dropdown-toggle::after {
            display: none;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .dropdown-item {
            padding: 8px 15px;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: rgba(79, 70, 229, 0.1);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <i class="bi bi-box"></i>
            <span>Impacto Visual</span>
        </div>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.content.*') || request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.content.sections') }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Gerenciador de Conteúdo</span>
                </a>
            </li>
            
            <!-- Seções do site -->
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/sections/hero*') ? 'active' : '' }}" href="{{ route('admin.sections.edit', 'hero') }}">
                    <i class="bi bi-house-fill"></i>
                    <span>Início</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/sections/sobre*') || request()->is('admin/sections/about*') ? 'active' : '' }}" href="{{ route('admin.sections.edit', 'about') }}">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>Sobre Nós</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/sections/services*') ? 'active' : '' }}" href="{{ route('admin.sections.edit', 'services') }}">
                    <i class="bi bi-briefcase-fill"></i>
                    <span>Serviços</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.portfolio*') ? 'active' : '' }}" href="{{ route('admin.portfolio.index') }}">
                    <i class="bi bi-collection-play"></i>
                    <span>Portfólio</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/testimonials*') ? 'active' : '' }}" href="{{ route('admin.testimonials.index') }}">
                    <i class="fas fa-comment-dots"></i>
                    <span>Depoimentos</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/clients*') ? 'active' : '' }}" href="{{ route('admin.clients.index') }}">
                    <i class="bi bi-building"></i>
                    <span>Clientes</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/sections/contato*') ? 'active' : '' }}" href="{{ route('admin.sections.edit', 'contato') }}">
                    <i class="bi bi-envelope-fill"></i>
                    <span>Contato</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.duplicate-fields.*') ? 'active' : '' }}" href="{{ route('admin.duplicate-fields.index') }}">
                    <i class="bi bi-tools"></i>
                    <span>Campos Duplicados</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                    <i class="bi bi-gear-fill"></i>
                    <span>Configurações</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="/landpage/public/admin/users">
                    <i class="bi bi-people-fill"></i>
                    <span>Gerenciar Usuários</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navigation -->
        <div class="top-navbar">
            <div class="d-flex align-items-center">
                <div>
                    <h4 class="mb-0">@yield('page_title', 'Painel de Controle')</h4>
                </div>
            </div>
            <div class="user-profile">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#">Notificações</a></li>
                    </ul>
                </div>
                <div class="dropdown ms-3">
                    <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="me-2">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Configurações</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i>Sair
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 