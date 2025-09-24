// Navigation functionality
document.addEventListener('DOMContentLoaded', function() {
  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  const menuIcon = document.getElementById('menu-icon');
  const closeIcon = document.getElementById('close-icon');

  let isMenuOpen = false;

  // Toggle mobile menu
  menuToggle.addEventListener('click', function() {
    isMenuOpen = !isMenuOpen;
    
    if (isMenuOpen) {
      mobileMenu.classList.remove('hidden');
      menuIcon.classList.add('hidden');
      closeIcon.classList.remove('hidden');
    } else {
      mobileMenu.classList.add('hidden');
      menuIcon.classList.remove('hidden');
      closeIcon.classList.add('hidden');
    }
  });

  // Close mobile menu when clicking outside
  document.addEventListener('click', function(event) {
    if (!menuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
      if (isMenuOpen) {
        isMenuOpen = false;
        mobileMenu.classList.add('hidden');
        menuIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
      }
    }
  });

  // Smooth scroll functionality
  window.scrollToSection = function(href) {
    const element = document.querySelector(href);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
      
      // Close mobile menu if open
      if (isMenuOpen) {
        isMenuOpen = false;
        mobileMenu.classList.add('hidden');
        menuIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
      }
    }
  };

  // Navigation transparency on scroll
  const navigation = document.getElementById('navigation');
  let lastScrollY = window.scrollY;

  window.addEventListener('scroll', function() {
    const currentScrollY = window.scrollY;
    
    if (currentScrollY > 100) {
      navigation.style.background = 'rgba(250, 250, 250, 0.98)';
    } else {
      navigation.style.background = 'rgba(250, 250, 250, 0.95)';
    }
    
    lastScrollY = currentScrollY;
  });

  // Intersection Observer for scroll animations
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, observerOptions);

  // Observe sections for animation
  const sections = document.querySelectorAll('section');
  sections.forEach(section => {
    section.style.opacity = '0';
    section.style.transform = 'translateY(20px)';
    section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(section);
  });

  // Card hover effects
  const cards = document.querySelectorAll('.feature-card, .use-case-card, .step-content');
  cards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-8px)';
    });
    
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
    });
  });

  // Button click effects
  const buttons = document.querySelectorAll('.btn');
  buttons.forEach(button => {
    button.addEventListener('click', function(e) {
      // Create ripple effect
      const ripple = document.createElement('span');
      const rect = this.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      const x = e.clientX - rect.left - size / 2;
      const y = e.clientY - rect.top - size / 2;
      
      ripple.style.width = ripple.style.height = size + 'px';
      ripple.style.left = x + 'px';
      ripple.style.top = y + 'px';
      ripple.classList.add('ripple');
      
      this.appendChild(ripple);
      
      setTimeout(() => {
        ripple.remove();
      }, 600);
    });
  });

  // Add ripple styles
  const style = document.createElement('style');
  style.textContent = `
    .btn {
      position: relative;
      overflow: hidden;
    }
    
    .ripple {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.3);
      transform: scale(0);
      animation: ripple-animation 0.6s linear;
      pointer-events: none;
    }
    
    @keyframes ripple-animation {
      to {
        transform: scale(4);
        opacity: 0;
      }
    }
    
    .feature-card, .use-case-card, .step-content {
      transition: all 0.3s ease;
    }
    
    .floating-card {
      animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
      0%, 100% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(-10px);
      }
    }
    
    .hero-image img {
      transition: transform 0.3s ease;
    }
    
    .hero-image:hover img {
      transform: scale(1.05);
    }
    
    .analytics-image img {
      transition: transform 0.3s ease;
    }
    
    .analytics-image:hover img {
      transform: scale(1.02);
    }
  `;
  document.head.appendChild(style);

  // Parallax effect for hero section
  window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    const parallax = document.querySelector('.hero-image');
    if (parallax) {
      const speed = scrolled * 0.1;
      parallax.style.transform = `translateY(${speed}px)`;
    }
  });

  // Initialize animation for first section
  setTimeout(() => {
    const heroSection = document.querySelector('#home');
    if (heroSection) {
      heroSection.style.opacity = '1';
      heroSection.style.transform = 'translateY(0)';
    }
  }, 100);
});

// Demo Video Modal Functions
function showDemoModal() {
  const modal = document.getElementById('demoModal');
  const video = document.getElementById('demoVideo');
  
  // Replace with your actual YouTube video ID for CustiCast demo
  // For now using a generic restaurant analytics demo video
  const youtubeVideoId = 'JI7Y4TbLJls'; // Example: Restaurant Analytics demo
  video.src = `https://www.youtube.com/embed/${youtubeVideoId}?autoplay=1&rel=0&modestbranding=1`;
  
  modal.style.display = 'block';
  document.body.style.overflow = 'hidden';
}

function closeDemoModal() {
  const modal = document.getElementById('demoModal');
  const video = document.getElementById('demoVideo');
  
  modal.style.display = 'none';
  video.src = '';
  document.body.style.overflow = 'auto';
}

// Request Demo Modal Functions
function showRequestDemoModal() {
  const modal = document.getElementById('requestDemoModal');
  modal.style.display = 'block';
  document.body.style.overflow = 'hidden';
}

function closeRequestDemoModal() {
  const modal = document.getElementById('requestDemoModal');
  modal.style.display = 'none';
  document.body.style.overflow = 'auto';
  document.getElementById('requestDemoForm').reset();
}

// Contact Sales Modal Functions
function showContactModal() {
  const modal = document.getElementById('contactModal');
  modal.style.display = 'block';
  document.body.style.overflow = 'hidden';
}

function closeContactModal() {
  const modal = document.getElementById('contactModal');
  modal.style.display = 'none';
  document.body.style.overflow = 'auto';
  document.getElementById('contactForm').reset();
}

// Close modals when clicking outside
window.addEventListener('click', function(event) {
  const demoModal = document.getElementById('demoModal');
  const requestModal = document.getElementById('requestDemoModal');
  const contactModal = document.getElementById('contactModal');
  
  if (event.target === demoModal) {
    closeDemoModal();
  }
  if (event.target === requestModal) {
    closeRequestDemoModal();
  }
  if (event.target === contactModal) {
    closeContactModal();
  }
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
  if (event.key === 'Escape') {
    closeDemoModal();
    closeRequestDemoModal();
    closeContactModal();
  }
});

// Form Submission Handlers
document.addEventListener('DOMContentLoaded', function() {
  // Request Demo Form Handler
  const requestDemoForm = document.getElementById('requestDemoForm');
  if (requestDemoForm) {
    requestDemoForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const data = Object.fromEntries(formData.entries());
      
      // Show loading state
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalText = submitBtn.textContent;
      submitBtn.textContent = 'Sending...';
      submitBtn.disabled = true;
      
      // Send email request (replace with actual endpoint)
      fetch('/api/send-demo-request', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Demo request sent successfully! We will contact you within 24 hours.');
          closeRequestDemoModal();
        } else {
          throw new Error(data.message || 'Failed to send demo request');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Failed to send demo request. Please try again or contact us directly.');
      })
      .finally(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
      });
    });
  }
  
  // Contact Form Handler
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const data = Object.fromEntries(formData.entries());
      
      // Show loading state
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalText = submitBtn.textContent;
      submitBtn.textContent = 'Sending...';
      submitBtn.disabled = true;
      
      // Send email request (replace with actual endpoint)
      fetch('/api/send-contact-message', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Message sent successfully! Our sales team will contact you soon.');
          closeContactModal();
        } else {
          throw new Error(data.message || 'Failed to send message');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Failed to send message. Please try again or contact us directly.');
      })
      .finally(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
      });
    });
  }
});