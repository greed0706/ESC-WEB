# Trang chi tiết việc làm (page-tuyen-dung-chi-tiet.php) — Design Spec

**Date:** 2026-07-27
**Nguồn thiết kế:** Layout tham khảo trang chi tiết việc làm của TopCV (không fetch được trực tiếp — 403 với request tự động; dựng theo cấu trúc phổ biến của trang chi tiết job Việt Nam: header tóm tắt → nội dung chính (Mô tả/Yêu cầu/Quyền lợi/Cách ứng tuyển) → sidebar thông tin công ty, đã xác nhận với người dùng qua các câu hỏi brainstorm).

## 1. Bối cảnh

Trang "Tuyển dụng" (`page-tuyen-dung.php`, xem spec `2026-07-21-tuyen-dung-page-design.md`) hiện liệt kê job từ mảng tĩnh `ecsges_jobs()` (`inc/data.php`), mỗi card có badge Hot/Mới, 4 dòng info, nút "Ứng tuyển ngay" (mở `.ecs-job-modal`). Chưa có trang chi tiết cho từng job.

Người dùng yêu cầu 2 việc:
1. Thêm nút "Tìm hiểu thêm" trên mỗi job card, dẫn tới trang chi tiết việc làm kiểu TopCV (badge Hot giữ nguyên, chỉ đổi text "Mới"→"Hot" — **đã làm xong**, không thuộc phạm vi spec này).
2. Trang chi tiết đó phải theo đúng pattern "hardcode trước, nội dung thật sau" đã dùng cho Tin tức (`tin-tuc-featured.php`/`tin-tuc-knowledge.php`: hardcode ở `inc/data.php`, sau này đổi thân hàm sang truy vấn WP thật mà không sửa template/SCSS) — áp dụng **ngay bây giờ**, không phải TODO để sau: danh sách job tự động chuyển từ hardcode sang nội dung thật ngay khi có Page thật gán template này, không cần sửa code thêm.

## 2. Phạm vi

**Trong phạm vi:**
- 1 template dùng lại được (`Template Name`), gán cho nhiều WP Page — mỗi Page = 1 job thật, không cần Custom Post Type.
- ACF field group riêng cho template này (khác với field group hiện tại — field group duy nhất đang có chỉ gắn `page_type == front_page`).
- Helper đọc ACF theo Page bất kỳ (không hardcode `page_on_front` như `ecsges_field()` hiện tại).
- Đổi `ecsges_jobs()` → `ecsges_jobs_list()`: tự động dùng Page thật (nếu có) thay hardcode, không merge — có Page thật thì bỏ hardcode hoàn toàn.
- Card: thêm nút "Tìm hiểu thêm" — có href thật khi job có Page, hiện nhưng bất hoạt (`<a>` không có `href`) khi job vẫn là hardcode.

**Ngoài phạm vi:**
- Custom Post Type, taxonomy riêng cho job.
- Đổi cơ chế 3 dropdown lọc (`ecsges_job_areas/departments/types`) — vẫn là danh sách tĩnh như hiện tại.
- "Việc làm tương tự" ở sidebar (đã thống nhất bỏ — chưa có nhiều job thật để gợi ý).
- Gửi dữ liệu ứng tuyển tới backend thật (modal hiện tại vẫn chỉ đóng + reset form).
- Đa ngôn ngữ Polylang cho từng Page job — dùng cơ chế Polylang chuẩn của WP nếu client tự dịch Page, không cần code thêm.

## 3. Cấu trúc file

```
page-tuyen-dung-chi-tiet.php                       (Template Name: Chi tiết tuyển dụng)
template-parts/job-chi-tiet-header.php              (tiêu đề, lương, địa điểm, hạn nộp, nút Ứng tuyển ngay)
template-parts/job-chi-tiet-content.php             (Mô tả / Yêu cầu / Quyền lợi / Cách ứng tuyển)
template-parts/job-chi-tiet-sidebar.php              (thẻ thông tin ECSGES + nút Ứng tuyển ngay, sticky)
template-parts/section-tuyen-dung-jobs.php           (sửa: nút "Tìm hiểu thêm", gọi ecsges_jobs_list())
inc/acf-fields.php                                   + group_ecsges_job_detail
inc/data.php                                         + ecsges_jobs_list(), sửa ecsges_jobs() giữ nguyên làm fallback
functions.php                                        + ecsges_field_page()
src/scss/components/_pages.scss                      + .ecs-job-detail (+ __header/__content/__sidebar...), .ecs-jobs__more
```

## 4. Template chính (`page-tuyen-dung-chi-tiet.php`)

Đăng ký qua header comment `Template Name` (giống cơ chế `page-tin-tuc.php` đã dùng), **không** dựa vào tên file khớp slug — vì template này phải gán được cho NHIỀU Page (mỗi Page 1 slug khác nhau, ví dụ Page mẫu đầu tiên: slug `tuyen-dung-chi-tiet`):

```php
<?php
/**
 * Template Name: Chi tiết tuyển dụng
 * Gán template này cho 1 WP Page = 1 tin tuyển dụng thật. Không giới hạn số
 * Page dùng chung template — mỗi Page có field riêng (group_ecsges_job_detail).
 */
get_header();
get_template_part( 'template-parts/job-chi-tiet', 'header' );
get_template_part( 'template-parts/job-chi-tiet', 'content' );
get_template_part( 'template-parts/job-chi-tiet', 'sidebar' );
get_footer();
```

`header`/`content`/`sidebar` xếp cạnh nhau trong 1 layout 2 cột (content trái, sidebar phải, sticky ở `>=1024px` — giống cách `.ecs-branch__grid` dùng `380px 1fr`), `header` full-width phía trên lưới 2 cột.

## 5. ACF field group (`inc/acf-fields.php`)

Field group **mới**, KHÔNG gộp vào `group_ecsges_home` (group đó chỉ gắn front page). Location rule `page_template == page-tuyen-dung-chi-tiet.php` (rule chuẩn của ACF, không cần PRO):

```php
acf_add_local_field_group( array(
	'key'      => 'group_ecsges_job_detail',
	'title'    => 'Chi tiết tuyển dụng — Nội dung',
	'fields'   => array(
		$text( 'job_salary', 'Mức lương', 'Thoả thuận' ),
		$text( 'job_location', 'Địa điểm', 'Hà Nội' ),
		$text( 'job_department', 'Phòng ban', 'Phòng Công nghệ thông tin và Truyền thông' ),
		$text( 'job_type', 'Loại công việc', 'Toàn thời gian' ),
		$text( 'job_deadline', 'Hạn nộp hồ sơ', 'Thời hạn: 20/7/2026' ),
		array( 'key' => 'field_ecsges_job_hot', 'name' => 'job_hot', 'label' => 'Đánh dấu Hot', 'type' => 'true_false', 'default_value' => 0 ),
		$textarea( 'job_description', 'Mô tả công việc (mỗi dòng 1 ý)', $job_desc_default, '', 5 ),
		$textarea( 'job_requirements', 'Yêu cầu ứng viên (mỗi dòng 1 ý)', $job_req_default, '', 5 ),
		$textarea( 'job_benefits', 'Quyền lợi (mỗi dòng 1 ý)', $job_benefit_default, '', 5 ),
		$textarea( 'job_how_to_apply', 'Cách ứng tuyển (mỗi dòng 1 ý)', $job_apply_default, '', 4 ),
	),
	'location' => array( array( array(
		'param'    => 'page_template',
		'operator' => '==',
		'value'    => 'page-tuyen-dung-chi-tiet.php',
	) ) ),
	'hide_on_screen' => array( 'the_content' ),
) );
```

Dùng lại helper `$text`/`$textarea` đã có trong file (khai báo ở đầu closure `acf/init`). `default_value` của 4 textarea = nội dung mẫu viết đúng cho vị trí "Nhân viên Digital Marketing" (khớp job hardcode đầu tiên trong `ecsges_jobs()`) — 4-5 dòng mỗi khối, viết cụ thể lúc code (không để rỗng, không để `"..."`), để Page mới tạo trong admin có sẵn nội dung mẫu hợp lý thay vì trống.

`job_description`/`job_requirements`/`job_benefits`/`job_how_to_apply` parse giống `linh-vuc-tabs.php` đang làm: mỗi dòng không rỗng → 1 `<li>` trong `<ul>`.

## 6. Helper đọc ACF theo Page (`functions.php`)

`ecsges_field()` hiện tại hardcode `ecsges_home_id()` — không dùng lại được. Thêm hàm song song, nhận `$post_id` tường minh:

```php
/**
 * Lấy giá trị 1 ACF field trên Page bất kỳ (không phải Trang chủ); nếu ACF
 * chưa cài / field trống → $default. Dùng cho các template gán field group
 * riêng qua location "page_template" (vd Chi tiết tuyển dụng).
 */
function ecsges_field_page($post_id, $name, $default = '')
{
	if (!function_exists('get_field') || !$post_id) {
		return ecsges_t($default);
	}
	$value = get_field($name, $post_id);
	if (null === $value || '' === $value || false === $value || array() === $value) {
		return ecsges_t($default);
	}
	return ecsges_t($value);
}
```

`job-chi-tiet-*.php` gọi `ecsges_field_page( get_the_ID(), 'job_salary', 'Thoả thuận' )` v.v. — mẫu giống hệt `ecsges_field()` nhưng post ID truyền vào thay vì cố định.

## 7. Danh sách job tự chuyển hardcode → thật (`inc/data.php`)

`ecsges_jobs()` **giữ nguyên không đổi** (vẫn là fallback tĩnh, đúng 4 job như hiện tại). Thêm hàm mới mà `section-tuyen-dung-jobs.php` sẽ gọi thay vì gọi thẳng `ecsges_jobs()`:

```php
/**
 * Danh sách job hiển thị ở trang Tuyển dụng. Ưu tiên Page thật đã gán
 * template "Chi tiết tuyển dụng" (page-tuyen-dung-chi-tiet.php) — có Page
 * thật thì BỎ HẲN hardcode, không merge. Chưa có Page nào → fallback
 * ecsges_jobs() để trang không bao giờ trống.
 */
function ecsges_jobs_list()
{
	$q = new WP_Query( array(
		'post_type'      => 'page',
		'posts_per_page' => -1,
		'no_found_rows'  => true,
		'meta_key'       => '_wp_page_template',
		'meta_value'     => 'page-tuyen-dung-chi-tiet.php',
		'orderby'        => 'date',
		'order'          => 'DESC',
	) );

	if ( empty( $q->posts ) ) {
		return ecsges_jobs();
	}

	$jobs = array();
	foreach ( $q->posts as $p ) {
		$jobs[] = array(
			'title'      => get_the_title( $p ),
			'location'   => ecsges_field_page( $p->ID, 'job_location', '' ),
			'department' => ecsges_field_page( $p->ID, 'job_department', '' ),
			'type'       => ecsges_field_page( $p->ID, 'job_type', '' ),
			'deadline'   => ecsges_field_page( $p->ID, 'job_deadline', '' ),
			'tag'        => get_field( 'job_hot', $p->ID ) ? 'hot' : '',
			'href'       => get_permalink( $p ),
		);
	}
	return $jobs;
}
```

`section-tuyen-dung-jobs.php`: đổi `foreach ( ecsges_jobs() as ... )` → `foreach ( ecsges_jobs_list() as ... )`. Toàn bộ phần lọc/phân trang/card/modal phía dưới **không đổi gì** — đúng tinh thần "đổi hàm data, giữ nguyên markup" của pattern Tin tức.

`ecsges_jobs()` (fallback) không có `href` → xem mục 8.

## 8. Card: nút "Tìm hiểu thêm" (`section-tuyen-dung-jobs.php`)

Thêm cạnh nút `.ecs-jobs__apply` hiện có (không thay thế, không đổi hành vi nút Ứng tuyển ngay):

```php
<?php if ( ! empty( $ecsges_job['href'] ) ) : ?>
	<a href="<?php echo esc_url( $ecsges_job['href'] ); ?>" class="ecs-jobs__more"><?php echo esc_html( ecsges_t( 'Tìm hiểu thêm' ) ); ?></a>
<?php else : ?>
	<a class="ecs-jobs__more ecs-jobs__more--inert"><?php echo esc_html( ecsges_t( 'Tìm hiểu thêm' ) ); ?></a>
<?php endif; ?>
```

`ecsges_jobs()` (hardcode) không có khoá `'href'` → nhánh `else` luôn chạy cho 4 job mẫu hiện tại: nút vẫn hiển thị (đúng yêu cầu "vẫn hiện nhưng chả trỏ về đâu") nhưng `<a>` không có `href` nên không điều hướng, không nhận focus bàn phím (hành vi chuẩn HTML, không cần JS chặn click). `.ecs-jobs__more--inert` chỉ đổi con trỏ chuột (`cursor: default`) để không trông như link sống.

## 9. SCSS (`src/scss/components/_pages.scss`)

Thêm cùng vị trí với `.ecs-jobs`/`.ecs-job-modal` hiện có (không tách file riêng — theo đúng convention "trang phụ nằm trong `_pages.scss`"):

- `.ecs-jobs__more` — nút viền cam chữ cam (secondary, phân biệt với `.ecs-jobs__apply` primary cam đặc), `&--inert { cursor: default; opacity: .5; }`.
- `.ecs-job-detail` (+ `__header`, `__title`, `__meta`, `__meta-item`, `__apply`, `__grid`, `__content`, `__block`, `__block-title`, `__block-list`, `__sidebar`, `__sidebar-card`, `__sidebar-apply`) — bố cục 2 cột `380px 1fr` giống `.ecs-branch__grid` ở `>=1024px`, 1 cột ở mobile; sidebar `position: sticky` chỉ ở `>=1024px`, `top` đo trực tiếp bằng chiều cao header cố định của theme lúc code (không đoán số).

Không có Figma cho phần này (layout dựng theo mô tả TopCV đã thống nhất) — giá trị màu/spacing lấy theo token sẵn có của theme (`$brand`, `$ink`, `$body`, `$surface-2`, thang `text-sm/md/lg`), không bịa số đo Figma.

## 10. Rủi ro / giả định

- Truy vấn theo `meta_key => '_wp_page_template'` là kỹ thuật chuẩn của WP (không phải hack) nhưng phụ thuộc giá trị meta đúng bằng tên file — nếu sau này đổi tên `page-tuyen-dung-chi-tiet.php` thì các Page đã gán template cũ sẽ "rơi" khỏi danh sách (WP tự hiển thị cảnh báo "template không tồn tại" trong admin, không mất dữ liệu field).
- Không tạo Page mẫu nào trong DB — theo quy ước dự án, người dùng tự tạo Page trong wp-admin, gán Template "Chi tiết tuyển dụng", điền field. Cho tới lúc đó `ecsges_jobs_list()` luôn trả fallback.
- 3 dropdown lọc (Khu vực/Phòng ban/Loại công việc) vẫn đọc từ `ecsges_job_areas()`/`ecsges_job_departments()`/`ecsges_job_types()` tĩnh — job thật có `department`/`type`/`location` không khớp đúng chính tả với các list này thì lọc sẽ không khớp; ngoài phạm vi spec này (không đổi 3 hàm đó).
