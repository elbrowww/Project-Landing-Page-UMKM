 // Sticky Navigation
        const nav = document.querySelector('.sticky-nav');
        const logo = document.getElementById('logo');
        const navLinks = document.querySelector('.nav-links-white');
        const menuBtn = document.getElementById('menuBtn');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                nav.classList.add('scrolled');
                // Ganti warna logo menjadi biru
                logo.classList.remove('logo-white');
                logo.classList.add('logo-blue');
                // Ganti warna menu navigasi menjadi hitam
                navLinks.classList.remove('nav-links-white');
                navLinks.classList.add('nav-links-black');
                // Ganti warna ikon menu hamburger
                menuBtn.classList.remove('menu-btn-white');
                menuBtn.classList.add('menu-btn-black');
            } else {
                nav.classList.remove('scrolled');
                // Kembalikan warna logo menjadi putih
                logo.classList.remove('logo-blue');
                logo.classList.add('logo-white');
                // Kembalikan warna menu navigasi menjadi putih
                navLinks.classList.remove('nav-links-black');
                navLinks.classList.add('nav-links-white');
                // Kembalikan warna ikon menu hamburger
                menuBtn.classList.remove('menu-btn-black');
                menuBtn.classList.add('menu-btn-white');
            }
        });

        // Mobile Menu Toggle
        const mobileMenu = document.getElementById('mobileMenu');
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

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