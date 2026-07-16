# ECSGES — WordPress theme

Landing page ECSGES chuyển từ bản React/Vite (`../my-web`) sang classic PHP theme.
**Giai đoạn 1 (giao diện tĩnh) + Giai đoạn 2 (ACF — client tự sửa nội dung) đã hoàn thành.**

## Cấu trúc

```
ecsges/
├── style.css                  # Header khai báo theme (WP nhận diện)
├── functions.php              # Enqueue CSS/JS + helper (icon, section-heading, underline-link...)
├── index.php                  # Fallback template
├── front-page.php             # Trang chủ: compose 6 section
├── header.php / footer.php    # SiteHeader / SiteFooter
├── template-parts/section-*.php  # 6 section (hero, about, journey, ecosystem, news, branch)
├── inc/data.php               # Nội dung tĩnh HARDCODE (port từ my-web/src/.../data.ts)
├── assets/
│   ├── css/main.css           # Output SCSS (KHÔNG sửa tay — sửa src/scss/*)
│   ├── js/main.js             # Tabs + hamburger + phân trang tin tức (thay React state)
│   ├── fonts/Roboto-*.ttf     # Font self-host
│   └── img/                   # Ảnh + SVG
├── src/scss/                  # Nguồn SCSS: _variables/_mixins/_base/_keyframes/_components + components/_<section>.scss
└── package.json               # Fallback build SCSS (Node)
```

## Build CSS (chỉ cần khi đổi giao diện — SCSS, KHÔNG còn Tailwind)

Styling = **SCSS viết tay** với class BEM ngữ nghĩa (`.ecs-<block>__<part>`, state `.is-active`/`.is-hidden`).
**Chỉ sửa file `.scss`; đừng sửa `main.css`.**

- **Cách chính:** extension VS Code **"Live Sass Compiler" (Watch Sass)** biên dịch `src/scss/main.scss` → `assets/css/main.css`, đã chạy **autoprefixer** (nên `main.css` có sẵn vendor prefix `-webkit-*`, `-o-*`…).
- **Fallback khi không có extension:** `npm run build:scss` / `npm run watch:scss` (Dart Sass thuần, **KHÔNG có autoprefixer**).

> ⚠️ ĐỪNG chạy `npm run build:scss` khi đang dùng extension — nó ghi đè `main.css` mất vendor prefix và hai trình biên dịch tranh nhau cùng 1 file.

Design tokens (màu brand, font Roboto/Roboto Flex/Dancing Script, `$page-max` 1274px) là biến SCSS trong `src/scss/_variables.scss`; reset nằm ở `_base.scss`.
`main.css` là stylesheet duy nhất của theme, enqueue với handle `ecsges-main`.

## Cài trên WordPress

1. Đặt thư mục `ecsges/` vào `wp-content/themes/`.
2. Appearance → Themes → Activate **ECSGES**.
3. Trang chủ (`/`) tự dùng `front-page.php`. Không cần cấu hình thêm.

## Giai đoạn 2 — Client tự sửa nội dung (ACF)

Dùng **ACF Free** (không có Options Page / Repeater), nên nội dung gắn vào **1 Trang đặt làm Trang chủ**:

- Field group đăng ký bằng PHP tại [inc/acf-fields.php](inc/acf-fields.php) — 63 field, chia tab: Chung / Hero / Về ECS / Hành trình / Lĩnh vực / Chi nhánh / Footer. Location = **Page Type: Front Page**.
- Mỗi field có **default_value = nội dung hiện tại**; nếu client để trống, theme **fallback về nội dung mặc định** (trong `inc/data.php`), nên trang không bao giờ trống.
- Nội dung lặp không cần Repeater: tab lĩnh vực dùng field phẳng (Tab 1..5), danh sách (tỉnh/thành, gợi ý địa chỉ, link cột footer) dùng **textarea — mỗi dòng 1 mục**.
- Menu header: `ecsges_get_nav()` **tự nhận menu do admin tạo**. Thứ tự ưu tiên:
  1. Menu gán vào vị trí `primary` (Appearance → Menus → Manage Locations).
  2. Nếu chưa gán vị trí nhưng admin đã tạo menu bất kỳ → dùng **menu đầu tiên**.
  3. Nếu **chưa có menu nào** → fallback về **nav hardcode** (`ecsges_nav_items()` trong `inc/data.php`).
  → Nói cách khác: **có menu trong admin thì header dùng menu đó; chưa có menu mới hardcode.**
- Tin tức: **vẫn để tĩnh** (theo yêu cầu), sẽ chuyển Custom Post Type ở bước sau.

### Client sửa nội dung ở đâu?
1. **wp-admin → Pages → "Trang chủ"** → cuộn xuống nhóm field **"Trang chủ ECSGES — Nội dung"** → sửa từng tab → Update.
2. **wp-admin → Appearance → Menus** → sửa "Menu chính" cho menu header.

### Đã cấu hình sẵn (local ecs.test)
- Trang "Trang chủ" (ID 14) đặt làm front page (Settings → Reading → *A static page*).
- Menu "Menu chính" (6 mục) đã tạo trong admin — theme tự nhận (chưa cần gán vị trí `primary`).

Khi bê theme sang site khác: tạo 1 Page, Settings → Reading chọn Page đó làm Trang chủ; tạo Menu và gán vị trí "Menu chính". Field ACF tự hiện trên Page đó (cần plugin **Advanced Custom Fields** kích hoạt).

## Ghi chú

- Nav "Về ECS" trỏ tới anchor `#ve-ecs` (section About) — trang riêng `/ve-ecs` (có trong bản React) chưa dựng.
- Cần plugin **Advanced Custom Fields** (Free) kích hoạt để client sửa nội dung; nếu tắt ACF, theme vẫn chạy với nội dung mặc định.

## Trang "Về ECS" (/ve-ecs)

Port từ `VeEcsPage.tsx` — 5 section: Hero → Hành trình phát triển (timeline cầu thang) → Tầm nhìn + Sứ mệnh → Giá trị cốt lõi (hình quạt 5 múi) → Những con số ấn tượng.

- Template: [page-ve-ecs.php](page-ve-ecs.php) (tự áp dụng cho Page slug `ve-ecs` theo template hierarchy) + 5 part `template-parts/ve-ecs-*.php`.
- Nội dung tĩnh trong `inc/data.php` (`ecsges_milestones`, `ecsges_core_values`, `ecsges_ve_ecs_*`).
- Assets riêng ở `assets/img/ve-ecs/` (gồm `bg/`, `arrow/`, `last-section/`).
- Layout đặc thù (timeline & hình quạt) dùng container query + `clamp()`/`cqw` qua inline style — giữ tỉ lệ như Figma.

### Đã cấu hình sẵn (local ecs.test)
- Page "Về ECS" (ID 16), slug `ve-ecs` → `http://ecs.test/ve-ecs/`.
- **Pretty permalinks** bật (`/%postname%/`) + `.htaccess` chuẩn WordPress ở web root (bắt buộc để URL `/ve-ecs/` hoạt động).
- Menu item "Về ECS" trỏ tới trang này.

> Nếu bê sang site mới: tạo Page slug `ve-ecs`, bật Permalinks = *Post name*, và đảm bảo `.htaccess` (Apache) / rewrite (nginx) có rule WordPress.

## `inc/data.php` — nội dung HARDCODE (chưa phải post)

⚠️ **Toàn bộ `inc/data.php` là dữ liệu tĩnh viết cứng trong PHP**, port từ `my-web/.../data.ts`. Đây là
**fallback** cho các helper `ecsges_field*()` (khi ACF trống) và là nguồn dữ liệu cho các phần chưa gắn ACF.
Muốn client tự quản lý, một số phần nên chuyển thành **post / Custom Post Type (CPT)** thay vì hardcode:

| Hàm trong `inc/data.php` | Đang hardcode | Nên chuyển thành |
|---|---|---|
| `ecsges_news_items()`, `ecsges_featured_news()` | Danh sách tin tức + tin nổi bật | **CPT `news`** + WP Loop + phân trang *(ưu tiên cao nhất)* |
| `ecsges_milestones()` | Timeline "Hành trình phát triển" (/ve-ecs) | CPT `milestone` (sắp theo năm) hoặc ACF Repeater |
| `ecsges_ecosystem_tabs()`, `ecsges_linh_vuc_tabs()` | Tab lĩnh vực hoạt động | CPT `linh_vuc` + taxonomy, hoặc ACF |
| `ecsges_core_values()`, `ecsges_ptbv_values()`, `ecsges_ptbv_team()`, `ecsges_ptbv_guides()` | Giá trị cốt lõi / phát triển bền vững | CPT tương ứng hoặc ACF |
| `ecsges_branch_provinces()`, `ecsges_branch_addresses()` | Danh sách chi nhánh | CPT `chi_nhanh` hoặc ACF list |
| `ecsges_nav_items()` | Nav dự phòng | Đã có WP Menu ghi đè (xem phần Menu header ở trên) |

> Nguyên tắc: **hardcode để trang không bao giờ trống**; khi cần client tự đăng/sửa thì bọc bằng ACF
> hoặc nâng lên CPT. Các phần `ecsges_ve_ecs_*` của trang "Về ECS" hiện vẫn tĩnh, chưa gắn ACF.

## Bước tiếp theo (tùy chọn)

- News → Custom Post Type + WP Loop + phân trang để client tự đăng bài.
- Đưa nội dung trang "Về ECS" (`ecsges_ve_ecs_*`, `ecsges_milestones`, `ecsges_core_values`) vào ACF/CPT (hiện đang tĩnh trong `inc/data.php`).
