document.addEventListener('DOMContentLoaded', () => {
  const nav = document.querySelector('.sticky-nav');
  const logo = document.getElementById('logo');
  const navLinks = document.querySelector('.nav-links-white');
  const menuBtn = document.getElementById('menuBtn');
  const mobileMenu = document.getElementById('mobileMenu');


  window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
      if (nav) nav.classList.add('scrolled');
      if (logo) {
        logo.classList.remove('logo-white');
        logo.classList.add('logo-blue');
      }
      if (navLinks) {
        navLinks.classList.remove('nav-links-white');
        navLinks.classList.add('nav-links-black');
      }
      if (menuBtn) {
        menuBtn.classList.remove('menu-btn-white');
        menuBtn.classList.add('menu-btn-black');
      }
    } else {
      if (nav) nav.classList.remove('scrolled');
      if (logo) {
        logo.classList.remove('logo-blue');
        logo.classList.add('logo-white');
      }
      if (navLinks) {
        navLinks.classList.remove('nav-links-black');
        navLinks.classList.add('nav-links-white');
      }
      if (menuBtn) {
        menuBtn.classList.remove('menu-btn-black');
        menuBtn.classList.add('menu-btn-white');
      }
    }
  });

  if (menuBtn && mobileMenu) {
    menuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  }

// Fade In Animation on Scroll
        const fadeElements = document.querySelectorAll('.fade-in');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        fadeElements.forEach(element => {
            observer.observe(element);
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    mobileMenu.classList.add('hidden');
                }
            });
        });

        // Form Submission
        document.querySelector('form').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Terima kasih! Pesan Anda telah dikirim. Kami akan segera menghubungi Anda.');
            e.target.reset();
        });
        
});

let currentTestimoniIndex = 0;
const testimoniSlider = document.getElementById('testimoniSlider');

function getVisibleItemsCount() {
    if (!testimoniSlider) return 0;
    const container = testimoniSlider.parentElement;
    const containerWidth = container.offsetWidth;
    const itemWidth = 300 + 24;
    return Math.floor(containerWidth / itemWidth);
}

function getMaxIndex() {
    const totalTestimoni = testimoniSlider ? testimoniSlider.children.length : 0;
    const visibleItems = getVisibleItemsCount();
    return Math.max(0, totalTestimoni - visibleItems);
}

function scrollTestimoniLeft() {
    if (currentTestimoniIndex > 0) {
        currentTestimoniIndex--;
        updateTestimoniSlider();
    }
}

function scrollTestimoniRight() {
    const maxIndex = getMaxIndex();
    if (currentTestimoniIndex < maxIndex) {
        currentTestimoniIndex++;
        updateTestimoniSlider();
    }
}

function updateTestimoniSlider() {
    if (testimoniSlider) {
        const itemWidth = 300 + 24;
        const offset = -currentTestimoniIndex * itemWidth;
        testimoniSlider.style.transform = `translateX(${offset}px)`;
    }
}

// Handle resize
window.addEventListener('resize', function() {
    currentTestimoniIndex = Math.min(currentTestimoniIndex, getMaxIndex());
    updateTestimoniSlider();
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Testimoni slider loaded - RAPI & TIDAK KEPOTONG!');
});