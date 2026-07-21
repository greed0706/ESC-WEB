/**
 * ECSGES theme — vanilla JS thay cho React state.
 * 1) Hamburger menu (SiteHeader)
 * 2) Ecosystem tabs (EcosystemTabs)
 * 3) News pagination (NewsSection)
 * 4) Sticky header (Headroom.js) — dính + ẩn/hiện theo hướng cuộn
 */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    initMobileMenu();
    initEcosystemTabs();
    initNewsPagination();
    initJobsPagination();
    initJobModal();
    initStickyHeader();
    initAOS();
    initHeroIntro();
    initCharsReveal();
    initPinsReveal();
    initPtbvCarousel();
    initLangDropdown();
    initMobileSubmenu();
  });

  /* ---------------------------------------------------------------- */
  /**
   * Dropdown ngôn ngữ mở bằng CLICK (không hover). Click ra ngoài hoặc phím
   * Esc thì đóng lại.
   */
  function initLangDropdown() {
    var wrap = document.querySelector('[data-lang]');
    if (!wrap) return;
    var btn = wrap.querySelector('[data-lang-toggle]');
    if (!btn) return;

    function close() {
      wrap.classList.remove('is-open');
      btn.setAttribute('aria-expanded', 'false');
    }
    function toggle(e) {
      e.preventDefault();
      e.stopPropagation();
      var open = wrap.classList.toggle('is-open');
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    btn.addEventListener('click', toggle);
    document.addEventListener('click', function (e) {
      if (!wrap.contains(e.target)) close();
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') close();
    });
  }

  /* ---------------------------------------------------------------- */
  /**
   * Accordion menu con trong menu di động (mobile không có hover). Bấm caret để
   * xổ/thu; bấm vào chữ vẫn điều hướng tới trang cha. Không đóng các mục khác —
   * ba mục ngắn, mở cùng lúc không sao.
   */
  function initMobileSubmenu() {
    var toggles = document.querySelectorAll('[data-submenu-toggle]');
    Array.prototype.forEach.call(toggles, function (btn) {
      var panel = document.getElementById(btn.getAttribute('aria-controls'));
      var item = btn.closest('.ecs-header__mobile-item');
      if (!panel || !item) return;

      btn.addEventListener('click', function () {
        var open = item.classList.toggle('is-open');
        panel.classList.toggle('is-hidden', !open);
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
    });
  }

  /* ---------------------------------------------------------------- */
  /**
   * Map-pin zoom-in (kiểu .partners Viettel): pin scale 0 → 1 lần lượt khi
   * globe cuộn vào viewport. Tôn trọng prefers-reduced-motion.
   */
  function initPinsReveal() {
    var blocks = document.querySelectorAll('[data-pins-reveal]');
    if (!blocks.length) return;

    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce || !('IntersectionObserver' in window)) return; // không "arm" → pin hiện bình thường

    function revealPins(block) {
      var pins = block.querySelectorAll('.ecsges-pin');
      Array.prototype.forEach.call(pins, function (p, j) {
        setTimeout(function () { p.classList.add('is-in'); }, j * 90);
      });
    }

    Array.prototype.forEach.call(blocks, function (b) { b.classList.add('pins-armed'); });

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) {
          revealPins(e.target);
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.25 });
    Array.prototype.forEach.call(blocks, function (b) { io.observe(b); });
  }

  /* ---------------------------------------------------------------- */
  /**
   * Hiện từng chữ (typewriter) cho các khối [data-chars-reveal] khi cuộn tới.
   * Tôn trọng prefers-reduced-motion.
   */
  function initCharsReveal() {
    var blocks = document.querySelectorAll('[data-chars-reveal]');
    if (!blocks.length) return;

    function revealBlock(block) {
      var chars = block.querySelectorAll('.rchar');
      Array.prototype.forEach.call(chars, function (c, j) {
        setTimeout(function () { c.classList.add('is-in'); }, j * 10);
      });
    }

    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce || !('IntersectionObserver' in window)) {
      Array.prototype.forEach.call(blocks, revealBlock);
      return;
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) {
          revealBlock(e.target);
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.2 });
    Array.prototype.forEach.call(blocks, function (b) { io.observe(b); });
  }

  /* ---------------------------------------------------------------- */
  /**
   * Hero intro (học từ Viettel): emblem xuất hiện ở giữa hero, trượt về đúng
   * chỗ, xong xuôi thì các dòng text hiện ra lần lượt. Dùng FLIP để canh
   * chính xác vị trí. Tôn trọng prefers-reduced-motion.
   */
  function initHeroIntro() {
    var section = document.getElementById('top');
    if (!section) return;
    var emblem = section.querySelector('.ecsges-hero-emblem');
    var mark = section.querySelector('.ecsges-hero-mark');
    if (!emblem) return;

    // Các bước hiện text theo đúng thứ tự DOM (heading = hiện từng chữ).
    var steps = Array.prototype.slice.call(
      section.querySelectorAll('.hero-reveal, [data-hero-chars]')
    );

    function revealStep(step) {
      if (step.hasAttribute('data-hero-chars')) {
        var chars = step.querySelectorAll('.hero-char');
        Array.prototype.forEach.call(chars, function (c, j) {
          setTimeout(function () { c.classList.add('is-in'); }, j * 55);
        });
      } else {
        step.classList.add('is-in');
      }
    }

    // Lịch chạy tuần tự: heading chiếm thời gian theo số ký tự.
    function runSequence() {
      var t = 0;
      steps.forEach(function (step) {
        (function (startT, s) {
          setTimeout(function () { revealStep(s); }, startT);
        })(t, step);
        if (step.hasAttribute('data-hero-chars')) {
          t += step.querySelectorAll('.hero-char').length * 55 + 500;
        } else {
          t += 260;
        }
      });
    }

    function startRipple() {
      if (mark) mark.classList.add('is-ripple');
    }

    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce) {
      emblem.style.opacity = '1';
      startRipple();
      steps.forEach(revealStep);
      return;
    }

    // FLIP: emblem ở giữa hero + phóng to; trượt về chỗ thì nhỏ lại.
    var e = emblem.getBoundingClientRect();
    var s = section.getBoundingClientRect();
    var dx = ( s.left + s.width / 2 ) - ( e.left + e.width / 2 );
    var dy = ( s.top + s.height / 2 ) - ( e.top + e.height / 2 );

    emblem.style.transition = 'none';
    emblem.style.transform = 'translate(' + dx + 'px,' + dy + 'px) scale(1.35)';
    emblem.style.opacity = '1';
    void emblem.offsetWidth; // reflow để áp trạng thái đầu

    var done = false;
    function afterEmblem() {
      if (done) return;
      done = true;
      startRipple();  // sóng tròn bắt đầu khi ảnh đã về đúng chỗ
      runSequence();  // rồi mới tới text
    }
    emblem.addEventListener('transitionend', function te(ev) {
      if (ev.propertyName !== 'transform') return;
      emblem.removeEventListener('transitionend', te);
      afterEmblem();
    });
    setTimeout(afterEmblem, 3200); // fallback nếu transitionend không bắn

    // Giữ ở giữa một nhịp rồi thong thả trượt về (đồng thời nhỏ lại).
    setTimeout(function () {
      emblem.style.transition = 'transform 1.7s cubic-bezier(0.22, 0.61, 0.36, 1)';
      emblem.style.transform = 'none';
    }, 550);
  }

  /* ---------------------------------------------------------------- */
  /**
   * AOS (Animate On Scroll): reveal/entrance cho các phần tử có data-aos.
   * Tự tắt khi người dùng bật "giảm chuyển động".
   */
  function initAOS() {
    if (typeof AOS === 'undefined') return;
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    AOS.init({
      duration: 1200,
      easing: 'ease-out-cubic',
      once: true,
      offset: 80,
      disable: function () { return reduce; }
    });
    // Tính lại vị trí sau khi ảnh tải xong (tránh reveal sai điểm).
    window.addEventListener('load', function () { AOS.refresh(); });
  }

  /* ---------------------------------------------------------------- */
  /**
   * Header dính với Headroom.js: cuộn xuống → trượt lên ẩn; cuộn lên →
   * hiện lại; rời đỉnh trang → đổ bóng. Style nằm ở .site-header trong CSS.
   */
  function initStickyHeader() {
    var header = document.querySelector('.site-header');
    if (!header || typeof Headroom === 'undefined') return;

    var headroom = new Headroom(header, {
      offset: 100,
      tolerance: { up: 5, down: 8 }
    });
    headroom.init();
  }

  /* ---------------------------------------------------------------- */
  function initMobileMenu() {
    var toggle = document.getElementById('ecsges-menu-toggle');
    var menu = document.getElementById('mobile-menu');
    if (!toggle || !menu) return;

    var openIcon = toggle.querySelector('[data-menu-open]');
    var closeIcon = toggle.querySelector('[data-menu-close]');

    function setOpen(open) {
      menu.classList.toggle('is-hidden', !open);
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      toggle.setAttribute('aria-label', open ? 'Đóng menu' : 'Mở menu');
      if (openIcon) openIcon.classList.toggle('is-hidden', open);
      if (closeIcon) closeIcon.classList.toggle('is-hidden', !open);
    }

    toggle.addEventListener('click', function () {
      setOpen(menu.classList.contains('is-hidden'));
    });

    // Đóng menu khi bấm 1 link.
    menu.querySelectorAll('[data-menu-link]').forEach(function (link) {
      link.addEventListener('click', function () {
        setOpen(false);
      });
    });
  }

  /* ---------------------------------------------------------------- */
  function initEcosystemTabs() {
    var root = document.querySelector('[data-ecosystem]');
    if (!root) return;

    var tabs = Array.prototype.slice.call(root.querySelectorAll('[data-tab]'));
    var panels = Array.prototype.slice.call(root.querySelectorAll('[data-panel]'));

    function activate(id) {
      tabs.forEach(function (btn) {
        var on = btn.getAttribute('data-tab') === id;
        btn.classList.toggle('is-active', on);
        btn.setAttribute('aria-selected', on ? 'true' : 'false');
      });
      panels.forEach(function (panel) {
        panel.classList.toggle('is-active', panel.getAttribute('data-panel') === id);
      });
    }

    tabs.forEach(function (btn) {
      btn.addEventListener('click', function () {
        activate(btn.getAttribute('data-tab'));
      });
    });
  }

  /* ---------------------------------------------------------------- */
  function initNewsPagination() {
    var list = document.querySelector('[data-news]');
    var nav = document.querySelector('[data-news-pagination]');
    if (!list || !nav) return;

    var pages = Array.prototype.slice.call(list.querySelectorAll('[data-news-page]'));
    var dots = Array.prototype.slice.call(nav.querySelectorAll('[data-news-dot]'));
    var count = pages.length;
    if (count <= 1) return;

    var current = 0;

    function show(index) {
      current = ((index % count) + count) % count;
      pages.forEach(function (page, i) {
        page.classList.toggle('is-active', i === current);
      });
      dots.forEach(function (dot, i) {
        var on = i === current;
        dot.classList.toggle('is-active', on);
        dot.setAttribute('aria-selected', on ? 'true' : 'false');
      });
    }

    var prev = nav.querySelector('[data-news-prev]');
    var next = nav.querySelector('[data-news-next]');
    if (prev) prev.addEventListener('click', function () { show(current - 1); });
    if (next) next.addEventListener('click', function () { show(current + 1); });
    dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () { show(i); });
    });
  }

  /* ---------------------------------------------------------------- */
  /**
   * Carousel nhân sự (trang Phát triển bền vững). Dịch track bằng transform.
   * perView theo bề rộng màn hình; clamp trong [0, cards - perView].
   */
  function initPtbvCarousel() {
    var root = document.querySelector('[data-ptbv-carousel]');
    if (!root) return;
    var track = root.querySelector('[data-ptbv-track]');
    var cards = track ? Array.prototype.slice.call(track.children) : [];
    if (!track || cards.length === 0) return;

    var prev = root.querySelector('[data-ptbv-prev]');
    var next = root.querySelector('[data-ptbv-next]');
    var index = 0;

    function perView() {
      var w = window.innerWidth;
      if (w >= 1024) return 3;
      if (w >= 640) return 2;
      return 1;
    }
    function maxIndex() { return Math.max(0, cards.length - perView()); }
    function step() {
      var s = window.getComputedStyle(track);
      var gap = parseFloat(s.columnGap || s.gap || '0') || 0;
      return cards[0].getBoundingClientRect().width + gap;
    }
    function go(i) {
      index = Math.max(0, Math.min(i, maxIndex()));
      track.style.transform = 'translateX(' + (-index * step()) + 'px)';
    }

    if (prev) prev.addEventListener('click', function () { go(index - 1); });
    if (next) next.addEventListener('click', function () { go(index + 1); });
    window.addEventListener('resize', function () { go(index); });
    go(0);
  }
  /* ---------------------------------------------------------------- */
  function initJobsPagination() {
    var list = document.querySelector('[data-jobs]');
    var nav = document.querySelector('[data-jobs-pagination]');
    if (!list || !nav) return;

    var pages = Array.prototype.slice.call(list.querySelectorAll('[data-jobs-page]'));
    var dots = Array.prototype.slice.call(nav.querySelectorAll('[data-jobs-dot]'));
    var count = pages.length;
    if (count <= 1) return;

    var current = 0;

    function show(index) {
      current = ((index % count) + count) % count;
      pages.forEach(function (page, i) {
        page.classList.toggle('is-active', i === current);
      });
      dots.forEach(function (dot, i) {
        var on = i === current;
        dot.classList.toggle('is-active', on);
        dot.setAttribute('aria-selected', on ? 'true' : 'false');
      });
    }

    var prev = nav.querySelector('[data-jobs-prev]');
    var next = nav.querySelector('[data-jobs-next]');
    if (prev) prev.addEventListener('click', function () { show(current - 1); });
    if (next) next.addEventListener('click', function () { show(current + 1); });
    dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () { show(i); });
    });
  }

  /* ---------------------------------------------------------------- */
  /**
   * Modal "Nộp đơn ứng tuyển": mở khi bấm [data-job-apply], đóng bằng nút X /
   * click overlay / Esc. Submit chỉ reset + đóng modal (chưa nối backend).
   *
   * Bàn phím: khi mở thì chuyển focus vào panel và giam focus trong đó (Tab
   * xoay vòng), khi đóng thì trả focus về đúng nút đã mở — nếu không, người
   * dùng bàn phím sẽ tab thẳng xuống trang nằm dưới lớp overlay.
   */
  function initJobModal() {
    var modal = document.querySelector('[data-job-modal]');
    if (!modal) return;

    var panel = modal.querySelector('[data-job-modal-panel]');
    var positionEl = modal.querySelector('[data-job-modal-position]');
    var form = modal.querySelector('[data-job-modal-form]');
    var lastFocused = null;
    var fileFields = Array.prototype.slice.call(modal.querySelectorAll('[data-job-modal-file]')).map(function (input) {
      var label = input.closest('label');
      var hint = label ? label.querySelector('[data-job-modal-filename]') : null;
      return { input: input, hint: hint, placeholder: hint ? hint.textContent : '' };
    });

    function focusables() {
      if (!panel) return [];
      return Array.prototype.slice.call(
        panel.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])')
      ).filter(function (el) {
        return !el.disabled && el.offsetParent !== null;
      });
    }

    function open(title) {
      if (positionEl) positionEl.textContent = 'VỊ TRÍ ' + title.toUpperCase();
      lastFocused = document.activeElement;
      modal.classList.add('is-open');
      modal.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      if (panel) panel.focus();
    }

    function close() {
      modal.classList.remove('is-open');
      modal.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
      if (lastFocused && lastFocused.focus) lastFocused.focus();
      lastFocused = null;
    }

    function trapTab(e) {
      var items = focusables();
      if (!items.length) return;
      var first = items[0];
      var last = items[items.length - 1];
      if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    }

    function resetFileHints() {
      fileFields.forEach(function (field) {
        if (field.hint) field.hint.textContent = field.placeholder;
      });
    }

    Array.prototype.slice.call(document.querySelectorAll('[data-job-apply]')).forEach(function (btn) {
      btn.addEventListener('click', function () {
        open(btn.getAttribute('data-job-title') || '');
      });
    });

    Array.prototype.slice.call(modal.querySelectorAll('[data-job-modal-close]')).forEach(function (el) {
      el.addEventListener('click', close);
    });

    document.addEventListener('keydown', function (e) {
      if (!modal.classList.contains('is-open')) return;
      if (e.key === 'Escape') close();
      else if (e.key === 'Tab') trapTab(e);
    });

    fileFields.forEach(function (field) {
      field.input.addEventListener('change', function () {
        if (field.hint && field.input.files && field.input.files[0]) {
          field.hint.textContent = field.input.files[0].name;
        }
      });
    });

    if (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        // TODO: nối backend nhận hồ sơ. Khi làm, nhớ kèm nonce + check_ajax_referer()
        // và validate/giới hạn kiểu file phía server trước khi nhận CV/Portfolio.
        form.reset();
        resetFileHints();
        close();
      });
    }
  }

})();
