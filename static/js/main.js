// ── Custom cursor via requestAnimationFrame (smooth, no lag) ──
const cursor = document.getElementById('customCursor');
let mouseX = 0, mouseY = 0;
let curX = 0, curY = 0;
document.addEventListener('mousemove', e => { mouseX = e.clientX; mouseY = e.clientY; });
function animateCursor() {
    curX += (mouseX - curX) * 0.18;
    curY += (mouseY - curY) * 0.18;
    if (cursor) { cursor.style.left = curX + 'px'; cursor.style.top = curY + 'px'; }
    requestAnimationFrame(animateCursor);
}
requestAnimationFrame(animateCursor);

// ── Navbar scroll effect ──
const nav = document.getElementById('mainNav');
window.addEventListener('scroll', () => {
    if (nav) nav.style.background = window.scrollY > 50 ? 'rgba(0,0,0,0.98)' : 'rgba(0,0,0,0.88)';
}, { passive: true });

// ── Unified reveal observer (handles both .fade-in and .reveal) ──
// Limit stagger to avoid massive delays on large pages
const revealObserver = new IntersectionObserver((entries, obs) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.classList.add('visible');
            obs.unobserve(e.target);
        }
    });
}, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });

// Fade-in: stagger limited to 6 items max (0.06s each), then reset
document.querySelectorAll('.fade-in').forEach((el, i) => {
    el.style.transitionDelay = `${Math.min(i, 6) * 0.06}s`;
    revealObserver.observe(el);
});

// Reveal: very light stagger per section (no global index carry-over)
document.querySelectorAll('section, .row').forEach(section => {
    section.querySelectorAll('.reveal').forEach((el, i) => {
        el.style.transitionDelay = `${i * 0.07}s`;
        revealObserver.observe(el);
    });
});

// ── Counter animation ──
const counterObserver = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (!e.isIntersecting) return;
        const target = +e.target.dataset.target;
        let count = 0;
        const step = Math.max(1, Math.ceil(target / 50));
        const timer = setInterval(() => {
            count = Math.min(count + step, target);
            e.target.textContent = count;
            if (count >= target) clearInterval(timer);
        }, 25);
        counterObserver.unobserve(e.target);
    });
}, { threshold: 0.5 });
document.querySelectorAll('.counter').forEach(c => counterObserver.observe(c));

// ── Testimonial slider ──
let currentSlide = 0;
const slides = document.querySelectorAll('.testimonial-slide');
const dots = document.querySelectorAll('.t-dot');
function goToSlide(n) {
    if (!slides.length) return;
    slides[currentSlide].classList.remove('active');
    dots[currentSlide]?.classList.remove('active');
    currentSlide = ((n % slides.length) + slides.length) % slides.length;
    slides[currentSlide].classList.add('active');
    dots[currentSlide]?.classList.add('active');
}
if (slides.length) setInterval(() => goToSlide(currentSlide + 1), 5000);

// ── Password toggle ──
function togglePw(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.type = el.type === 'password' ? 'text' : 'password';
}

// ── FAQ accordion ──
function toggleFaq(btn) {
    const answer = btn.nextElementSibling;
    const chevron = btn.querySelector('.faq-chevron');
    const isOpen = answer.classList.contains('open');
    // Close all
    document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('open'));
    document.querySelectorAll('.faq-chevron').forEach(c => c.classList.remove('rotated'));
    if (!isOpen) {
        answer.classList.add('open');
        chevron?.classList.add('rotated');
    }
}

// ── Auto-dismiss flash toasts ──
setTimeout(() => {
    document.querySelectorAll('.flash-toast').forEach(t => {
        t.style.opacity = '0';
        t.style.transition = 'opacity .4s';
        setTimeout(() => t.remove(), 400);
    });
}, 5000);
