# Trang "Tuyển dụng" Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a new WordPress page template `page-tuyen-dung.php` (Recruitment) matching Figma node `402:280`/`405:228`: hero banner, filter sidebar, static job-listing cards with pagination, and a job-application modal.

**Architecture:** Classic PHP theme pattern already used by `page-linh-vuc-hoat-dong.php` — a thin `page-tuyen-dung.php` calls `get_header()`, two `template-parts/section-tuyen-dung-*.php` partials, then `get_footer()`. Job data is a static PHP array (`ecsges_jobs()` in `inc/data.php`), mirroring `ecsges_milestones()`. Pagination and the apply-modal are vanilla-JS IIFEs added to `assets/js/main.js`, following the exact toggle pattern already used by `initNewsPagination()`/`initLangDropdown()`.

**Tech Stack:** PHP 8.3 (WordPress classic theme, no build step), SCSS compiled via VS Code "Live Sass Compiler" extension to `assets/css/main.css`, vanilla JS (`assets/js/main.js`, no bundler).

## Global Constraints

- Only edit `.scss` — `assets/css/main.css` is rebuilt by the Live Sass Compiler extension, not by hand and not via `npm run build:scss` (that strips vendor prefixes; see repo `CLAUDE.md`).
- Styling = hand-written SCSS, semantic BEM classes (`.ecs-<block>__<part>`, state via `.is-active`/`.is-open`/`.is-hidden`) — no utility-class/Tailwind-style authoring.
- No `rem` units in new SCSS — this theme now uses `px` exclusively (converted 2026-07-21).
- No inline explanatory comments mapping to Tailwind-style utility names; comments only where genuinely non-obvious.
- Do not create a WP Page, menu item, or ACF field group in the database — only add theme files. The user creates the Page (slug `tuyen-dung`) in wp-admin themselves; WordPress' template hierarchy auto-maps `page-tuyen-dung.php` to it.
- Job data is a hardcoded static PHP array — no Custom Post Type, no ACF.
- Filter `<select>` elements are real, accessible markup but are **not** wired to any filtering logic in this plan.
- The apply-modal's submit handler only closes/resets the form — no backend call (email/API) is implemented in this plan.
- Lint every touched `.php` file with `"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l <file>` before considering a task done.
- Spec reference: `docs/superpowers/specs/2026-07-21-tuyen-dung-page-design.md`.

---

### Task 1: Job data source

**Files:**
- Modify: `inc/data.php` (append a new function near `ecsges_milestones()`)

**Interfaces:**
- Produces: `ecsges_jobs(): array` — list of associative arrays, each with keys `title` (string), `location` (string), `department` (string), `type` (string), `deadline` (string), `tag` (string `'hot'`|`'new'`, or `null`), `apply_href` (string URL).

- [ ] **Step 1: Add `ecsges_jobs()` to `inc/data.php`**

Append this function (place it after `ecsges_milestones()`, matching the file's existing doc-comment style):

```php
/** Danh sách việc làm đang tuyển (trang Tuyển dụng). */
function ecsges_jobs() {
	return array(
		array(
			'title'      => 'Nhân viên Digital Marketing',
			'location'   => 'Hà Nội',
			'department' => 'Phòng Công nghệ thông tin và Truyền thông',
			'type'       => 'Toàn thời gian',
			'deadline'   => 'Thời hạn: 20/7/2026',
			'tag'        => 'hot',
			'apply_href' => '#',
		),
		array(
			'title'      => 'Nhân viên Digital Marketing',
			'location'   => 'Hà Nội',
			'department' => 'Phòng Công nghệ thông tin và Truyền thông',
			'type'       => 'Toàn thời gian',
			'deadline'   => 'Thời hạn: 20/7/2026',
			'tag'        => 'new',
			'apply_href' => '#',
		),
		array(
			'title'      => 'Nhân viên Media',
			'location'   => 'Hà Nội',
			'department' => 'Phòng Công nghệ thông tin và Truyền thông',
			'type'       => 'Toàn thời gian',
			'deadline'   => 'Thời hạn: 20/7/2026',
			'tag'        => 'new',
			'apply_href' => '#',
		),
		array(
			'title'      => 'Nhân viên Designer',
			'location'   => 'Hà Nội',
			'department' => 'Phòng Công nghệ thông tin và Truyền thông',
			'type'       => 'Toàn thời gian',
			'deadline'   => 'Thời hạn: 20/7/2026',
			'tag'        => 'new',
			'apply_href' => '#',
		),
	);
}
```

- [ ] **Step 2: Lint**

Run: `"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l "d:\laragon\www\ECS\wp-content\themes\ecsges\inc\data.php"`
Expected: `No syntax errors detected`

- [ ] **Step 3: Verify via WP-CLI**

Run:
```
& "D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" "D:\wp-cli\wp-cli.phar" eval "print_r(ecsges_jobs());" --path=d:/laragon/www/ECS
```
Expected: prints the 4-item array with the fields above (no PHP errors/warnings).

- [ ] **Step 4: Commit**

```bash
git add inc/data.php
git commit -m "Thêm ecsges_jobs() dữ liệu tĩnh cho trang Tuyển dụng"
```

---

### Task 2: Hero section

**Files:**
- Create: `template-parts/section-tuyen-dung-hero.php`
- Modify: `src/scss/components/_pages.scss` (append `.ecs-recruit-hero` block)
- Asset already in place: `assets/img/tuyen-dung/hero.jpg` (1920×681 JPEG, downloaded from Figma node `402:300`)

**Interfaces:**
- Consumes: `ecsges_img( string $relativePath ): string` (existing helper in `functions.php:85`).
- Produces: renders a `<section id="tuyen-dung-hero" class="ecs-recruit-hero">` — no PHP return value, no other task depends on internals beyond the section existing before `section-tuyen-dung-jobs.php` in the page template.

- [ ] **Step 1: Create `template-parts/section-tuyen-dung-hero.php`**

```php
<?php
/**
 * Section Hero — trang Tuyển dụng. Ảnh nền (2 người + sóng cam, đã dựng sẵn
 * trong assets/img/tuyen-dung/hero.jpg) + tiêu đề lớn phủ lên trên.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section id="tuyen-dung-hero" aria-labelledby="tuyen-dung-hero-heading" class="ecs-recruit-hero">
	<img src="<?php echo esc_url( ecsges_img( 'tuyen-dung/hero.jpg' ) ); ?>" alt="" class="ecs-recruit-hero__bg">
	<h1 id="tuyen-dung-hero-heading" data-aos="fade-up" class="ecs-recruit-hero__title">Tuyển dụng</h1>
</section>
```

- [ ] **Step 2: Lint**

Run: `"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l "d:\laragon\www\ECS\wp-content\themes\ecsges\template-parts\section-tuyen-dung-hero.php"`
Expected: `No syntax errors detected`

- [ ] **Step 3: Add `.ecs-recruit-hero` SCSS**

Append to `src/scss/components/_pages.scss` (after the existing `.ecs-page-hero` block):

```scss
.ecs-recruit-hero {
  position: relative;
  overflow: hidden;

  &__bg {
    display: block;
    width: 100%;
    height: auto;
  }

  &__title {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: $font-display;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: $brand;
    text-shadow: 0 4px 4px rgba(255, 255, 255, 0.45);
    font-size: 32px;

    @include bp(sm) { font-size: 56px; }
    @include bp(lg) { font-size: 98px; }
  }
}
```

- [ ] **Step 4: Commit**

```bash
git add template-parts/section-tuyen-dung-hero.php src/scss/components/_pages.scss assets/img/tuyen-dung/hero.jpg
git commit -m "Thêm section hero cho trang Tuyển dụng"
```

---

### Task 3: Filter sidebar + job list + pagination markup

**Files:**
- Create: `template-parts/section-tuyen-dung-jobs.php`
- Modify: `src/scss/components/_pages.scss` (append `.ecs-jobs` block)

**Interfaces:**
- Consumes: `ecsges_jobs(): array` (Task 1), `ecsges_img()` (existing helper).
- Produces: markup with hooks Task 5's JS binds to: `[data-jobs]`, `[data-jobs-page]` (one per page-chunk), `[data-jobs-pagination]`, `[data-jobs-dot]`, `[data-jobs-prev]`, `[data-jobs-next]`; and `[data-job-apply]` (+ `data-job-title` attribute) that Task 4's modal listens for.

- [ ] **Step 1: Create `template-parts/section-tuyen-dung-jobs.php`**

```php
<?php
/**
 * Section Bộ lọc + Danh sách việc làm — trang Tuyển dụng.
 * Dữ liệu tĩnh từ ecsges_jobs() (inc/data.php), phân trang 4 job/trang bằng
 * JS thuần (giống cơ chế initNewsPagination() ở section-news.php).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ecsges_jobs_all  = ecsges_jobs();
$ecsges_jobs_per  = 4;
$ecsges_jobs_pgs  = array_chunk( $ecsges_jobs_all, $ecsges_jobs_per );
$ecsges_jobs_pgct = count( $ecsges_jobs_pgs );
$ecsges_jobs_arw  = ecsges_img( 'arrow.svg' );
?>
<section id="tuyen-dung-jobs" aria-labelledby="tuyen-dung-jobs-heading" class="ecs-jobs">
	<div class="ecs-jobs__inner">
		<div class="ecs-jobs__filters" data-aos="fade-up">
			<h2 class="ecs-jobs__filters-title">Bộ lọc</h2>

			<div class="ecs-jobs__field">
				<label class="ecs-jobs__label" for="jobs-filter-area">Khu vực</label>
				<select id="jobs-filter-area" class="ecs-jobs__select">
					<option value="" selected disabled>- Chọn khu vực -</option>
				</select>
			</div>

			<div class="ecs-jobs__field">
				<label class="ecs-jobs__label" for="jobs-filter-dept">Phòng ban</label>
				<select id="jobs-filter-dept" class="ecs-jobs__select">
					<option value="" selected disabled>- Chọn phòng ban -</option>
				</select>
			</div>

			<div class="ecs-jobs__field">
				<label class="ecs-jobs__label" for="jobs-filter-level">Cấp bậc</label>
				<select id="jobs-filter-level" class="ecs-jobs__select">
					<option value="" selected disabled>- Chọn cấp bậc -</option>
				</select>
			</div>
		</div>

		<div class="ecs-jobs__list-col">
			<h2 id="tuyen-dung-jobs-heading" class="ecs-jobs__list-title">Tất cả công việc</h2>

			<div class="ecs-jobs__list" data-aos="fade-up" data-aos-delay="120" data-jobs>
				<?php foreach ( $ecsges_jobs_pgs as $ji => $ecsges_jobs_page ) : ?>
					<div data-jobs-page="<?php echo esc_attr( $ji ); ?>" class="ecs-jobs__page<?php echo 0 === $ji ? ' is-active' : ''; ?>">
						<?php foreach ( $ecsges_jobs_page as $ecsges_job ) : ?>
							<article class="ecs-jobs__card">
								<h3 class="ecs-jobs__card-title"><?php echo esc_html( $ecsges_job['title'] ); ?></h3>

								<?php if ( ! empty( $ecsges_job['tag'] ) ) : ?>
									<div class="ecs-jobs__badge ecs-jobs__badge--<?php echo esc_attr( $ecsges_job['tag'] ); ?>">
										<img src="<?php echo esc_url( ecsges_img( 'hot' === $ecsges_job['tag'] ? 'tuyen-dung/star-hot.SVG' : 'tuyen-dung/star-new.svg' ) ); ?>" alt="" class="ecs-jobs__badge-star">
										<span class="ecs-jobs__badge-label"><?php echo esc_html( 'hot' === $ecsges_job['tag'] ? 'Hot' : 'Mới' ); ?></span>
									</div>
								<?php endif; ?>

								<ul class="ecs-jobs__info">
									<li class="ecs-jobs__info-item">
										<img src="<?php echo esc_url( ecsges_img( 'tuyen-dung/pin.svg' ) ); ?>" alt="" class="ecs-jobs__info-icon">
										<?php echo esc_html( $ecsges_job['location'] ); ?>
									</li>
									<li class="ecs-jobs__info-item">
										<img src="<?php echo esc_url( ecsges_img( 'tuyen-dung/home.svg' ) ); ?>" alt="" class="ecs-jobs__info-icon">
										<?php echo esc_html( $ecsges_job['department'] ); ?>
									</li>
									<li class="ecs-jobs__info-item">
										<img src="<?php echo esc_url( ecsges_img( 'tuyen-dung/time.svg' ) ); ?>" alt="" class="ecs-jobs__info-icon">
										<?php echo esc_html( $ecsges_job['type'] ); ?>
									</li>
									<li class="ecs-jobs__info-item">
										<img src="<?php echo esc_url( ecsges_img( 'tuyen-dung/file.svg' ) ); ?>" alt="" class="ecs-jobs__info-icon">
										<?php echo esc_html( $ecsges_job['deadline'] ); ?>
									</li>
								</ul>

								<a href="<?php echo esc_url( $ecsges_job['apply_href'] ); ?>" class="ecs-jobs__apply" data-job-apply data-job-title="<?php echo esc_attr( $ecsges_job['title'] ); ?>">ỨNG TUYỂN NGAY &gt;&gt;</a>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( $ecsges_jobs_pgct > 1 ) : ?>
				<div class="ecs-jobs__pagination" data-jobs-pagination data-page-count="<?php echo esc_attr( $ecsges_jobs_pgct ); ?>">
					<button type="button" data-jobs-prev aria-label="Trang trước" class="ecs-jobs__arrow">
						<img src="<?php echo esc_url( $ecsges_jobs_arw ); ?>" alt="" class="ecs-jobs__arrow-img">
					</button>

					<div class="ecs-jobs__dots" role="tablist" aria-label="Trang việc làm">
						<?php for ( $i = 0; $i < $ecsges_jobs_pgct; $i++ ) : ?>
							<button type="button" data-jobs-dot="<?php echo esc_attr( $i ); ?>" aria-label="Trang <?php echo esc_attr( $i + 1 ); ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" class="ecs-jobs__dot<?php echo 0 === $i ? ' is-active' : ''; ?>"></button>
						<?php endfor; ?>
					</div>

					<button type="button" data-jobs-next aria-label="Trang sau" class="ecs-jobs__arrow">
						<img src="<?php echo esc_url( $ecsges_jobs_arw ); ?>" alt="" class="ecs-jobs__arrow-img ecs-jobs__arrow-img--next">
					</button>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
```

- [ ] **Step 2: Lint**

Run: `"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l "d:\laragon\www\ECS\wp-content\themes\ecsges\template-parts\section-tuyen-dung-jobs.php"`
Expected: `No syntax errors detected`

- [ ] **Step 3: Add `.ecs-jobs` SCSS**

Append to `src/scss/components/_pages.scss`:

```scss
.ecs-jobs {
  background: #fff;
  padding-block: 64px;

  @include bp(lg) {
    padding-block: 96px;
  }

  &__inner {
    @include container;
    display: grid;
    gap: 40px;

    @include bp(lg) {
      grid-template-columns: 448px 1fr;
      gap: 64px;
    }
  }

  &__filters-title,
  &__list-title {
    font-family: $font-display;
    font-weight: 500;
    font-size: 32px;
    color: $ink;

    @include bp(lg) {
      font-size: 50px;
    }
  }

  &__field {
    margin-top: 24px;
  }

  &__label {
    display: block;
    font-weight: 300;
    font-size: 18px;
    color: $ink;
  }

  &__select {
    margin-top: 12px;
    width: 100%;
    height: 51px;
    border: 0.5px solid $placeholder;
    background: #fff;
    padding-inline: 16px;
    font-size: 18px;
    color: $muted-2;
  }

  &__list-col {
    min-width: 0;
  }

  &__list {
    position: relative;
    margin-top: 24px;
  }

  &__page {
    display: none;

    &.is-active {
      display: flex;
      flex-direction: column;
      gap: 24px;
    }
  }

  &__card {
    position: relative;
    border: 0.5px solid $placeholder;
    background: #fff;
    padding: 24px;
  }

  &__card-title {
    font-family: $font-display;
    font-weight: 500;
    font-size: 22px;
    color: $ink;
    padding-right: 80px;
  }

  &__badge {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
  }

  &__badge-star {
    width: 66px;
    height: 67px;
  }

  &__badge-label {
    position: absolute;
    font-family: $font-display;
    font-weight: 500;
    font-size: 16px;
  }

  &__badge--hot &__badge-label {
    color: #fff;
  }

  &__badge--new &__badge-label {
    color: $brand;
  }

  &__info {
    margin-top: 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    font-weight: 300;
    font-size: 18px;
    color: $ink;
  }

  &__info-item {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  &__info-icon {
    flex-shrink: 0;
    width: 18px;
    height: 18px;
  }

  &__apply {
    display: inline-block;
    margin-top: 16px;
    font-family: $font-display;
    font-weight: 500;
    font-size: 18px;
    color: $brand;
    transition: opacity 0.15s ease;

    &:hover {
      opacity: 0.7;
    }
  }

  &__pagination {
    margin-top: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
  }

  &__arrow-img {
    width: 32px;
    height: 32px;
  }

  &__arrow-img--next {
    transform: scaleX(-1);
  }

  &__dots {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  &__dot {
    width: 10px;
    height: 10px;
    border-radius: 9999px;
    background: $placeholder;
    transition: background-color 0.15s ease;

    &.is-active {
      background: $brand;
    }
  }
}
```

- [ ] **Step 4: Commit**

```bash
git add template-parts/section-tuyen-dung-jobs.php src/scss/components/_pages.scss
git commit -m "Thêm bộ lọc + danh sách job + phân trang cho trang Tuyển dụng"
```

---

### Task 4: Apply modal markup + styles

**Files:**
- Modify: `template-parts/section-tuyen-dung-jobs.php` (append modal markup right before `</section>`)
- Modify: `src/scss/components/_pages.scss` (append `.ecs-job-modal` block)

**Interfaces:**
- Consumes: nothing new from PHP.
- Produces: markup hooks Task 5's JS binds to: `[data-job-modal]` (root, toggles `.is-open`), `[data-job-modal-position]` (text node updated with job title), `[data-job-modal-form]`, `[data-job-modal-close]` (×2: overlay + close button), `[data-job-modal-file]` (×2: CV + Portfolio inputs), `[data-job-modal-filename]` (×2: matching hint spans, one per upload field, each a sibling inside the same `<label>` as its `[data-job-modal-file]`).

- [ ] **Step 1: Append modal markup**

In `template-parts/section-tuyen-dung-jobs.php`, insert immediately before the final `</section>` tag:

```php
	<div class="ecs-job-modal" data-job-modal aria-hidden="true">
		<div class="ecs-job-modal__overlay" data-job-modal-close></div>
		<div class="ecs-job-modal__panel" role="dialog" aria-modal="true" aria-labelledby="job-modal-title">
			<button type="button" class="ecs-job-modal__close" data-job-modal-close aria-label="Đóng">&times;</button>

			<h2 id="job-modal-title" class="ecs-job-modal__title">
				<span class="ecs-job-modal__title-line">NỘP ĐƠN ỨNG TUYỂN</span>
				<span class="ecs-job-modal__title-line ecs-job-modal__title-job" data-job-modal-position>VỊ TRÍ ...</span>
			</h2>

			<form class="ecs-job-modal__form" data-job-modal-form>
				<div class="ecs-job-modal__field">
					<label for="job-apply-name">Họ và tên</label>
					<input type="text" id="job-apply-name" name="name" placeholder="Nhập họ và tên" required>
				</div>

				<div class="ecs-job-modal__field">
					<label for="job-apply-email">Địa chỉ email</label>
					<input type="email" id="job-apply-email" name="email" placeholder="Nhập địa chỉ email" required>
				</div>

				<div class="ecs-job-modal__field">
					<label for="job-apply-phone">Số điện thoại</label>
					<input type="tel" id="job-apply-phone" name="phone" placeholder="Nhập số điện thoại" required>
				</div>

				<label class="ecs-job-modal__upload">
					<input type="file" name="cv" hidden data-job-modal-file>
					<span class="ecs-job-modal__upload-title">CV của bạn</span>
					<span class="ecs-job-modal__upload-hint" data-job-modal-filename>Click để chọn và tải lên CV của bạn</span>
				</label>

				<label class="ecs-job-modal__upload">
					<input type="file" name="portfolio" hidden data-job-modal-file>
					<span class="ecs-job-modal__upload-title">Portfolio của bạn</span>
					<span class="ecs-job-modal__upload-hint" data-job-modal-filename>Click để chọn và tải lên Portfolio của bạn</span>
				</label>

				<button type="submit" class="ecs-job-modal__submit">NỘP ĐƠN ỨNG TUYỂN</button>
			</form>
		</div>
	</div>
```

- [ ] **Step 2: Lint**

Run: `"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l "d:\laragon\www\ECS\wp-content\themes\ecsges\template-parts\section-tuyen-dung-jobs.php"`
Expected: `No syntax errors detected`

- [ ] **Step 3: Add `.ecs-job-modal` SCSS**

Append to `src/scss/components/_pages.scss`:

```scss
.ecs-job-modal {
  position: fixed;
  inset: 0;
  z-index: 100;
  display: none;
  align-items: flex-start;
  justify-content: center;
  overflow-y: auto;
  padding: 48px 24px;

  &.is-open {
    display: flex;
  }

  &__overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.2);
  }

  &__panel {
    position: relative;
    width: 100%;
    max-width: 620px;
    background: #fff;
    padding: 32px;

    @include bp(sm) {
      padding: 48px;
    }
  }

  &__close {
    position: absolute;
    top: 16px;
    right: 16px;
    width: 32px;
    height: 32px;
    border: 0;
    background: none;
    font-size: 24px;
    line-height: 1;
    color: $ink;
    cursor: pointer;
  }

  &__title {
    text-align: center;
  }

  &__title-line {
    display: block;
    font-family: $font-display;
    font-weight: 600;
    font-size: 24px;
    color: $brand;
  }

  &__form {
    margin-top: 32px;
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  &__field {
    display: flex;
    flex-direction: column;
    gap: 8px;

    label {
      font-weight: 300;
      font-size: 18px;
      color: $ink;
    }

    input {
      height: 51px;
      border: 0.5px solid $placeholder;
      padding-inline: 16px;
      font-size: 18px;
      color: $ink;

      &::placeholder {
        color: $muted-2;
      }
    }
  }

  &__upload {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    border: 1px dashed $placeholder;
    padding: 24px;
    text-align: center;
    cursor: pointer;
  }

  &__upload-title {
    font-weight: 300;
    font-size: 18px;
    color: $ink;
  }

  &__upload-hint {
    font-weight: 300;
    font-size: 18px;
    color: $muted-2;
  }

  &__submit {
    height: 51px;
    border: 0;
    background: $brand;
    font-family: $font-display;
    font-weight: 600;
    font-size: 24px;
    color: #fff;
    cursor: pointer;
    transition: opacity 0.15s ease;

    &:hover {
      opacity: 0.9;
    }
  }
}
```

- [ ] **Step 4: Commit**

```bash
git add template-parts/section-tuyen-dung-jobs.php src/scss/components/_pages.scss
git commit -m "Thêm modal ứng tuyển cho trang Tuyển dụng"
```

---

### Task 5: JS behavior (pagination + modal)

**Files:**
- Modify: `assets/js/main.js`

**Interfaces:**
- Consumes: DOM hooks produced by Task 3 (`[data-jobs]`, `[data-jobs-page]`, `[data-jobs-pagination]`, `[data-jobs-dot]`, `[data-jobs-prev]`, `[data-jobs-next]`, `[data-job-apply]` + `data-job-title`) and Task 4 (`[data-job-modal]`, `[data-job-modal-position]`, `[data-job-modal-form]`, `[data-job-modal-close]`, `[data-job-modal-file]`, `[data-job-modal-filename]`).
- Produces: `initJobsPagination()`, `initJobModal()` — both called once from the existing `DOMContentLoaded` listener; no return values, no other task depends on them.

- [ ] **Step 1: Register the two new init calls**

In `assets/js/main.js`, find the `DOMContentLoaded` listener (starts around line 12) and add two calls alongside the existing ones:

```js
    initEcosystemTabs();
    initNewsPagination();
    initJobsPagination();
    initJobModal();
    initStickyHeader();
```

- [ ] **Step 2: Add `initJobsPagination()`**

Append this function after `initNewsPagination()` (mirror its structure exactly, renamed to the `data-jobs*` attributes):

```js
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
```

- [ ] **Step 3: Add `initJobModal()`**

Append this function after `initJobsPagination()`:

```js
  /* ---------------------------------------------------------------- */
  /**
   * Modal "Nộp đơn ứng tuyển": mở khi bấm [data-job-apply], đóng bằng nút X /
   * click overlay / Esc. Submit chỉ reset + đóng modal (chưa nối backend).
   */
  function initJobModal() {
    var modal = document.querySelector('[data-job-modal]');
    if (!modal) return;

    var positionEl = modal.querySelector('[data-job-modal-position]');
    var form = modal.querySelector('[data-job-modal-form]');
    var fileFields = Array.prototype.slice.call(modal.querySelectorAll('[data-job-modal-file]')).map(function (input) {
      var label = input.closest('label');
      var hint = label ? label.querySelector('[data-job-modal-filename]') : null;
      return { input: input, hint: hint, placeholder: hint ? hint.textContent : '' };
    });

    function open(title) {
      if (positionEl) positionEl.textContent = 'VỊ TRÍ ' + title.toUpperCase();
      modal.classList.add('is-open');
      modal.setAttribute('aria-hidden', 'false');
    }

    function close() {
      modal.classList.remove('is-open');
      modal.setAttribute('aria-hidden', 'true');
    }

    function resetFileHints() {
      fileFields.forEach(function (field) {
        if (field.hint) field.hint.textContent = field.placeholder;
      });
    }

    Array.prototype.slice.call(document.querySelectorAll('[data-job-apply]')).forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        open(btn.getAttribute('data-job-title') || '');
      });
    });

    Array.prototype.slice.call(modal.querySelectorAll('[data-job-modal-close]')).forEach(function (el) {
      el.addEventListener('click', close);
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && modal.classList.contains('is-open')) close();
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
        // TODO: nối backend nhận hồ sơ (wp_mail/API) khi có yêu cầu.
        form.reset();
        resetFileHints();
        close();
      });
    }
  }
```

- [ ] **Step 4: Manual verification (no JS test runner in this project)**

Run: none (no build step for JS). Verification happens in Task 6 Step 3 via Playwright once the page template exists.

- [ ] **Step 5: Commit**

```bash
git add assets/js/main.js
git commit -m "Thêm initJobsPagination() và initJobModal() vào main.js"
```

---

### Task 6: Page template + end-to-end verification

**Files:**
- Create: `page-tuyen-dung.php`

**Interfaces:**
- Consumes: `template-parts/section-tuyen-dung-hero.php` (Task 2), `template-parts/section-tuyen-dung-jobs.php` (Tasks 3-4).
- Produces: the page template WordPress maps to a Page with slug `tuyen-dung`.

- [ ] **Step 1: Create `page-tuyen-dung.php`**

```php
<?php
/**
 * Trang Tuyển dụng (page-tuyen-dung.php, Figma node 402:280 / 405:228).
 *
 * @package ECSGES
 */

get_header();
get_template_part( 'template-parts/section', 'tuyen-dung-hero' );
get_template_part( 'template-parts/section', 'tuyen-dung-jobs' );
get_footer();
```

- [ ] **Step 2: Lint**

Run: `"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l "d:\laragon\www\ECS\wp-content\themes\ecsges\page-tuyen-dung.php"`
Expected: `No syntax errors detected`

- [ ] **Step 3: Create a temporary WP Page to preview (local-only, not part of the deliverable)**

Run:
```
& "D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" "D:\wp-cli\wp-cli.phar" post create --post_type=page --post_title="Tuyển dụng" --post_name=tuyen-dung --post_status=publish --path=d:/laragon/www/ECS
```
Expected: prints `Success: Created post <ID>.`

> Note: this Page is created only so the template can be viewed in a browser during this task. It is a local preview aid, not a production content decision — tell the user it exists and that they can keep it, edit its title/menu placement, or delete it, per the project's "no silent DB mutations" convention.

- [ ] **Step 4: Confirm the Live Sass Compiler has rebuilt `main.css`**

Check that `assets/css/main.css` contains the new classes:
Run: `grep -c "ecs-recruit-hero\|ecs-jobs\|ecs-job-modal" "d:/laragon/www/ECS/wp-content/themes/ecsges/assets/css/main.css"`
Expected: non-zero. If zero, the VS Code "Live Sass Compiler" watcher isn't running — tell the user to enable "Watch Sass" before continuing.

- [ ] **Step 5: Visual verification in browser (Playwright)**

Navigate to `http://ecs.test/tuyen-dung/`, screenshot the hero, the filter+job-list area, and — after clicking an "ỨNG TUYỂN NGAY" link — the open modal. Compare against the Figma screenshots for node `402:280` and `405:228`. Check:
- Hero image displays full-bleed with "TUYỂN DỤNG" centered, orange, drop-shadowed.
- 4 job cards render with correct icons (pin/home/time/file) and Hot/Mới badges.
- Pagination controls are absent (only 4 jobs = 1 page).
- Clicking "ỨNG TUYỂN NGAY >>" opens the modal with the correct job title in "VỊ TRÍ …", and the modal closes via X, overlay click, and Esc.
- Choosing a file for CV/Portfolio updates the hint text to the file name.
- Submitting the form closes the modal and does not throw a JS console error.

- [ ] **Step 6: Commit**

```bash
git add page-tuyen-dung.php
git commit -m "Thêm page-tuyen-dung.php ghép các section trang Tuyển dụng"
```

---

## Self-Review Notes

- **Spec coverage:** File structure (§3) → Tasks 1-6. Data (§4) → Task 1. Hero (§5) → Task 2. Filters/list/pagination (§6) → Task 3. Modal (§7) → Task 4. JS (§8) → Task 5. SCSS (§9) → spread across Tasks 2-4 (co-located with their markup, per "files that change together live together"). Risks/assumptions (§10) → hero asset already downloaded as part of Task 2 setup; icon filenames kept as-provided (`star-hot.SVG` case preserved); no DB Page/menu created except the explicitly-flagged local preview Page in Task 6 Step 3.
- **Placeholder scan:** none found — every step has literal code/commands.
- **Type/name consistency:** `ecsges_jobs()` keys (`title`, `location`, `department`, `type`, `deadline`, `tag`, `apply_href`) used identically in Task 1 and Task 3. JS data-attributes (`data-jobs*`, `data-job-modal*`, `data-job-apply`) match 1:1 between Tasks 3/4 (markup) and Task 5 (JS).
