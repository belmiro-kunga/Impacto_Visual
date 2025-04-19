// Aplicação principal
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar todos os componentes
    initNavbar();
    initScrollNavigation();
    initParallaxEffects();
    initCounterAnimations();
    initScrollToTop();
    initServiceCards();
    initPortfolioInteractions();
    initSocialIcons();
    initContactForm();
    initVideoPlayer();
});

// ===== NAVBAR FUNCTIONS =====
function initNavbar() {
    window.addEventListener('scroll', handleNavbarScroll);
}

function handleNavbarScroll() {
    const navbar = document.querySelector('.navbar');
    const threshold = 50;
    
    if (window.scrollY > threshold) {
        navbar.classList.add('scrolled');
        animateNavbarScroll(true);
    } else {
        navbar.classList.remove('scrolled');
        animateNavbarScroll(false);
    }
}

function animateNavbarScroll(isScrolled) {
    if (typeof gsap === 'undefined') return;
    
    if (isScrolled) {
        gsap.to('.navbar', {
            backgroundColor: 'rgba(255, 255, 255, 0.98)',
            boxShadow: '0 4px 20px rgba(0, 0, 0, 0.1), 0 0 15px rgba(79, 70, 229, 0.1)',
            padding: '0.75rem 0',
            duration: 0.4,
            ease: 'power2.out'
        });
        
        gsap.to('.navbar-brand', {
            color: 'var(--primary-color)',
            fontSize: '1.35rem',
            duration: 0.4,
            ease: 'power2.out'
        });
        
        gsap.to('.nav-link', {
            color: 'var(--dark-color)',
            duration: 0.4,
            ease: 'power2.out'
        });
    } else {
        gsap.to('.navbar', {
            backgroundColor: 'transparent',
            boxShadow: 'none',
            padding: '1.5rem 0',
            duration: 0.4,
            ease: 'power2.out'
        });
        
        gsap.to('.navbar-brand', {
            color: 'var(--text-color)',
            fontSize: '1.5rem',
            duration: 0.4,
            ease: 'power2.out'
        });
        
        gsap.to('.nav-link', {
            color: 'var(--text-color)',
            duration: 0.4,
            ease: 'power2.out'
        });
    }
}

// ===== SCROLL NAVIGATION =====
function initScrollNavigation() {
    setupSmoothScrolling();
    setupActiveNavHighlight();
}

function setupSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                closeMenuIfOpen();
                updateActiveNavLink(this);
                scrollToElement(targetElement);
                updatePageUrl(targetId);
            }
        });
    });
}

function closeMenuIfOpen() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    if (navbarCollapse.classList.contains('show')) {
        navbarToggler.click();
    }
}

function updateActiveNavLink(currentLink) {
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
    });
    currentLink.classList.add('active');
}

function scrollToElement(element) {
    if (typeof gsap !== 'undefined' && gsap.to) {
        gsap.to(window, {
            duration: 1, 
            scrollTo: {
                y: element,
                offsetY: 80
            },
            ease: "power2.inOut"
        });
    } else {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function updatePageUrl(targetId) {
    history.pushState(null, null, targetId);
}

function setupActiveNavHighlight() {
    window.addEventListener('scroll', highlightActiveSection);
}

function highlightActiveSection() {
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.nav-link');
    
    let currentSection = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        
        if (window.scrollY >= (sectionTop - 200)) {
            currentSection = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${currentSection}`) {
            link.classList.add('active');
        }
    });
}

// ===== PARALLAX EFFECTS =====
function initParallaxEffects() {
    document.addEventListener('mousemove', handleParallax);
}

function handleParallax(e) {
    const shapes = document.querySelectorAll('.hero-shapes .shape');
    if (!shapes.length || typeof gsap === 'undefined') return;
    
    const x = e.clientX / window.innerWidth;
    const y = e.clientY / window.innerHeight;

    shapes.forEach((shape, index) => {
        const speed = (index + 1) * 2;
        gsap.to(shape, {
            duration: 0.5,
            x: x * speed * 50,
            y: y * speed * 50,
            ease: 'power2.out'
        });
    });
}

// ===== COUNTER ANIMATIONS =====
function initCounterAnimations() {
    const counterElements = document.querySelectorAll('.counter');
    if (!counterElements.length) return;
    
    const counterObserver = createCounterObserver();
    counterElements.forEach(counter => {
        counterObserver.observe(counter);
    });
}

function createCounterObserver() {
    return new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-target') || counter.innerText);
                animateCounter(counter, target);
                counterObserver.unobserve(counter);
            }
        });
    }, { threshold: 0.5 });
}

function animateCounter(element, endValue) {
    // Remover o sinal "+" do texto para evitar problemas
    const cleanValue = parseInt(endValue);
    
    if (typeof gsap === 'undefined') {
        element.textContent = cleanValue + '+';
        return;
    }
    
    gsap.to(element, {
        textContent: cleanValue,
        duration: 2,
        ease: 'power1.out',
        snap: { textContent: 1 },
        stagger: {
            each: 0.15,
            onUpdate: function() {
                element.textContent = Math.ceil(element.textContent) + '+';
            },
        }
    });
}

// ===== CONTACT FORM =====
function initContactForm() {
    const form = document.querySelector('form');
    if (!form) return;
    
    form.addEventListener('submit', handleFormSubmit);
}

function handleFormSubmit(e) {
    e.preventDefault();
    
    const form = this;
    const name = form.querySelector('input[type="text"]');
    const email = form.querySelector('input[type="email"]');
    const message = form.querySelector('textarea');
    
    if (validateForm(name, email, message)) {
        submitForm(form);
    }
}

function validateForm(name, email, message) {
    let isValid = true;
    
    if (!name.value.trim()) {
        showError(name, 'Por favor, insira seu nome');
        isValid = false;
    } else {
        removeError(name);
    }
    
    if (!email.value.trim() || !isValidEmail(email.value)) {
        showError(email, 'Por favor, insira um e-mail válido');
        isValid = false;
    } else {
        removeError(email);
    }
    
    if (!message.value.trim()) {
        showError(message, 'Por favor, insira sua mensagem');
        isValid = false;
    } else {
        removeError(message);
    }
    
    return isValid;
}

function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function showError(element, message) {
    const formGroup = element.parentElement;
    const errorElement = formGroup.querySelector('.error-message') || document.createElement('div');
    errorElement.className = 'error-message text-danger mt-1';
    errorElement.textContent = message;
    
    if (!formGroup.querySelector('.error-message')) {
        formGroup.appendChild(errorElement);
    }
    
    element.classList.add('is-invalid');
}

function removeError(element) {
    const formGroup = element.parentElement;
    const errorElement = formGroup.querySelector('.error-message');
    
    if (errorElement) {
        formGroup.removeChild(errorElement);
    }
    
    element.classList.remove('is-invalid');
}

function submitForm(form) {
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    // Show loading state
    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...';
    submitButton.disabled = true;
    
    // Simulate form submission (Replace with actual AJAX call in production)
    setTimeout(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
        showSuccessMessage('Mensagem enviada com sucesso!');
        form.reset();
    }, 2000);
}

function showSuccessMessage(message) {
    const alert = document.createElement('div');
    alert.className = 'alert alert-success alert-dismissible fade show';
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    const form = document.querySelector('form');
    form.parentElement.insertBefore(alert, form);
    
    setTimeout(() => {
        alert.classList.remove('show');
        setTimeout(() => alert.remove(), 150);
    }, 3000);
}

// ===== SCROLL TO TOP =====
function initScrollToTop() {
    createScrollTopButton();
    setupScrollTopEvents();
}

function createScrollTopButton() {
    // Check if button already exists
    if (document.querySelector('.scroll-to-top')) return;
    
    const scrollToTopButton = document.createElement('button');
    scrollToTopButton.className = 'scroll-to-top';
    scrollToTopButton.innerHTML = '<i class="bi bi-chevron-up"></i>';
    scrollToTopButton.setAttribute('title', 'Voltar ao topo');
    scrollToTopButton.setAttribute('aria-label', 'Voltar ao topo da página');
    document.body.appendChild(scrollToTopButton);
}

function setupScrollTopEvents() {
    const scrollToTopButton = document.querySelector('.scroll-to-top');
    if (!scrollToTopButton) return;
    
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            scrollToTopButton.classList.add('visible');
        } else {
            scrollToTopButton.classList.remove('visible');
        }
    });
    
    scrollToTopButton.addEventListener('click', scrollToTop);
}

function scrollToTop() {
    if (typeof gsap !== 'undefined' && gsap.to) {
        gsap.to(window, {
            duration: 1,
            scrollTo: {
                y: 0,
                autoKill: false
            },
            ease: "power2.inOut"
        });
    } else {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
}

// ===== SERVICE CARDS =====
function initServiceCards() {
    const serviceCards = document.querySelectorAll('.service-card');
    if (!serviceCards.length) return;
    
    const observer = createServiceCardObserver();
    
    serviceCards.forEach(card => {
        prepareCardForAnimation(card);
        observer.observe(card);
    });
}

function prepareCardForAnimation(card) {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'all 0.5s ease';
}

function createServiceCardObserver() {
    return new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
}

// ===== PORTFOLIO INTERACTIONS =====
function initPortfolioInteractions() {
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    if (!portfolioItems.length) return;
    
    portfolioItems.forEach(item => {
        setupPortfolioHoverEffect(item);
    });
}

function setupPortfolioHoverEffect(item) {
    const iframe = item.querySelector('iframe');
    if (!iframe) return;
    
    item.addEventListener('mouseenter', () => {
        iframe.style.transform = 'scale(1.05)';
    });
    
    item.addEventListener('mouseleave', () => {
        iframe.style.transform = 'scale(1)';
    });
}

// ===== SOCIAL ICONS =====
function initSocialIcons() {
    const socialIcons = document.querySelectorAll('.social-icon');
    if (!socialIcons.length) return;
    
    socialIcons.forEach(icon => {
        setupSocialIconHoverEffect(icon);
    });
}

function setupSocialIconHoverEffect(icon) {
    icon.addEventListener('mouseenter', () => {
        icon.style.transform = 'translateY(-3px) scale(1.2)';
    });
    
    icon.addEventListener('mouseleave', () => {
        icon.style.transform = 'translateY(0) scale(1)';
    });
}

// ===== VIDEO PLAYER =====
function initVideoPlayer() {
    const video = document.getElementById('hero-background-video');
    const fallbackBg = document.querySelector('.hero-fallback-bg');
    const playBtn = document.getElementById('play-btn');
    
    if (!video) return;
    
    setupVideoEvents(video, fallbackBg, playBtn);
}

function setupVideoEvents(video, fallbackBg, playBtn) {
    // Handle loading errors
    video.addEventListener('error', () => {
        showVideoFallback(fallbackBg);
    });
    
    // Attempt to play when loaded
    video.addEventListener('loadeddata', () => {
        playVideo(video, playBtn);
    });
    
    // Check if already loaded
    if (video.readyState >= 2) {
        playVideo(video, playBtn);
    }
    
    // Check playback after a delay
    setTimeout(() => {
        if (video.paused) {
            playVideo(video, playBtn);
            
            // Final check
            setTimeout(() => {
                if (video.paused && playBtn) {
                    playBtn.style.display = 'flex';
                }
            }, 1000);
        }
    }, 1500);
    
    // Handle manual play button
    if (playBtn) {
        playBtn.addEventListener('click', () => {
            playVideo(video, playBtn);
            playBtn.style.display = 'none';
        });
    }
    
    // Handle pause event
    video.addEventListener('pause', () => {
        if (!video.ended && playBtn) {
            playBtn.style.display = 'flex';
        }
    });
    
    // Loop video
    video.addEventListener('ended', () => {
        video.currentTime = 0;
        playVideo(video, playBtn);
    });
    
    // Enable one-time click to play (for mobile)
    document.addEventListener('click', () => {
        if (video.paused) {
            playVideo(video, playBtn);
        }
    }, { once: true });
}

function playVideo(video, playBtn) {
    video.muted = true; // Required for autoplay on most browsers
    
    const playPromise = video.play();
    
    if (playPromise !== undefined) {
        playPromise.then(() => {
            if (playBtn) playBtn.style.display = 'none';
        }).catch(error => {
            console.log('Error playing video:', error);
            if (playBtn) playBtn.style.display = 'flex';
        });
    }
}

function showVideoFallback(fallbackBg) {
    if (fallbackBg) {
        fallbackBg.style.opacity = '1';
    }
    document.querySelector('.hero-section')?.classList.add('video-error');
} 