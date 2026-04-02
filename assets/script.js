/* ============================================================
   City Care Clinic — script.js
   Global JavaScript
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

  /* ── Mobile nav toggle ──────────────────────────────────── */
  const toggle = document.getElementById('navToggle');
  const navLinks = document.getElementById('navLinks');

  if (toggle && navLinks) {
    toggle.addEventListener('click', function () {
      navLinks.classList.toggle('open');
      const bars = toggle.querySelectorAll('span');
      if (navLinks.classList.contains('open')) {
        bars[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
        bars[1].style.opacity = '0';
        bars[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
      } else {
        bars[0].style.transform = '';
        bars[1].style.opacity = '';
        bars[2].style.transform = '';
      }
    });

    // Close nav when clicking outside
    document.addEventListener('click', function (e) {
      if (!toggle.contains(e.target) && !navLinks.contains(e.target)) {
        navLinks.classList.remove('open');
      }
    });
  }

  /* ── Active nav link highlighting ──────────────────────── */
  const currentPage = window.location.pathname.split('/').pop() || 'index.php';
  const links = document.querySelectorAll('.nav-links a');
  links.forEach(function (link) {
    const href = link.getAttribute('href');
    if (href && (href === currentPage || href.endsWith(currentPage))) {
      link.classList.add('active');
    }
  });

  /* ── Character counter for textareas ────────────────────── */
  document.querySelectorAll('textarea[data-maxlength]').forEach(function (el) {
    const max = parseInt(el.getAttribute('data-maxlength'), 10);
    const counterId = el.getAttribute('data-counter');
    const counter = counterId ? document.getElementById(counterId) : null;

    function updateCounter() {
      const remaining = max - el.value.length;
      if (counter) {
        counter.textContent = remaining + ' characters remaining';
        counter.style.color = remaining < 20 ? '#dc2626' : '#6b7280';
      }
    }

    el.addEventListener('input', updateCounter);
    updateCounter();
  });

  /* ── Form: live date validation (no past date) ──────────── */
  const dateInput = document.getElementById('appointment_date');
  if (dateInput) {
    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);
  }

  /* ── Fade-in animation on elements ─────────────────────── */
  const fadeEls = document.querySelectorAll('.fade-in');
  fadeEls.forEach(function (el, i) {
    el.style.opacity = '0';
    el.style.animationDelay = (i * 0.06) + 's';
    el.style.animationFillMode = 'forwards';
  });

  /* ── Smooth scroll to first error ──────────────────────── */
  const firstError = document.querySelector('.is-invalid, .alert-error');
  if (firstError) {
    setTimeout(function () {
      firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 100);
  }

  /* ── BMI progress bar animation ────────────────────────── */
  const bmiBar = document.querySelector('.bmi-fill');
  if (bmiBar) {
    const target = bmiBar.getAttribute('data-width') || '0';
    setTimeout(function () {
      bmiBar.style.width = target + '%';
    }, 200);
  }

  /* ── Copy reference number ──────────────────────────────── */
  const copyBtn = document.getElementById('copyRef');
  if (copyBtn) {
    copyBtn.addEventListener('click', function () {
      const ref = document.getElementById('refNumber');
      if (ref) {
        navigator.clipboard.writeText(ref.textContent).then(function () {
          copyBtn.textContent = 'Copied!';
          setTimeout(function () { copyBtn.textContent = 'Copy'; }, 1500);
        });
      }
    });
  }

  /* ── Print button ───────────────────────────────────────── */
  const printBtn = document.getElementById('printPage');
  if (printBtn) {
    printBtn.addEventListener('click', function () {
      window.print();
    });
  }

  /* ── Auto-dismiss alerts after 6 seconds ───────────────── */
  const alerts = document.querySelectorAll('.alert[data-auto-dismiss]');
  alerts.forEach(function (alert) {
    setTimeout(function () {
      alert.style.transition = 'opacity 0.5s ease';
      alert.style.opacity = '0';
      setTimeout(function () { alert.remove(); }, 500);
    }, 6000);
  });

  /* ── Step progress: prevent going back via browser button ─ */
  if (document.getElementById('stepForm')) {
    window.addEventListener('popstate', function () {
      history.pushState(null, '', location.href);
    });
    history.pushState(null, '', location.href);
  }

});
