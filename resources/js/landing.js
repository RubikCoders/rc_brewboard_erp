// Landing Page Interactive JavaScript
// Optimized for performance and user experience

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all interactive features
    initializeNavigation();
    initializeScrollAnimations();
    initializeFormEnhancements();
    initializeStatCounters();
    initializeLazyLoading();
    initializeAnalytics();
});

/**
 * Navigation Enhancement
 * Handles mobile menu, scroll behavior, and active states
 */
function initializeNavigation() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const navbar = document.querySelector('nav');
    
    // Mobile menu toggle
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            const isOpen = !mobileMenu.classList.contains('hidden');
            
            if (isOpen) {
                // Close menu
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                // Reset icon
                mobileMenuButton.innerHTML = `
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                `;
            } else {
                // Open menu
                mobileMenu.classList.remove('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'true');
                // Change to close icon
                mobileMenuButton.innerHTML = `
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                `;
            }
        });
        
        // Close mobile menu when clicking on links
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                mobileMenuButton.innerHTML = `
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                `;
            });
        });
    }
    
    // Navbar scroll behavior
    let lastScrollY = window.scrollY;
    
    function handleNavbarScroll() {
        const currentScrollY = window.scrollY;
        
        if (navbar) {
            if (currentScrollY > 100) {
                navbar.classList.add('bg-white/95', 'backdrop-blur-sm', 'shadow-sm');
            } else {
                navbar.classList.remove('bg-white/95', 'backdrop-blur-sm', 'shadow-sm');
            }
        }
        
        lastScrollY = currentScrollY;
    }
    
    // Throttled scroll listener for better performance
    let ticking = false;
    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(function() {
                handleNavbarScroll();
                ticking = false;
            });
            ticking = true;
        }
    });
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            
            if (target) {
                const headerOffset = 80; // Account for fixed header
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
                
                // Update URL without jumping
                history.pushState(null, null, this.getAttribute('href'));
            }
        });
    });
}

/**
 * Scroll Animations
 * Implements intersection observer for fade-in animations
 */
function initializeScrollAnimations() {
    // Check if animations are reduced
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    
    if (prefersReducedMotion) {
        return; // Skip animations if user prefers reduced motion
    }
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
                observer.unobserve(entry.target); // Only animate once
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    const animateElements = document.querySelectorAll('.card-hover, .feature-card, .testimonial-card');
    animateElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        observer.observe(el);
    });
    
    // Parallax effect for hero background elements (subtle)
    const parallaxElements = document.querySelectorAll('[data-parallax]');
    if (parallaxElements.length > 0) {
        function updateParallax() {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            
            parallaxElements.forEach(el => {
                el.style.transform = `translateY(${rate}px)`;
            });
        }
        
        let ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    updateParallax();
                    ticking = false;
                });
                ticking = true;
            }
        });
    }
}

/**
 * Form Enhancements
 * Adds validation, loading states, and UX improvements
 */
function initializeFormEnhancements() {
    const contactForm = document.querySelector('form[action*="contact"]');
    
    if (!contactForm) return;
    
    const submitButton = contactForm.querySelector('button[type="submit"]');
    const inputs = contactForm.querySelectorAll('input, textarea, select');
    
    // Real-time validation
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('form-error')) {
                validateField(this);
            }
        });
    });
    
    // Form submission with loading state
    contactForm.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validate all fields
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            showNotification('Por favor corrige los errores en el formulario', 'error');
            return;
        }
        
        // Show loading state
        if (submitButton) {
            submitButton.classList.add('btn-loading');
            submitButton.disabled = true;
            
            // Reset loading state after 10 seconds (fallback)
            setTimeout(() => {
                submitButton.classList.remove('btn-loading');
                submitButton.disabled = false;
            }, 10000);
        }
        
        // Track form submission
        trackEvent('form_submit', 'contact', 'demo_request');
    });
    
    // Character counter for textarea
    const messageTextarea = contactForm.querySelector('textarea[name="message"]');
    if (messageTextarea) {
        const minLength = 10;
        const maxLength = 1000;
        
        // Create counter element
        const counter = document.createElement('div');
        counter.className = 'text-sm text-gray-500 mt-1 text-right';
        messageTextarea.parentNode.appendChild(counter);
        
        function updateCounter() {
            const length = messageTextarea.value.length;
            counter.textContent = `${length}/${maxLength} caracteres`;
            
            if (length < minLength) {
                counter.className = 'text-sm text-red-500 mt-1 text-right';
            } else if (length > maxLength * 0.9) {
                counter.className = 'text-sm text-orange-500 mt-1 text-right';
            } else {
                counter.className = 'text-sm text-gray-500 mt-1 text-right';
            }
        }
        
        messageTextarea.addEventListener('input', updateCounter);
        updateCounter(); // Initialize
    }
}

/**
 * Field Validation
 * Validates individual form fields
 */
function validateField(field) {
    const value = field.value.trim();
    const fieldName = field.name;
    let isValid = true;
    let errorMessage = '';
    
    // Remove existing error styling
    field.classList.remove('form-error');
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Required field validation
    if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'Este campo es obligatorio';
    } else {
        // Specific field validations
        switch (fieldName) {
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (value && !emailRegex.test(value)) {
                    isValid = false;
                    errorMessage = 'Ingresa un email válido';
                }
                break;
                
            case 'phone':
                if (value && value.length < 10) {
                    isValid = false;
                    errorMessage = 'Ingresa un teléfono válido';
                }
                break;
                
            case 'message':
                if (value && value.length < 10) {
                    isValid = false;
                    errorMessage = 'El mensaje debe tener al menos 10 caracteres';
                } else if (value && value.length > 1000) {
                    isValid = false;
                    errorMessage = 'El mensaje no puede exceder 1000 caracteres';
                }
                break;
                
            case 'preferred_contact':
                if (field.type === 'radio') {
                    const radioGroup = document.querySelectorAll(`input[name="${fieldName}"]`);
                    const isChecked = Array.from(radioGroup).some(radio => radio.checked);
                    if (!isChecked) {
                        isValid = false;
                        errorMessage = 'Selecciona un método de contacto';
                    }
                }
                break;
        }
    }
    
    // Show error if invalid
    if (!isValid) {
        field.classList.add('form-error');
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error text-red-500 text-sm mt-1';
        errorDiv.textContent = errorMessage;
        field.parentNode.appendChild(errorDiv);
    }
    
    return isValid;
}

/**
 * Stats Counter Animation
 * Animates numbers when they come into view
 */
function initializeStatCounters() {
    const statElements = document.querySelectorAll('.stat-number');
    
    if (statElements.length === 0) return;
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    statElements.forEach(el => observer.observe(el));
}

/**
 * Animate Counter
 * Animates a number from 0 to its target value
 */
function animateCounter(element) {
    const target = parseInt(element.textContent.replace(/[^\d]/g, ''));
    const duration = 2000; // 2 seconds
    const increment = target / (duration / 16); // 60fps
    let current = 0;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = formatNumber(target);
            clearInterval(timer);
        } else {
            element.textContent = formatNumber(Math.floor(current));
        }
    }, 16);
}

/**
 * Format Number
 * Formats numbers with appropriate suffixes
 */
function formatNumber(num) {
    if (num >= 1000) {
        return (num / 1000).toFixed(0) + 'K+';
    }
    return num.toString() + '+';
}

/**
 * Lazy Loading
 * Implements lazy loading for images and heavy content
 */
function initializeLazyLoading() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

/**
 * Analytics and Event Tracking
 * Tracks user interactions for optimization
 */
function initializeAnalytics() {
    // Track scroll depth
    let maxScroll = 0;
    const scrollMilestones = [25, 50, 75, 100];
    
    function trackScrollDepth() {
        const scrollPercent = Math.round(
            (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100
        );
        
        if (scrollPercent > maxScroll) {
            maxScroll = scrollPercent;
            
            scrollMilestones.forEach(milestone => {
                if (scrollPercent >= milestone && !window[`scroll_${milestone}_tracked`]) {
                    trackEvent('scroll_depth', 'engagement', `${milestone}%`);
                    window[`scroll_${milestone}_tracked`] = true;
                }
            });
        }
    }
    
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(trackScrollDepth, 100);
    });
    
    // Track CTA clicks
    document.querySelectorAll('.btn-primary, .btn-secondary').forEach(button => {
        button.addEventListener('click', function(e) {
            const buttonText = this.textContent.trim();
            const buttonType = this.classList.contains('btn-primary') ? 'primary' : 'secondary';
            trackEvent('cta_click', buttonType, buttonText);
        });
    });
    
    // Track time on page
    const startTime = Date.now();
    window.addEventListener('beforeunload', function() {
        const timeOnPage = Math.round((Date.now() - startTime) / 1000);
        trackEvent('time_on_page', 'engagement', timeOnPage);
    });
}

/**
 * Track Event
 * Generic event tracking function
 */
function trackEvent(action, category, label) {
    // This would integrate with your analytics service
    // Google Analytics, Mixpanel, etc.
    
    console.log('Event tracked:', { action, category, label });
    
    // Example Google Analytics integration:
    if (typeof gtag !== 'undefined') {
        gtag('event', action, {
            event_category: category,
            event_label: label
        });
    }
    
    // Example for other analytics services
    if (typeof analytics !== 'undefined') {
        analytics.track(action, {
            category: category,
            label: label
        });
    }
}

/**
 * Show Notification
 * Displays user feedback notifications
 */
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform translate-x-full transition-transform duration-300 ${
        type === 'error' ? 'bg-red-500 text-white' : 
        type === 'success' ? 'bg-green-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    
    notification.innerHTML = `
        <div class="flex items-center space-x-2">
            <span>${message}</span>
            <button class="ml-2 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

/**
 * Utility Functions
 */

// Debounce function for performance optimization
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Throttle function for scroll events
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Feature detection
const hasIntersectionObserver = 'IntersectionObserver' in window;
const hasRequestAnimationFrame = 'requestAnimationFrame' in window;

// Export functions for testing (if needed)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        trackEvent,
        validateField,
        formatNumber,
        debounce,
        throttle
    };
}