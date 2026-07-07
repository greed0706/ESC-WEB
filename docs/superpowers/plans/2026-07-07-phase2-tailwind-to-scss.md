# Phase 2 — Migrate Tailwind → SCSS (semantic/BEM) — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Thay toàn bộ class utility Tailwind trong markup PHP bằng class ngữ nghĩa (BEM) + style viết bằng SCSS, giữ nguyên 100% giao diện & hành vi, không làm vỡ site giữa chừng.

**Architecture:** Migration **incremental, không big-bang cutover**. Trong lúc chuyển: giữ Tailwind vẫn build `assets/css/main.css` cho các section CHƯA chuyển; SCSS compile ra **file riêng** `assets/css/theme.css`, enqueue SAU main.css. Mỗi section chuyển xong thì (1) markup đổi từ utility → class BEM, (2) style của nó nằm trong partial SCSS. Utility bị gỡ khỏi PHP → Tailwind ngừng sinh chúng; class BEM do theme.css style. Class BEM và utility không trùng tên nên 2 stylesheet cùng tồn tại an toàn. **Cutover cuối:** khi mọi section đã chuyển, gỡ Tailwind + main.css, thêm reset tối thiểu vào SCSS, đổi `theme.css` thành nguồn CSS duy nhất.

**Tech Stack:** WordPress classic PHP theme; **Dart Sass** compile bằng extension IDE (Live Sass Compiler) — KHÔNG thêm npm dep; vanilla JS (`assets/js/main.js`); AOS + Headroom vendored; PHP 8.3 (Laragon).

## Global Constraints

- **Giữ giao diện & hành vi y hệt.** Không đổi layout, màu, spacing, animation. Migration thuần tuý đổi cách viết style.
- **KHÔNG cutover sớm.** Tailwind `main.css` phải còn sống tới khi TẤT CẢ section đã chuyển (Task cuối). Trước đó site chạy đồng thời `main.css` (Tailwind, cho phần chưa chuyển) + `theme.css` (SCSS, cho phần đã chuyển).
- **SCSS compile bằng Dart Sass CLI** (`npm run build:scss`; watch: `npm run watch:scss`), input `src/scss/main.scss` → output `assets/css/theme.css` (nén). KHÔNG dùng `main.css` làm output SCSS cho tới khi cutover. (`sass` là devDependency; người dùng vẫn có thể watch bằng extension IDE nếu muốn.)
- **JS coupling bắt buộc xử lý cùng lúc.** `assets/js/main.js` hiện toggle TRỰC TIẾP class Tailwind. Khi chuyển section có JS, phải đổi JS sang toggle **class trạng thái ngữ nghĩa** (`.is-active`, `.is-open`, `.is-hidden`) và SCSS phải định nghĩa các trạng thái đó. Các coupling:
  - `initMobileMenu` → toggle `hidden` trên menu + icon open/close.
  - `initEcosystemTabs` (dùng cho cả trang chủ ecosystem VÀ `linh-vuc-tabs`) → toggle `bg-brand`,`text-white`,`bg-white`,`text-ink` (tab), `text-white`/`text-[#A4A4A4]` (icon), `lg:block` (caret), `grid`/`hidden` (panel).
  - `initNewsPagination` → toggle `flex`/`hidden` (page), `bg-brand`/`bg-placeholder` (dot).
  - `initLangDropdown` → đã dùng `.is-open` (ngữ nghĩa) — GIỮ NGUYÊN.
  - `initStickyHeader`/Headroom → dùng class `headroom--*` (đã ngữ nghĩa, đã có trong `_components`) — GIỮ NGUYÊN.
  - `initPtbvCarousel` → set `style.transform` inline, KHÔNG toggle class — GIỮ NGUYÊN.
- **Đặt tên BEM** theo tiền tố `ecs-`: block `.ecs-<section>`, element `.ecs-<section>__<part>`, modifier `.ecs-<section>__<part>--<state>`; trạng thái động dùng `.is-*`.
- **Token dùng biến SCSS**, không hardcode hex/px rời rạc khi đã có biến (xem `_variables.scss`). Giá trị token gốc lấy từ `src/tailwind.css` (`@theme`).
- **Không placeholder trong code steps.** Foundation (Task 1) và bản mẫu Footer (Task 2) có code đầy đủ; các task section áp dụng ĐÚNG phương pháp của Task 2 (đây là phương pháp hoàn chỉnh, không phải placeholder).
- **Lint PHP**: `"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l <file>`. **Check JS**: `node --check assets/js/main.js`.
- **Verify mỗi section**: sau khi chuyển, mở section trên `http://ecs.test/...` và so sánh mắt với trước (phải giống hệt); các section chưa chuyển vẫn nguyên nhờ Tailwind còn sống.

---

## File Structure

**SCSS mới (`src/scss/`):**
```
main.scss                // @use tất cả partial theo thứ tự
_variables.scss          // tokens từ @theme (màu, font, layout)
_mixins.scss             // container(), reduced-motion, focus-visible
_base.scss               // @layer base hiện có (+ reset tối thiểu khi cutover)
_keyframes.scss          // 5 @keyframes hiện có
_components.scss         // @layer components hiện có + lang dropdown + reduced-motion media
components/
  _header.scss  _footer.scss  _section-heading.scss  _buttons.scss
  _hero.scss  _about.scss  _journey.scss  _ecosystem.scss  _news.scss  _branch.scss
  _ve-ecs.scss           // gộp 5 partial ve-ecs (hero/journey/vision-mission/values/stats) hoặc tách nếu lớn
  _page-hero.scss  _linh-vuc-tabs.scss  _ptbv.scss  (team/values/guides)
```

**Sửa:** `functions.php` (enqueue theme.css; cutover: bỏ main.css), `assets/js/main.js` (đổi class-toggle sang trạng thái ngữ nghĩa), tất cả `template-parts/*.php` + `header.php` + `footer.php` + `index.php` (utility → BEM), `package.json` + `src/tailwind.css` (xoá khi cutover), `CLAUDE.md` (cập nhật workflow).

**Thứ tự chuyển section** (shared trước → landing → ve-ecs → trang mới):
footer → header → primitives(functions.php helpers) → hero(landing) → about → journey → ecosystem(+JS) → news(+JS) → branch → ve-ecs(×5) → page-hero → linh-vuc-tabs(+JS) → ptbv-team → ptbv-values → ptbv-guides → JS refactor cuối → cutover.

---

## Task 0: Toolchain SCSS + cơ chế transition (không phá site)

**Files:**
- Create: `src/scss/main.scss` (rỗng tạm), `.vscode/settings.json` (cấu hình extension — nếu chưa có)
- Modify: `functions.php` (enqueue theme.css)

**Interfaces — Produces:** `assets/css/theme.css` (SCSS compile ra), enqueue sau `ecsges-main`; npm scripts `build:scss`/`watch:scss`.

- [ ] **Step 1: Thêm Dart Sass** — `npm install -D sass`, và thêm scripts vào `package.json` (giữ nguyên script Tailwind tới cutover):

```json
    "build:scss": "sass src/scss/main.scss assets/css/theme.css --style=compressed --no-source-map",
    "watch:scss": "sass --watch src/scss/main.scss:assets/css/theme.css --style=compressed --no-source-map"
```

- [ ] **Step 2: Tạo `src/scss/main.scss` tạm** (một dòng để compile ra file):

```scss
// ECSGES theme styles (SCSS). Partial sẽ được @use dần ở Task 1+.
body { -webkit-font-smoothing: antialiased; }
```

- [ ] **Step 3: Enqueue `theme.css` sau main.css** trong `functions.php` (trong `ecsges_assets()`, ngay sau block enqueue `ecsges-main`):

```php
	// SCSS (Phase 2) — nạp SAU main.css để phủ dần các section đã chuyển.
	$theme_css_path = $dir . '/assets/css/theme.css';
	if ( file_exists( $theme_css_path ) ) {
		$theme_css_ver = filemtime( $theme_css_path );
		wp_enqueue_style( 'ecsges-theme', $uri . '/assets/css/theme.css', array( 'ecsges-main' ), $theme_css_ver );
	}
```

- [ ] **Step 4: Verify** — compile SCSS (Watch Sass), rồi:

Run: `"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l functions.php`
Run: `ls -l assets/css/theme.css` (tồn tại)
Run: `curl -s http://ecs.test/ | grep -c 'theme.css'` → Expected: `1`
Expected: site vẫn hiển thị y hệt (theme.css gần như rỗng, chưa ảnh hưởng).

---

## Task 1: SCSS foundation (tokens, base, keyframes, components)

**Files:**
- Create: `src/scss/_variables.scss`, `_mixins.scss`, `_base.scss`, `_keyframes.scss`, `_components.scss`
- Modify: `src/scss/main.scss` (@use tất cả)

**Interfaces — Produces:** biến `$brand`, `$brand-dark`, `$blue`, `$ink`, `$body`, `$muted`, `$muted-2`, `$surface`, `$surface-2`, `$placeholder`, `$font-sans`, `$font-display`, `$font-script`, `$page-max`; mixin `container()`; tất cả animation/hero/header component classes (port nguyên từ `src/tailwind.css`).

- [ ] **Step 1: `_variables.scss`** (port từ `@theme` trong tailwind.css:38-62)

```scss
// Brand
$brand:       #f05a28;
$brand-dark:  #de4f1f;
$blue:        #0060ae;
// Text
$ink:         #000000;
$body:        #2d2d2d;
$muted:       #686868;
$muted-2:     #747272;
// Surfaces
$surface:     #f3f3f3;
$surface-2:   #f0f0f0;
$placeholder: #d9d9d9;
// Typography
$font-sans:    'Roboto', system-ui, 'Segoe UI', sans-serif;
$font-display: 'Roboto Flex', 'Roboto', system-ui, sans-serif;
$font-script:  'Dancing Script', 'Roboto Flex', cursive;
// Layout
$page-max: 1152px;
// Breakpoints (khớp Tailwind mặc định đang dùng: sm/md/lg)
$bp-sm: 640px;
$bp-md: 768px;
$bp-lg: 1024px;
```

- [ ] **Step 2: `_mixins.scss`**

```scss
@use 'variables' as *;

// Container căn giữa + max-width trang + padding ngang (thay 'mx-auto w-full max-w-page px-6 md:px-10').
@mixin container {
  margin-inline: auto;
  width: 100%;
  max-width: $page-max;
  padding-inline: 1.5rem;            // px-6
  @media (min-width: $bp-md) { padding-inline: 2.5rem; } // md:px-10
}

@mixin bp($size) {
  @if $size == sm { @media (min-width: $bp-sm) { @content; } }
  @else if $size == md { @media (min-width: $bp-md) { @content; } }
  @else if $size == lg { @media (min-width: $bp-lg) { @content; } }
}
```

- [ ] **Step 3: `_base.scss`** (port `@layer base` tailwind.css:64-79; @font-face giữ nguyên URL `../fonts/` vì output theme.css cùng thư mục `assets/css/`)

```scss
@use 'variables' as *;

@font-face { font-family:'Roboto'; font-style:normal; font-weight:300; font-display:swap; src:url('../fonts/Roboto-Light.ttf') format('truetype'); }
@font-face { font-family:'Roboto'; font-style:normal; font-weight:400; font-display:swap; src:url('../fonts/Roboto-Regular.ttf') format('truetype'); }
@font-face { font-family:'Roboto'; font-style:normal; font-weight:500; font-display:swap; src:url('../fonts/Roboto-Medium.ttf') format('truetype'); }
@font-face { font-family:'Roboto'; font-style:normal; font-weight:700; font-display:swap; src:url('../fonts/Roboto-Bold.ttf') format('truetype'); }

// LƯU Ý: reset/preflight KHÔNG thêm ở đây trong lúc transition (Tailwind preflight còn sống qua main.css).
// Ở Task cutover mới thêm reset tối thiểu.
body {
  margin: 0;
  font-family: $font-sans;
  color: $body;
  background: #fff;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-rendering: optimizeLegibility;
}
:focus-visible { outline: 2px solid $blue; outline-offset: 2px; }
```

- [ ] **Step 4: `_keyframes.scss`** — port nguyên 5 keyframes (tailwind.css:251-314): `ecsges-ripple`, `ecsges-breathe`, `ecsges-earth-ping`, `ecsges-underline-sweep`, `ecsges-hero-failsafe`. (Chép y hệt phần `@keyframes` từ tailwind.css.)

- [ ] **Step 5: `_components.scss`** — port `@layer components` (tailwind.css:85-235) + dropdown ngôn ngữ (237-249) + media reduced-motion (316-329). Bỏ wrapper `@layer components { }` (SCSS không cần), giữ nguyên mọi selector/khai báo bên trong. Thay `var(--color-brand)` → `$brand` (thêm `@use 'variables' as *;` đầu file).

- [ ] **Step 6: `main.scss`** — thay nội dung tạm bằng:

```scss
@use 'variables';
@use 'base';
@use 'keyframes';
@use 'components';
// components/* sẽ được thêm dần khi chuyển từng section (Task 2+).
```

- [ ] **Step 7: Verify** — compile SCSS; `ls -l assets/css/theme.css`; mở `http://ecs.test/` — hero animation/header sticky/lang dropdown vẫn chạy (giờ do theme.css cấp, trùng với Tailwind nhưng không xung đột). Không lỗi console.

---

## Task 2: BẢN MẪU phương pháp — chuyển Footer

**Đây là phương pháp chuẩn cho MỌI task section sau.** Footer chọn làm mẫu vì tự chứa, dùng chung mọi trang, có JS = 0.

**Files:**
- Modify: `footer.php` (utility → BEM)
- Create: `src/scss/components/_footer.scss`
- Modify: `src/scss/main.scss` (`@use 'components/footer';`)

**Phương pháp (4 bước, lặp cho mọi section):**
1. Đọc markup hiện tại, liệt kê từng element + chuỗi utility của nó.
2. Đặt tên BEM cho từng element; thay `class="<utilities>"` bằng `class="ecs-footer__<part>"`.
3. Viết partial SCSS: mỗi class BEM tái tạo CHÍNH XÁC các utility đã gỡ (map từng utility → thuộc tính CSS; responsive dùng `@include bp()`), ưu tiên biến token.
4. `@use` partial vào main.scss; compile; so sánh mắt với bản cũ.

- [ ] **Step 1: Đổi markup `footer.php` sang BEM.** Ví dụ mapping (áp cho toàn file):

| Element | Utility cũ | Class BEM |
|---|---|---|
| `<footer>` | `bg-brand text-white` | `ecs-footer` |
| container | `mx-auto w-full max-w-page px-6 py-12 md:px-10 lg:py-16` | `ecs-footer__inner` |
| logo | `h-12 w-auto` | `ecs-footer__logo` |
| grid cột | `mt-10 grid gap-10 sm:grid-cols-2 lg:grid-cols-4` | `ecs-footer__grid` |
| tiêu đề cột | `font-display text-lg font-semibold` | `ecs-footer__col-title` |
| list | `mt-4 space-y-2` | `ecs-footer__list` |
| link | `flex items-center gap-3 font-light text-white/95 transition-all duration-200 hover:translate-x-1 hover:text-white` | `ecs-footer__link` |
| chấm | `size-1.5 shrink-0 rounded-full bg-white/90` | `ecs-footer__dot` |
| ... | (tiếp: contact list, social) | `ecs-footer__contact`, `ecs-footer__social`, ... |

- [ ] **Step 2: Viết `src/scss/components/_footer.scss`** — tái tạo chính xác, ví dụ:

```scss
@use '../variables' as *;
@use '../mixins' as *;

.ecs-footer {
  background: $brand;
  color: #fff;
  &__inner { @include container; padding-block: 3rem; @include bp(lg) { padding-block: 4rem; } } // py-12 / lg:py-16
  &__logo { height: 3rem; width: auto; }                                                          // h-12 w-auto
  &__grid {
    margin-top: 2.5rem; display: grid; gap: 2.5rem;                                                // mt-10 gap-10
    @include bp(sm) { grid-template-columns: repeat(2, minmax(0,1fr)); }                            // sm:grid-cols-2
    @include bp(lg) { grid-template-columns: repeat(4, minmax(0,1fr)); }                            // lg:grid-cols-4
  }
  &__col-title { font-family: $font-display; font-size: 1.125rem; font-weight: 600; }               // text-lg font-semibold
  &__list { margin-top: 1rem; > li + li { margin-top: 0.5rem; } }                                   // mt-4 space-y-2
  &__link {
    display: flex; align-items: center; gap: 0.75rem; font-weight: 300;
    color: rgba(#fff, 0.95); transition: all .2s;
    &:hover { color: #fff; transform: translateX(0.25rem); }
  }
  &__dot { width: .375rem; height: .375rem; flex-shrink: 0; border-radius: 9999px; background: rgba(#fff, .9); }
  // ... contact + social: map nốt các utility còn lại theo đúng cách trên.
}
```
(Implementer map HẾT các element còn lại của footer y phương pháp này — không bỏ sót element nào.)

- [ ] **Step 3: `@use 'components/footer';`** vào `main.scss`.

- [ ] **Step 4: Verify** — lint `footer.php`; compile SCSS; mở bất kỳ trang nào, cuộn xuống footer: **phải giống hệt** trước (màu cam, 4 cột, hover dịch phải, social). Vì đã gỡ utility khỏi footer.php, Tailwind ngừng style nó; theme.css lo. Các phần khác trang không đổi.

---

## Task 3..18: Chuyển từng section (áp dụng phương pháp Task 2)

Mỗi task dưới đây = 1 file markup + 1 partial SCSS + `@use` vào main.scss + verify. **Áp dụng ĐÚNG 4 bước của Task 2.** Chỉ ghi điểm đặc thù/bẫy của từng section.

- [ ] **Task 3 — Header** (`header.php` → `_header.scss`, block `.ecs-header`). Bẫy: (a) `.site-header` + `headroom--*` đã ở `_components` — GIỮ class `site-header`, chỉ chuyển các utility khác. (b) `.js` gating (inline script thêm `.js` vào `<html>`) giữ nguyên. (c) menu mobile toggle `hidden` — xem Task 17 (JS): tạm thời để cả class `hidden` (Tailwind còn sống) HOẶC chuyển ngay sang `.is-hidden` + cập nhật JS phần menu. **Khuyến nghị: chuyển JS của menu ngay trong task này** (đổi `menu.classList.toggle('hidden')` → `toggle('is-hidden')`, định nghĩa `.ecs-header__mobile.is-hidden{display:none}`).
- [ ] **Task 4 — Primitives (helpers trong `functions.php`)**: `ecsges_section_heading()`, `ecsges_underline_link()`, `ecsges_see_more()`, `ecsges_img`/icon output — đổi markup các helper này sang BEM (`.ecs-heading`, `.ecs-underline`, `.ecs-see-more`) → `_section-heading.scss` + `_buttons.scss`. Bẫy: `.ecsges-underline` animation đã ở `_components` — giữ tên đó; chỉ chuyển utility phần còn lại.
- [ ] **Task 5 — Hero trang chủ** (`section-hero.php` → `_hero.scss`, `.ecs-hero`). Bẫy: các class hero-intro (`.ecsges-hero-emblem`, `.ecsges-hero-mark`, `.hero-reveal`, `[data-hero-chars]`, `.hero-char`, `.ecsges-earth-ping`) đã ở `_components` — GIỮ NGUYÊN, chỉ chuyển utility bố cục.
- [ ] **Task 6 — About** (`section-about.php` → `_about.scss`, `.ecs-about`).
- [ ] **Task 7 — Journey landing** (`section-journey.php` → `_journey.scss`, `.ecs-journey`).
- [ ] **Task 8 — Ecosystem (+JS tabs)** (`section-ecosystem.php` → `_ecosystem.scss`, `.ecs-ecosystem`). Bẫy: `initEcosystemTabs` toggle class — chuyển JS sang `.is-active` (xem Task 17). Markup: tab active/inactive & panel dùng `.ecs-ecosystem__tab.is-active` / `.ecs-ecosystem__panel.is-active`. **Cập nhật cả `linh-vuc-tabs.php` (Task 15) vì dùng chung JS này** — làm JS 1 lần ở Task 17, 2 markup ở Task 8 & 15 phải cùng quy ước class.
- [ ] **Task 9 — News (+JS pagination)** (`section-news.php` → `_news.scss`, `.ecs-news`). Bẫy: `initNewsPagination` toggle `flex`/`hidden`/`bg-brand`/`bg-placeholder` — chuyển sang `.is-active` (page) & `.is-active` (dot) trong Task 17.
- [ ] **Task 10 — Branch** (`section-branch.php` → `_branch.scss`, `.ecs-branch`). Bẫy: `.ecsges-pin`, `[data-pins-reveal]`, `.ecsges-earth-ping` đã ở `_components` — giữ nguyên.
- [ ] **Task 11 — Ve-ECS hero + journey** (`ve-ecs-hero.php`, `ve-ecs-journey.php` → `_ve-ecs.scss`, `.ecs-ve-hero`, `.ecs-ve-journey`).
- [ ] **Task 12 — Ve-ECS vision-mission + stats** (`ve-ecs-vision-mission.php`, `ve-ecs-stats.php` → thêm vào `_ve-ecs.scss`).
- [ ] **Task 13 — Ve-ECS values** (`ve-ecs-values.php` → `_ve-ecs.scss`). Bẫy: nhiều toạ độ tuyệt đối (`left-[..%] top-[..%]` + `scale`) — map cẩn thận từng arbitrary value sang CSS; `.ecsges-pin`/scale reveal giữ như `_components`.
- [ ] **Task 14 — Page-hero + linh-vuc-tabs** (`page-hero.php` → `_page-hero.scss` `.ecs-page-hero`; `linh-vuc-tabs.php` → `_linh-vuc.scss` `.ecs-lv`). Bẫy: `linh-vuc-tabs` dùng `data-ecosystem`/JS chung — cùng quy ước `.is-active` với Task 8; giữ overlap `.ecs-lv__panel` (image full-height + hộp chữ `z-index`).
- [ ] **Task 15 — Ptbv team + values + guides** (`ptbv-team.php`, `ptbv-values.php`, `ptbv-guides.php` → `_ptbv.scss`, `.ecs-team`, `.ecs-values`, `.ecs-guides`). Bẫy: carousel dùng inline transform — không cần đổi JS; giữ `data-ptbv-*`.
- [ ] **Task 16 — index.php** (fallback loop) — chuyển utility còn lại → dùng `container` mixin.

Mỗi task: lint PHP file đã sửa; compile SCSS; mở đúng trang chứa section, so sánh mắt với trước (giống hệt).

---

## Task 17: Refactor `main.js` — class Tailwind → trạng thái ngữ nghĩa

**Files:**
- Modify: `assets/js/main.js`
- Modify (nếu Task 3/8/9 chưa làm): các partial SCSS liên quan để định nghĩa `.is-*`.

**Nội dung:** đổi các chỗ `classList.toggle('<utility>')` sang trạng thái ngữ nghĩa, đồng bộ với markup đã chuyển:

- [ ] **Step 1: `initMobileMenu`** — `menu.classList.toggle('hidden', !open)` → `toggle('is-hidden', !open)`; icon open/close tương tự. SCSS: `.ecs-header__mobile.is-hidden{display:none}`, `.ecs-header__icon.is-hidden{display:none}`.
- [ ] **Step 2: `initEcosystemTabs`** — thay khối toggle nhiều class bằng:
```js
tabs.forEach(function (btn) {
  var on = btn.getAttribute('data-tab') === id;
  btn.classList.toggle('is-active', on);
  btn.setAttribute('aria-selected', on ? 'true' : 'false');
});
panels.forEach(function (p) {
  p.classList.toggle('is-active', p.getAttribute('data-panel') === id);
});
```
SCSS (`.ecs-ecosystem`/`.ecs-lv`): tab base + `&__tab.is-active{background:$brand;color:#fff}`; panel `&__panel{display:none}` + `&__panel.is-active{display:grid}` (ecosystem) / `display:block`(linh-vuc); caret `&__caret{display:none}` + `.is-active &__caret{...}` theo bản gốc.
- [ ] **Step 3: `initNewsPagination`** — `page.classList.toggle('flex'/'hidden')` → `toggle('is-active')`; dot `bg-brand`/`bg-placeholder` → `toggle('is-active')`. SCSS: `.ecs-news__page{display:none}`+`.is-active{display:flex}`; `.ecs-news__dot{background:$placeholder}`+`.is-active{background:$brand}`.
- [ ] **Step 4: Verify** — `node --check assets/js/main.js`; mở trang chủ: tab ecosystem đổi panel đúng, phân trang tin tức chạy, menu mobile (thu nhỏ cửa sổ) đóng/mở đúng; trang lĩnh-vực: tab chạy.

---

## Task 18: CUTOVER — gỡ Tailwind, SCSS thành nguồn CSS duy nhất

**Chỉ chạy khi TẤT CẢ section (Task 2–16) đã chuyển & verify.**

**Files:**
- Modify: `functions.php` (bỏ enqueue `ecsges-main`/main.css; đổi `ecsges-theme` thành handle chính, dependency chỉ còn `aos`)
- Modify: `src/scss/_base.scss` (thêm reset tối thiểu thay Tailwind preflight)
- Modify: `package.json` (xoá `@tailwindcss/cli`, `tailwindcss`, script `build:css`/`watch:css`)
- Delete: `src/tailwind.css`; `assets/css/main.css` (Tailwind build)
- Modify: `CLAUDE.md` (đổi mục "Commands" & "Animation/CSS conventions" từ Tailwind → SCSS)

- [ ] **Step 1: Thêm reset tối thiểu vào `_base.scss`** (thay preflight Tailwind):
```scss
*, *::before, *::after { box-sizing: border-box; }
* { margin: 0; }
img, svg, video { display: block; max-width: 100%; }
a { color: inherit; text-decoration: none; }
button { font: inherit; color: inherit; background: none; border: 0; cursor: pointer; }
ul { list-style: none; padding: 0; }
```
(Rà: nếu section nào dựa vào chi tiết preflight khác, bổ sung.)

- [ ] **Step 2: `functions.php`** — bỏ block enqueue `ecsges-main`; enqueue SCSS làm chính:
```php
	$css_path = $dir . '/assets/css/theme.css';
	$css_ver  = file_exists( $css_path ) ? filemtime( $css_path ) : ECSGES_VERSION;
	wp_enqueue_style( 'ecsges-main', $uri . '/assets/css/theme.css', array( 'aos' ), $css_ver );
```
(JS `ecsges-main` handle không đổi.)

- [ ] **Step 3: Đổi output SCSS** trong `.vscode/settings.json`: giữ `theme.css` (functions.php đã trỏ vào đó) — không cần đổi tên. Xoá `src/tailwind.css`.

- [ ] **Step 4: `package.json`** — xoá devDependencies Tailwind + 2 script; nếu rỗng, để `scripts: {}`.

- [ ] **Step 5: Cập nhật `CLAUDE.md`** — mục Commands: bỏ `npm run build:css`, thay bằng "compile SCSS bằng Live Sass Compiler (`src/scss/main.scss` → `assets/css/theme.css`)"; mục Architecture/Animation: đổi "Tailwind v4 / src/tailwind.css" → "SCSS (`src/scss/`), class ngữ nghĩa BEM".

- [ ] **Step 6: Verify cutover** — compile SCSS; xoá `main.css`; `curl -s http://ecs.test/ | grep -c 'main.css'` không còn tham chiếu Tailwind; duyệt **cả 3 trang** (chủ, ve-ecs, lĩnh-vực, phát-triển) + footer/header: **toàn bộ giống hệt trước migration**; tab/menu/carousel/animation chạy; responsive + reduced-motion ok. Lint PHP + `node --check`.

---

## Self-review (đã thực hiện khi soạn plan)

- **Spec coverage:** khớp mục 8–12 spec Phase 2 (toolchain extension IDE, cấu trúc SCSS, incremental per-section, giữ FLIP/`.js`/pins scale, cập nhật CLAUDE.md). ✅
- **JS coupling:** spec không nêu chi tiết nhưng là rủi ro thực → thêm Task 17 (bắt buộc). ✅
- **Không big-bang:** Task 0 tách output `theme.css`, giữ Tailwind tới Task 18 → site không vỡ giữa chừng. ✅
- **Placeholder:** foundation (Task 1) + mẫu Footer (Task 2) có code đầy đủ; Task 3–16 là ÁP DỤNG phương pháp Task 2 (phương pháp hoàn chỉnh) — không phải placeholder. Ghi rõ để implementer map HẾT element, không bỏ sót. ✅

## Ngoài phạm vi (YAGNI)
- Không đổi cấu trúc DOM/markup ngoài việc đổi class.
- Không thêm dep npm (SCSS compile bằng extension IDE).
- Không tối ưu/gộp lại animation — port nguyên trạng.
