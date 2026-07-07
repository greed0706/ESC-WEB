# Spec: 2 page mới (Lĩnh vực hoạt động, Phát triển bền vững) + Migration Tailwind → SCSS

**Ngày:** 2026-07-06
**Theme:** `wp-content/themes/ecsges`
**Nguồn thiết kế:** Figma `N1rYl9k1gxRsXuQQsKWYFM`
- Page 1 — Lĩnh vực hoạt động: node `23-2121`
- Page 2 — Phát triển bền vững: node `92-400`

---

## 1. Mục tiêu

1. Dựng **2 page mới** theo Figma, đúng pattern theme hiện có.
2. **Gán link nav** cho "Lĩnh vực hoạt động" và "Phát triển bền vững" (hiện là anchor `#` placeholder) trỏ tới 2 page mới.
3. Lập kế hoạch **migrate toàn bộ style Tailwind → SCSS ngữ nghĩa (BEM)** cho cả theme.

## 2. Quyết định đã chốt (từ brainstorm)

| Vấn đề | Quyết định |
|---|---|
| Lý do dùng SCSS | Quen SCSS / dễ bảo trì → target là **class ngữ nghĩa (BEM)**, markup PHP sạch, không phải utility-in-scss |
| Thứ tự | **Phase 1: dựng 2 page (Tailwind hiện có) trước**, Phase 2: migrate toàn theme sang SCSS |
| Nguồn nội dung 2 page | **Tĩnh trong `inc/data.php`** (giống trang Ve-ECS), KHÔNG dùng ACF |
| Page 1 — 5 tab | Tab HƯỚNG NGHIỆP dùng text thật từ Figma; 4 tab còn lại **placeholder** |
| Page 2 — carousel | **4–6 nhân sự placeholder** (tên/chức danh/ảnh mẫu) |
| Slug | `linh-vuc-hoat-dong`, `phat-trien-ben-vung` |
| Page 2 có TIN TỨC? | **Không** (chỉ hero + carousel + values + footer) |
| Compile SCSS (Phase 2) | Người dùng dùng **extension IDE (Live Sass Compiler)**, không thêm npm/Dart-Sass CLI |

---

## PHASE 1 — Dựng 2 page + gán nav

### 3. Page 1 — Lĩnh vực hoạt động

**Template chính:** `page-linh-vuc.php`
- `Template Name: Lĩnh vực hoạt động`. Thin: `get_header()` → các `get_template_part()` → `get_footer()` (giống `page-ve-ecs.php`).

**Template-parts (mới, prefix `linh-vuc-`):**

| File | Nội dung | Kỹ thuật |
|---|---|---|
| `template-parts/linh-vuc-hero.php` | Banner ảnh nền + tiêu đề lớn "LĨNH VỰC HOẠT ĐỘNG" | Tái dùng pattern hero-banner của `ve-ecs-hero.php` (ảnh + overlay + tiêu đề gạch chân) |
| `template-parts/linh-vuc-tabs.php` | Thanh 5 tab + panel nội dung (ảnh trái, đoạn text phải trong khối xám) | Tab switch **JS thuần** (mở rộng `assets/js/main.js`); tất cả 5 panel render sẵn trong DOM, JS toggle `.is-active` |
| *(TIN TỨC)* | Tái dùng nguyên `template-parts/section-news.php` | `get_template_part('template-parts/section','news')` |

**5 tab:** HƯỚNG NGHIỆP (active mặc định, nền cam), TUYỂN SINH, ĐÀO TẠO, VIỆC LÀM, TRUYỀN THÔNG.

**Data:** `ecsges_linh_vuc_tabs()` trong `inc/data.php` → mảng:
```php
[ 'key' => 'huong-nghiep', 'label' => 'HƯỚNG NGHIỆP', 'image' => '...', 'paragraph' => '<text thật từ Figma>' ],
[ 'key' => 'tuyen-sinh',   'label' => 'TUYỂN SINH',   'image' => '...', 'paragraph' => '<placeholder>' ],
// ... đào tạo, việc làm, truyền thông (placeholder)
```
Text HƯỚNG NGHIỆP (từ Figma): "Định hướng tương lai từ sự thấu hiểu năng lực. ECSGES đồng hành cùng học sinh, sinh viên trên hành trình khám phá bản thân… — Định hướng nghề nghiệp – Lựa chọn ngành học – Phát triển kỹ năng." (chép nguyên văn khi implement).

**JS (main.js):** thêm `initLinhVucTabs()` — click tab → set `.is-active` cho tab + panel tương ứng (theo `data-tab` key). Vanilla, trong IIFE `DOMContentLoaded` hiện có.

### 4. Page 2 — Phát triển bền vững

**Template chính:** `page-phat-trien-ben-vung.php` (`Template Name: Phát triển bền vững`).

**Template-parts (mới, prefix `ptbv-`):**

| File | Nội dung | Kỹ thuật |
|---|---|---|
| `template-parts/ptbv-hero.php` | Banner + tiêu đề "PHÁT TRIỂN BỀN VỮNG" | Pattern hero-banner (như page 1) |
| `template-parts/ptbv-team.php` | Carousel thẻ nhân sự: ảnh + overlay tên (PHAN TRẦN DUY ĐẠT) + chức danh (Giám đốc kinh doanh) + mũi tên ◀ ▶ | Carousel **JS thuần** trong `main.js` |
| `template-parts/ptbv-values.php` | Icon tròn viền nét đứt (bên trái) + 3 cột: TẬN TÂM / ĐỒNG HÀNH / ĐỔI MỚI (đoạn text dưới TẬN TÂM) | Layout 3 cột thường. **KHÔNG** tái dùng `ve-ecs-values.php` (đó là fan 5 múi TÂM/BỀN/HỢP/TRÍ/SÁNG khác hẳn) |

**Data:** trong `inc/data.php`
- `ecsges_ptbv_team()` → 4–6 người `{ name, title, image }` (placeholder).
- `ecsges_ptbv_values()` → 3 giá trị `{ title, text }` (TẬN TÂM có text, 2 cái kia có thể placeholder).

**JS (main.js):** thêm `initPtbvCarousel()` — track ngang, nút prev/next dịch transform/scroll; responsive (desktop 3 thẻ, mobile 1). Vanilla.

### 5. Nav & WP Pages

1. **Tạo 2 WP Page** qua WP-CLI (php Laragon + wp-cli.phar):
   - Page "Lĩnh vực hoạt động", slug `linh-vuc-hoat-dong`, `page_template = page-linh-vuc.php`.
   - Page "Phát triển bền vững", slug `phat-trien-ben-vung`, `page_template = page-phat-trien-ben-vung.php`.
   - (Mô phỏng cách Page ID 16 = ve-ecs được gán template.)
2. **Sửa `ecsges_nav_items()`** ([inc/data.php:17](../../../inc/data.php)):
   - `'href' => '#linh-vuc'` → `'/linh-vuc-hoat-dong/'`
   - `'href' => '#phat-trien-ben-vung'` → `'/phat-trien-ben-vung/'`
   - (Fallback tĩnh; nếu site dùng WP menu 'primary' thì cập nhật menu tương ứng — nhưng mặc định theme chạy fallback này.)
3. **Footer** (`footer.php`): cột "LĨNH VỰC HOẠT ĐỘNG" và "PHÁT TRIỂN BỀN VỮNG" trỏ về page tương ứng; link con (Hướng nghiệp/Tuyển sinh/…) trỏ `/linh-vuc-hoat-dong/#<tab-key>` (anchor mở đúng tab — tuỳ chọn nâng cao, có thể để trỏ chung page ở bước đầu).
4. **Build CSS:** chạy `npm run build:css` sau MỌI thay đổi class Tailwind (bắt buộc — Tailwind v4 chỉ emit class xuất hiện trong `.php`).

### 6. Assets

- Tải ảnh/icon cần thiết từ Figma (`get_design_context` / `download_assets`) khi implement: ảnh banner hero, ảnh panel tab HƯỚNG NGHIỆP, icon tròn nét đứt của values, mũi tên carousel. Đặt trong `assets/img/` theo quy ước hiện có (`ecsges_img()`).
- Màu/kích thước chính xác lấy từ `get_design_context` từng node lúc code (không đoán).

### 7. Kiểm thử Phase 1

- Lint PHP mọi file mới bằng php Laragon: `php -l <file>`.
- `npm run build:css` không lỗi; class mới xuất hiện trong `assets/css/main.css`.
- Mở `http://ecs.test/linh-vuc-hoat-dong/` và `/phat-trien-ben-vung/`: hero, tab switch, carousel, values, footer hiển thị & hoạt động; nav 2 mục trỏ đúng; TIN TỨC hiện ở page 1, KHÔNG ở page 2.
- Kiểm tra responsive (mobile) và `prefers-reduced-motion` (AOS tắt).

---

## PHASE 2 — Migration Tailwind → SCSS (semantic/BEM)

### 8. Mục tiêu & nguyên tắc

- Markup PHP dùng **class ngữ nghĩa** (vd `.ecs-hero`, `.ecs-hero__title`, `.ecs-tabs__item--active`), style tách vào file `.scss`.
- **Không** giữ utility Tailwind trong markup sau khi chuyển.
- Chuyển **incremental — từng section một**, verify trên trình duyệt trước khi sang section kế (không big-bang).

### 9. Toolchain

- Người dùng compile bằng **extension IDE (Live Sass Compiler hoặc tương đương)**: input `src/scss/main.scss` → output `assets/css/main.css` (nén). Cấu hình extension để output đúng path này.
- Không thêm dependency npm cho SCSS. `functions.php` vẫn enqueue `assets/css/main.css` như cũ (không đổi enqueue).
- Gỡ `@tailwindcss/cli` + script `build:css`/`watch:css` khỏi `package.json` ở bước cuối cùng (khi Tailwind không còn được dùng).

### 10. Cấu trúc SCSS đề xuất

```
src/scss/
  main.scss            // @use tất cả partial
  _variables.scss      // màu cam brand, spacing, max-page, breakpoints
  _mixins.scss         // responsive, focus-visible, container
  _base.scss           // reset nhẹ, body, .js gating (progressive enhancement)
  _keyframes.scss      // port @keyframes từ src/tailwind.css
  components/
    _header.scss  _footer.scss  _hero.scss  _news.scss
    _ecosystem.scss  _journey.scss  _about.scss  _branch.scss
    _ve-ecs-*.scss  _linh-vuc-tabs.scss  _ptbv-team.scss  _ptbv-values.scss
```

### 11. Chiến lược chuyển đổi

1. Dựng khung SCSS (`_variables`, `_mixins`, `_base`, `_keyframes`, `main.scss`) — port token & keyframe hiện có từ `src/tailwind.css` (@layer components + top-level @keyframes).
2. Chuyển **từng template-part**: đặt class ngữ nghĩa trong PHP → viết partial SCSS tương ứng → xoá utility Tailwind của phần đó → verify trình duyệt.
   Thứ tự gợi ý: shared trước (header, footer, hero, section-heading, các primitive trong `functions.php`), rồi từng section landing, rồi ve-ecs, rồi 2 page mới.
3. Bảo toàn các quy ước động (CLAUDE.md): FLIP hero intro, `.js` gating reveal, pins dùng `scale` (không `transform`), specificity của `.is-in`.
4. Khi tất cả đã chuyển: xoá `src/tailwind.css`, gỡ Tailwind khỏi `package.json`, cập nhật **CLAUDE.md** (đổi phần "Commands" và "Animation/CSS conventions" từ Tailwind → SCSS workflow).

### 12. Rủi ro Phase 2

- Refactor toàn theme: ~13 file markup + animations/keyframes/FLIP hero phức tạp. Giảm rủi ro bằng cách chuyển từng section & verify liên tục.
- Dễ sót class động (Tailwind arbitrary values, `.is-*` states). Cần rà kỹ từng section.
- CLAUDE.md phải cập nhật để không còn hướng dẫn Tailwind gây nhầm lẫn.

---

## 13. Ngoài phạm vi (YAGNI)

- Không dùng ACF cho 2 page mới (tĩnh như ve-ecs).
- Không làm CPT cho News/Team (giữ tĩnh, đúng scope note hiện tại).
- Không dịch Polylang cho 2 page mới ở bước đầu (có thể bổ sung sau, mô phỏng `ecsges_ve_ecs_url()`).
- Phase 2 không đổi cơ chế enqueue CSS (vẫn `assets/css/main.css`).

## 14. Tiêu chí hoàn thành

- **Phase 1:** 2 page render đúng Figma, nav + footer trỏ đúng, tab & carousel chạy, PHP lint sạch, `build:css` ok.
- **Phase 2:** toàn theme render giống trước, không còn utility Tailwind trong markup, compile SCSS ra `assets/css/main.css`, CLAUDE.md cập nhật.
