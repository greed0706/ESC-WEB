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
├── inc/data.php               # Nội dung tĩnh (port từ my-web/src/.../data.ts)
├── assets/
│   ├── css/main.css           # Tailwind build (KHÔNG sửa tay)
│   ├── js/main.js             # Tabs + hamburger + phân trang tin tức (thay React state)
│   ├── fonts/Roboto-*.ttf     # Font self-host
│   └── img/                   # Ảnh + SVG
├── src/tailwind.css           # Nguồn Tailwind (input build)
└── package.json               # Chỉ để build CSS
```

## Build CSS (chỉ cần khi đổi class Tailwind trong .php)

Cần Node.js. Sau khi build ra `assets/css/main.css`, theme chạy trên WP không cần Node.

```bash
npm install          # cài @tailwindcss/cli một lần
npm run build:css    # build 1 lần (minify)
npm run watch:css    # build + watch khi đang dev
```

Tailwind v4 quét class trong toàn bộ file `.php` qua chỉ thị `@source "../**/*.php"` trong `src/tailwind.css`.
Design tokens (màu brand/blue, font Roboto/Roboto Flex/Dancing Script, `max-w-page` 1274px) nằm trong khối `@theme`.

## Cài trên WordPress

1. Đặt thư mục `ecsges/` vào `wp-content/themes/`.
2. Appearance → Themes → Activate **ECSGES**.
3. Trang chủ (`/`) tự dùng `front-page.php`. Không cần cấu hình thêm.

## Giai đoạn 2 — Client tự sửa nội dung (ACF)

Dùng **ACF Free** (không có Options Page / Repeater), nên nội dung gắn vào **1 Trang đặt làm Trang chủ**:

- Field group đăng ký bằng PHP tại [inc/acf-fields.php](inc/acf-fields.php) — 63 field, chia tab: Chung / Hero / Về ECS / Hành trình / Lĩnh vực / Chi nhánh / Footer. Location = **Page Type: Front Page**.
- Mỗi field có **default_value = nội dung hiện tại**; nếu client để trống, theme **fallback về nội dung mặc định** (trong `inc/data.php`), nên trang không bao giờ trống.
- Nội dung lặp không cần Repeater: tab lĩnh vực dùng field phẳng (Tab 1..5), danh sách (tỉnh/thành, gợi ý địa chỉ, link cột footer) dùng **textarea — mỗi dòng 1 mục**.
- Menu header: dùng **WP Menu** (Appearance → Menus, vị trí "Menu chính"/`primary`), theme `ecsges_get_nav()` đọc menu này, fallback về nav tĩnh.
- Tin tức: **vẫn để tĩnh** (theo yêu cầu), sẽ chuyển Custom Post Type ở bước sau.

### Client sửa nội dung ở đâu?
1. **wp-admin → Pages → "Trang chủ"** → cuộn xuống nhóm field **"Trang chủ ECSGES — Nội dung"** → sửa từng tab → Update.
2. **wp-admin → Appearance → Menus** → sửa "Menu chính" cho menu header.

### Đã cấu hình sẵn (local ecs.test)
- Trang "Trang chủ" (ID 14) đặt làm front page (Settings → Reading → *A static page*).
- Menu "Menu chính" gán vào vị trí `primary`.

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

## Bước tiếp theo (tùy chọn)

- News → Custom Post Type + WP Loop + phân trang để client tự đăng bài.
- Đưa nội dung trang "Về ECS" vào ACF (hiện đang tĩnh trong `inc/data.php`).
