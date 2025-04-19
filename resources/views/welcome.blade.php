<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['site_name'] ?? 'Impacto Visual' }} - {{ $settings['site_description'] ?? 'Produção de Vídeos' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=1.0.3">
    @if(isset($settings['favicon']))
    <link rel="shortcut icon" href="{{ asset($settings['favicon']) }}" type="image/x-icon">
    @endif
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#" data-aos="fade-right">
                @if(isset($settings['logo']))
                    <img src="{{ asset($settings['logo']) }}" alt="{{ $settings['site_name'] ?? 'Impacto Visual' }}" class="img-fluid" style="max-height: 40px;">
                @else
                    <span class="text-gradient">{{ $settings['site_name'] ?? 'Impacto Visual' }}</span>
                @endif
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @php
                        $menuItems = [];
                        for ($i = 1; $i <= 7; $i++) {
                            $title = isset($contents["menu-item-{$i}"]) ? $contents["menu-item-{$i}"]->value : '';
                            $link = isset($contents["menu-item-{$i}-link"]) ? $contents["menu-item-{$i}-link"]->value : "#";
                            
                            if (!empty($title)) {
                                $menuItems[] = [
                                    'title' => $title,
                                    'link' => !empty($link) ? $link : "#"
                                ];
                            }
                        }
                        
                        // Se não houver itens definidos, usar o menu padrão
                        if (empty($menuItems)) {
                            $menuItems = [
                                ['title' => 'Início', 'link' => '#inicio'],
                                ['title' => 'Sobre Nós', 'link' => '#sobre'],
                                ['title' => 'Serviços', 'link' => '#servicos'],
                                ['title' => 'Portfólio', 'link' => '#portfolio'],
                                ['title' => 'Depoimentos', 'link' => '#depoimentos'],
                                ['title' => 'Clientes', 'link' => '#clientes'],
                                ['title' => 'Contato', 'link' => '#contato']
                            ];
                        }
                    @endphp
                    
                    @foreach($menuItems as $index => $item)
                    <li class="nav-item" data-aos="fade-down" data-aos-delay="{{ 100 + ($index * 50) }}">
                        <a class="nav-link" href="{{ $item['link'] }}">{{ $item['title'] }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="hero-section">
        <div class="hero-video-container">
            <video 
                id="hero-background-video" 
                class="hero-video" 
                autoplay 
                muted 
                loop 
                playsinline
                preload="auto"
                defaultMuted
                webkit-playsinline>
                <source src="{{ asset($settings['header_video'] ?? 'videos/Coca-Col.mp4') }}" type="video/mp4">
            </video>
            <button id="play-btn" class="video-play-btn">
                <i class="bi bi-play-fill"></i>
            </button>
            <div class="hero-overlay"></div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center" data-aos="fade-up" data-aos-duration="1000">
                    <h1 class="hero-title text-gradient">{{ $contents['hero-title']->value ?? 'Transformamos ideias em vídeos incríveis para redes sociais e empresas' }}</h1>
                    <p class="hero-subtitle">{{ $contents['hero-subtitle']->value ?? 'Produção audiovisual com qualidade, estratégia e impacto visual' }}</p>
                    <div class="hero-cta">
                        <a href="#contato" class="btn btn-primary btn-lg glow-effect">{{ $contents['hero-button-text']->value ?? 'Solicite um orçamento' }}</a>
                        <a href="https://wa.me/{{ $contents['hero-whatsapp-number']->value ?? '5511999999999' }}" class="btn btn-whatsapp btn-lg ms-3">
                            <i class="bi bi-whatsapp"></i> {{ $contents['hero-whatsapp-text']->value ?? 'Fale no WhatsApp' }}
                        </a>
                    </div>
                    <div class="hero-stats mt-5">
                        <div class="row">
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3 class="counter" data-target="{{ $contents['contador-projetos']->value ?? '100' }}">{{ $contents['contador-projetos']->value ?? '100' }}+</h3>
                                    <p>Projetos</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3 class="counter" data-target="{{ $contents['contador-clientes']->value ?? '50' }}">{{ $contents['contador-clientes']->value ?? '50' }}+</h3>
                                    <p>Clientes</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3 class="counter" data-target="{{ $contents['contador-anos']->value ?? '5' }}">{{ $contents['contador-anos']->value ?? '5' }}+</h3>
                                    <p>Anos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="whatsapp-float">
            <a href="https://wa.me/{{ $contents['hero-whatsapp-number']->value ?? '5511999999999' }}" class="btn-float-whatsapp">
                <i class="bi bi-whatsapp"></i>
            </a>
        </div>
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
    </section>

    <!-- Sobre Nós Section -->
    <section id="sobre" class="about-section">
        <div class="container">
            <h2 class="text-center mb-5">{{ $contents['sobre-titulo']->value ?? 'Conheça a Impacto Visual' }}</h2>
            <div class="row align-items-center mb-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/{{ $contents['sobre-video']->value ?? 'IS1XHAJVURI' }}?autoplay=0&rel=0" title="Vídeo Institucional Impacto Visual" frameborder="0" allowfullscreen class="video-embed rounded-4 shadow-lg"></iframe>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="section-title mb-4">
                        <h3>{{ $contents['sobre-historia-titulo']->value ?? 'Nossa Trajetória de Sucesso' }}</h3>
                    </div>
                    <div class="about-text">
                        {!! nl2br(e($contents['sobre-historia-texto']->value ?? 'Fundada em 2018 por um grupo de profissionais visionários e apaixonados pelo audiovisual, a Impacto Visual nasceu com uma missão clara: transformar ideias em histórias visuais memoráveis. O que começou como um estúdio boutique rapidamente se expandiu para uma produtora completa, especializada em conteúdo premium para marcas e empresas de todos os portes.

Nosso crescimento é resultado de uma filosofia centrada na excelência criativa e no compromisso com resultados mensuráveis. Combinamos expertise técnica com sensibilidade artística para desenvolver conteúdos que não apenas capturam a atenção, mas também geram engajamento genuíno e impulsionam o crescimento dos nossos clientes.

Hoje, somos reconhecidos no mercado pela nossa abordagem estratégica e pela capacidade de traduzir a essência de cada marca em narrativas audiovisuais autênticas e impactantes.')) !!}
                    </div>
                    <div class="about-features mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="bi bi-check-circle-fill text-gradient"></i>
                                    <span>+{{ $contents['contador-projetos']->value ?? '100' }} projetos entregues</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="bi bi-check-circle-fill text-gradient"></i>
                                    <span>+{{ $contents['contador-clientes']->value ?? '50' }} clientes satisfeitos</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="bi bi-check-circle-fill text-gradient"></i>
                                    <span>+{{ $contents['contador-anos']->value ?? '5' }} anos de experiência</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <i class="bi bi-check-circle-fill text-gradient"></i>
                                    <span>Atendimento nacional</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="mission-card">
                        <div class="mission-icon">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <h3>{{ $contents['missao-titulo']->value ?? 'Nossa Missão' }}</h3>
                        <p>{{ $contents['missao-texto']->value ?? 'Transformar ideias em experiências audiovisuais memoraveis que conectam marcas ao seu público, através de conteúdo estratégico, criativo e tecnicamente impecável, gerando impacto mensurável nos resultados de negócio de nossos clientes.' }}</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="mission-card">
                        <div class="mission-icon">
                            <i class="bi bi-eye"></i>
                        </div>
                        <h3>{{ $contents['visao-titulo']->value ?? 'Nossa Visão' }}</h3>
                        <p>{{ $contents['visao-texto']->value ?? 'Ser reconhecida como referência em storytelling audiovisual no Brasil, liderando inovações no setor, antecipando tendências de mercado e estabelecendo novos padrões de qualidade que inspiram a indústria e encantam nossos clientes.' }}</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="mission-card">
                        <div class="mission-icon">
                            <i class="bi bi-stars"></i>
                        </div>
                        <h3>{{ $contents['valores-titulo']->value ?? 'Nossos Valores' }}</h3>
                        <ul class="values-list">
                            @php
                                $valoresList = $contents['valores-texto']->value ?? "Excelência criativa e inovação constante\nCompromisso com resultados mensuráveis\nTransparência e ética em todas as relações\nColaboração e trabalho em equipe\nAdaptabilidade e aprendizado contínuo";
                                $valores = explode("\n", $valoresList);
                            @endphp
                            
                            @foreach($valores as $valor)
                                <li>{{ $valor }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4" data-aos="fade-up">
                <a href="#contato" class="btn btn-primary btn-lg">Vamos trabalhar juntos</a>
            </div>
            
            <div class="row mt-5">
                <h3 class="text-center mb-4" data-aos="fade-up">Por Que Escolher a Impacto Visual</h3>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="differential-card">
                        <div class="differential-icon">
                            <i class="bi {{ $contents['diferencial-card1-icone']->value ?? 'bi-person-check' }}"></i>
                        </div>
                        <h4>{{ $contents['diferencial-card1-titulo']->value ?? 'Abordagem Consultiva' }}</h4>
                        <p>{{ $contents['diferencial-card1-texto']->value ?? 'Não somos apenas executores, somos consultores estratégicos. Mergulhamos profundamente no seu negócio para entender seus objetivos, público e desafios, criando soluções audiovisuais que geram resultados tangveis e mensuráveis para sua marca.' }}</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="differential-card">
                        <div class="differential-icon">
                            <i class="bi {{ $contents['diferencial-card2-icone']->value ?? 'bi-lightning-charge' }}"></i>
                        </div>
                        <h4>{{ $contents['diferencial-card2-titulo']->value ?? 'Metodologia Ágil' }}</h4>
                        <p>{{ $contents['diferencial-card2-texto']->value ?? 'Nosso fluxo de trabalho otimizado combina eficiência e qualidade. Utilizamos metodologias ágeis que garantem comunicação transparente, entregas pontuais e flexibilidade para adaptações durante o processo, sem comprometer a excelência do resultado final.' }}</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="differential-card">
                        <div class="differential-icon">
                            <i class="bi {{ $contents['diferencial-card3-icone']->value ?? 'bi-graph-up' }}"></i>
                        </div>
                        <h4>{{ $contents['diferencial-card3-titulo']->value ?? 'Foco em Resultados' }}</h4>
                        <p>{{ $contents['diferencial-card3-texto']->value ?? 'Cada projeto é desenvolvido com objetivos claros de performance. Combinamos criatividade com estratégia de dados para criar conteúdos que não apenas impressionam visualmente, mas também impulsionam métricas importantes para o crescimento do seu negócio.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Serviços Section -->
    <section id="servicos" class="services-section">
        <div class="container">
            <h2 class="text-center mb-5">{{ $contents['servicos-titulo']->value ?? 'Nossos Serviços' }}</h2>
            <div class="row g-4">
                @forelse($services as $index => $service)
                    <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                        <div class="service-card {{ $service->is_highlighted ? 'service-card-highlight' : '' }}">
                            <i class="bi {{ $service->icon }} service-icon"></i>
                            <h3>{{ $service->title }}</h3>
                            <p>{{ $service->description }}</p>
                            @if($service->is_highlighted)
                                <a href="#contato" class="btn-service-cta">Solicitar orçamento <i class="bi bi-arrow-right"></i></a>
                            @else
                                <a href="#contato" class="btn-service-more">Saiba mais <i class="bi bi-arrow-right"></i></a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Nenhum serviço disponível no momento.</p>
                    </div>
                @endforelse
            </div>
            <div class="row mt-5">
                <div class="col-12 text-center" data-aos="fade-up" data-aos-delay="900">
                    <p class="service-tagline">{{ $contents['servicos-tagline']->value ?? 'Cada projeto é único. Vamos trabalhar juntos para encontrar a melhor solução para suas necessidades.' }}</p>
                    <a href="#contato" class="btn btn-primary btn-lg mt-3">Fale com nossa equipe</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfólio Section -->
    <section id="portfolio" class="portfolio-section">
        <div class="container">
            <h2 class="text-center mb-5">Nosso Portfólio</h2>
            <div class="row g-4">
                @forelse($portfolios as $portfolio)
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <div class="portfolio-item">
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $portfolio->youtube_embed_url }}" allowfullscreen></iframe>
                        </div>
                        <div class="portfolio-content">
                            <h3 class="portfolio-title">{{ $portfolio->title }}</h3>
                            @if($portfolio->description)
                            <p class="portfolio-description">{{ $portfolio->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-white">Nenhum item de portfólio disponível no momento.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Depoimentos Section -->
    <section id="depoimentos" class="testimonials-section">
        <div class="container">
            <h2 class="text-center mb-5">{{ $contents['depoimentos-titulo']->value ?? 'O Que Nossos Clientes Dizem' }}</h2>
            <div class="row">
                @forelse($testimonials as $testimonial)
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="testimonial-card">
                            <div class="testimonial-image">
                                @if($testimonial->image)
                                    <img src="{{ $testimonial->image_url }}" 
                                         alt="{{ $testimonial->name }}" 
                                         class="img-fluid rounded-circle"
                                         loading="lazy"
                                         width="100"
                                         height="100">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial->name) }}&background=random" 
                                         alt="{{ $testimonial->name }}" 
                                         class="img-fluid rounded-circle"
                                         loading="lazy"
                                         width="100"
                                         height="100">
                                @endif
                            </div>
                            <div class="testimonial-content">
                                <div class="testimonial-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $testimonial->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                                <p class="testimonial-text">"{{ $testimonial->testimonial }}"</p>
                                <div class="testimonial-author">
                                    <h5>{{ $testimonial->name }}</h5>
                                    <p>{{ $testimonial->position }}, {{ $testimonial->company }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Ainda não há depoimentos cadastrados.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Clientes Section -->
    <section id="clientes" class="clients-section">
        <div class="container">
            <h2 class="text-center mb-5">{{ $contents['clientes-titulo']->value ?? 'Empresas Que Confiam em Nós' }}</h2>
            <div class="client-logos" data-aos="fade-up">
                <div class="row align-items-center">
                    @forelse($clients as $client)
                    <div class="col-6 col-md-2 mb-4">
                        <div class="client-logo">
                            @if($client->website)
                            <a href="{{ $client->website }}" target="_blank" title="{{ $client->name }}">
                                <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" class="img-fluid">
                            </a>
                            @else
                            <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" class="img-fluid">
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center">
                        <p>Em breve, novos clientes serão adicionados.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Contato Section -->
    <section id="contato" class="contact-section">
        <div class="container">
            <h2 class="text-center mb-5">{{ $contents['contato-titulo']->value ?? 'Entre em Contato' }}</h2>
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact-form">
                        @if(session('success'))
                            <div class="alert alert-success mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger mb-4">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form action="{{ route('contact.send') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control text-white" placeholder="Seu Nome" value="{{ old('name') }}" style="background-color: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.2);" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control text-white" placeholder="Seu E-mail" value="{{ old('email') }}" style="background-color: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.2);" required>
                            </div>
                            <div class="mb-3">
                                <textarea name="message" class="form-control text-white" rows="5" placeholder="Sua Mensagem" style="background-color: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.2);" required>{{ old('message') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-whatsapp w-100" style="display: flex; justify-content: center; align-items: center;">Enviar Mensagem</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="contact-info">
                        <h4>Informações de Contato</h4>
                        <p><i class="bi bi-envelope"></i> {{ $settings['contact_email'] ?? ($contents['contato-email']->value ?? 'contato@impactovisual.com.br') }}</p>
                        <p><i class="bi bi-telephone"></i> {{ $settings['contact_phone'] ?? ($contents['contato-telefone']->value ?? '(11) 99999-9999') }}</p>
                        <p><i class="bi bi-geo-alt"></i> {{ $settings['contact_address'] ?? 'São Paulo, SP' }}</p>
                        <p><i class="bi bi-clock"></i> {{ $settings['contact_hours'] ?? 'Segunda a Sexta: 9h às 18h' }}</p>
                        <div class="mt-4">
                            <a href="{{ $settings['facebook_url'] ?? ($contents['contato-facebook']->value ?? '#') }}" class="social-icon" target="_blank"><i class="bi bi-facebook"></i></a>
                            <a href="{{ $settings['instagram_url'] ?? ($contents['contato-instagram']->value ?? '#') }}" class="social-icon" target="_blank"><i class="bi bi-instagram"></i></a>
                            <a href="{{ $settings['tiktok_url'] ?? ($contents['contato-tiktok']->value ?? '#') }}" class="social-icon" target="_blank"><i class="bi bi-tiktok"></i></a>
                            <a href="{{ $settings['youtube_url'] ?? ($contents['contato-youtube']->value ?? '#') }}" class="social-icon" target="_blank"><i class="bi bi-youtube"></i></a>
                            <a href="https://wa.me/{{ $settings['whatsapp_number'] ?? ($contents['hero-whatsapp-number']->value ?? '5511999999999') }}" class="social-icon" target="_blank"><i class="bi bi-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 text-center">
                    <p class="footer-text">{{ $contents['footer-copyright']->value ?? '&copy; ' . date('Y') . ' ' . ($settings['site_name'] ?? 'Impacto Visual') . '. Todos os direitos reservados.' }}</p>
                </div>
                <div class="col-12 text-center mt-3">
                    <a href="{{ $settings['facebook_url'] ?? ($contents['contato-facebook']->value ?? '#') }}" class="social-icon" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="{{ $settings['instagram_url'] ?? ($contents['contato-instagram']->value ?? '#') }}" class="social-icon" target="_blank"><i class="bi bi-instagram"></i></a>
                    <a href="{{ $settings['tiktok_url'] ?? ($contents['contato-tiktok']->value ?? '#') }}" class="social-icon" target="_blank"><i class="bi bi-tiktok"></i></a>
                    <a href="{{ $settings['youtube_url'] ?? ($contents['contato-youtube']->value ?? '#') }}" class="social-icon" target="_blank"><i class="bi bi-youtube"></i></a>
                    <a href="https://wa.me/{{ $settings['whatsapp_number'] ?? ($contents['hero-whatsapp-number']->value ?? '5511999999999') }}" class="social-icon" target="_blank"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollToPlugin.min.js"></script>
    <script>
        // Garantir que o vídeo inicie assim que possível
        window.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('hero-background-video');
            const playBtn = document.getElementById('play-btn');
            
            if (video) {
                // Forçar reprodução com múltiplas tentativas
                function playVideo() {
                    video.play().catch(error => {
                        console.log('Erro ao iniciar vídeo:', error);
                        if (playBtn) playBtn.style.display = 'flex';
                    });
                }
                
                // Tentar reproduzir o vídeo assim que possível
                playVideo();
                
                // Tentar novamente após um segundo
                setTimeout(playVideo, 1000);
                
                // Configurar botão de play manual
                if (playBtn) {
                    playBtn.addEventListener('click', function() {
                        video.play();
                        this.style.display = 'none';
                    });
                }
                
                // Garantir que a interação do usuário inicie o vídeo em navegadores restritivos
                document.body.addEventListener('click', function() {
                    if (video.paused) playVideo();
                }, {once: true});
            }
        });
        
        // Inicialização AOS (Animate on Scroll)
        AOS.init({
            duration: 800,
            once: true
        });

        // Preloader
        window.addEventListener('load', () => {
            const preloader = document.getElementById('preloader');
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        });

        // Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // SPA Navigation - Smooth Scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    // Fecha o menu mobile se estiver aberto
                    const navbarToggler = document.querySelector('.navbar-toggler');
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse.classList.contains('show')) {
                        navbarToggler.click();
                    }
                    
                    // Scroll suave usando GSAP
                    gsap.to(window, {
                        duration: 1, 
                        scrollTo: {
                            y: targetElement,
                            offsetY: 80
                        },
                        ease: "power2.inOut"
                    });
                    
                    // Atualiza URL sem recarregar a página (comportamento SPA)
                    history.pushState(null, null, targetId);
                }
            });
        });

        // Counter Animation
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = parseInt(counter.innerText);
            let count = 0;
            const duration = 2000;
            const increment = target / (duration / 16);

            function updateCount() {
                if (count < target) {
                    count += increment;
                    counter.innerText = Math.ceil(count) + '+';
                    requestAnimationFrame(updateCount);
                } else {
                    counter.innerText = target + '+';
                }
            }

            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    updateCount();
                    observer.unobserve(counter);
                }
            });

            observer.observe(counter);
        });

        // GSAP Animations
        gsap.from('.hero-shapes .shape', {
            duration: 1.5,
            opacity: 0,
            y: 100,
            stagger: 0.2,
            ease: 'power3.out'
        });
        
        // Active Section Highlight
        window.addEventListener('scroll', () => {
            const sections = document.querySelectorAll('section');
            const navLinks = document.querySelectorAll('.nav-link');
            
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                
                if (window.scrollY >= (sectionTop - 200)) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });

        // Script para controlar o vídeo no hero
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('hero-background-video');
            const playBtn = document.getElementById('play-btn');
            
            // Função para verificar se o vídeo está pausado e atualizar o ícone
            function updatePlayButton() {
                if (video.paused) {
                    playBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
                } else {
                    playBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
                }
            }
            
            // Verifica se o vídeo carregou e está reproduzindo
            video.addEventListener('playing', function() {
                playBtn.style.display = 'flex';
                updatePlayButton();
            });
            
            // Evento de clique no botão de play/pause
            playBtn.addEventListener('click', function() {
                if (video.paused) {
                    video.play();
                } else {
                    video.pause();
                }
                updatePlayButton();
            });
            
            // Fallback para dispositivos móveis que podem não reproduzir automaticamente
            if (video.paused) {
                playBtn.style.display = 'flex';
            }
        });
    </script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
