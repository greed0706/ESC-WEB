# Trang chi tiết việc làm (page-tuyen-dung-chi-tiet.php) Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a reusable "Chi tiết tuyển dụng" page template that any WordPress Page can be assigned to (one Page per real job posting), and make the existing job list on `page-tuyen-dung.php` automatically switch from its hardcoded 4-job array to real Pages the moment one exists — with zero further code changes.

**Architecture:** Classic thin-template pattern already used throughout this theme (`get_header()` → `template-parts/*` → `get_footer()`). The new template is registered via a `Template Name:` header comment (same mechanism as `page-tin-tuc.php`) so it's selectable in wp-admin's Page Attributes for any Page, not auto-mapped by slug. Its content comes from a new ACF field group located by `page_template` (not `front_page`, unlike every other field group in this theme today) via a new helper `ecsges_field_page()` that reads a field from an arbitrary Page ID. The job list on `page-tuyen-dung.php` switches data source via one new function, `ecsges_jobs_list()`, which queries for Pages using this template and — if any exist — returns only those (ACF-sourced), otherwise falls back to the existing hardcoded `ecsges_jobs()`. This mirrors the "GIAI ĐOẠN 1 hardcode / GIAI ĐOẠN 2 real query" pattern already documented in `tin-tuc-featured.php`.

**Tech Stack:** PHP 8.3 (WordPress classic theme, no build step for PHP/JS), SCSS compiled via `npm run build:css` (sass + postcss/autoprefixer) to `assets/css/main.css`, ACF Free (no Options Page/Repeater), WP-CLI for verification.

## Global Constraints

- After **every** `.scss` edit, run `cd d:\laragon\www\ECS\wp-content\themes\ecsges && npm run build:css` — never rely on the Live Sass Compiler VS Code extension (it writes expanded, unprefixed CSS to the wrong path; see repo `CLAUDE.md`).
- Styling = hand-written SCSS, semantic BEM (`.ecs-<block>__<part>`, state via `.is-active`/`.is-hidden`), no utility-class authoring. All new job-detail styles go in `src/scss/components/_pages.scss`, next to the existing `.ecs-jobs`/`.ecs-job-modal` rules (per the theme's file manifest — "trang phụ" styles live in `_pages.scss`).
- Lint every touched `.php` file with `"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l <file>` before considering a task done.
- No Custom Post Type, no Options Page, no Repeater field — ACF Free only, exactly the fields listed in this plan.
- `ecsges_jobs()` (the existing hardcoded array in `inc/data.php`) is **not modified** — it stays as the fallback source, used verbatim by the new `ecsges_jobs_list()`.
- Do not create a permanent WP Page/menu item as part of the deliverable. Task 6's verification Page is created explicitly as a disclosed, local-only aid (WP-CLI), and the plan ends by telling the user it exists so they can keep, edit, or delete it — never a silent DB mutation.
- Site under test: `http://ecs.test` (Apache via Laragon). WP-CLI: `"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" "D:\wp-cli\wp-cli.phar" <cmd> --path=d:/laragon/www/ECS`.
- No browser/screenshot tool is available in this environment — visual verification is curl/WP-CLI based (structural checks: class names, field values, permalink present in output). Tell the user to eyeball the page in a real browser once each task is done.
- Spec reference: `docs/superpowers/specs/2026-07-27-tuyen-dung-chi-tiet-design.md`.

---

### Task 1: `ecsges_field_page()` helper

**Files:**
- Modify: `functions.php` (add near `ecsges_field()`, `functions.php:334-348`)

**Interfaces:**
- Produces: `ecsges_field_page( int $post_id, string $name, mixed $default = '' ): mixed` — reads ACF field `$name` from `$post_id` (any Page, not just the front page); returns `ecsges_t( $default )` if ACF isn't active, `$post_id` is falsy, or the field is empty/null/false/`array()`.

- [ ] **Step 1: Add `ecsges_field_page()` to `functions.php`**

Insert immediately after the closing `}` of `ecsges_field()` (`functions.php:348`):

```php
/**
 * Lấy giá trị 1 ACF field trên Page bất kỳ (không phải Trang chủ); nếu ACF
 * chưa cài / field trống → $default. Dùng cho template gán field group
 * riêng qua location "page_template" (vd Chi tiết tuyển dụng), khác với
 * ecsges_field() ở trên vốn luôn đọc Trang chủ.
 *
 * @param int    $post_id
 * @param string $name
 * @param mixed  $default
 * @return mixed
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

- [ ] **Step 2: Lint**

Run: `"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l "d:\laragon\www\ECS\wp-content\themes\ecsges\functions.php"`
Expected: `No syntax errors detected`

- [ ] **Step 3: Verify via WP-CLI (fallback path, since no Page/field exists yet)**

Run:
```bash
"/d/laragon/bin/php/php-8.3.28-Win32-vs16-x64/php.exe" "/d/wp-cli/wp-cli.phar" eval 'echo ecsges_field_page(0, "job_salary", "Thoả thuận");' --path=d:/laragon/www/ECS
```
Expected: prints `Thoả thuận` (falsy `$post_id` → default returned, no PHP warnings/fatals).

- [ ] **Step 4: Commit**

```bash
git add functions.php
git commit -m "Thêm ecsges_field_page() đọc ACF theo Page bất kỳ"
```

---

### Task 2: ACF field group cho trang chi tiết tuyển dụng

**Files:**
- Modify: `inc/acf-fields.php` (add a second `acf_add_local_field_group()` call inside the existing `acf/init` closure)

**Interfaces:**
- Produces: ACF field group `group_ecsges_job_detail`, located via `page_template == page-tuyen-dung-chi-tiet.php`, with field names: `job_salary`, `job_location`, `job_department`, `job_type`, `job_deadline`, `job_hot` (true_false), `job_description`, `job_requirements`, `job_benefits`, `job_how_to_apply` (all `text`/`textarea` except `job_hot`).
- Consumes: the `$text`/`$textarea` field-builder closures already defined at the top of the `acf/init` closure in `inc/acf-fields.php` (`functions.php:39-61`... actually `inc/acf-fields.php:39-61`).

- [ ] **Step 1: Add the field group**

In `inc/acf-fields.php`, insert this **before** the closing `}` of the `add_action('acf/init', function () { ... });` closure (i.e. right after the existing `acf_add_local_field_group( array( 'key' => 'group_ecsges_home', ... ) );` call, still inside the same closure so `$text`/`$textarea` are in scope):

```php
			/* ---------------- CHI TIẾT TUYỂN DỤNG ---------------- */
			acf_add_local_field_group(
				array(
					'key'            => 'group_ecsges_job_detail',
					'title'          => 'Chi tiết tuyển dụng — Nội dung',
					'fields'         => array(
						$text( 'job_salary', 'Mức lương', 'Thoả thuận' ),
						$text( 'job_location', 'Địa điểm', 'Hà Nội' ),
						$text( 'job_department', 'Phòng ban', 'Phòng Công nghệ thông tin và Truyền thông' ),
						$text( 'job_type', 'Loại công việc', 'Toàn thời gian' ),
						$text( 'job_deadline', 'Hạn nộp hồ sơ', 'Thời hạn: 20/7/2026' ),
						array(
							'key'           => 'field_ecsges_job_hot',
							'label'         => 'Đánh dấu Hot',
							'name'          => 'job_hot',
							'type'          => 'true_false',
							'default_value' => 0,
							'ui'            => 1,
							'instructions'  => 'Bật để hiện badge "Hot" trên card ngoài trang danh sách.',
						),
						$textarea(
							'job_description',
							'Mô tả công việc (mỗi dòng 1 ý)',
							"Xây dựng và triển khai kế hoạch digital marketing theo tháng/quý.\nQuản lý các kênh quảng cáo Facebook, Google, TikTok.\nTheo dõi, đo lường hiệu quả chiến dịch và đề xuất tối ưu.\nPhối hợp với đội Content/Design để sản xuất ấn phẩm truyền thông.",
							'',
							5
						),
						$textarea(
							'job_requirements',
							'Yêu cầu ứng viên (mỗi dòng 1 ý)',
							"Tốt nghiệp Cao đẳng/Đại học chuyên ngành Marketing, Truyền thông hoặc liên quan.\nCó ít nhất 1 năm kinh nghiệm ở vị trí tương đương.\nThành thạo Facebook Ads Manager, Google Ads.\nCó tư duy sáng tạo, chủ động trong công việc.",
							'',
							5
						),
						$textarea(
							'job_benefits',
							'Quyền lợi (mỗi dòng 1 ý)',
							"Lương thoả thuận theo năng lực, review 6 tháng/lần.\nBảo hiểm đầy đủ theo quy định, thưởng lễ Tết.\nMôi trường làm việc trẻ, năng động, nhiều cơ hội đào tạo.\nĐược tham gia các hoạt động team building định kỳ.",
							'',
							5
						),
						$textarea(
							'job_how_to_apply',
							'Cách ứng tuyển (mỗi dòng 1 ý)',
							"Nộp CV trực tiếp qua nút \"Ứng tuyển ngay\" trên trang này.\nHoặc gửi CV về email tuyendung@ecs.edu.vn, tiêu đề: [Vị trí] - Họ tên.\nỨng viên phù hợp sẽ được liên hệ phỏng vấn trong vòng 5 ngày làm việc.",
							'',
							4
						),
					),
					'location'       => array(
						array(
							array(
								'param'    => 'page_template',
								'operator' => '==',
								'value'    => 'page-tuyen-dung-chi-tiet.php',
							),
						),
					),
					'menu_order'     => 1,
					'position'       => 'normal',
					'style'          => 'default',
					'label_placement' => 'top',
					'active'         => true,
					'description'    => 'Nội dung 1 tin tuyển dụng. Gán template "Chi tiết tuyển dụng" cho Page này để field group xuất hiện.',
					'hide_on_screen' => array( 'the_content' ),
				)
			);
```

- [ ] **Step 2: Lint**

Run: `"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l "d:\laragon\www\ECS\wp-content\themes\ecsges\inc\acf-fields.php"`
Expected: `No syntax errors detected`

- [ ] **Step 3: Verify the group registers (WP-CLI)**

Run:
```bash
"/d/laragon/bin/php/php-8.3.28-Win32-vs16-x64/php.exe" "/d/wp-cli/wp-cli.phar" eval 'do_action("acf/init"); $g = acf_get_local_field_group("group_ecsges_job_detail"); echo $g ? "OK: " . count(acf_get_fields($g)) . " fields" : "MISSING";' --path=d:/laragon/www/ECS
```
Expected: `OK: 10 fields` (no PHP warnings/fatals).

- [ ] **Step 4: Commit**

```bash
git add inc/acf-fields.php
git commit -m "Thêm ACF field group cho trang Chi tiết tuyển dụng"
```

---

### Task 3: Template + 3 template-parts (header/content/sidebar)

**Files:**
- Create: `page-tuyen-dung-chi-tiet.php`
- Create: `template-parts/job-chi-tiet-header.php`
- Create: `template-parts/job-chi-tiet-content.php`
- Create: `template-parts/job-chi-tiet-sidebar.php`
- Modify: `src/scss/components/_pages.scss` (append `.ecs-job-detail` block)

**Interfaces:**
- Consumes: `ecsges_field_page()` (Task 1), ACF fields from `group_ecsges_job_detail` (Task 2), existing helpers `ecsges_t()`, `ecsges_img()`, `ecsges_footer_contact()` (`inc/data.php`, already used by the footer for address/email/phone).
- Produces: renders a full page at any Page URL that has this template assigned. No other task's PHP depends on these files' internals — Task 5 only needs `page-tuyen-dung-chi-tiet.php` to exist as a filename (for the `_wp_page_template` meta match).

- [ ] **Step 1: Create `page-tuyen-dung-chi-tiet.php`**

```php
<?php
/**
 * Template Name: Chi tiết tuyển dụng
 *
 * Gán template này cho 1 WP Page = 1 tin tuyển dụng thật (Page Attributes →
 * Template, trong wp-admin). Không giới hạn số Page dùng chung template —
 * mỗi Page có nội dung riêng qua ACF field group "group_ecsges_job_detail"
 * (inc/acf-fields.php), đọc bằng ecsges_field_page( get_the_ID(), ... ).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
	<main class="ecs-job-detail">
		<?php
		get_template_part( 'template-parts/job-chi-tiet', 'header' );
		?>
		<div class="ecs-job-detail__inner ecs-job-detail__grid">
			<?php
			get_template_part( 'template-parts/job-chi-tiet', 'content' );
			get_template_part( 'template-parts/job-chi-tiet', 'sidebar' );
			?>
		</div>
	</main>
<?php
get_footer();
```

- [ ] **Step 2: Create `template-parts/job-chi-tiet-header.php`**

```php
<?php
/**
 * Chi tiết tuyển dụng — header tóm tắt (tiêu đề, lương, địa điểm, hạn nộp,
 * nút Ứng tuyển ngay mở lại đúng .ecs-job-modal đã có ở section-tuyen-dung-jobs.php).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$jd_id       = get_the_ID();
$jd_title    = get_the_title();
$jd_salary   = ecsges_field_page( $jd_id, 'job_salary', 'Thoả thuận' );
$jd_location = ecsges_field_page( $jd_id, 'job_location', 'Hà Nội' );
$jd_deadline = ecsges_field_page( $jd_id, 'job_deadline', 'Thời hạn: 20/7/2026' );
?>
<header class="ecs-job-detail__header">
	<div class="ecs-job-detail__header-inner">
		<h1 class="ecs-job-detail__title"><?php echo esc_html( $jd_title ); ?></h1>
		<ul class="ecs-job-detail__meta">
			<li class="ecs-job-detail__meta-item ecs-job-detail__meta-item--salary"><?php echo esc_html( $jd_salary ); ?></li>
			<li class="ecs-job-detail__meta-item">
				<img src="<?php echo esc_url( ecsges_img( 'tuyen-dung/pin.svg' ) ); ?>" alt="" class="ecs-job-detail__meta-icon">
				<?php echo esc_html( $jd_location ); ?>
			</li>
			<li class="ecs-job-detail__meta-item">
				<img src="<?php echo esc_url( ecsges_img( 'tuyen-dung/file.svg' ) ); ?>" alt="" class="ecs-job-detail__meta-icon">
				<?php echo esc_html( $jd_deadline ); ?>
			</li>
		</ul>
		<button type="button" class="ecs-job-detail__apply ecs-jobs__apply" data-job-apply data-job-title="<?php echo esc_attr( $jd_title ); ?>" aria-haspopup="dialog"><?php echo esc_html( ecsges_t( 'Ứng tuyển ngay' ) ); ?></button>
	</div>
</header>
```

- [ ] **Step 3: Create `template-parts/job-chi-tiet-content.php`**

```php
<?php
/**
 * Chi tiết tuyển dụng — nội dung chính: 4 khối Mô tả công việc / Yêu cầu ứng
 * viên / Quyền lợi / Cách ứng tuyển. Mỗi field textarea (1 dòng = 1 ý) được
 * tách thành <ul><li>, đúng cách linh-vuc-tabs.php đang xử lý paragraph/bullet.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$jd_id = get_the_ID();

$jd_blocks = array(
	array(
		'title' => 'Mô tả công việc',
		'body'  => ecsges_field_page( $jd_id, 'job_description', '' ),
	),
	array(
		'title' => 'Yêu cầu ứng viên',
		'body'  => ecsges_field_page( $jd_id, 'job_requirements', '' ),
	),
	array(
		'title' => 'Quyền lợi',
		'body'  => ecsges_field_page( $jd_id, 'job_benefits', '' ),
	),
	array(
		'title' => 'Cách ứng tuyển',
		'body'  => ecsges_field_page( $jd_id, 'job_how_to_apply', '' ),
	),
);
?>
<div class="ecs-job-detail__content">
	<?php foreach ( $jd_blocks as $jd_block ) : ?>
		<?php
		$jd_lines = array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $jd_block['body'] ) ), 'strlen' ) );
		if ( empty( $jd_lines ) ) {
			continue;
		}
		?>
		<section class="ecs-job-detail__block">
			<h2 class="ecs-job-detail__block-title"><?php echo esc_html( ecsges_t( $jd_block['title'] ) ); ?></h2>
			<ul class="ecs-job-detail__block-list">
				<?php foreach ( $jd_lines as $jd_line ) : ?>
					<li><?php echo esc_html( $jd_line ); ?></li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endforeach; ?>
</div>
```

- [ ] **Step 4: Create `template-parts/job-chi-tiet-sidebar.php`**

```php
<?php
/**
 * Chi tiết tuyển dụng — sidebar: thẻ thông tin ECSGES (địa chỉ/email/điện
 * thoại, tái dùng ecsges_footer_contact() đã có cho footer) + nút Ứng tuyển
 * ngay, sticky ở màn hình rộng.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$jd_contact = ecsges_footer_contact();
$jd_title   = get_the_title();
?>
<aside class="ecs-job-detail__sidebar">
	<div class="ecs-job-detail__sidebar-card">
		<img src="<?php echo esc_url( ecsges_img( 'logo-ecsges.svg' ) ); ?>" alt="ECSGES" class="ecs-job-detail__sidebar-logo">
		<p class="ecs-job-detail__sidebar-name">ECSGES — ECS Global Education System</p>
		<p class="ecs-job-detail__sidebar-line"><?php echo esc_html( $jd_contact['address'] ); ?></p>
		<p class="ecs-job-detail__sidebar-line"><?php echo esc_html( $jd_contact['email'] ); ?></p>
		<p class="ecs-job-detail__sidebar-line"><?php echo esc_html( $jd_contact['phone'] ); ?></p>
		<button type="button" class="ecs-job-detail__sidebar-apply ecs-jobs__apply" data-job-apply data-job-title="<?php echo esc_attr( $jd_title ); ?>" aria-haspopup="dialog"><?php echo esc_html( ecsges_t( 'Ứng tuyển ngay' ) ); ?></button>
	</div>
</aside>
```

- [ ] **Step 5: Lint all 4 new files**

Run:
```bash
for f in page-tuyen-dung-chi-tiet.php template-parts/job-chi-tiet-header.php template-parts/job-chi-tiet-content.php template-parts/job-chi-tiet-sidebar.php; do "/d/laragon/bin/php/php-8.3.28-Win32-vs16-x64/php.exe" -l "d:/laragon/www/ECS/wp-content/themes/ecsges/$f"; done
```
Expected: 4x `No syntax errors detected`

- [ ] **Step 6: Add `.ecs-job-detail` SCSS**

Append to `src/scss/components/_pages.scss`:

```scss
// Trang Chi tiết tuyển dụng (page-tuyen-dung-chi-tiet.php) — template dùng
// lại cho nhiều Page (mỗi Page 1 tin), không gắn với 1 Figma node cụ thể;
// bố cục tham khảo trang chi tiết job phổ biến (header tóm tắt → nội dung
// 2 cột: khối mô tả trái, sidebar công ty phải, sticky ở màn rộng).
.ecs-job-detail {
  &__inner {
    @include container;
  }

  &__header {
    background: $surface-2;
    padding-block: 40px;

    @include bp(lg) {
      padding-block: 56px;
    }
  }

  &__header-inner {
    @include container;
  }

  &__title {
    margin: 0;
    font-family: $font-display;
    font-weight: 500;
    @include text-lg;
    color: $ink;
  }

  &__meta {
    margin: 20px 0 0;
    padding: 0;
    list-style: none;
    display: flex;
    flex-wrap: wrap;
    gap: 16px 32px;
  }

  &__meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 300;
    @include text-sm;
    color: $body;

    &--salary {
      font-weight: 500;
      color: $brand;
    }
  }

  &__meta-icon {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
  }

  &__apply {
    margin-top: 24px;
  }

  &__grid {
    padding-block: 48px;
    display: grid;
    gap: 40px;

    @include bp(lg) {
      grid-template-columns: 1fr 380px;
      gap: 64px;
      align-items: start;
    }
  }

  &__block + &__block {
    margin-top: 32px;
  }

  &__block-title {
    margin: 0 0 16px;
    font-family: $font-display;
    font-weight: 500;
    @include text-md;
    color: $ink;
  }

  &__block-list {
    margin: 0;
    padding-left: 20px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    font-weight: 300;
    @include text-sm;
    color: $body;
  }

  &__sidebar-card {
    background: $surface-2;
    padding: 24px;

    @include bp(lg) {
      position: sticky;
      top: 24px;
    }
  }

  &__sidebar-logo {
    display: block;
    height: 32px;
    width: auto;
  }

  &__sidebar-name {
    margin: 16px 0 0;
    font-family: $font-display;
    font-weight: 500;
    @include text-sm;
    color: $ink;
  }

  &__sidebar-line {
    margin: 8px 0 0;
    font-weight: 300;
    @include text-sm;
    color: $body;
  }

  &__sidebar-apply {
    margin-top: 20px;
    width: 100%;
  }
}
```

- [ ] **Step 7: Build CSS**

Run: `cd "d:/laragon/www/ECS/wp-content/themes/ecsges" && npm run build:css`
Expected: exits 0, no sass/postcss errors.

- [ ] **Step 8: Commit**

```bash
git add page-tuyen-dung-chi-tiet.php template-parts/job-chi-tiet-header.php template-parts/job-chi-tiet-content.php template-parts/job-chi-tiet-sidebar.php src/scss/components/_pages.scss assets/css/main.css
git commit -m "Thêm template Chi tiết tuyển dụng (header/content/sidebar)"
```

---

### Task 4: `ecsges_jobs_list()` — auto-switch hardcode → real Pages

**Files:**
- Modify: `inc/data.php` (add new function near `ecsges_jobs()`)

**Interfaces:**
- Consumes: `ecsges_jobs(): array` (existing, untouched), `ecsges_field_page()` (Task 1).
- Produces: `ecsges_jobs_list(): array` — same shape as `ecsges_jobs()` (`title`, `location`, `department`, `type`, `deadline`, `tag`) **plus** a new key `href` (string, empty `''` when the item came from the hardcoded fallback, a real permalink when it came from a Page).

- [ ] **Step 1: Add `ecsges_jobs_list()` to `inc/data.php`**

Insert immediately after the closing `}` of `ecsges_jobs()` (`inc/data.php:617`):

```php
/**
 * Danh sách job hiển thị ở trang Tuyển dụng. Ưu tiên Page thật đã gán
 * template "Chi tiết tuyển dụng" (page-tuyen-dung-chi-tiet.php) — có Page
 * thật thì BỎ HẲN hardcode, không merge. Chưa có Page nào → fallback
 * ecsges_jobs() để trang không bao giờ trống.
 */
function ecsges_jobs_list()
{
	$q = new WP_Query(array(
		'post_type'      => 'page',
		'posts_per_page' => -1,
		'no_found_rows'  => true,
		'meta_key' => '_wp_page_template',
		'meta_value' => 'page-tuyen-dung-chi-tiet.php',
		'orderby' => 'date',
		'order' => 'DESC',
	));

	if (empty($q->posts)) {
		return ecsges_jobs();
	}

	$jobs = array();
	foreach ($q->posts as $p) {
		$jobs[] = array(
			'title' => get_the_title($p),
			'location' => ecsges_field_page($p->ID, 'job_location', ''),
			'department' => ecsges_field_page($p->ID, 'job_department', ''),
			'type' => ecsges_field_page($p->ID, 'job_type', ''),
			'deadline' => ecsges_field_page($p->ID, 'job_deadline', ''),
			'tag' => get_field('job_hot', $p->ID) ? 'hot' : '',
			'href' => get_permalink($p),
		);
	}
	return $jobs;
}
```

- [ ] **Step 2: Lint**

Run: `"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l "d:\laragon\www\ECS\wp-content\themes\ecsges\inc\data.php"`
Expected: `No syntax errors detected`

- [ ] **Step 3: Verify fallback path via WP-CLI (no matching Page exists yet)**

Run:
```bash
"/d/laragon/bin/php/php-8.3.28-Win32-vs16-x64/php.exe" "/d/wp-cli/wp-cli.phar" eval 'echo count(ecsges_jobs_list());' --path=d:/laragon/www/ECS
```
Expected: `4` (same count as hardcoded `ecsges_jobs()` — proves the fallback branch runs cleanly).

- [ ] **Step 4: Commit**

```bash
git add inc/data.php
git commit -m "Thêm ecsges_jobs_list(): tự chuyển hardcode sang Page thật"
```

---

### Task 5: Job card — "Tìm hiểu thêm" button + wire to `ecsges_jobs_list()`

**Files:**
- Modify: `template-parts/section-tuyen-dung-jobs.php`
- Modify: `src/scss/components/_pages.scss` (append `.ecs-jobs__more`)

**Interfaces:**
- Consumes: `ecsges_jobs_list()` (Task 4) — replaces the current direct call to `ecsges_jobs()`.
- Produces: no new interface for other tasks — this is the final consumer in the chain.

- [ ] **Step 1: Swap the data source**

In `template-parts/section-tuyen-dung-jobs.php`, find the loop that builds `$ecsges_jobs_all` (currently `foreach ( ecsges_jobs() as $ecsges_job_raw )`) and change the call from `ecsges_jobs()` to `ecsges_jobs_list()`:

```php
$ecsges_jobs_all = array();
foreach ( ecsges_jobs_list() as $ecsges_job_raw ) {
	$ecsges_job_tr                   = ecsges_tr_deep( $ecsges_job_raw );
	$ecsges_job_tr['key_location']   = $ecsges_job_raw['location'];
	$ecsges_job_tr['key_department'] = $ecsges_job_raw['department'];
	$ecsges_job_tr['key_type']       = $ecsges_job_raw['type'];
	$ecsges_jobs_all[]               = $ecsges_job_tr;
}
```

- [ ] **Step 2: Add the "Tìm hiểu thêm" button next to "Ứng tuyển ngay"**

Find this line in the same file (the apply button inside the `<article class="ecs-jobs__card">` loop):

```php
								<button type="button" class="ecs-jobs__apply" data-job-apply data-job-title="<?php echo esc_attr( $ecsges_job['title'] ); ?>" aria-haspopup="dialog"><?php echo esc_html( ecsges_t( 'Ứng tuyển ngay' ) ); ?></button>
```

Add this immediately after it (still inside the same `<article>`, before its closing `</article>`):

```php
								<?php if ( ! empty( $ecsges_job['href'] ) ) : ?>
									<a href="<?php echo esc_url( $ecsges_job['href'] ); ?>" class="ecs-jobs__more"><?php echo esc_html( ecsges_t( 'Tìm hiểu thêm' ) ); ?></a>
								<?php else : ?>
									<a class="ecs-jobs__more ecs-jobs__more--inert"><?php echo esc_html( ecsges_t( 'Tìm hiểu thêm' ) ); ?></a>
								<?php endif; ?>
```

(`$ecsges_job['href']` only exists — and is only non-empty — for jobs sourced from a real Page in Task 4; the hardcoded fallback array has no `href` key, so `empty()` is `true` and the inert branch renders, matching "vẫn hiện nhưng chả trỏ về đâu".)

- [ ] **Step 3: Lint**

Run: `"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l "d:\laragon\www\ECS\wp-content\themes\ecsges\template-parts\section-tuyen-dung-jobs.php"`
Expected: `No syntax errors detected`

- [ ] **Step 4: Add `.ecs-jobs__more` SCSS**

Append inside the existing `.ecs-jobs { ... }` block in `src/scss/components/_pages.scss` (add as a new `&__more` rule, sibling to the existing `&__apply` rule):

```scss
  &__more {
    display: inline-block;
    margin-top: 12px;
    margin-inline-start: 16px;
    border: 1px solid $brand;
    padding: 8px 16px;
    font-family: $font-display;
    font-weight: 500;
    @include text-sm;
    color: $brand;
    text-decoration: none;
    transition: background-color 0.15s ease, color 0.15s ease;

    &:hover {
      background: $brand;
      color: #fff;
    }

    &--inert {
      cursor: default;
      opacity: 0.5;
      pointer-events: none;
    }
  }
```

- [ ] **Step 5: Build CSS**

Run: `cd "d:/laragon/www/ECS/wp-content/themes/ecsges" && npm run build:css`
Expected: exits 0, no errors.

- [ ] **Step 6: Verify with curl (fallback state — no real Page yet)**

Run:
```bash
curl -s http://ecs.test/tuyen-dung/ | grep -c 'ecs-jobs__more'
curl -s http://ecs.test/tuyen-dung/ | grep -c 'ecs-jobs__more--inert'
```
Expected: both counts equal `4` (one inert "Tìm hiểu thêm" per hardcoded job card, no live href yet).

- [ ] **Step 7: Commit**

```bash
git add template-parts/section-tuyen-dung-jobs.php src/scss/components/_pages.scss assets/css/main.css
git commit -m "Thêm nút Tìm hiểu thêm trên job card, dùng ecsges_jobs_list()"
```

---

### Task 6: End-to-end verification with a real Page

**Files:** none (verification only — WP-CLI operations against the local database).

**Interfaces:**
- Consumes: everything from Tasks 1-5.
- Produces: nothing further downstream — this is the last task.

- [ ] **Step 1: Create one local verification Page (disclosed, not silent)**

Run:
```bash
"/d/laragon/bin/php/php-8.3.28-Win32-vs16-x64/php.exe" "/d/wp-cli/wp-cli.phar" post create --post_type=page --post_title="Nhân viên Digital Marketing" --post_status=publish --path=d:/laragon/www/ECS --porcelain
```
Expected: prints a numeric post ID — save it as `<JOB_ID>` for the next steps.

> Note for whoever runs this: this Page is created only to prove the auto-switch works end-to-end. It is a local, disclosed action (per this repo's "no silent DB mutations" convention) — after this task, tell the user it exists at `/nhan-vien-digital-marketing/` and that they can keep it as their first real job posting, edit it, or delete it (`wp post delete <JOB_ID> --force`).

- [ ] **Step 2: Assign the template and fill the ACF fields**

Run:
```bash
"/d/laragon/bin/php/php-8.3.28-Win32-vs16-x64/php.exe" "/d/wp-cli/wp-cli.phar" post meta update <JOB_ID> _wp_page_template page-tuyen-dung-chi-tiet.php --path=d:/laragon/www/ECS
"/d/laragon/bin/php/php-8.3.28-Win32-vs16-x64/php.exe" "/d/wp-cli/wp-cli.phar" post meta update <JOB_ID> job_salary "15 - 20 triệu" --path=d:/laragon/www/ECS
"/d/laragon/bin/php/php-8.3.28-Win32-vs16-x64/php.exe" "/d/wp-cli/wp-cli.phar" post meta update <JOB_ID> job_location "Hà Nội" --path=d:/laragon/www/ECS
"/d/laragon/bin/php/php-8.3.28-Win32-vs16-x64/php.exe" "/d/wp-cli/wp-cli.phar" post meta update <JOB_ID> job_department "Phòng Công nghệ thông tin và Truyền thông" --path=d:/laragon/www/ECS
"/d/laragon/bin/php/php-8.3.28-Win32-vs16-x64/php.exe" "/d/wp-cli/wp-cli.phar" post meta update <JOB_ID> job_type "Toàn thời gian" --path=d:/laragon/www/ECS
"/d/laragon/bin/php/php-8.3.28-Win32-vs16-x64/php.exe" "/d/wp-cli/wp-cli.phar" post meta update <JOB_ID> job_deadline "Thời hạn: 20/7/2026" --path=d:/laragon/www/ECS
"/d/laragon/bin/php/php-8.3.28-Win32-vs16-x64/php.exe" "/d/wp-cli/wp-cli.phar" post meta update <JOB_ID> job_hot 1 --path=d:/laragon/www/ECS
"/d/laragon/bin/php/php-8.3.28-Win32-vs16-x64/php.exe" "/d/wp-cli/wp-cli.phar" post meta update <JOB_ID> job_description "Xây dựng kế hoạch digital marketing.
Quản lý kênh quảng cáo Facebook/Google." --path=d:/laragon/www/ECS
```
(replace `<JOB_ID>` with the ID from Step 1 in every command)
Expected: each command prints `Success: Updated custom field 'X'.`

- [ ] **Step 3: Confirm the detail page itself renders**

Run:
```bash
curl -s -o /dev/null -w "%{http_code}\n" "http://ecs.test/nhan-vien-digital-marketing/"
curl -s "http://ecs.test/nhan-vien-digital-marketing/" | grep -c 'ecs-job-detail__title'
curl -s "http://ecs.test/nhan-vien-digital-marketing/" | grep -c '15 - 20 triệu'
curl -s "http://ecs.test/nhan-vien-digital-marketing/" | grep -io 'warning\|fatal error' | sort -u
```
Expected: `200`; both `grep -c` calls return `1` or more; the warning/error check prints nothing.

- [ ] **Step 4: Confirm the job list auto-switched (hardcode gone, real job now first)**

Run:
```bash
curl -s "http://ecs.test/tuyen-dung/" | grep -c 'href="http://ecs.test/nhan-vien-digital-marketing/"'
curl -s "http://ecs.test/tuyen-dung/" | grep -c 'ecs-jobs__more--inert'
```
Expected: first count ≥ `1` (the real Page's permalink is now used as an active "Tìm hiểu thêm" href); second count = `0` (no inert buttons left — `ecsges_jobs_list()` returned only the 1 real Page, hardcode fully replaced, matching the spec's "có Page thật thì bỏ hẳn hardcode, không merge").

- [ ] **Step 5: Report to the user and stop**

Tell the user:
- The local verification Page `Nhân viên Digital Marketing` (ID `<JOB_ID>`) now exists at `/nhan-vien-digital-marketing/`, assigned the "Chi tiết tuyển dụng" template, with sample field values.
- They can keep it as a real posting (edit the fields to match reality), or delete it with `wp post delete <JOB_ID> --force --path=d:/laragon/www/ECS`.
- To add more real job postings later: create a Page in wp-admin, set Template = "Chi tiết tuyển dụng" under Page Attributes, fill in the fields — no further code changes needed; `ecsges_jobs_list()` picks it up automatically.
- Ask the user to open `/tuyen-dung/` and `/nhan-vien-digital-marketing/` in a real browser to eyeball spacing/layout, since this environment has no screenshot tool.

No commit in this task (verification only, no file changes).

---

## Self-Review Notes

- **Spec coverage:** §4 template registration → Task 3 Step 1. §5 ACF field group → Task 2. §6 helper → Task 1. §7 auto-switch data function → Task 4. §8 card button → Task 5. §9 SCSS → Tasks 3 & 5 (co-located with their markup). §10 risks (meta_key template matching, no DB Page created except disclosed) → addressed directly in Task 4's query and Task 6's disclosure step.
- **Placeholder scan:** none — every step has literal code/commands, including full placeholder copy text for the 4 ACF textareas (no `"..."`).
- **Type/name consistency:** `ecsges_jobs_list()` (Task 4) returns the same 5 keys as `ecsges_jobs()` (`title`/`location`/`department`/`type`/`deadline`/`tag`) plus `href`; Task 5's card loop and the `empty($ecsges_job['href'])` check match this shape exactly. ACF field names (`job_salary`, `job_location`, `job_department`, `job_type`, `job_deadline`, `job_hot`, `job_description`, `job_requirements`, `job_benefits`, `job_how_to_apply`) are identical across Task 2 (registration), Task 3 (template-parts reading them via `ecsges_field_page()`), and Task 4 (`ecsges_jobs_list()` reading `job_location`/`job_department`/`job_type`/`job_deadline`/`job_hot`).
