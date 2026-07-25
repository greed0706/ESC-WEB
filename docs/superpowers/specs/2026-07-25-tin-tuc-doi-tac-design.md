# Thiết kế: trang Tin tức (category) & trang Đối tác

Ngày: 2026-07-25
Nguồn thiết kế: Figma `Website ECSGES` (`N1rYl9k1gxRsXuQQsKWYFM`)
- Đối tác — node `539:372`, frame 1920×3856
- Tin tức — node `548:9518`, frame 1920×2911

Số đo dưới đây đọc trực tiếp từ Figma plugin API (`figma-console` MCP), không ước lượng.

> **Trạng thái thực thi (2026-07-25):**
> - **Mục 2 — trang Đối tác: ĐÃ XONG.**
> - **Mục 3 — trang Tin tức: phương án đã ĐỔI, chưa code.** Chốt mới của chủ dự án:
>   Tin tức là **một trang riêng** (`page-tin-tuc.php`), **`category.php` giữ nguyên**
>   (không viết lại). Ngoài ra các mục menu *Hướng nghiệp / Tuyển sinh / Đào tạo /
>   Việc làm / Truyền thông* phải trỏ vào **category thật** (render bằng `category.php`
>   hiện có), không phải chuyển tab trong trang.
>   → Số đo Figma ở mục 3 vẫn dùng được; phần "viết lại category.php" và
>   "6 tab = bộ lọc trong trang" ở mục 3.1–3.2 **đã lỗi thời**, cần soạn lại trước khi code.

---

## 1. Quyết định đã chốt

| Vấn đề | Quyết định |
|---|---|
| Trang Tin tức là page hay archive | **Archive** — viết lại `category.php`, không tạo `page-tin-tuc.php` |
| 6 tab chủ đề | Tạo **6 category thật** trong WP; bấm tab → `/category/<slug>/` render đúng chủ đề đó |
| Nội dung bài viết | **Hardcode trước** trong `inc/data.php`, tách theo slug category; sau đổi sang `WP_Query` chỉ sửa 1 hàm |
| 4 ô logo trống ở khối "Đối tác giáo dục trong nước" | **Bỏ** — chỉ render logo thật (3 logo) |
| Banner 2 trang | Ảnh đã bake sẵn chữ tiêu đề → dùng lại `template-parts/page-hero.php` với `variant: 'banner'` |

### Điểm cần bạn xác nhận
Nav trong Figma của **cả hai** trang chỉ có 6 mục (`Về ECS / Lĩnh vực hoạt động / Phát triển bền vững / Tin tức / Tuyển dụng / Liên hệ`) — **không có "Đối tác"**. Spec này *không* thêm mục nav mới, nên `/doi-tac/` chỉ truy cập được bằng URL trực tiếp. Nếu muốn vào được từ menu thì cần thêm mục nav (sẽ lệch Figma ở mọi trang).

---

## 2. Trang Đối tác

### 2.1 File

| File | Việc |
|---|---|
| `page-doi-tac.php` | mới — template mỏng: `get_header()` → hero → part → `get_footer()` |
| `template-parts/doi-tac-groups.php` | mới — lặp 4 khối logo |
| `inc/data.php` | thêm `ecsges_partner_groups()` |
| `inc/i18n.php` | thêm 4 tiêu đề khối VN→EN |
| `src/scss/components/_doi-tac.scss` | mới — **phải** `@use` trong `src/scss/main.scss` |
| `assets/img/doi-tac/` | banner + 42 logo |

WP: tạo Page slug `doi-tac` (WP-CLI) để `page-doi-tac.php` được chọn tự động.

### 2.2 Số đo

Banner: ảnh **1920×681** tại y=79, `scaleMode: FILL`, chữ "ĐỐI TÁC" bake trong ảnh.
Node text `539:399` ("LĨNH VỰC HOẠT ĐỘNG") là **rác không có fill → vô hình**, bỏ qua.

Container nội dung: x **324 → 1594** = **1273px**.

Nhịp dọc:

```
banner hết (y=760)
  ↓ 114
tiêu đề khối  (h=55)
  ↓ 52
lưới logo
  ↓ 114   → tiêu đề khối kế tiếp
lưới cuối hết (y=3327)
  ↓ 120
footer (y=3447)
```

Tiêu đề khối: `Roboto Flex Medium`, **50px / lh 55px / ls 0.2px**, `#000000`, căn giữa.
Khớp `$fs-lg: 50px` sẵn có trong `_variables.scss`.

Card logo: **233×153** (một số 232 do làm tròn Figma → dùng 233 đều), bg `#ffffff`,
border **0.5px solid `#a4a4a4`**, `border-radius: 0`, không shadow.

Lưới: **5 cột**, `column-gap: 27px`, `row-gap: 28px`.
(5×233 + 4×27 = 1273 ✓ khớp container.)

> Ghi chú Figma: khối 1 có khoảng cách hàng 190px (thay vì 181px = 153+28) — sai lệch
> của designer, không tái tạo; dùng 28px đều cho mọi hàng.

Logo bên trong ô: căn giữa cả 2 trục, giữ **đúng kích thước px riêng của từng logo**
theo Figma (không scale đồng loạt). Ví dụ: Honda 188×80, Viettel 183×39,
Đông Đô 146×147, Griffith 107×115.

### 2.3 Bốn khối

| # | Tiêu đề | Số logo | Hàng |
|---|---|---|---|
| 1 | ` ĐỐI TÁC GIÁO DỤC TRONG NƯỚC` | 3 | 1 (đã bỏ 4 ô trống) |
| 2 | ` ĐỐI TÁC GIÁO DỤC QUỐC TẾ` | 15 | 3 |
| 3 | ` ĐỐI TÁC DOANH NGHIỆP TRONG NƯỚC` | 15 | 3 |
| 4 | ` ĐỐI TÁC DOANH NGHIỆP QUỐC TẾ` | 9 | 2 |

Tổng **42 logo**. Chuỗi tiêu đề trong Figma có **khoảng trắng đầu** — cắt bỏ khi đưa vào code.

Hai logo là **vector** (không phải image fill), export riêng dạng SVG:
`539:1973` (BYD, 149×29, `#d72027`) và `539:1207` (Group, 105×105).

### 2.4 Cấu trúc dữ liệu

```php
function ecsges_partner_groups() {
    return array(
        array(
            'title' => 'ĐỐI TÁC GIÁO DỤC TRONG NƯỚC',
            'logos' => array(
                array( 'file' => 'doi-tac/dong-do.png', 'alt' => 'Đại học Đông Đô', 'w' => 146, 'h' => 147 ),
                // ...
            ),
        ),
        // 3 khối còn lại
    );
}
```

`w`/`h` render thành `width`/`height` attribute + `max-width`/`max-height` trong CSS để
logo không bị phóng to quá kích thước thiết kế.

---

## 3. Trang Tin tức (`category.php`)

### 3.1 File

| File | Việc |
|---|---|
| `category.php` | **viết lại** — bỏ layout 2 cột + sidebar hiện tại |
| `template-parts/tin-tuc-tabs.php` | mới — thanh 6 tab chủ đề |
| `template-parts/tin-tuc-featured.php` | mới — khối TIN NỔI BẬT |
| `template-parts/tin-tuc-knowledge.php` | mới — khối KIẾN THỨC + phân trang |
| `inc/data.php` | thêm `ecsges_news_topics()` (nội dung hardcode theo slug) |
| `inc/i18n.php` | thêm `TIN NỔI BẬT`, `KIẾN THỨC`, tên 6 tab |
| `src/scss/components/_posts.scss` | mở rộng (cùng khu vực với `single`/`search`) |
| `assets/img/tin-tuc/` | banner + ảnh placeholder bài viết |

`search.php` và `single.php` **không** đổi trong phạm vi này. Các class `.ecs-archive__*`
cũ chỉ còn `search.php` dùng — giữ lại, không xoá.

### 3.2 Sáu category cần tạo

| Tab | Slug | Ghi chú |
|---|---|---|
| ECSGES | `tin-tuc` | đã có (ID 13) — tab "tất cả" |
| HƯỚNG NGHIỆP | `huong-nghiep` | tạo mới |
| TUYỂN SINH | `tuyen-sinh` | tạo mới |
| ĐÀO TẠO | `dao-tao` | tạo mới |
| VIỆC LÀM | `viec-lam` | tạo mới |
| TRUYỀN THÔNG | `truyen-thong` | tạo mới |

Tab đang xem tô cam theo `get_queried_object()->slug`.

### 3.3 Số đo

**Banner:** ảnh 1920×681 tại y=79, chữ "TIN TỨC" bake sẵn.

**Thanh tab** (y 766–834, cao 68):

- Tab active: pill `#f05a28` **203×68**, chữ `#ffffff`
- Tab thường: chữ `#000000`
- Chữ: `Roboto Flex Regular`, **24px / lh 32px / ls 1px**, căn giữa
- Đường kẻ **1px `#a4a4a4`** ở đáy thanh (y=834). Trong Figma đường kẻ chạy x 485→1597
  (chỉ dưới các tab không active). Cách làm: `border-bottom` cho cả thanh, pill active cao
  68px đè lên che phần kẻ của nó → render giống hệt mà đúng với **mọi** tab đang active.
- Mốc x các tab: 380 / 575 / 832 / 1050 / 1229 / 1416

**TIN NỔI BẬT** (y=881): `Roboto Flex Medium`, **50px / lh 68px / ls 1px**, `#000`, căn trái.

**Khối featured** (y 992–1699), container 323→1596 = **1273px**:

```
┌─ cột trái 816px ────────────┐  gap 44  ┌─ cột phải 413px ─┐
│ ảnh 816×488  (y 992)        │          │ ảnh 413×247      │
│   ↓ 24                      │          │   ↓ 14           │
│ title 40px/50 Roboto Regular│          │ title 22px/28    │
│   ↓ (y 1621)                │          │   ↓ 49           │
│ excerpt 28px/32 Light       │          │ ảnh 413×247      │
│         #2d2d2d justified   │          │   ↓ 14           │
└─────────────────────────────┘          │ title 22px/28    │
                                         └──────────────────┘
```

- Title lớn: `Roboto Regular` **40px / lh 50px / ls 0.25px**, `#000000`
- Excerpt lớn: `Roboto Light` **28px / lh 32px / ls 0**, `#2d2d2d`, `text-align: justify`
- Title nhỏ: `Roboto Light` **22px / lh 28px / ls 0.25px**, `#000000`
- Ảnh: `scaleMode: CROP` → `object-fit: cover`

> Node `548:10574` ("Hot", 16px trắng, y=1378) không hiện trong bản render Figma — rác, bỏ qua.

**Khối KIẾN THỨC** (y 1748–2502, cao **754**):

- Dải nền `#f0f0f0` (= `$surface-2`) **full-bleed** hết chiều rộng viewport
- Heading `KIẾN THỨC` y=1809 → cách đỉnh dải **61px**, cùng style `TIN NỔI BẬT`
- 3 card y=1925 → cách heading **48px**
- Card **408×426**, bg `#ffffff`, `padding-left/right: 19px`
  - ảnh **408×244** (tràn sát mép card, không padding)
  - title y=2184 → cách đáy ảnh **15px**; `Roboto Regular` **22px / lh 28px / ls 0.25px**
  - excerpt y=2250; `Roboto Light` **18px / lh 26px**, `#2d2d2d`, justified
- Lưới 3 cột, **gap 24px** (3×408 + 2×24 = 1272 ≈ 1273)
- Phân trang y=2399, rộng 386, **căn giữa**, cách đáy card **48px**:
  **dùng lại** markup + SCSS `.ecs-news__pagination` của `template-parts/section-news.php`
  (mũi tên prev/next + dots, đổi trang bằng JS thuần đã có trong `assets/js/main.js`)
- Figma có **6 dot** → hardcode **18 card** (6 trang × 3)
- Đáy dải: sau phân trang còn **53px**

### 3.4 Cấu trúc dữ liệu hardcode

```php
function ecsges_news_topics() {
    return array(
        'tin-tuc' => array(
            'featured' => array(
                'main'  => array( 'title' => '…', 'excerpt' => '…', 'img' => 'tin-tuc/…', 'href' => '#' ),
                'side'  => array( /* 2 item */ ),
            ),
            'knowledge' => array( /* 18 item: title, excerpt, img, href */ ),
        ),
        'huong-nghiep' => array( /* … */ ),
        // …
    );
}
```

`category.php` lấy slug hiện tại → chọn bộ dữ liệu; slug không có trong mảng thì dùng bộ
`tin-tuc` làm fallback (trang không bao giờ trắng — cùng nguyên tắc `ecsges_field()`).

Vì nội dung là hardcode, `category.php` **không dùng main loop** (`have_posts()`) trong
giai đoạn này. Hệ quả: 5 category mới có 0 bài vẫn render đầy đủ nội dung placeholder,
không hiện "Chưa có bài viết". Khi chuyển sang bài thật thì đổi `ecsges_news_topics()`
sang `WP_Query` (hoặc dùng main loop) — markup và SCSS không phải sửa.

Nội dung placeholder lấy đúng từ Figma: title `Lễ ký kết hợp tác ECS GLOBAL và Học viện
Quản lý NanYang`, excerpt `ECS Global phát triển lớn mạnh dưới sự dẫn dắt tâm huyết và bề
dày kinh nghiệm.`, ảnh dùng chung 1 file (Figma cũng chỉ dùng 1 image hash cho mọi card).

---

## 4. Lấy asset từ Figma

Figma REST API hết quota (**Starter + seat View = 6 call/tháng**) và thiếu scope
`file_content:read`, nên **không** dùng REST. Cách làm:

1. Dựng HTTP server tạm bằng Node ở `http://localhost:9226`
   (port nằm trong `networkAccess.allowedDomains` của plugin Figma Desktop Bridge —
   xem `C:\Users\van hai\.figma-console-mcp\plugin\manifest.json`).
   Server nhận `POST /save?name=<path>` và ghi file vào `assets/img/`.
2. `figma_execute` chạy `node.exportAsync()` cho từng node rồi `fetch()` POST bytes lên server.
   - logo raster: PNG @2x
   - logo vector (BYD, Group): SVG
   - banner: PNG @1x (đã 1920px)
3. Tắt server, `git status` để kiểm file đã về đủ.

Ưu điểm: bytes gốc từ Figma, không tốn quota REST, không đẩy base64 qua context.

Đặt tên: `assets/img/doi-tac/<slug-thương-hiệu>.png`, `assets/img/tin-tuc/banner.png`,
`assets/img/tin-tuc/news-placeholder.jpg`.

---

## 5. SCSS & animation

- Chỉ sửa file `.scss`; **không** chạy `npm run build:scss` (mất autoprefixer, tranh file
  với Live Sass Compiler). Để extension "Live Sass Compiler" build ra `assets/css/main.css`.
- `_doi-tac.scss` phải được `@use` trong `main.scss`, nếu không sẽ âm thầm không biên dịch.
- Class BEM ngữ nghĩa: `.ecs-partners__*`, `.ecs-newsroom__*`. Trạng thái `.is-active`.
- Scroll-reveal: `data-aos="fade-up"` cho tiêu đề khối và từng lưới, theo đúng cách các
  section khác đang dùng. Không thêm animation mới.
- Responsive: lưới logo 5 → 4 (≥1024) → 3 (≥768) → 2 (<768). Lưới KIẾN THỨC 3 → 2 → 1.
  Khối featured: 2 cột → 1 cột dưới `$bp-lg`.

## 6. Kiểm chứng

1. `php -l` mọi file PHP mới/sửa (PHP của Laragon).
2. Mở `http://ecs.test/doi-tac/` và `http://ecs.test/category/tin-tuc/` + 1 tab khác,
   screenshot so với Figma, đối chiếu số đo.
3. Kiểm tab active đổi đúng theo category.
4. Kiểm bản EN (Polylang) render cùng layout.
