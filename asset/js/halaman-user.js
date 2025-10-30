// navbar resize / scrolled state + logo color switching
const nav = document.querySelector('.sticky-nav');
const logo = document.getElementById('logo');
const navLinks = document.querySelectorAll('nav a');

function onScrollNav() {
  const scrolled = window.scrollY > 90;
  nav.classList.toggle('scrolled', scrolled);

  if (scrolled) {
    logo.classList.remove('text-white');
    logo.classList.add('text-sky-600');
    document.querySelectorAll('nav a').forEach(a => a.classList.remove('text-white'));
  } else {
    logo.classList.remove('text-sky-600');
    logo.classList.add('text-white');
    document.querySelectorAll('nav a').forEach(a => a.classList.add('text-white'));
  }
}
window.addEventListener('scroll', onScrollNav);
onScrollNav();

// mobile menu toggle
document.getElementById('menuBtn').addEventListener('click', () => {
  document.getElementById('mobileMenu').classList.toggle('hidden');
});

// fade-in on scroll observer
const fadeEls = document.querySelectorAll('.fade-in');
const io = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.12 });
fadeEls.forEach(el => io.observe(el));

// smooth scroll with navbar offset when clicking internal links
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', function (e) {
    const href = this.getAttribute('href');
    if (!href || href === '#') return;
    const target = document.querySelector(href);
    if (!target) return;
    e.preventDefault();
    const navHeight = document.querySelector('.sticky-nav').offsetHeight || 72;
    const y = target.getBoundingClientRect().top + window.scrollY - navHeight - 8;
    window.scrollTo({ top: y, behavior: 'smooth' });
    document.getElementById('mobileMenu').classList.add('hidden');

  });
});
