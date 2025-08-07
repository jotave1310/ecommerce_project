/**
 * E-commerce Project - Animações e Interatividade
 * Sistema avançado de animações e micro-interações
 */

class EcommerceAnimations {
    constructor() {
        this.init();
        this.setupEventListeners();
        this.initializeAnimations();
        this.setupIntersectionObserver();
        this.setupParallaxEffects();
        this.setupSmoothScrolling();
        this.setupLoadingAnimations();
        this.setupMicroInteractions();
    }

    init() {
        // Configurações globais
        this.isReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        this.isMobile = window.innerWidth <= 768;
        this.scrollPosition = 0;
        this.ticking = false;
        
        // Cache de elementos DOM
        this.elements = {
            header: document.querySelector('header'),
            productCards: document.querySelectorAll('.product-card'),
            buttons: document.querySelectorAll('.btn'),
            forms: document.querySelectorAll('form'),
            inputs: document.querySelectorAll('input, textarea, select'),
            cartIcon: document.querySelector('.cart-icon'),
            logo: document.querySelector('.logo'),
            navLinks: document.querySelectorAll('nav a'),
            hero: document.querySelector('.hero'),
            preloader: document.querySelector('.preloader')
        };

        // Criar preloader se não existir
        if (!this.elements.preloader) {
            this.createPreloader();
        }
    }

    createPreloader() {
        const preloader = document.createElement('div');
        preloader.className = 'preloader';
        preloader.innerHTML = `
            <div class="spinner"></div>
            <div class="preloader-text">Carregando experiência incrível...</div>
        `;
        document.body.appendChild(preloader);
        this.elements.preloader = preloader;
    }

    setupEventListeners() {
        // Scroll events
        window.addEventListener('scroll', this.handleScroll.bind(this), { passive: true });
        
        // Resize events
        window.addEventListener('resize', this.handleResize.bind(this));
        
        // Load events
        window.addEventListener('load', this.handleLoad.bind(this));
        
        // Mouse events para efeitos de cursor
        document.addEventListener('mousemove', this.handleMouseMove.bind(this));
        
        // Touch events para dispositivos móveis
        document.addEventListener('touchstart', this.handleTouchStart.bind(this), { passive: true });
        
        // Visibility change para pausar animações quando tab não está ativa
        document.addEventListener('visibilitychange', this.handleVisibilityChange.bind(this));
    }

    initializeAnimations() {
        // Animações de entrada para elementos
        this.animateOnLoad();
        
        // Configurar animações de hover para cards
        this.setupCardAnimations();
        
        // Configurar animações de botões
        this.setupButtonAnimations();
        
        // Configurar animações de formulários
        this.setupFormAnimations();
        
        // Configurar animações de navegação
        this.setupNavigationAnimations();
    }

    animateOnLoad() {
        if (this.isReducedMotion) return;

        // Animar elementos com delay escalonado
        const elementsToAnimate = document.querySelectorAll('.fade-in, .product-card, .hero, h1, h2');
        
        elementsToAnimate.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                element.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }

    setupCardAnimations() {
        this.elements.productCards.forEach(card => {
            // Efeito de hover 3D
            card.addEventListener('mouseenter', (e) => {
                if (this.isReducedMotion) return;
                
                card.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                card.style.transform = 'translateY(-15px) rotateX(5deg) scale(1.02)';
                
                // Efeito de brilho
                this.addShineEffect(card);
                
                // Animar imagem do produto
                const productImage = card.querySelector('.product-image');
                if (productImage) {
                    productImage.style.transform = 'scale(1.05)';
                }
            });

            card.addEventListener('mouseleave', (e) => {
                if (this.isReducedMotion) return;
                
                card.style.transform = 'translateY(0) rotateX(0) scale(1)';
                
                // Resetar imagem do produto
                const productImage = card.querySelector('.product-image');
                if (productImage) {
                    productImage.style.transform = 'scale(1)';
                }
                
                // Remover efeito de brilho
                this.removeShineEffect(card);
            });

            // Efeito de clique
            card.addEventListener('mousedown', (e) => {
                if (this.isReducedMotion) return;
                card.style.transform = 'translateY(-10px) rotateX(2deg) scale(1.01)';
            });

            card.addEventListener('mouseup', (e) => {
                if (this.isReducedMotion) return;
                card.style.transform = 'translateY(-15px) rotateX(5deg) scale(1.02)';
            });
        });
    }

    addShineEffect(element) {
        const shine = document.createElement('div');
        shine.className = 'shine-effect';
        shine.style.cssText = `
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
            pointer-events: none;
            z-index: 1;
        `;
        
        element.style.position = 'relative';
        element.appendChild(shine);
        
        // Trigger animation
        setTimeout(() => {
            shine.style.left = '100%';
        }, 50);
        
        // Remove after animation
        setTimeout(() => {
            if (shine.parentNode) {
                shine.parentNode.removeChild(shine);
            }
        }, 650);
    }

    removeShineEffect(element) {
        const shine = element.querySelector('.shine-effect');
        if (shine) {
            shine.remove();
        }
    }

    setupButtonAnimations() {
        this.elements.buttons.forEach(button => {
            // Efeito ripple
            button.addEventListener('click', (e) => {
                if (this.isReducedMotion) return;
                this.createRippleEffect(e, button);
            });

            // Efeito de hover
            button.addEventListener('mouseenter', (e) => {
                if (this.isReducedMotion) return;
                
                button.style.transform = 'translateY(-3px) scale(1.02)';
                
                // Adicionar partículas ao redor do botão
                this.addButtonParticles(button);
            });

            button.addEventListener('mouseleave', (e) => {
                if (this.isReducedMotion) return;
                button.style.transform = 'translateY(0) scale(1)';
            });
        });
    }

    createRippleEffect(event, element) {
        const ripple = document.createElement('span');
        const rect = element.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s ease-out;
            pointer-events: none;
            z-index: 1;
        `;
        
        element.style.position = 'relative';
        element.style.overflow = 'hidden';
        element.appendChild(ripple);
        
        // Adicionar keyframes se não existirem
        if (!document.querySelector('#ripple-keyframes')) {
            const style = document.createElement('style');
            style.id = 'ripple-keyframes';
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(2);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    addButtonParticles(button) {
        if (this.isMobile) return;
        
        const particleCount = 6;
        const rect = button.getBoundingClientRect();
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'button-particle';
            particle.style.cssText = `
                position: fixed;
                width: 4px;
                height: 4px;
                background: var(--primary-color);
                border-radius: 50%;
                pointer-events: none;
                z-index: 1000;
                left: ${rect.left + rect.width / 2}px;
                top: ${rect.top + rect.height / 2}px;
                animation: particle-float 2s ease-out forwards;
            `;
            
            // Direção aleatória
            const angle = (i / particleCount) * Math.PI * 2;
            const distance = 30 + Math.random() * 20;
            const endX = Math.cos(angle) * distance;
            const endY = Math.sin(angle) * distance;
            
            particle.style.setProperty('--end-x', `${endX}px`);
            particle.style.setProperty('--end-y', `${endY}px`);
            
            document.body.appendChild(particle);
            
            setTimeout(() => {
                particle.remove();
            }, 2000);
        }
        
        // Adicionar keyframes para partículas
        if (!document.querySelector('#particle-keyframes')) {
            const style = document.createElement('style');
            style.id = 'particle-keyframes';
            style.textContent = `
                @keyframes particle-float {
                    0% {
                        transform: translate(0, 0) scale(1);
                        opacity: 1;
                    }
                    100% {
                        transform: translate(var(--end-x), var(--end-y)) scale(0);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }

    setupFormAnimations() {
        this.elements.inputs.forEach(input => {
            // Efeito de foco
            input.addEventListener('focus', (e) => {
                if (this.isReducedMotion) return;
                
                input.style.transform = 'translateY(-2px)';
                
                // Adicionar efeito de onda
                this.addInputWaveEffect(input);
            });

            input.addEventListener('blur', (e) => {
                if (this.isReducedMotion) return;
                input.style.transform = 'translateY(0)';
            });

            // Efeito de digitação
            input.addEventListener('input', (e) => {
                if (this.isReducedMotion) return;
                this.addTypingEffect(input);
            });
        });
    }

    addInputWaveEffect(input) {
        const wave = document.createElement('div');
        wave.className = 'input-wave';
        wave.style.cssText = `
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        `;
        
        const parent = input.parentNode;
        parent.style.position = 'relative';
        parent.appendChild(wave);
        
        setTimeout(() => {
            wave.style.width = '100%';
        }, 50);
        
        input.addEventListener('blur', () => {
            wave.style.width = '0';
            setTimeout(() => {
                if (wave.parentNode) {
                    wave.remove();
                }
            }, 300);
        }, { once: true });
    }

    addTypingEffect(input) {
        input.style.boxShadow = '0 0 20px rgba(233, 69, 96, 0.3)';
        
        clearTimeout(input.typingTimeout);
        input.typingTimeout = setTimeout(() => {
            input.style.boxShadow = '';
        }, 500);
    }

    setupNavigationAnimations() {
        // Animação do logo
        if (this.elements.logo) {
            this.elements.logo.addEventListener('mouseenter', () => {
                if (this.isReducedMotion) return;
                this.elements.logo.style.transform = 'translateY(-2px) scale(1.05)';
            });

            this.elements.logo.addEventListener('mouseleave', () => {
                if (this.isReducedMotion) return;
                this.elements.logo.style.transform = 'translateY(0) scale(1)';
            });
        }

        // Animação dos links de navegação
        this.elements.navLinks.forEach((link, index) => {
            link.addEventListener('mouseenter', () => {
                if (this.isReducedMotion) return;
                
                link.style.transform = 'translateY(-2px)';
                
                // Efeito de onda nos outros links
                this.elements.navLinks.forEach((otherLink, otherIndex) => {
                    if (otherIndex !== index) {
                        const distance = Math.abs(otherIndex - index);
                        const delay = distance * 50;
                        
                        setTimeout(() => {
                            otherLink.style.transform = 'translateY(-1px)';
                            setTimeout(() => {
                                otherLink.style.transform = 'translateY(0)';
                            }, 150);
                        }, delay);
                    }
                });
            });

            link.addEventListener('mouseleave', () => {
                if (this.isReducedMotion) return;
                link.style.transform = 'translateY(0)';
            });
        });

        // Animação do carrinho
        if (this.elements.cartIcon) {
            this.elements.cartIcon.addEventListener('mouseenter', () => {
                if (this.isReducedMotion) return;
                this.elements.cartIcon.style.transform = 'translateY(-3px) scale(1.05)';
                this.addCartBounce();
            });

            this.elements.cartIcon.addEventListener('mouseleave', () => {
                if (this.isReducedMotion) return;
                this.elements.cartIcon.style.transform = 'translateY(0) scale(1)';
            });
        }
    }

    addCartBounce() {
        const cartCount = this.elements.cartIcon.querySelector('.cart-count');
        if (cartCount) {
            cartCount.style.animation = 'none';
            setTimeout(() => {
                cartCount.style.animation = 'cartBounce 0.6s ease';
            }, 10);
        }
    }

    setupIntersectionObserver() {
        if (!window.IntersectionObserver) return;

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateElement(entry.target);
                }
            });
        }, observerOptions);

        // Observar elementos que devem animar ao entrar na viewport
        const elementsToObserve = document.querySelectorAll('.product-card, .hero, h2, form, table');
        elementsToObserve.forEach(element => {
            observer.observe(element);
        });
    }

    animateElement(element) {
        if (this.isReducedMotion) return;

        element.classList.add('animate-in');
        
        // Adicionar classe CSS se não existir
        if (!document.querySelector('#animate-in-styles')) {
            const style = document.createElement('style');
            style.id = 'animate-in-styles';
            style.textContent = `
                .animate-in {
                    animation: slideInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
                }
                
                @keyframes slideInUp {
                    from {
                        opacity: 0;
                        transform: translateY(30px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }

    setupParallaxEffects() {
        if (this.isMobile || this.isReducedMotion) return;

        // Efeito parallax no hero
        if (this.elements.hero) {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const parallax = scrolled * 0.5;
                
                this.elements.hero.style.transform = `translateY(${parallax}px)`;
            }, { passive: true });
        }

        // Efeito parallax nas imagens dos produtos
        this.elements.productCards.forEach(card => {
            const image = card.querySelector('.product-image');
            if (image) {
                window.addEventListener('scroll', () => {
                    const rect = card.getBoundingClientRect();
                    const scrolled = window.pageYOffset;
                    const rate = scrolled * -0.1;
                    
                    if (rect.top < window.innerHeight && rect.bottom > 0) {
                        image.style.transform = `translateY(${rate}px)`;
                    }
                }, { passive: true });
            }
        });
    }

    setupSmoothScrolling() {
        // Smooth scroll para links internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(anchor.getAttribute('href'));
                
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    setupLoadingAnimations() {
        // Simular carregamento e remover preloader
        window.addEventListener('load', () => {
            setTimeout(() => {
                if (this.elements.preloader) {
                    this.elements.preloader.classList.add('hidden');
                    
                    setTimeout(() => {
                        this.elements.preloader.remove();
                    }, 500);
                }
                
                // Iniciar animações de entrada
                this.startEntryAnimations();
            }, 1000);
        });
    }

    startEntryAnimations() {
        if (this.isReducedMotion) return;

        // Animar header
        if (this.elements.header) {
            this.elements.header.style.transform = 'translateY(-100%)';
            setTimeout(() => {
                this.elements.header.style.transition = 'transform 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                this.elements.header.style.transform = 'translateY(0)';
            }, 200);
        }

        // Animar conteúdo principal
        const mainContent = document.querySelector('main');
        if (mainContent) {
            mainContent.style.opacity = '0';
            mainContent.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                mainContent.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
                mainContent.style.opacity = '1';
                mainContent.style.transform = 'translateY(0)';
            }, 400);
        }
    }

    setupMicroInteractions() {
        // Efeito de cursor personalizado
        this.setupCustomCursor();
        
        // Efeitos de hover em elementos interativos
        this.setupHoverEffects();
        
        // Animações de loading em formulários
        this.setupFormLoadingStates();
        
        // Efeitos de feedback visual
        this.setupFeedbackEffects();
    }

    setupCustomCursor() {
        if (this.isMobile) return;

        const cursor = document.createElement('div');
        cursor.className = 'custom-cursor';
        cursor.style.cssText = `
            position: fixed;
            width: 20px;
            height: 20px;
            background: var(--primary-color);
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            transition: all 0.1s ease;
            opacity: 0;
            transform: translate(-50%, -50%);
        `;
        
        document.body.appendChild(cursor);

        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
            cursor.style.opacity = '0.6';
        });

        document.addEventListener('mouseenter', () => {
            cursor.style.opacity = '0.6';
        });

        document.addEventListener('mouseleave', () => {
            cursor.style.opacity = '0';
        });

        // Expandir cursor em elementos interativos
        const interactiveElements = document.querySelectorAll('a, button, .btn, .product-card');
        interactiveElements.forEach(element => {
            element.addEventListener('mouseenter', () => {
                cursor.style.transform = 'translate(-50%, -50%) scale(2)';
                cursor.style.opacity = '0.3';
            });

            element.addEventListener('mouseleave', () => {
                cursor.style.transform = 'translate(-50%, -50%) scale(1)';
                cursor.style.opacity = '0.6';
            });
        });
    }

    setupHoverEffects() {
        // Efeito de magnetismo em botões
        this.elements.buttons.forEach(button => {
            button.addEventListener('mousemove', (e) => {
                if (this.isMobile || this.isReducedMotion) return;
                
                const rect = button.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                
                button.style.transform = `translate(${x * 0.1}px, ${y * 0.1}px) translateY(-3px) scale(1.02)`;
            });

            button.addEventListener('mouseleave', () => {
                if (this.isReducedMotion) return;
                button.style.transform = 'translate(0, 0) translateY(0) scale(1)';
            });
        });
    }

    setupFormLoadingStates() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitButton) {
                    this.addLoadingState(submitButton);
                }
            });
        });
    }

    addLoadingState(button) {
        const originalText = button.textContent;
        button.textContent = 'Processando...';
        button.disabled = true;
        
        // Adicionar spinner
        const spinner = document.createElement('span');
        spinner.className = 'loading-spinner';
        spinner.style.cssText = `
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 8px;
        `;
        
        button.appendChild(spinner);
        
        // Simular processamento (remover em produção)
        setTimeout(() => {
            button.textContent = originalText;
            button.disabled = false;
            spinner.remove();
        }, 2000);
    }

    setupFeedbackEffects() {
        // Efeito de sucesso em formulários
        const inputs = document.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('change', () => {
                if (input.value && input.checkValidity()) {
                    this.addSuccessEffect(input);
                }
            });
        });
    }

    addSuccessEffect(element) {
        element.style.borderColor = '#28a745';
        element.style.boxShadow = '0 0 10px rgba(40, 167, 69, 0.3)';
        
        setTimeout(() => {
            element.style.borderColor = '';
            element.style.boxShadow = '';
        }, 2000);
    }

    handleScroll() {
        if (!this.ticking) {
            requestAnimationFrame(() => {
                this.updateScrollEffects();
                this.ticking = false;
            });
            this.ticking = true;
        }
    }

    updateScrollEffects() {
        const scrolled = window.pageYOffset;
        
        // Efeito no header
        if (this.elements.header) {
            if (scrolled > 100) {
                this.elements.header.classList.add('scrolled');
            } else {
                this.elements.header.classList.remove('scrolled');
            }
        }
        
        // Efeito parallax no background
        if (!this.isMobile && !this.isReducedMotion) {
            document.body.style.backgroundPosition = `center ${scrolled * 0.5}px`;
        }
    }

    handleResize() {
        this.isMobile = window.innerWidth <= 768;
        
        // Reconfigurar efeitos baseados no tamanho da tela
        if (this.isMobile) {
            this.disableDesktopEffects();
        } else {
            this.enableDesktopEffects();
        }
    }

    handleLoad() {
        // Otimizar performance após carregamento
        this.optimizeAnimations();
    }

    handleMouseMove(e) {
        if (this.isMobile) return;
        
        // Efeito de movimento do background baseado no mouse
        const x = e.clientX / window.innerWidth;
        const y = e.clientY / window.innerHeight;
        
        document.body.style.backgroundPosition = `${50 + x * 5}% ${50 + y * 5}%`;
    }

    handleTouchStart(e) {
        // Adicionar feedback tátil em dispositivos móveis
        if (e.target.matches('.btn, button, a, .product-card')) {
            e.target.style.transform = 'scale(0.98)';
            
            setTimeout(() => {
                e.target.style.transform = '';
            }, 150);
        }
    }

    handleVisibilityChange() {
        if (document.hidden) {
            this.pauseAnimations();
        } else {
            this.resumeAnimations();
        }
    }

    disableDesktopEffects() {
        // Desabilitar efeitos pesados em mobile
        const customCursor = document.querySelector('.custom-cursor');
        if (customCursor) {
            customCursor.style.display = 'none';
        }
    }

    enableDesktopEffects() {
        // Reabilitar efeitos em desktop
        const customCursor = document.querySelector('.custom-cursor');
        if (customCursor) {
            customCursor.style.display = 'block';
        }
    }

    pauseAnimations() {
        document.body.style.animationPlayState = 'paused';
    }

    resumeAnimations() {
        document.body.style.animationPlayState = 'running';
    }

    optimizeAnimations() {
        // Otimizações de performance
        if (this.isReducedMotion) {
            this.disableAllAnimations();
        }
        
        // Usar will-change para elementos que serão animados
        this.elements.productCards.forEach(card => {
            card.style.willChange = 'transform';
        });
        
        this.elements.buttons.forEach(button => {
            button.style.willChange = 'transform';
        });
    }

    disableAllAnimations() {
        const style = document.createElement('style');
        style.textContent = `
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        `;
        document.head.appendChild(style);
    }

    // Método público para adicionar animação a novos elementos
    animateNewElement(element, animationType = 'fadeIn') {
        if (this.isReducedMotion) return;
        
        const animations = {
            fadeIn: 'fadeInUp 0.6s ease-out',
            slideIn: 'slideInLeft 0.6s ease-out',
            bounce: 'bounceIn 0.8s ease-out',
            zoom: 'zoomIn 0.5s ease-out'
        };
        
        element.style.animation = animations[animationType] || animations.fadeIn;
    }

    // Método público para trigger de animações customizadas
    triggerAnimation(selector, animationType) {
        const elements = document.querySelectorAll(selector);
        elements.forEach((element, index) => {
            setTimeout(() => {
                this.animateNewElement(element, animationType);
            }, index * 100);
        });
    }
}

// Inicializar quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    window.ecommerceAnimations = new EcommerceAnimations();
});

// Adicionar keyframes CSS necessários
const animationStyles = document.createElement('style');
animationStyles.textContent = `
    @keyframes bounceIn {
        0% { transform: scale(0.3); opacity: 0; }
        50% { transform: scale(1.05); }
        70% { transform: scale(0.9); }
        100% { transform: scale(1); opacity: 1; }
    }
    
    @keyframes zoomIn {
        0% { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    @keyframes slideInLeft {
        0% { transform: translateX(-100px); opacity: 0; }
        100% { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes cartBounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-10px); }
        60% { transform: translateY(-5px); }
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
`;

document.head.appendChild(animationStyles);

// Exportar para uso global
window.EcommerceAnimations = EcommerceAnimations;

