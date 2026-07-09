# Header Dropdown Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Ba mục nav ("Về ECS", "Lĩnh vực hoạt động", "Phát triển bền vững") xổ panel mục con khi hover trên desktop, và bấm accordion trên mobile.

**Architecture:** Dữ liệu nav lên 2 cấp (`children`) từ WP menu con với fallback tĩnh. Desktop mở panel bằng CSS thuần `:hover` / `:focus-within` — không một dòng JS. Mobile dùng một hàm JS nhỏ toggle class, đúng quy ước "SCSS định nghĩa state, JS chỉ toggle class".

**Tech Stack:** WordPress classic theme (PHP 8.3), SCSS (Live Sass Compiler → `assets/css/main.css`), vanilla JS ES5-style IIFE.

## Global Constraints

- **KHÔNG chạy `npm run build:scss`.** CSS build bằng VS Code "Live Sass Compiler" (Watch Sass). Script npm là Dart Sass trần, không autoprefixer, sẽ ghi đè `main.css` mất vendor prefix.
- Chỉ sửa `.scss`; không bao giờ sửa tay `assets/css/main.css`.
- Lint PHP: `"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l <file>`
- WP-CLI: `& "D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" "D:\wp-cli\wp-cli.phar" <cmd> --path="d:/laragon/www/ECS"`
- Với `wp eval` có biến PHP `$var`: ghi code ra file tạm rồi dùng `wp eval-file` (PowerShell nuốt `$` trong chuỗi nháy kép).
- Class BEM ngữ nghĩa: `.ecs-header__<part>`, state `.is-open` / `.is-hidden`.
- `.is-hidden` **không** phải utility toàn cục trong theme này — mỗi component tự khai báo rule ẩn của mình.
- Site local: `http://ecs.test`. Theme không có test tự động; "test" = PHP lint + WP-CLI dump + kiểm chứng trên trình duyệt thật.
- Menu chỉ 2 cấp. Mục cháu (cấp 3) bị bỏ qua có chủ đích.

## File Structure

| File | Trách nhiệm | Thay đổi |
|---|---|---|
| `inc/data.php` | Fallback tĩnh cho nav | Modify: thêm `children` vào 3 mục |
| `functions.php` | `ecsges_get_nav()` — gom cây nav từ WP menu | Modify: dòng 376–404 |
| `page-ve-ecs.php` | Trang Về ECS | Modify: thêm `id` cho 2 khối anchor |
| `header.php` | Markup nav desktop + mobile | Modify: dòng 42–50, 81–99 |
| `src/scss/components/_layout.scss` | Style header | Modify: thêm rule trong block `.ecs-header` |
| `assets/js/main.js` | Hành vi front-end | Modify: thêm `initMobileSubmenu()` |

---

### Task 1: Tầng dữ liệu — nav 2 cấp + anchor thật trên trang Về ECS

Gom cả ba thứ vào một task vì chúng chỉ có ý nghĩa cùng nhau: `children` cần href,
href của "Về ECS" cần `id` tồn tại trên trang, và tất cả kiểm chứng bằng một lệnh.

**Files:**
- Modify: `inc/data.php:17-26`
- Modify: `functions.php:376-404`
- Modify: `page-ve-ecs.php:102`, `page-ve-ecs.php:118`
- Test: không có test tự động — dùng WP-CLI dump + PHP lint

**Interfaces:**
- Produces: `ecsges_get_nav()` trả về `array` các mục
  `array( 'label' => string, 'href' => string, 'children' => array )`.
  Khoá `children` **vắng mặt** (không phải mảng rỗng) với mục không có con.
  Mỗi phần tử `children` có shape `array( 'label' => string, 'href' => string )`
  và không lồng sâu thêm. Task 2 và Task 3 đọc trực tiếp shape này.
- Consumes: `ecsges_tr_deep()` (`inc/i18n.php:203`) — đã đệ quy sẵn, không sửa.

- [ ] **Step 1: Viết script kiểm chứng (đây là "test" thay cho unit test)**

Tạo `C:\Users\VANHAI~1\AppData\Local\Temp\claude\d--laragon-www-ECS-wp-content-themes-ecsges\7c2a9f6a-ddac-4311-bba8-d71792f1b8c7\scratchpad\dump-nav.php`:

```php
<?php
$nav = ecsges_get_nav();
foreach ( $nav as $item ) {
	$n = isset( $item['children'] ) ? count( $item['children'] ) : 0;
	echo $item['label'], ' [', $n, '] -> ', $item['href'], "\n";
	if ( $n ) {
		foreach ( $item['children'] as $c ) {
			echo '    - ', $c['label'], ' -> ', $c['href'], "\n";
		}
	}
}
```

- [ ] **Step 2: Chạy script để thấy nó FAIL (chưa có children)**

```bash
& "D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" "D:\wp-cli\wp-cli.phar" eval-file "<scratchpad>\dump-nav.php" --path="d:/laragon/www/ECS"
```

Expected: 6 dòng, **mọi mục đều `[0]`**. Chưa mục nào có con.

- [ ] **Step 3: Thêm `children` vào fallback tĩnh**

Trong `inc/data.php`, thay toàn bộ thân `ecsges_nav_items()`:

```php
function ecsges_nav_items() {
	return array(
		array(
			'label'    => 'Về ECS',
			'href'     => '/ve-ecs',
			'children' => array(
				array( 'label' => 'Hành trình phát triển', 'href' => '/ve-ecs#hanh-trinh-phat-trien' ),
				array( 'label' => 'Tầm nhìn',              'href' => '/ve-ecs#tam-nhin' ),
				array( 'label' => 'Sứ mệnh',               'href' => '/ve-ecs#su-menh' ),
				array( 'label' => 'Giá trị cốt lõi',       'href' => '/ve-ecs#gia-tri-cot-loi' ),
			),
		),
		array(
			'label'    => 'Lĩnh vực hoạt động',
			'href'     => '/linh-vuc-hoat-dong/',
			'children' => array(
				array( 'label' => 'Hướng nghiệp',  'href' => '/linh-vuc-hoat-dong/' ),
				array( 'label' => 'Tuyển sinh',    'href' => '/linh-vuc-hoat-dong/' ),
				array( 'label' => 'Đào tạo',       'href' => '/linh-vuc-hoat-dong/' ),
				array( 'label' => 'Việc làm',      'href' => '/linh-vuc-hoat-dong/' ),
				array( 'label' => 'Truyền thông',  'href' => '/linh-vuc-hoat-dong/' ),
			),
		),
		array(
			'label'    => 'Phát triển bền vững',
			'href'     => '/phat-trien-ben-vung/',
			'children' => array(
				array( 'label' => 'Văn hoá ECS',        'href' => '/phat-trien-ben-vung/' ),
				array( 'label' => 'Con người ECS',      'href' => '/phat-trien-ben-vung/' ),
				array( 'label' => 'Trách nhiệm xã hội', 'href' => '/phat-trien-ben-vung/' ),
			),
		),
		array( 'label' => 'Tin tức',    'href' => '/category/tin-tuc/' ),
		array( 'label' => 'Tuyển dụng', 'href' => '#tuyen-dung' ),
		array( 'label' => 'Liên hệ',    'href' => '#lien-he' ),
	);
}
```

- [ ] **Step 4: Sửa `ecsges_get_nav()` để gom cây thay vì bỏ mục con**

Trong `functions.php`, thay khối `if (!empty($locations['primary'])) { ... }` (dòng 380–394):

```php
	if (!empty($locations['primary'])) {
		$menu_items = wp_get_nav_menu_items($locations['primary']);
		if ($menu_items) {
			$by_id = array();
			// Lượt 1: mục cha, giữ nguyên thứ tự menu_order.
			foreach ($menu_items as $mi) {
				if ((int) $mi->menu_item_parent !== 0) {
					continue;
				}
				$by_id[(int) $mi->ID] = array(
					'label' => $mi->title,
					'href' => $mi->url,
				);
			}
			// Lượt 2: đẩy mục con vào cha. Cháu (cấp 3) bị bỏ qua có chủ đích.
			foreach ($menu_items as $mi) {
				$parent = (int) $mi->menu_item_parent;
				if (0 === $parent || !isset($by_id[$parent])) {
					continue;
				}
				$by_id[$parent]['children'][] = array(
					'label' => $mi->title,
					'href' => $mi->url,
				);
			}
			$items = array_values($by_id);
		}
	}
```

Phần còn lại của hàm (fallback, vòng lặp sửa href `ve-ecs`, `return ecsges_tr_deep($items)`) **giữ nguyên**.

Lưu ý: vòng lặp sửa href hiện dùng `foreach ($items as &$it)` và chỉ chạm `$it['href']` cấp 1. Không đổi — href mục con của "Về ECS" đã là `/ve-ecs#...` sẵn, và Polylang chỉ cần đúng trang cha.

- [ ] **Step 5: Thêm `id` anchor cho Tầm nhìn và Sứ mệnh**

Trong `page-ve-ecs.php` dòng 102:

```php
					<div id="tam-nhin" class="ecs-ve-vm__row">
```

Và dòng 118:

```php
					<div id="su-menh" class="ecs-ve-vm__row">
```

- [ ] **Step 6: Lint PHP**

```bash
"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l inc/data.php
"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l functions.php
"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l page-ve-ecs.php
```

Expected: `No syntax errors detected` cho cả ba.

- [ ] **Step 7: Chạy lại script kiểm chứng — giờ phải PASS**

```bash
& "D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" "D:\wp-cli\wp-cli.phar" eval-file "<scratchpad>\dump-nav.php" --path="d:/laragon/www/ECS"
```

Expected chính xác:

```
Về ECS [4] -> http://ecs.test/ve-ecs/
    - Hành trình phát triển -> /ve-ecs#hanh-trinh-phat-trien
    - Tầm nhìn -> /ve-ecs#tam-nhin
    - Sứ mệnh -> /ve-ecs#su-menh
    - Giá trị cốt lõi -> /ve-ecs#gia-tri-cot-loi
Lĩnh vực hoạt động [5] -> /linh-vuc-hoat-dong/
    - Hướng nghiệp -> /linh-vuc-hoat-dong/
    ...
Phát triển bền vững [3] -> /phat-trien-ben-vung/
    ...
Tin tức [0] -> /category/tin-tuc/
Tuyển dụng [0] -> #tuyen-dung
Liên hệ [0] -> #lien-he
```

(Href của "Về ECS" bị `ecsges_ve_ecs_url()` viết lại thành URL tuyệt đối — đúng như hiện tại.)

Nếu site đã gán menu `primary` trong admin thì output sẽ theo menu đó, không theo fallback. Kiểm tra bằng `wp menu location list --path="d:/laragon/www/ECS"`; nếu chưa gán, fallback tĩnh chạy và output khớp đúng như trên.

- [ ] **Step 8: Verify anchor id đã có mặt trong HTML**

```bash
curl -s http://ecs.test/ve-ecs/ | grep -o 'id="tam-nhin"\|id="su-menh"'
```

Expected: in ra `id="tam-nhin"` và `id="su-menh"`.

- [ ] **Step 9: Commit**

```bash
git add inc/data.php functions.php page-ve-ecs.php
git commit -m "Nav 2 cấp: children trong data + gom cây từ WP menu + anchor ve-ecs"
```

---

### Task 2: Dropdown desktop — markup + SCSS

**Files:**
- Modify: `header.php:42-50`
- Modify: `src/scss/components/_layout.scss` (thêm rule vào block `.ecs-header`, sau `&__nav-link` dòng 186)
- Test: kiểm chứng trên `http://ecs.test` bằng trình duyệt

**Interfaces:**
- Consumes: `ecsges_get_nav()` từ Task 1 — khoá `children` vắng mặt khi không có con.
- Consumes: `ecsges_icon( $name, $size = 24, $class = '', $stroke = 2 )` (`functions.php:159`), hỗ trợ tên `'chevron-down'`.
- Produces: class `.ecs-header__nav-item`, `.ecs-header__dropdown` — Task 4 kiểm chứng.

- [ ] **Step 1: Sửa markup nav desktop**

Trong `header.php`, thay khối `<ul class="ecs-header__nav-list">` (dòng 43–49):

```php
					<ul class="ecs-header__nav-list">
						<?php foreach ( $ecsges_nav as $item ) : ?>
							<?php $has_children = ! empty( $item['children'] ); ?>
							<li class="ecs-header__nav-item<?php echo $has_children ? ' has-children' : ''; ?>">
								<a href="<?php echo esc_url( $item['href'] ); ?>" class="ecs-header__nav-link">
									<?php echo esc_html( $item['label'] ); ?>
									<?php if ( $has_children ) : ?>
										<?php echo ecsges_icon( 'chevron-down', 13, 'ecs-header__nav-caret', 2.5 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									<?php endif; ?>
								</a>
								<?php if ( $has_children ) : ?>
									<div class="ecs-header__dropdown">
										<ul class="ecs-header__dropdown-list">
											<?php foreach ( $item['children'] as $child ) : ?>
												<li>
													<a href="<?php echo esc_url( $child['href'] ); ?>" class="ecs-header__dropdown-link"><?php echo esc_html( $child['label'] ); ?></a>
												</li>
											<?php endforeach; ?>
										</ul>
									</div>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
```

Không đặt `aria-expanded` trên link cha: không có JS cập nhật nó, thuộc tính sẽ nói dối screen reader. `:focus-within` lo phần bàn phím.

- [ ] **Step 2: Thêm SCSS dropdown**

Trong `src/scss/components/_layout.scss`, chèn ngay **sau** block `&__nav-link { ... }` (kết thúc dòng 186), vẫn nằm trong `.ecs-header`:

```scss
  // Mục nav có menu con — neo cho dropdown tuyệt đối.
  &__nav-item {
    position: relative;
  }

  &__nav-caret {
    margin-left: 0.25rem;
    vertical-align: middle;
    transition: transform 0.2s;
  }

  &__nav-item:hover &__nav-caret,
  &__nav-item:focus-within &__nav-caret {
    transform: rotate(180deg);
  }

  // Panel: padding-top là "cầu chuột" bắc qua khoảng hở giữa link và panel,
  // nếu không :hover sẽ đứt khi rê chuột xuống. Cùng thủ thuật .ecsges-lang-panel.
  // Dùng visibility (không display:none) để transition được và để :focus-within bắt focus.
  &__dropdown {
    position: absolute;
    left: 0;
    top: 100%;
    z-index: 50;
    padding-top: 0.75rem;
    opacity: 0;
    visibility: hidden;
    transition:
      opacity 0.2s ease,
      visibility 0.2s ease;
  }

  &__nav-item:hover > &__dropdown,
  &__nav-item:focus-within > &__dropdown {
    opacity: 1;
    visibility: visible;
  }

  &__dropdown-list {
    min-width: 220px;
    white-space: nowrap;
    border-radius: 0.375rem;
    background: #fff;
    padding-block: 0.5rem;
    box-shadow:
      0 0 0 1px rgba(0, 0, 0, 0.05),
      0 10px 15px -3px rgba(0, 0, 0, 0.1),
      0 4px 6px -4px rgba(0, 0, 0, 0.1);
  }

  &__dropdown-link {
    display: block;
    padding: 0.5rem 1rem;
    font-size: 15px;
    color: $ink;
    transition: color 0.15s ease;

    &:hover {
      color: $brand;
    }
  }
```

Nếu Dart Sass báo lỗi ở `&__nav-item:hover > &__dropdown` (lồng `&` trong selector con), viết tường minh:

```scss
.ecs-header__nav-item:hover > .ecs-header__dropdown,
.ecs-header__nav-item:focus-within > .ecs-header__dropdown { opacity: 1; visibility: visible; }
```

đặt **ngoài** block `.ecs-header`.

- [ ] **Step 3: Lint PHP + build CSS**

```bash
"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l header.php
```

Expected: `No syntax errors detected`.

Live Sass Compiler tự build khi lưu `.scss`. Xác nhận `main.css` đã chứa class mới:

```bash
grep -c "ecs-header__dropdown" assets/css/main.css
```

Expected: `1` (main.css minified một dòng, nên đếm dòng = 1 nghĩa là "có").
Nếu ra `0`: extension chưa chạy — bật "Watch Sass" trong VS Code rồi lưu lại file. **Đừng** chạy `npm run build:scss`.

- [ ] **Step 4: Kiểm chứng trên trình duyệt**

Mở `http://ecs.test`, cửa sổ rộng ≥ 1024px:

1. Hover "Về ECS" → panel hiện 4 mục con, caret xoay lên.
2. Rê chuột thẳng từ chữ "Về ECS" xuống panel → panel **không** biến mất.
3. Hover "Tin tức" → không có panel, không có caret.
4. Nhấn Tab tới "Về ECS" → panel mở (`:focus-within`); Tab qua hết 4 mục con rồi tiếp → panel đóng.
5. Trong DevTools tắt JS (Command Palette → Disable JavaScript), reload → hover vẫn mở panel.

- [ ] **Step 5: Commit**

```bash
git add header.php src/scss/components/_layout.scss assets/css/main.css
git commit -m "Dropdown desktop cho nav có menu con (CSS hover + focus-within)"
```

---

### Task 3: Accordion mobile — markup + SCSS + JS

**Files:**
- Modify: `header.php:81-99` (nav `#mobile-menu`)
- Modify: `src/scss/components/_layout.scss` (thêm rule sau `&__mobile-link`, dòng ~290)
- Modify: `assets/js/main.js` (thêm `initMobileSubmenu()` + gọi ở dòng 21)
- Test: kiểm chứng trên trình duyệt ở viewport hẹp

**Interfaces:**
- Consumes: `ecsges_get_nav()` từ Task 1, `ecsges_icon()`.
- Produces: attribute `data-submenu-toggle`, id `submenu-<i>`, class `.ecs-header__mobile-item`, `.ecs-header__mobile-sublist`.

- [ ] **Step 1: Sửa markup mobile nav**

Trong `header.php`, thay các dòng 84–88 (vòng `foreach` sinh `<li>` mobile) bằng — chú ý `foreach` giờ có index `$i` để sinh id duy nhất:

```php
						<?php foreach ( $ecsges_nav as $i => $item ) : ?>
							<?php $has_children = ! empty( $item['children'] ); ?>
							<li class="ecs-header__mobile-item">
								<div class="ecs-header__mobile-row">
									<a href="<?php echo esc_url( $item['href'] ); ?>" class="ecs-header__mobile-link" data-menu-link><?php echo esc_html( $item['label'] ); ?></a>
									<?php if ( $has_children ) : ?>
										<button type="button" data-submenu-toggle aria-expanded="false" aria-controls="submenu-<?php echo esc_attr( $i ); ?>" aria-label="Mở menu con <?php echo esc_attr( $item['label'] ); ?>" class="ecs-header__mobile-sub-toggle">
											<?php echo ecsges_icon( 'chevron-down', 16, '', 2.5 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
										</button>
									<?php endif; ?>
								</div>
								<?php if ( $has_children ) : ?>
									<ul id="submenu-<?php echo esc_attr( $i ); ?>" class="ecs-header__mobile-sublist is-hidden">
										<?php foreach ( $item['children'] as $child ) : ?>
											<li>
												<a href="<?php echo esc_url( $child['href'] ); ?>" class="ecs-header__mobile-sublink" data-menu-link><?php echo esc_html( $child['label'] ); ?></a>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
```

`data-menu-link` giữ trên cả link cha và link con để menu di động tự đóng sau khi bấm (hành vi sẵn có của `initMobileMenu()`).

- [ ] **Step 2: Thêm SCSS mobile**

Trong `src/scss/components/_layout.scss`, chèn **sau** block `&__mobile-link { ... }`, vẫn trong `.ecs-header`:

```scss
  &__mobile-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
  }

  &__mobile-sub-toggle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    padding: 0.5rem;
    border: 0;
    background: none;
    color: $ink;
    cursor: pointer;
    transition: transform 0.2s;
  }

  &__mobile-item.is-open &__mobile-sub-toggle {
    transform: rotate(180deg);
  }

  &__mobile-sublist {
    padding-left: 1rem;
    padding-bottom: 0.5rem;

    // .is-hidden KHÔNG phải utility toàn cục trong theme này — phải khai báo ở đây.
    &.is-hidden {
      display: none;
    }
  }

  &__mobile-sublink {
    display: block;
    padding-block: 0.375rem;
    font-size: 14px;
    color: $ink;
    transition: color 0.15s ease;

    &:hover {
      color: $brand;
    }
  }
```

- [ ] **Step 3: Thêm `initMobileSubmenu()` vào main.js**

Trong `assets/js/main.js`, thêm lời gọi vào khối `DOMContentLoaded` (sau `initLangDropdown();` dòng 21):

```js
    initLangDropdown();
    initMobileSubmenu();
```

Rồi thêm hàm ngay sau `initLangDropdown()` (sau dòng 53):

```js
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
```

- [ ] **Step 4: Lint + build**

```bash
"D:\laragon\bin\php\php-8.3.28-Win32-vs16-x64\php.exe" -l header.php
grep -c "ecs-header__mobile-sublist" assets/css/main.css
```

Expected: `No syntax errors detected`, và `grep -c` ra `1`.

- [ ] **Step 5: Kiểm chứng trên trình duyệt (viewport hẹp)**

Mở `http://ecs.test`, thu cửa sổ xuống < 1024px:

1. Bấm hamburger → menu di động mở, 3 mục đầu có caret, 3 mục sau không.
2. Bấm caret "Về ECS" → sublist xổ ra, caret xoay 180°, `aria-expanded="true"` (kiểm trong DevTools).
3. Bấm caret lần nữa → sublist thu lại, `aria-expanded="false"`.
4. Bấm **chữ** "Về ECS" → điều hướng tới `/ve-ecs/`, không xổ sublist.
5. Bấm "Tầm nhìn" trong sublist → menu di động đóng và cuộn tới đúng khối.

- [ ] **Step 6: Commit**

```bash
git add header.php src/scss/components/_layout.scss assets/js/main.js assets/css/main.css
git commit -m "Accordion menu con cho menu di động"
```

---

### Task 4: Kiểm chứng tổng thể

**Files:**
- Không sửa file nào. Task này chỉ chạy và quan sát.

**Interfaces:**
- Consumes: mọi thứ từ Task 1–3.

- [ ] **Step 1: Kiểm tra hồi quy các trang khác**

Mở lần lượt `http://ecs.test/`, `http://ecs.test/ve-ecs/`, `http://ecs.test/category/tin-tuc/`.
Header render đúng trên cả ba; không lỗi trong Console.

- [ ] **Step 2: Kiểm tra dropdown không bị cắt**

Hover "Phát triển bền vững" (mục nav ngoài cùng phải trong ba mục có con).
Panel phải nằm gọn trong viewport, không tràn ngang gây thanh cuộn.
Nếu tràn: đổi `left: 0` thành `right: 0` cho riêng mục cuối, hoặc dùng
`left: 50%; transform: translateX(-50%)`.

- [ ] **Step 3: Kiểm tra dropdown không đá nhau với dropdown ngôn ngữ**

Hover "Về ECS" rồi click nút ngôn ngữ (`VI`). Hai panel cùng `z-index: 50`
nhưng khác vị trí; không panel nào bị panel kia che.

- [ ] **Step 4: Kiểm tra header sticky (Headroom)**

Cuộn xuống rồi cuộn lên để header hiện lại → hover mục nav vẫn mở panel bình thường,
panel không bị `overflow` của header cắt mất.

- [ ] **Step 5: Kiểm tra không-JS lần cuối**

DevTools → Disable JavaScript → reload `http://ecs.test/`:
- Dropdown desktop hover: **hoạt động**.
- Menu di động và accordion: không hoạt động (chấp nhận — cần JS), nhưng
  link cha vẫn bấm được vì `<a href>` thật.

- [ ] **Step 6: Commit tài liệu nếu có chỉnh sửa**

Nếu Step 2 phải đổi cách neo panel, cập nhật spec cho khớp rồi:

```bash
git add -A
git commit -m "Chỉnh vị trí dropdown cho mục nav ngoài cùng"
```

---

## Ghi chú cho người triển khai

**Vì sao không có unit test.** Theme WordPress classic này không có test harness
(không PHPUnit, không Jest). Vòng "test" tương đương là: PHP lint bắt lỗi cú pháp,
WP-CLI `eval-file` bắt lỗi shape dữ liệu, và trình duyệt bắt lỗi hành vi. Task 1
cố tình chạy script dump **trước** khi sửa code để thấy nó fail — đó là bước
"red" của TDD, chỉ khác công cụ.

**Bẫy hay gặp.**

- `main.css` là file build. Nếu bạn thấy nó không đổi sau khi lưu `.scss`, extension
  Live Sass Compiler chưa bật. Đừng chữa bằng `npm run build:scss` — nó xoá vendor prefix.
- `.is-hidden` không tự có `display: none`. Rule ở Task 3 Step 2 là bắt buộc, không phải trang trí.
- `visibility: hidden` chứ không `display: none` cho dropdown: `display` không transition
  được, và phần tử `display:none` không nhận focus nên `:focus-within` sẽ chết.
- `padding-top` trên `.ecs-header__dropdown` không phải khoảng cách thẩm mỹ — bỏ nó đi
  là hover đứt quãng khi rê chuột từ link xuống panel.
