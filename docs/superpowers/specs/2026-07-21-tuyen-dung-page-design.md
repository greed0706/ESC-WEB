# Trang "Tuyển dụng" (page-tuyen-dung.php) — Design Spec

**Date:** 2026-07-21
**Nguồn thiết kế:** Figma `Website-ECSGES`, node `402:280` (trang danh sách job) và `405:228` (cùng trang, modal ứng tuyển đang mở).

## 1. Bối cảnh

Theme `ecsges` hiện có các trang phụ theo pattern `page-<slug>.php` (`page-ve-ecs.php`, `page-linh-vuc-hoat-dong.php`, `page-phat-trien-ben-vung.php`, `page-lien-he.php`), mỗi trang `get_header()` → 1-2 section template-parts → `get_footer()`. Trang "Tuyển dụng" hiện chưa tồn tại (không có file, không có ACF field, không có CPT). Trong `assets/img/tuyen-dung/` đã có sẵn 6 icon do người dùng export/đặt tên: `pin.svg`, `home.svg`, `time.svg`, `file.svg`, `star-hot.SVG`, `star-new.svg`.

WordPress tự map file `page-tuyen-dung.php` vào Page có slug `tuyen-dung` theo template hierarchy — **không cần** đăng ký Template Name, không cần tạo Page/menu trong DB (người dùng tự tạo Page trong wp-admin sau, theo quy ước đã thống nhất trước đó trong dự án).

## 2. Phạm vi

Trong phạm vi: 1 trang tĩnh gồm hero + bộ lọc (UI, chưa lọc thật) + danh sách 4 job mẫu + phân trang (ẩn khi chỉ có 1 trang) + modal ứng tuyển (UI, submit chưa nối backend).

Ngoài phạm vi: Custom Post Type cho job, ACF field group, JS lọc job theo bộ lọc, gửi form ứng tuyển tới email/API, trang chi tiết job riêng.

## 3. Cấu trúc file

```
page-tuyen-dung.php
template-parts/section-tuyen-dung-hero.php
template-parts/section-tuyen-dung-jobs.php   (bộ lọc + list + phân trang + modal)
inc/data.php                                  + ecsges_jobs()
src/scss/components/_pages.scss               + .ecs-recruit-hero, .ecs-jobs, .ecs-job-modal
assets/js/main.js                             + initJobModal(), initJobsPagination()
assets/img/tuyen-dung/hero.jpg                (tải từ Figma asset URL imgRectangle304)
```

`page-tuyen-dung.php` tối giản như `page-linh-vuc-hoat-dong.php`:

```php
get_header();
get_template_part( 'template-parts/section', 'tuyen-dung-hero' );
get_template_part( 'template-parts/section', 'tuyen-dung-jobs' );
get_footer();
```

## 4. Dữ liệu (`inc/data.php`)

`ecsges_jobs()` — mảng tĩnh, theo đúng convention của `ecsges_milestones()`:

```php
function ecsges_jobs() {
	return array(
		array(
			'title'      => 'Nhân viên Digital Marketing',
			'location'   => 'Hà Nội',
			'department' => 'Phòng Công nghệ thông tin và Truyền thông',
			'type'       => 'Toàn thời gian',
			'deadline'   => 'Thời hạn: 20/7/2026',
			'tag'        => 'hot', // 'hot' | 'new' | null
			'apply_href' => '#',
		),
		// ... 3 job còn lại (1x Digital Marketing/'new', 1x Media/'new', 1x Designer/'new')
	);
}
```

Mỗi job render 1 card; `tag` quyết định hiển thị badge `star-hot.SVG`+"Hot" hay `star-new.svg`+"Mới" (hoặc không có badge nếu `tag === null`, dù Figma hiện tại không có ví dụ này — chừa sẵn để mở rộng).

## 5. Hero (`section-tuyen-dung-hero.php` + `.ecs-recruit-hero`)

Không dùng chung `.ecs-page-hero` (banner tối, tiêu đề trắng nhỏ — khác thiết kế Figma của trang này). Tạo block riêng:

- Ảnh nền full-bleed sáng (không overlay tối), `object-fit: cover`, cao ~681px desktop (giống tỉ lệ `_landing.scss` `.ecs-about`/`.ecs-hero`).
- Chữ "TUYỂN DỤNG" khổng lồ, `font-size` responsive (~50px mobile → 98px desktop), màu `$brand`, `text-shadow: 0 4px 4px rgba(255,255,255,.45)`, căn giữa theo cả 2 trục trên ảnh.
- Ảnh hero (`assets/img/tuyen-dung/hero.jpg`) tải 1 lần từ asset URL Figma (`imgRectangle304`) trong lúc code — **không** dùng URL tạm thời của Figma trong code đã commit (URL hết hạn ~7 ngày).

## 6. Bộ lọc + danh sách job + phân trang (`section-tuyen-dung-jobs.php` + `.ecs-jobs`)

- Heading "Bộ lọc" (trái) / "Tất cả công việc" (phải), 2 cột (giống `_landing.scss` grid 2 cột `.ecs-about__inner`).
- Cột trái: 3 `<label>`+`<select>` thật — Khu vực / Phòng ban / Cấp bậc, mỗi select có 1 option placeholder disabled selected (`- Chọn khu vực -`...). **Chưa nối JS lọc** — chọn value không ảnh hưởng danh sách job (đã thống nhất ở bước brainstorm).
- Cột phải: 4 job card (`.ecs-jobs__card`), mỗi card: title, 4 dòng info (icon `pin/home/time/file.svg` + text), badge Hot/Mới (`.ecs-jobs__badge`, ảnh `star-hot.SVG`/`star-new.svg`), link "ỨNG TUYỂN NGAY >>" (`.ecs-jobs__apply`, text link màu `$brand`, không phải pill như `.ecs-see-more`).
- Phân trang: cùng cơ chế JS đã có ở News (`data-news-page`/`data-news-dot` → tổng quát hoá thành `data-jobs-page`/`data-jobs-dot`, `per_page = 4`). Vì `ecsges_jobs()` hiện có đúng 4 job = 1 trang, khối phân trang **tự ẩn** (điều kiện `$page_count > 1`, y hệt `section-news.php`). Thêm job vượt quá 4 sẽ tự hiện phân trang.
- Link "ỨNG TUYỂN NGAY" gắn `data-job-apply` + `data-job-title="<tên job>"` để JS biết job nào mở modal và điền lại tiêu đề job vào modal.

## 7. Modal ứng tuyển (trong cùng `section-tuyen-dung-jobs.php`, ẩn theo mặc định)

- Markup: overlay tối (`.ecs-job-modal`, `display:none` mặc định, JS toggle class `.is-open`) + panel trắng giữa màn hình.
- Tiêu đề động: "NỘP ĐƠN ỨNG TUYỂN" / "VỊ TRÍ {job title}" — job title được JS set từ `data-job-title` của nút bấm.
- Form: Họ và tên, Địa chỉ email, Số điện thoại (3 input text), CV của bạn / Portfolio của bạn (2 vùng click-để-chọn file, `<input type="file" hidden>` + label hiển thị tên file đã chọn).
- Nút "NỘP ĐƠN ỨNG TUYỂN" (submit): **chỉ đóng modal + reset form** ở bước này (không gọi API/wp_mail). Để lại `// TODO: nối backend nhận hồ sơ khi có yêu cầu` ngay tại handler JS.
- Đóng modal: nút X, click ra ngoài panel, phím Esc.

## 8. JS (`assets/js/main.js`)

Thêm 2 hàm theo đúng style IIFE hiện có (`initHeroIntro`, `initCharsReveal`...):

- `initJobsPagination()` — sao chép logic `initNewsPagination()` áp cho `[data-jobs]`/`data-jobs-page`/`data-jobs-dot`/`data-jobs-prev`/`data-jobs-next`.
- `initJobModal()` — lắng nghe click trên `[data-job-apply]`, mở modal + set tiêu đề job; lắng nghe close (X / overlay / Esc) + submit (preventDefault, đóng modal, reset form).

## 9. SCSS

Thêm vào `src/scss/components/_pages.scss` (không tách file riêng, theo đúng chỗ các trang phụ khác đang ở):
`.ecs-recruit-hero` (+ `__bg`, `__title`), `.ecs-jobs` (+ `__filters`, `__field`, `__list`, `__card`, `__info`, `__badge`, `__apply`, `__pagination` tái dùng style `.ecs-news__pagination` nếu hợp lý), `.ecs-job-modal` (+ `__panel`, `__field`, `__upload`, `__submit`).

Toàn bộ giá trị màu/spacing lấy theo đúng số đo trong code Figma đã trích xuất (đơn vị px trực tiếp — theo quy ước hiện tại của theme là px, không dùng rem, không để lại comment kiểu Tailwind).

## 10. Rủi ro / giả định

- Icon `star-hot.SVG` (đuôi hoa `.SVG`) khác case với `star-new.svg` — giữ nguyên tên file đã có, chỉ cần `esc_url` đúng path, không đổi tên (tránh phá liên kết nếu người dùng đã tham chiếu ở nơi khác).
- Ảnh hero tải từ Figma là ảnh raster đã dựng sẵn 2 người + sóng cam (không phải SVG) — lưu dạng `.jpg`/`.png` tuỳ định dạng gốc trả về.
- Không tạo Page/gán menu trong DB — chỉ tạo file theme; người dùng tự tạo Page "Tuyển dụng" slug `tuyen-dung` trong wp-admin.
