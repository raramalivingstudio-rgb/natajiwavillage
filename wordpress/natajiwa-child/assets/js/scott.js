/* Natajiwa Village — shared motion (reproduced from The Scott Resort) */
(function () {
  'use strict';

  // ---- Build two-layer, per-letter buttons (fill rises from bottom) ----
  document.querySelectorAll('.btn').forEach(function (btn) {
    if (btn.dataset.built) return;
    btn.dataset.built = '1';
    var text = btn.textContent.trim();
    var letters = function (t) {
      return [].map.call(t, function (c) {
        return '<span>' + (c === ' ' ? '&nbsp;' : c) + '</span>';
      }).join('');
    };
    btn.innerHTML = '<span class="fill"></span>' +
      '<span class="t t--base">' + letters(text) + '</span>' +
      '<span class="t t--in">' + letters(text) + '</span>';
    btn.querySelectorAll('.t--in span').forEach(function (s, i) {
      s.style.transitionDelay = (i * 0.015) + 's';
    });
  });

  // ---- Sticky header shadow ----
  var hdr = document.getElementById('hdr');
  if (hdr) {
    var onScroll = function () { hdr.classList.toggle('scrolled', window.scrollY > 40); };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  // ---- Mobile menu ----
  var burger = document.getElementById('burger');
  var mnav = document.getElementById('mnav');
  if (burger && mnav) {
    var toggle = function (open) {
      burger.classList.toggle('open', open);
      mnav.classList.toggle('open', open);
      document.body.classList.toggle('menu-open', open);
      burger.setAttribute('aria-expanded', String(open));
    };
    burger.addEventListener('click', function () {
      toggle(!mnav.classList.contains('open'));
    });
    mnav.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () { toggle(false); });
    });
    var mclose = document.getElementById('mnavClose');
    if (mclose) mclose.addEventListener('click', function () { toggle(false); });
    // Close on Escape for accessibility
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && mnav.classList.contains('open')) toggle(false);
    });
  }

  // ---- Reveal + image-wipe observer (mirrors The Scott's data-anim) ----
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
      });
    }, { threshold: 0.16 });
    document.querySelectorAll('.reveal,.media,.oasis').forEach(function (el) { io.observe(el); });
  } else {
    document.querySelectorAll('.reveal,.media,.oasis').forEach(function (el) { el.classList.add('in'); });
  }

  // ---- Hero auto-slideshow (crossfade + Ken Burns) ----
  var heroSlides = document.querySelectorAll('.hero-slide');
  var heroDots = document.getElementById('heroDots');
  // Assign a slide's deferred background (data-bg) the first time it's needed,
  // so only the first hero photo loads up-front (faster LCP).
  var ensureBg = function (slide) {
    if (slide && slide.dataset && slide.dataset.bg) {
      slide.style.backgroundImage = "url('" + slide.dataset.bg + "')";
      slide.removeAttribute('data-bg');
    }
  };
  if (heroSlides.length > 1) {
    var hi = 0, timer = null;
    var dots = [];
    // Warm the remaining slides shortly after load (off the critical path).
    window.addEventListener('load', function () {
      setTimeout(function () { heroSlides.forEach(ensureBg); }, 600);
    });
    if (heroDots) {
      heroSlides.forEach(function (_, idx) {
        var b = document.createElement('button');
        b.type = 'button';
        b.setAttribute('aria-label', 'Show slide ' + (idx + 1));
        if (idx === 0) b.className = 'on';
        b.addEventListener('click', function () { go(idx); reset(); });
        heroDots.appendChild(b);
        dots.push(b);
      });
    }
    var go = function (n) {
      heroSlides[hi].classList.remove('is-active');
      if (dots[hi]) dots[hi].classList.remove('on');
      hi = (n + heroSlides.length) % heroSlides.length;
      ensureBg( heroSlides[hi] );                     // load if not yet loaded
      ensureBg( heroSlides[ (hi + 1) % heroSlides.length ] ); // prefetch next
      heroSlides[hi].classList.add('is-active');
      if (dots[hi]) dots[hi].classList.add('on');
    };
    var reset = function () { clearInterval(timer); timer = setInterval(function () { go(hi + 1); }, 5200); };
    reset();
  }

  // ---- Hero plays on load ----
  var hero = document.querySelector('.hero-frame');
  if (hero) {
    window.addEventListener('load', function () {
      requestAnimationFrame(function () { hero.classList.add('in'); });
    });
    // fallback in case load already fired
    if (document.readyState === 'complete') hero.classList.add('in');
  }

  // ---- Footer year ----
  var y = document.getElementById('year');
  if (y) y.textContent = String(new Date().getFullYear());

  // ---- Contact form (submits to Web3Forms via fetch; dates optional) ----
  var form = document.getElementById('contactForm');
  if (form) {
    form.addEventListener('submit', function (ev) {
      var note = document.getElementById('formNote');
      var err = document.getElementById('formErr');
      var action = form.getAttribute('action') || '';
      if (note) note.hidden = true;
      if (err) err.hidden = true;

      // Not configured yet (placeholder key) -> show a friendly note, no send.
      if (action.indexOf('web3forms') === -1 || form.querySelector('[name=access_key]') && /YOUR_WEB3FORMS/.test(form.querySelector('[name=access_key]').value)) {
        ev.preventDefault();
        if (note) note.hidden = false;
        form.reset();
        return;
      }

      ev.preventDefault();
      var btn = form.querySelector('button[type=submit]');
      if (btn) btn.disabled = true;
      fetch(action, { method: 'POST', body: new FormData(form), headers: { 'Accept': 'application/json' } })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (data && data.success) { if (note) note.hidden = false; form.reset(); }
          else { if (err) err.hidden = false; }
        })
        .catch(function () { if (err) err.hidden = false; })
        .then(function () { if (btn) btn.disabled = false; });
    });
  }
})();
