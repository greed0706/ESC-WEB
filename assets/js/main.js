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
    initNewsFilter();
    initJobsFilter();
    initJobModal();
    initStickyHeader();
    initAOS();
    initHeroIntro();
    initHeroSlider();
    initCharsReveal();
    initPinsReveal();
    initStatsOdometer();
    initPtbvCarousel();
    initPtbvCulture();
    initLangDropdown();
    initMobileSubmenu();
    initHeaderSearch();
  });

  /* ---------------------------------------------------------------- */
  /**
   * Ô tìm kiếm ở header hoạt động như một NGĂN KÉO: bấm icon kính lúp thì
   * thanh dọc xám (.ecs-header__divider) trượt sang trái, ô nhập bung ra lấp
   * vào chỗ đó và che bớt .ecs-header__nav-list; icon biến mất. Enter submit
   * về /?s=... do search.php render. Esc hoặc click ra ngoài (bất kỳ chỗ nào
   * không thuộc form) thì ngăn kéo đóng lại về đúng vị trí cũ.
   *
   * Thanh dọc là ANH EM ĐỨNG TRƯỚC form nên CSS không chọn ngược lên nó được
   * từ .is-open của form — vì vậy phải gắn thêm .is-search-open lên
   * .ecs-header__actions (cha chung) để SCSS có chỗ bám.
   *
   * Không JS thì form vẫn submit bình thường — SCSS chỉ thu nhỏ ô nhập dưới
   * lớp .js nên trang vẫn dùng được.
   */
  function initHeaderSearch() {
    var form = document.querySelector('[data-header-search]');
    if (!form) return;

    var input = form.querySelector('[data-header-search-input]');
    var btn = form.querySelector('[data-header-search-btn]');
    if (!input || !btn) return;

    var actions = form.closest ? form.closest('.ecs-header__actions') : form.parentNode;

    function open() {
      form.classList.add('is-open');
      if (actions) actions.classList.add('is-search-open');
      input.removeAttribute('tabindex');
      input.focus();
    }

    function close() {
      form.classList.remove('is-open');
      if (actions) actions.classList.remove('is-search-open');
      input.setAttribute('tabindex', '-1');
      input.blur();
    }

    // Icon chỉ có một việc: mở ngăn kéo.
    //
    // TUYỆT ĐỐI KHÔNG preventDefault() vô điều kiện ở đây. Khi ngăn kéo đang mở
    // và người dùng bấm Enter trong ô nhập, trình duyệt submit ngầm bằng cách
    // BẮN MỘT SỰ KIỆN CLICK vào nút submit — click đó chạy qua handler này.
    // Chặn nó = chặn luôn việc tìm kiếm (gõ xong Enter không có gì xảy ra).
    btn.addEventListener('click', function (e) {
      if (form.classList.contains('is-open')) return; // để nút submit làm việc của nó
      e.preventDefault();
      open();
    });

    form.addEventListener('submit', function (e) {
      if (input.value.trim() === '') e.preventDefault();
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && form.classList.contains('is-open')) close();
    });

    document.addEventListener('click', function (e) {
      if (form.classList.contains('is-open') && !form.contains(e.target)) close();
    });
  }

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
   * Odometer cho "NHỮNG CON SỐ ẤN TƯỢNG" (.ecs-ve-stats): mỗi chữ số là một ô
   * cao 1em, bên trong là dải số xếp dọc trượt XUỐNG rồi dừng đúng số đích —
   * giống mặt công-tơ-mét. Chạy 1 lần khi khối cuộn vào viewport.
   *
   * Progressive enhancement: PHP in ra text thật ('235.000+'); hàm này mới
   * dựng các cột. Tắt JS / reduced-motion → DOM không bị đụng, số vẫn hiện.
   *
   * Ký tự không phải chữ số ('.', '+', ' ', 'năm') giữ nguyên, không quay.
   */
  function initStatsOdometer() {
    var blocks = document.querySelectorAll('[data-stats-odometer]');
    if (!blocks.length) return;

    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce || !('IntersectionObserver' in window)) return; // giữ nguyên text thật

    var SPINS = 2; // số vòng 0-9 quay trước khi dừng — càng lớn càng "lâu tới đích"

    /**
     * Dựng lại 1 ô số thành các cột chữ số. Dải số xếp theo thứ tự GIẢM DẦN và
     * chữ số đích nằm TRÊN CÙNG; strip bắt đầu ở đáy (translateY âm) rồi chạy
     * về 0 — nhờ vậy các con số trôi xuống chứ không trượt lên.
     */
    function build(el) {
      var text = el.textContent;
      var frag = document.createDocumentFragment();
      var digits = [];

      for (var i = 0; i < text.length; i++) {
        var ch = text.charAt(i);
        if (ch < '0' || ch > '9') {
          var sep = document.createElement('span');
          sep.className = 'ecs-ve-stats__sep';
          sep.textContent = ch;
          frag.appendChild(sep);
          continue;
        }

        var cell = document.createElement('span');
        cell.className = 'ecs-ve-stats__digit';
        var strip = document.createElement('span');
        strip.className = 'ecs-ve-stats__strip';

        // [đích, 9, 8, … 0] x SPINS vòng. Số phần tử phía DƯỚI đích = độ dài cần trượt.
        var target = Number(ch);
        var seq = [target];
        for (var s = 0; s < SPINS * 10; s++) {
          seq.push((target + s + 1) % 10);
        }
        for (var k = 0; k < seq.length; k++) {
          var d = document.createElement('span');
          d.className = 'ecs-ve-stats__num';
          d.textContent = String(seq[k]);
          strip.appendChild(d);
        }

        cell.appendChild(strip);
        frag.appendChild(cell);
        digits.push({ strip: strip, offset: seq.length - 1 });
      }

      if (!digits.length) return null; // ô không có chữ số nào → để yên

      el.textContent = '';
      el.appendChild(frag);
      el.classList.add('is-odometer');
      return digits;
    }

    /** Đặt strip ở đáy rồi thả về 0; chữ số bên phải quay lâu hơn bên trái. */
    function spin(digits) {
      digits.forEach(function (d) {
        d.strip.style.transform = 'translateY(-' + d.offset + 'em)';
      });

      // Ép trình duyệt nhận vị trí xuất phát trước khi gắn transition, nếu không
      // nó gộp 2 lần ghi style vào cùng 1 frame và chữ số nhảy thẳng tới đích.
      void digits[0].strip.offsetHeight;

      digits.forEach(function (d, i) {
        d.strip.style.transition = 'transform ' + (800 + i * 150) + 'ms cubic-bezier(.16,1,.3,1)';
        d.strip.style.transform = 'translateY(0)';
      });
    }

    function run(block) {
      var values = block.querySelectorAll('[data-odometer]');
      Array.prototype.forEach.call(values, function (el, i) {
        var digits = build(el);
        if (!digits) return;
        // Lệch nhau theo thẻ, khớp với data-aos-delay (si * 80) của chính các thẻ đó.
        setTimeout(function () { spin(digits); }, i * 80);
      });
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) {
          run(e.target);
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
   * Khối TIN TỨC trang chủ (template-parts/section-news.php) — tab + bộ lọc +
   * đổi kiểu xem, chạy trên dữ liệu đã có sẵn trong DOM (không AJAX, không
   * reload). "XEM THÊM" giờ là LINK THẬT tới category.php của Chủ đề đang
   * chọn (hoặc tab loại tin đang active nếu Chủ đề = "Tất cả") — hàm này chỉ
   * cập nhật lại `href` của nó, không còn lộ thêm card tại chỗ.
   *
   * PHP in ra mọi card kèm data-tab / data-year / data-topic / data-format;
   * hàm này chỉ bật/tắt thuộc tính `hidden` (luôn giới hạn tối đa `per` card
   * khớp bộ lọc). Không có JS thì mọi card đều hiện (SCSS không ẩn gì cả),
   * nên khối vẫn dùng được.
   *
   * KHÔNG dùng chung attribute với initNewsPagination(): hàm kia bám
   * [data-news] / [data-news-page], hàm này bám [data-news-filter] /
   * [data-news-item]. Đừng đổi tên qua lại.
   */
  function initNewsFilter() {
    var root = document.querySelector('[data-news-filter]');
    if (!root) return;

    var list = root.querySelector('[data-news-list]');
    if (!list) return;

    var cards = Array.prototype.slice.call(list.querySelectorAll('[data-news-item]'));
    if (cards.length === 0) return;

    var per = parseInt(list.getAttribute('data-news-per'), 10) || 3;
    var tabs = Array.prototype.slice.call(root.querySelectorAll('[data-news-tab]'));
    var indicator = root.querySelector('[data-news-tab-indicator]');
    var views = Array.prototype.slice.call(root.querySelectorAll('[data-news-view]'));
    var selects = Array.prototype.slice.call(root.querySelectorAll('[data-news-key]'));
    var topicSelect = root.querySelector('[data-news-key="topic"]');
    var yearFrom = root.querySelector('[data-news-year-from]');
    var yearTo = root.querySelector('[data-news-year-to]');
    var empty = root.querySelector('[data-news-empty]');
    var moreWrap = root.querySelector('[data-news-more-wrap]');
    var more = root.querySelector('[data-news-more]');
    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    var tab = tabs.length ? tabs[0].getAttribute('data-news-tab') : '';

    // Đặt vạch cam (xem &__tab-indicator trong _news.scss) khớp đúng tab đang
    // active — offsetLeft/offsetTop tính theo .ecs-news__tabs (positioned
    // ancestor gần nhất) nên tự đúng cả khi tab xuống dòng ở màn hẹp.
    function moveIndicator(btn) {
      if (!indicator || !btn) return;
      indicator.style.left = btn.offsetLeft + 'px';
      indicator.style.width = btn.offsetWidth + 'px';
      indicator.style.top = (btn.offsetTop + btn.offsetHeight - 3) + 'px';
    }

    // Card lọt qua bộ lọc hiện tại chưa? Năm so sánh dạng SỐ vì "2026" > "999"
    // là false nếu so chuỗi.
    function matches(card) {
      if (tab && card.getAttribute('data-tab') !== tab) return false;

      var year = parseInt(card.getAttribute('data-year'), 10);
      if (yearFrom && yearFrom.value && year < parseInt(yearFrom.value, 10)) return false;
      if (yearTo && yearTo.value && year > parseInt(yearTo.value, 10)) return false;

      return selects.every(function (select) {
        if (!select.value) return true; // "Tất cả"
        return card.getAttribute('data-' + select.getAttribute('data-news-key')) === select.value;
      });
    }

    function render() {
      var visible = 0;

      cards.forEach(function (card) {
        if (!matches(card)) {
          card.hidden = true;
          return;
        }
        visible++;
        card.hidden = visible > per;
      });

      if (empty) empty.hidden = visible > 0;
      if (moreWrap) moreWrap.hidden = visible === 0;
    }

    // Chủ đề có link riêng (data-news-href trên <option>) thì ưu tiên link đó;
    // "Tất cả" (option rỗng) rơi về link category.php của tab loại tin đang active.
    function updateMoreHref() {
      if (!more) return;

      var topicHref = '';
      if (topicSelect && topicSelect.selectedIndex > -1) {
        topicHref = topicSelect.options[topicSelect.selectedIndex].getAttribute('data-news-href') || '';
      }
      if (topicHref) {
        more.href = topicHref;
        return;
      }

      var activeTab = tabs.filter(function (btn) { return btn.classList.contains('is-active'); })[0];
      if (activeTab) {
        var tabHref = activeTab.getAttribute('data-news-href');
        if (tabHref) more.href = tabHref;
      }
    }

    // Đổi tab: vạch cam trượt ngay (CSS transition lo phần chuyển động), còn
    // lưới card mờ đi rồi mới đổi card/mờ lại — tránh cảm giác card cũ-mới
    // "nhảy" tại chỗ không báo trước. Tắt hẳn độ trễ này khi prefers-reduced-motion.
    var SWITCH_FADE_MS = 180;

    function switchTab(btn) {
      if (btn.classList.contains('is-active')) return;

      tab = btn.getAttribute('data-news-tab');
      tabs.forEach(function (other) {
        var on = other === btn;
        other.classList.toggle('is-active', on);
        other.setAttribute('aria-selected', on ? 'true' : 'false');
      });
      moveIndicator(btn);
      updateMoreHref();

      if (reduceMotion) {
        render();
        return;
      }

      list.classList.add('is-switching');
      window.setTimeout(function () {
        render();
        list.classList.remove('is-switching');
      }, SWITCH_FADE_MS);
    }

    tabs.forEach(function (btn) {
      btn.addEventListener('click', function () { switchTab(btn); });
    });

    selects.forEach(function (select) {
      select.addEventListener('change', function () {
        render();
        updateMoreHref();
      });
    });
    if (yearFrom) yearFrom.addEventListener('change', render);
    if (yearTo) yearTo.addEventListener('change', render);

    // Đổi kiểu xem KHÔNG động vào bộ lọc — chỉ đổi lưới 3 cột ↔ hàng ngang.
    views.forEach(function (btn) {
      btn.addEventListener('click', function () {
        list.classList.toggle('is-list', btn.getAttribute('data-news-view') === 'list');
        views.forEach(function (other) {
          var on = other === btn;
          other.classList.toggle('is-active', on);
          other.setAttribute('aria-pressed', on ? 'true' : 'false');
        });
      });
    });

    // Đặt vạch cam đúng vị trí tab active NGAY lúc tải trang, tắt transition
    // tạm thời để nó không trượt từ (0,0) tới — chỉ animate khi người dùng
    // thật sự đổi tab (transition được bật lại ở khung hình kế tiếp).
    if (indicator) {
      var activeOnLoad = tabs.filter(function (btn) { return btn.classList.contains('is-active'); })[0];
      indicator.style.transition = 'none';
      moveIndicator(activeOnLoad || tabs[0]);
      // Ép trình duyệt áp style trên trước khi gỡ transition:none.
      indicator.getBoundingClientRect();
      indicator.style.transition = '';
    }

    render();
    updateMoreHref();

    // Tab có thể xuống dòng khác khi resize (flex-wrap) — đo lại vị trí tab
    // active để vạch cam không bị lệch chỗ cũ. Debounce nhẹ vì resize bắn liên tục.
    if (indicator) {
      var resizeTimer = null;
      window.addEventListener('resize', function () {
        window.clearTimeout(resizeTimer);
        resizeTimer = window.setTimeout(function () {
          var active = tabs.filter(function (btn) { return btn.classList.contains('is-active'); })[0];
          moveIndicator(active || tabs[0]);
        }, 150);
      });
    }
  }

  /* ---------------------------------------------------------------- */
  /**
   * Hero slider trang chủ (template-parts/section-hero-banner.php).
   *
   * Ảnh + cấu hình do Theme Options → Hero Slider quyết định; PHP chỉ in ra
   * [data-hero-slider] khi có TỪ 2 SLIDE TRỞ LÊN, nên trang chủ 1 banner đi
   * thẳng qua hàm này mà không tốn gì.
   *
   * Class .owl-* đặt theo quy ước OwlCarousel cho quen mắt nhưng KHÔNG dùng
   * thư viện đó (nó cần jQuery) — track dịch bằng transform, mỗi slide rộng
   * đúng 100% nên translateX(-n * 100%) là sang slide thứ n.
   */
  function initHeroSlider() {
    var root = document.querySelector('[data-hero-slider]');
    if (!root) return;
    var track = root.querySelector('[data-hero-track]');
    var slides = track ? Array.prototype.slice.call(track.querySelectorAll('[data-hero-slide]')) : [];
    if (!track || slides.length < 2) return;

    var dots = Array.prototype.slice.call(root.querySelectorAll('[data-hero-dot]'));
    var prev = root.querySelector('[data-hero-prev]');
    var next = root.querySelector('[data-hero-next]');

    // Tôn trọng "giảm chuyển động" của hệ điều hành: tắt tự chạy và bỏ luôn
    // hiệu ứng trượt, nhưng vẫn bấm dot/mũi tên đổi slide được.
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var speed = reduce ? 0 : (parseInt(root.getAttribute('data-speed'), 10) || 0);
    var interval = parseInt(root.getAttribute('data-interval'), 10) || 5000;
    var autoplay = root.getAttribute('data-autoplay') === '1' && !reduce;

    var index = 0;
    var timer = null;
    var paused = false;

    track.style.transitionDuration = speed + 'ms';

    function show(i) {
      index = ((i % slides.length) + slides.length) % slides.length;
      track.style.transform = 'translateX(' + (-index * 100) + '%)';

      slides.forEach(function (slide, n) {
        var on = n === index;
        slide.classList.toggle('is-active', on);
        if (on) slide.removeAttribute('aria-hidden');
        else slide.setAttribute('aria-hidden', 'true');
        // Banner có link: slide đang ẩn không được nhận focus bằng phím Tab.
        var link = slide.querySelector('a');
        if (link) {
          if (on) link.removeAttribute('tabindex');
          else link.setAttribute('tabindex', '-1');
        }
      });

      dots.forEach(function (dot, n) {
        var on = n === index;
        dot.classList.toggle('is-active', on);
        dot.setAttribute('aria-selected', on ? 'true' : 'false');
      });
    }

    function stop() {
      if (timer) {
        clearInterval(timer);
        timer = null;
      }
    }

    function start() {
      stop();
      if (autoplay && !paused) timer = setInterval(function () { show(index + 1); }, interval);
    }

    /** Chuyển slide do người dùng chủ động → đặt lại đồng hồ tự chạy. */
    function go(i) {
      show(i);
      start();
    }

    if (prev) prev.addEventListener('click', function () { go(index - 1); });
    if (next) next.addEventListener('click', function () { go(index + 1); });
    dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () { go(i); });
    });

    // Dừng khi người dùng đang xem/thao tác, và khi tab bị ẩn.
    root.addEventListener('mouseenter', function () { paused = true; stop(); });
    root.addEventListener('mouseleave', function () { paused = false; start(); });
    root.addEventListener('focusin', function () { paused = true; stop(); });
    root.addEventListener('focusout', function () { paused = false; start(); });
    document.addEventListener('visibilitychange', function () {
      if (document.hidden) stop();
      else start();
    });

    // Vuốt ngang trên mobile. Chỉ tính khi đi đủ xa VÀ rõ ràng ngang hơn dọc,
    // nếu không sẽ cướp mất thao tác cuộn trang.
    var startX = 0;
    var startY = 0;
    var swiping = false;
    track.addEventListener('touchstart', function (e) {
      if (e.touches.length !== 1) return;
      startX = e.touches[0].clientX;
      startY = e.touches[0].clientY;
      swiping = true;
      paused = true;
      stop();
    }, { passive: true });
    track.addEventListener('touchend', function (e) {
      if (!swiping) return;
      swiping = false;
      var touch = e.changedTouches[0];
      var dx = touch.clientX - startX;
      var dy = touch.clientY - startY;
      if (Math.abs(dx) > 40 && Math.abs(dx) > Math.abs(dy)) show(dx < 0 ? index + 1 : index - 1);
      paused = false;
      start();
    }, { passive: true });

    show(0);
    start();
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
  /**
   * VĂN HÓA ECS — carousel đổi nội dung thẻ theo chấm phân trang. Chỉ bật/tắt
   * lớp .is-active trên slide + chấm tương ứng (SCSS lo hiện/ẩn).
   */
  function initPtbvCulture() {
    var root = document.querySelector('[data-ptbv-culture]');
    if (!root) return;
    var slides = Array.prototype.slice.call(root.querySelectorAll('[data-culture-slide]'));
    var dots = Array.prototype.slice.call(root.querySelectorAll('[data-culture-dot]'));
    if (slides.length === 0 || dots.length !== slides.length) return;

    function show(i) {
      slides.forEach(function (s, n) { s.classList.toggle('is-active', n === i); });
      dots.forEach(function (d, n) {
        var on = n === i;
        d.classList.toggle('is-active', on);
        d.setAttribute('aria-selected', on ? 'true' : 'false');
      });
    }

    dots.forEach(function (dot, i) {
      dot.addEventListener('click', function () { show(i); });
    });
    show(0);
  }
  /* ---------------------------------------------------------------- */
  /**
   * Bộ lọc + phân trang việc làm (trang Tuyển dụng).
   *
   * Các thẻ job mang data-location / data-department / data-type là giá trị
   * GỐC tiếng Việt, khớp với value của <option> trong 3 select — nên bộ lọc
   * chạy đúng cả khi giao diện đang hiển thị tiếng Anh.
   *
   * Bấm TÌM KIẾM → lọc thẻ khớp cả 3 điều kiện (bỏ trống = không lọc), rồi
   * xếp lại thành các trang 4 thẻ và dựng lại chấm phân trang. Thẻ được DI
   * CHUYỂN (không clone) nên listener của nút "Ứng tuyển ngay" vẫn còn.
   */
  function initJobsFilter() {
    var list = document.querySelector('[data-jobs]');
    if (!list) return;

    var cards = Array.prototype.slice.call(list.querySelectorAll('[data-job]'));
    if (cards.length === 0) return;

    var per = parseInt(list.getAttribute('data-jobs-per'), 10) || 4;
    var nav = document.querySelector('[data-jobs-pagination]');
    var dotsWrap = nav ? nav.querySelector('[data-jobs-dots]') : null;
    var empty = document.querySelector('[data-jobs-empty]');
    var selects = Array.prototype.slice.call(document.querySelectorAll('[data-jobs-filter]'));
    var search = document.querySelector('[data-jobs-search]');

    var pages = [];
    var dots = [];
    var current = 0;

    function show(index) {
      if (pages.length === 0) return;
      current = ((index % pages.length) + pages.length) % pages.length;
      pages.forEach(function (page, i) {
        page.classList.toggle('is-active', i === current);
      });
      dots.forEach(function (dot, i) {
        var on = i === current;
        dot.classList.toggle('is-active', on);
        dot.setAttribute('aria-selected', on ? 'true' : 'false');
      });
    }

    function buildDots(count) {
      if (!nav) return;
      dots = [];
      nav.hidden = count <= 1;
      if (!dotsWrap) return;
      dotsWrap.innerHTML = '';
      if (count <= 1) return;

      var label = nav.getAttribute('data-page-label') || 'Trang';
      for (var i = 0; i < count; i++) {
        var dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'ecs-jobs__dot';
        dot.setAttribute('data-jobs-dot', i);
        dot.setAttribute('aria-label', label + ' ' + (i + 1));
        dot.setAttribute('aria-selected', 'false');
        dot.addEventListener('click', (function (n) {
          return function () { show(n); };
        })(i));
        dotsWrap.appendChild(dot);
        dots.push(dot);
      }
    }

    function layout(visible) {
      Array.prototype.slice.call(list.querySelectorAll('[data-jobs-page]')).forEach(function (page) {
        page.parentNode.removeChild(page);
      });
      pages = [];

      var count = Math.ceil(visible.length / per);
      for (var i = 0; i < count; i++) {
        var page = document.createElement('div');
        page.className = 'ecs-jobs__page';
        page.setAttribute('data-jobs-page', i);
        visible.slice(i * per, (i + 1) * per).forEach(function (card) {
          page.appendChild(card);
        });
        list.appendChild(page);
        pages.push(page);
      }

      if (empty) empty.hidden = visible.length > 0;
      buildDots(count);
      show(0);
    }

    function apply() {
      var criteria = selects.map(function (select) {
        return { key: select.getAttribute('data-jobs-filter'), value: select.value };
      }).filter(function (c) { return c.value !== ''; });

      layout(cards.filter(function (card) {
        return criteria.every(function (c) {
          return card.getAttribute('data-' + c.key) === c.value;
        });
      }));
    }

    if (search) search.addEventListener('click', apply);
    selects.forEach(function (select) {
      select.addEventListener('change', apply);
    });

    if (nav) {
      var prev = nav.querySelector('[data-jobs-prev]');
      var next = nav.querySelector('[data-jobs-next]');
      if (prev) prev.addEventListener('click', function () { show(current - 1); });
      if (next) next.addEventListener('click', function () { show(current + 1); });
    }

    layout(cards);
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
