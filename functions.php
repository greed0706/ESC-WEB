<?php
/**
 * ECSGES theme — functions & helpers.
 *
 * @package ECSGES
 */

if (!defined('ABSPATH')) {
	exit;
}

define('ECSGES_VERSION', '1.0.0');

require_once get_template_directory() . '/inc/i18n.php';
require_once get_template_directory() . '/inc/data.php';
require_once get_template_directory() . '/inc/acf-fields.php';

/**
 * Theme setup.
 */
function ecsges_setup()
{
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', array('search-form', 'gallery', 'caption', 'style', 'script'));

	// GĐ2: menu wp_nav_menu() sẽ dùng vị trí này.
	register_nav_menus(
		array(
			'primary' => __('Menu chính', 'ecsges'),
		)
	);
}
add_action('after_setup_theme', 'ecsges_setup');

/**
 * Enqueue CSS (SCSS build → theme.css) + JS.
 */
function ecsges_assets()
{
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	// AOS (Animate On Scroll) — CSS hiệu ứng reveal. Vendor cục bộ.
	$aoscss_path = $dir . '/assets/css/vendor/aos.css';
	$aoscss_ver = file_exists($aoscss_path) ? filemtime($aoscss_path) : ECSGES_VERSION;
	wp_enqueue_style('aos', $uri . '/assets/css/vendor/aos.css', array(), $aoscss_ver);

	// Google Fonts: Roboto Flex (font-display) + Dancing Script (font-script — chữ "Kiến tạo").
	// (Khi migrate Tailwind→SCSS, @import Google Fonts ở đầu tailwind.css bị mất; enqueue lại tại đây.)
	wp_enqueue_style('ecsges-gfonts', 'https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,300..700&family=Dancing+Script:wght@500;600;700&display=swap', array(), null);

	// CSS chính: SCSS build (Phase 2 — đã cutover khỏi Tailwind). Nguồn: src/scss/ → assets/css/main.css.
	$css_path = $dir . '/assets/css/main.css';
	$css_ver = file_exists($css_path) ? filemtime($css_path) : ECSGES_VERSION;
	wp_enqueue_style('ecsges-main', $uri . '/assets/css/main.css', array('aos'), $css_ver);

	// Headroom.js — hiệu ứng header (dính + ẩn/hiện theo hướng cuộn). Vendor cục bộ.
	$hr_path = $dir . '/assets/js/vendor/headroom.min.js';
	$hr_ver = file_exists($hr_path) ? filemtime($hr_path) : ECSGES_VERSION;
	wp_enqueue_script('headroom', $uri . '/assets/js/vendor/headroom.min.js', array(), $hr_ver, true);

	// AOS — hiệu ứng reveal/entrance. Vendor cục bộ.
	$aos_path = $dir . '/assets/js/vendor/aos.js';
	$aos_ver = file_exists($aos_path) ? filemtime($aos_path) : ECSGES_VERSION;
	wp_enqueue_script('aos', $uri . '/assets/js/vendor/aos.js', array(), $aos_ver, true);

	$js_path = $dir . '/assets/js/main.js';
	$js_ver = file_exists($js_path) ? filemtime($js_path) : ECSGES_VERSION;
	wp_enqueue_script('ecsges-main', $uri . '/assets/js/main.js', array('headroom', 'aos'), $js_ver, true);
}
add_action('wp_enqueue_scripts', 'ecsges_assets');

/* ------------------------------------------------------------------ *\
 * Helpers dùng lại (port từ các primitive React)
\* ------------------------------------------------------------------ */

/**
 * URL tới 1 asset trong assets/img. Kèm cache-buster ?ver=filemtime để khi
 * thay ảnh (cùng tên file) trình duyệt tải bản mới ngay, không phải xoá cache.
 *
 * @param string $file Tên file (vd 'hero-mark.svg').
 * @return string
 */
function ecsges_img($file)
{
	$rel  = ltrim($file, '/');
	$url  = get_template_directory_uri() . '/assets/img/' . $rel;
	$path = get_template_directory() . '/assets/img/' . $rel;
	if (file_exists($path)) {
		$url = add_query_arg('ver', filemtime($path), $url);
	}
	return $url;
}

/**
 * Ngày hiển thị của 1 post: ưu tiên ACF field 'time' (Date Time Picker);
 * nếu người dùng chưa nhập thì fallback về ngày đăng bài.
 *
 * @param int|null $post_id Mặc định: post hiện tại trong loop.
 * @param string   $format  Định dạng date_i18n (mặc định 'M j, Y' → "May 29, 2023").
 * @return string
 */
function ecsges_post_time($post_id = null, $format = 'M j, Y')
{
	$post_id = $post_id ? $post_id : get_the_ID();
	$acf = function_exists('get_field') ? get_field('time', $post_id) : '';
	$ts = $acf ? strtotime($acf) : get_post_time('U', false, $post_id);
	if (!$ts) {
		$ts = get_post_time('U', false, $post_id);
	}
	return date_i18n($format, $ts);
}

/**
 * URL ảnh đại diện của post; nếu không có featured image thì fallback ảnh tĩnh.
 *
 * @param int|null $post_id
 * @param string   $size     Kích thước WP (thumbnail|medium|large|full).
 * @param string   $fallback Tên file trong assets/img.
 * @return string
 */
function ecsges_post_thumb($post_id = null, $size = 'large', $fallback = 'news.png')
{
	$post_id = $post_id ? $post_id : get_the_ID();
	if (has_post_thumbnail($post_id)) {
		$url = get_the_post_thumbnail_url($post_id, $size);
		if ($url) {
			return $url;
		}
	}
	return ecsges_img($fallback);
}

/**
 * Inline nội dung 1 file SVG trong assets/img (để recolor bằng currentColor).
 *
 * @param string $file Tên file svg (vd 'icon-daotao.svg').
 * @return string
 */
function ecsges_inline_svg($file)
{
	$path = get_template_directory() . '/assets/img/' . ltrim($file, '/');
	if (!file_exists($path)) {
		return '';
	}
	return file_get_contents($path); // phpcs:ignore WordPress.WP.AlternativeFunctions
}

/**
 * Icon kiểu Lucide (stroke, currentColor) — thay cho lucide-react.
 *
 * @param string $name  Tên icon: search|chevron-down|menu|x|map-pin|mail|phone.
 * @param int    $size  Kích thước px.
 * @param string $class Class CSS thêm cho <svg>.
 * @param float  $stroke Độ dày nét.
 * @return string SVG markup.
 */
function ecsges_icon($name, $size = 24, $class = '', $stroke = 2)
{
	$paths = array(
		'search' => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
		'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
		'menu' => '<line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>',
		'x' => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
		'map-pin' => '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/>',
		'mail' => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
		'phone' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
		'heart' => '<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>',
		'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
		'lightbulb' => '<path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/>',
	);

	if (empty($paths[$name])) {
		return '';
	}

	return sprintf(
		'<svg xmlns="http://www.w3.org/2000/svg" width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="%2$s" stroke-linecap="round" stroke-linejoin="round" class="%3$s" aria-hidden="true">%4$s</svg>',
		(int) $size,
		esc_attr((string) $stroke),
		esc_attr($class),
		$paths[$name] // Nội dung SVG tĩnh, an toàn.
	);
}

/**
 * Section heading (port SectionHeading.tsx): tiêu đề 2 dòng + eyebrow + accent màu brand.
 *
 * @param array $args {
 *     @type string   $id       id cho <h2> (dùng cho aria-labelledby).
 *     @type string   $eyebrow  Nhãn nhỏ phía trên + gạch brand.
 *     @type string[] $lines    Các dòng tiêu đề.
 *     @type int[]    $accent   Chỉ số dòng tô màu brand (mặc định: dòng cuối).
 *     @type string   $tone     'dark' | 'light'.
 *     @type string   $align    'left' | 'center'.
 *     @type string   $class    Class thêm.
 * }
 */
function ecsges_section_heading($args = array())
{
	$a = wp_parse_args(
		$args,
		array(
			'id' => '',
			'eyebrow' => '',
			'lines' => array(),
			'accent' => null,
			'tone' => 'dark',
			'align' => 'left',
			'class' => '',
		)
	);

	$lines = ecsges_tr_deep($a['lines']);
	$accent = is_null($a['accent']) ? array(count($lines) - 1) : $a['accent'];
	$is_center = 'center' === $a['align'];
	$is_light = 'light' === $a['tone'];

	$root_class = 'ecs-heading';
	if ($is_center) {
		$root_class .= ' ecs-heading--center';
	}
	if ($is_light) {
		$root_class .= ' ecs-heading--light';
	}
	if ($a['class']) {
		$root_class .= ' ' . $a['class'];
	}

	echo '<div class="' . esc_attr($root_class) . '">';

	if ($a['eyebrow']) {
		echo '<div class="ecs-heading__eyebrow-row">';
		echo '<span class="ecs-heading__eyebrow">' . esc_html(ecsges_t($a['eyebrow'])) . '</span>';
		echo '<span aria-hidden="true" class="ecs-heading__accent"></span>';
		echo '</div>';
	}

	printf(
		'<h2%s class="ecs-heading__title">',
		$a['id'] ? ' id="' . esc_attr($a['id']) . '"' : ''
	);
	foreach ($lines as $i => $line) {
		$line_class = 'ecs-heading__line';
		if (!$is_light && in_array($i, $accent, true)) {
			$line_class .= ' ecs-heading__line--accent';
		}
		echo '<span class="' . esc_attr($line_class) . '">' . esc_html($line) . '</span>';
	}
	echo '</h2>';
	echo '</div>';
}

/**
 * Underline link (port UnderlineLink.tsx): link + gạch chân.
 *
 * @param string $href
 * @param string $text
 * @param string $tone  'brand' | 'white'.
 * @param string $class
 */
function ecsges_underline_link($href, $text, $tone = 'brand', $class = '')
{
	$tone_class = 'white' === $tone ? 'ecs-underline--white' : 'ecs-underline--brand';
	printf(
		'<a href="%1$s" class="ecsges-underline ecs-underline %2$s"><span class="ecs-underline__text">%3$s</span><span aria-hidden="true" class="ecs-underline__bar"></span></a>',
		esc_url($href),
		esc_attr($tone_class . ' ' . $class),
		esc_html($text)
	);
}

/**
 * URL archive của một chuyên mục theo slug (vd 've-ecs' → /category/ve-ecs/).
 *
 * Dùng cho các nút "Tìm hiểu thêm" / "Xem thêm": mỗi nút trỏ về chuyên mục riêng.
 * Chuyên mục do client tự tạo trong admin — nếu slug chưa tồn tại thì trả
 * $fallback (neo cũ) thay vì in ra một link 404.
 *
 * @param string $slug     Slug chuyên mục.
 * @param string $fallback Link dự phòng khi chuyên mục chưa tồn tại.
 * @return string
 */
function ecsges_category_link($slug, $fallback = '')
{
	$slug = trim((string) $slug);
	if ('' === $slug) {
		return $fallback;
	}
	$term = get_term_by('slug', $slug, 'category');
	if (! $term || is_wp_error($term)) {
		return $fallback;
	}
	$link = get_term_link($term);
	return is_wp_error($link) ? $fallback : $link;
}

/**
 * "Xem thêm" pill (port SeeMoreButton.tsx).
 *
 * @param string $href
 * @param string $label
 * @param string $class
 */
function ecsges_see_more($href, $label = 'Xem thêm', $class = '')
{
	printf(
		'<a href="%1$s" class="ecs-see-more %2$s">%3$s</a>',
		esc_url($href),
		esc_attr($class),
		esc_html(ecsges_t($label))
	);
}

/* ------------------------------------------------------------------ *\
 * GIAI ĐOẠN 2 — ACF helpers (đọc nội dung từ Trang chủ, có fallback)
\* ------------------------------------------------------------------ */

/** ID của Trang đặt làm "Trang chủ" (page_on_front). */
function ecsges_home_id()
{
	$id = (int) get_option('page_on_front');
	return $id > 0 ? $id : 0;
}

/**
 * Lấy giá trị 1 ACF field trên Trang chủ; nếu ACF chưa cài / field trống → $default.
 *
 * @param string $name    Tên field.
 * @param mixed  $default Giá trị mặc định.
 * @return mixed
 */
function ecsges_field($name, $default = '')
{
	if (!function_exists('get_field')) {
		return ecsges_t($default);
	}
	$id = ecsges_home_id();
	if (!$id) {
		return ecsges_t($default);
	}
	$value = get_field($name, $id);
	if (null === $value || '' === $value || false === $value || array() === $value) {
		return ecsges_t($default);
	}
	return ecsges_t($value);
}

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

/**
 * Field text tách theo dòng → mảng (bỏ dòng trống). Dùng cho tiêu đề nhiều dòng / danh sách.
 *
 * @param string   $name
 * @param string[] $default Mảng mặc định.
 * @return string[]
 */
function ecsges_field_lines($name, $default = array())
{
	$raw = ecsges_field($name, null);
	if (null === $raw || '' === $raw) {
		return ecsges_tr_deep($default);
	}
	$lines = preg_split('/\r\n|\r|\n/', (string) $raw);
	$lines = array_values(array_filter(array_map('trim', $lines), 'strlen'));
	return ecsges_tr_deep($lines ? $lines : $default);
}

/**
 * Field textarea → mảng đoạn văn (ngăn bởi 1+ dòng trống).
 *
 * @param string   $name
 * @param string[] $default
 * @return string[]
 */
function ecsges_field_paragraphs($name, $default = array())
{
	$raw = ecsges_field($name, null);
	if (null === $raw || '' === $raw) {
		return ecsges_tr_deep($default);
	}
	$parts = preg_split('/(\r\n|\r|\n){2,}/', trim((string) $raw));
	$parts = array_values(array_filter(array_map('trim', $parts), 'strlen'));
	return ecsges_tr_deep($parts ? $parts : $default);
}

/**
 * Field image (URL). Trống → asset mặc định trong assets/img.
 *
 * @param string $name
 * @param string $default_file Tên file mặc định trong assets/img.
 * @return string URL.
 */
function ecsges_field_img($name, $default_file)
{
	$url = ecsges_field($name, '');
	return $url ? $url : ecsges_img($default_file);
}

/**
 * Menu điều hướng: ưu tiên WP menu (vị trí 'primary'), fallback về NAV_ITEMS tĩnh.
 *
 * @return array[] Mỗi mục: array( 'label' => ..., 'href' => ... ).
 */
function ecsges_get_nav()
{
	$items = array();
	// Ưu tiên vị trí 'primary' nếu đã gán; nếu chưa gán mà admin đã tạo menu thì
	// dùng menu đó. Chỉ hardcode khi HOÀN TOÀN chưa có menu nào.
	$menu_id = 0;
	$locations = get_nav_menu_locations();
	if (!empty($locations['primary'])) {
		$menu_id = (int) $locations['primary'];
	} else {
		// Chưa gán vị trí: chọn menu ĐÚNG NGÔN NGỮ đang xem. Polylang gán ngôn ngữ
		// cho từng menu (taxonomy 'term_language'); menu chưa gán ngôn ngữ dùng chung.
		// Không lọc theo ngôn ngữ ở đây thì bản /en/ sẽ hiện menu tiếng Việt.
		$menus = wp_get_nav_menus();
		$cur   = function_exists('pll_current_language') ? pll_current_language('slug') : '';
		if ($cur && function_exists('pll_get_term_language')) {
			foreach ($menus as $m) {
				if (pll_get_term_language((int) $m->term_id) === $cur) {
					$menu_id = (int) $m->term_id;
					break;
				}
			}
		}
		if (!$menu_id && !empty($menus)) {
			$menu_id = (int) $menus[0]->term_id;
		}
	}
	if ($menu_id) {
		$menu_items = wp_get_nav_menu_items($menu_id);
		if ($menu_items) {
			$by_id = array();
			// Lượt 1: mục cha, giữ nguyên thứ tự menu_order.
			foreach ($menu_items as $mi) {
				if ((int) $mi->menu_item_parent !== 0) {
					continue;
				}
				$by_id[(int) $mi->ID] = array(
					'label' => $mi->title,
					'href' => ecsges_menu_item_url($mi),
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
					'href' => ecsges_menu_item_url($mi),
				);
			}
			$items = array_values($by_id);
		}
	}
	if (!$items) {
		// Fallback tĩnh: href là đường dẫn tương đối → đổi sang bản dịch nếu có.
		$items = ecsges_nav_items();
		foreach ($items as &$it) {
			if (isset($it['href'])) {
				$it['href'] = ecsges_translate_path($it['href']);
			}
			if (!empty($it['children'])) {
				foreach ($it['children'] as &$ch) {
					if (isset($ch['href'])) {
						$ch['href'] = ecsges_translate_path($ch['href']);
					}
				}
				unset($ch);
			}
		}
		unset($it);
	}
	return ecsges_tr_deep($items);
}

/**
 * URL của 1 menu item theo ngôn ngữ hiện tại (Polylang).
 *
 * Dùng object_id/type của chính menu item (chính xác hơn so khớp chuỗi URL).
 * Chưa có bản dịch → giữ URL gốc: link vẫn chạy (hiển thị bản gốc) thay vì 404.
 *
 * @param WP_Post $mi Menu item (nav_menu_item).
 * @return string
 */
function ecsges_menu_item_url($mi)
{
	$url = $mi->url;
	if (!function_exists('pll_current_language')) {
		return $url;
	}
	$lang = pll_current_language('slug');
	$oid  = (int) $mi->object_id;
	if (!$lang || !$oid) {
		return $url;
	}
	if ('post_type' === $mi->type && function_exists('pll_get_post')) {
		$tr = pll_get_post($oid, $lang);
		if ($tr && 'publish' === get_post_status($tr)) {
			return get_permalink($tr);
		}
		return $url;
	}
	if ('taxonomy' === $mi->type && function_exists('pll_get_term')) {
		$tr = pll_get_term($oid, $lang);
		if ($tr) {
			$link = get_term_link((int) $tr);
			if (!is_wp_error($link)) {
				return $link;
			}
		}
		return $url;
	}
	return $url;
}

/**
 * Đổi 1 đường dẫn tĩnh (vd '/ve-ecs#tam-nhin') sang bản dịch của ngôn ngữ hiện
 * tại. Neo (#...) được giữ nguyên. Không tra được → trả nguyên đường dẫn.
 *
 * @param string $path
 * @return string
 */
function ecsges_translate_path($path)
{
	if (!is_string($path) || '' === $path || '#' === $path[0] || preg_match('#^https?://#i', $path)) {
		return $path;
	}
	$hash  = '';
	$clean = $path;
	if (false !== ($p = strpos($clean, '#'))) {
		$hash  = substr($clean, $p);
		$clean = substr($clean, 0, $p);
	}
	$slug = trim($clean, '/');
	if ('' === $slug || false !== strpos($slug, '/')) {
		return $path; // category/... hoặc đường dẫn nhiều cấp: để nguyên.
	}
	// Tra theo slug, không hardcode ID: mỗi site (local/production) có ID khác nhau.
	$page = get_page_by_path($slug);
	if (!$page) {
		return $path;
	}
	$id = (int) $page->ID;
	if (function_exists('pll_get_post') && function_exists('pll_current_language')) {
		$tr = pll_get_post($id, pll_current_language('slug'));
		if ($tr && 'publish' === get_post_status($tr)) {
			$id = (int) $tr;
		}
	}
	return get_permalink($id) . $hash;
}

/**
 * Danh sách ngôn ngữ (Polylang). Trả mảng chuẩn hoá để template lặp; nếu chưa
 * có Polylang thì fallback tĩnh VI/EN (để dropdown vẫn hiển thị).
 *
 * @return array[] Mỗi mục: slug, name, url, current_lang (bool), flag (HTML|'').
 */
function ecsges_languages()
{
	if (function_exists('pll_the_languages')) {
		$list = pll_the_languages(array('raw' => 1, 'hide_if_empty' => 0));
		if (is_array($list) && $list) {
			return $list;
		}
	}
	return array(
		array('slug' => 'vi', 'name' => 'Tiếng Việt', 'url' => home_url('/'), 'current_lang' => true, 'flag' => ''),
		array('slug' => 'en', 'name' => 'English', 'url' => '#', 'current_lang' => false, 'flag' => ''),
	);
}

/**
 * Trang bản dịch (Polylang) tự dùng template của bản gốc.
 *
 * Bản dịch do Polylang tạo thường có slug khác bản gốc (vd 've-ecs' → '66-2'),
 * nên page-{slug}.php không khớp. Theme lại KHÔNG có page.php, vì vậy WP rơi
 * xuống index.php và trang hiện ra trắng trơn (chỉ header + footer). Ở đây khi
 * đã rơi xuống fallback cuối, ta tra sang bản dịch cùng nhóm để lấy template
 * của nó. Template gán tay trong Page Attributes vẫn được ưu tiên tuyệt đối
 * (WP xử lý trước, template_include không còn là index.php).
 *
 * @param string $template Đường dẫn template WP đã chọn.
 * @return string
 */
function ecsges_translated_page_template($template)
{
	if (!is_page() || !function_exists('pll_get_post_translations')) {
		return $template;
	}
	// Chỉ can thiệp khi WP đã hết ứng viên cụ thể (theme không có page.php).
	if ('index.php' !== basename($template)) {
		return $template;
	}
	$id = (int) get_queried_object_id();
	if (!$id) {
		return $template;
	}
	foreach (pll_get_post_translations($id) as $src_id) {
		$src_id = (int) $src_id;
		if ($src_id === $id || 'publish' !== get_post_status($src_id)) {
			continue;
		}
		// a) Template bản gốc chọn tay.
		$slug  = get_page_template_slug($src_id);
		$found = $slug ? locate_template($slug) : '';
		if ($found) {
			return $found;
		}
		// b) page-{slug}.php theo slug bản gốc.
		$found = locate_template('page-' . get_post_field('post_name', $src_id) . '.php');
		if ($found) {
			return $found;
		}
	}
	return $template;
}
add_filter('template_include', 'ecsges_translated_page_template');

/* ------------------------------------------------------------------ *\
 * Tìm kiếm — mở rộng sang TÊN CHUYÊN MỤC + khớp cả NFC/NFD tiếng Việt
\* ------------------------------------------------------------------ */

/**
 * Chuẩn hoá chuỗi tiếng Việt để SO SÁNH: về NFC + chữ thường.
 *
 * Dữ liệu site này lưu lẫn nhiều dạng Unicode cho cùng một chữ: post_title dùng
 * NFC ("ứ" = E1BBA9) còn tên chuyên mục dùng dạng nửa phân rã ("ư" U+01B0 +
 * dấu sắc rời = C6B0 CC81). Chúng hiển thị y hệt nhau nhưng KHÁC BYTE, nên LIKE
 * của MySQL không khớp — đó là lý do gõ "tin tức" ra 0 kết quả. Vì vậy việc so
 * khớp tên chuyên mục được làm ở tầng PHP sau khi chuẩn hoá, thay vì đoán từng
 * biến thể byte để đưa vào SQL.
 *
 * @param string $s
 * @return string
 */
function ecsges_normalize_nfc($s)
{
	$s = (string) $s;
	if (! class_exists('Normalizer')) {
		return $s; // Thiếu ext intl — trả nguyên trạng, tìm kiếm vẫn chạy kiểu cũ.
	}
	$n = Normalizer::normalize($s, Normalizer::FORM_C);
	return (is_string($n) && '' !== $n) ? $n : $s;
}

function ecsges_normalize_for_compare($s)
{
	$s = ecsges_normalize_nfc($s);
	return function_exists('mb_strtolower') ? mb_strtolower($s, 'UTF-8') : strtolower($s);
}

/**
 * Chuẩn hoá TỪ KHOÁ về NFC trước khi WP dựng SQL.
 *
 * Bộ gõ tiếng Việt trên Windows (Unikey) sinh dạng NỬA PHÂN RÃ: "ễ" gõ ra là
 * "ê" U+00EA + dấu ngã rời U+0303, trong khi post_title lưu NFC "ễ" U+1EC5.
 * WP dựng "post_title LIKE '%<từ khoá>%'" với đúng bytes nhận từ request, mà
 * LIKE so byte nên hai dạng này KHÔNG khớp nhau — gõ "lễ ký" ra 0 kết quả dù
 * bài "Lễ ký kết hợp tác ECS GLOBAL..." đang nằm ngay đó.
 *
 * Sửa ở pre_get_posts (trước lúc dựng SQL) thay vì vá mệnh đề search: query var
 * 's' sau khi đổi cũng là cái get_search_query() in ra, nên tiêu đề trang kết
 * quả và ô nhập trong form đều đã ở dạng NFC — bấm tìm lại không tái phát.
 *
 * @param WP_Query $query
 * @return void
 */
function ecsges_search_normalize_s($query)
{
	if (is_admin() || ! $query->is_search()) {
		return;
	}

	$s = $query->get('s');
	if (! is_string($s) || '' === $s) {
		return;
	}

	$nfc = ecsges_normalize_nfc($s);
	if ($nfc !== $s) {
		$query->set('s', $nfc);
	}
}
add_action('pre_get_posts', 'ecsges_search_normalize_s');

/**
 * ID các bài thuộc chuyên mục / thẻ có TÊN chứa từ khoá (so khớp đã chuẩn hoá).
 *
 * @param string $s Từ khoá.
 * @return int[]
 */
function ecsges_post_ids_by_term_name($s)
{
	$needle = ecsges_normalize_for_compare(trim($s));
	if ('' === $needle) {
		return array();
	}

	$terms = get_terms(
		array(
			'taxonomy'   => array('category', 'post_tag'),
			'hide_empty' => true,
		)
	);
	if (is_wp_error($terms) || empty($terms)) {
		return array();
	}

	// Khớp theo term_taxonomy_id để dùng chung cho cả category lẫn post_tag.
	$tt_ids = array();
	foreach ($terms as $term) {
		if (false !== strpos(ecsges_normalize_for_compare($term->name), $needle)) {
			$tt_ids[] = (int) $term->term_taxonomy_id;
		}
	}
	if (empty($tt_ids)) {
		return array();
	}

	global $wpdb;
	$in  = implode(',', array_map('absint', $tt_ids));
	$ids = $wpdb->get_col(
		"SELECT DISTINCT object_id FROM {$wpdb->term_relationships} WHERE term_taxonomy_id IN ({$in})"
	);

	return array_map('intval', (array) $ids);
}

/**
 * ID các bài/trang có TIÊU ĐỀ lưu ở dạng phân rã mà chuẩn hoá rồi thì chứa từ khoá.
 *
 * Chuẩn hoá từ khoá về NFC (xem ecsges_search_normalize_s) chỉ chữa được chiều
 * "gõ phân rã, dữ liệu NFC". Site này còn dính chiều ngược lại: vài tiêu đề
 * được nhập bằng bộ gõ sinh dạng nửa phân rã — "Tuyển Dụng" lưu là
 * 79 C3AA CC89 ("y" + "ê" + dấu hỏi rời) — nên LIKE với từ khoá NFC bỏ sót
 * đúng những dòng đó.
 *
 * Lọc trước ở SQL cho những dòng CÓ dấu tổ hợp (U+0300–U+036F = byte CC 80–BF
 * hoặc CD 80–AF) rồi mới so ở PHP: dấu tổ hợp là ngoại lệ hiếm, nên số dòng
 * phải nạp về luôn nhỏ bất kể site to cỡ nào — phần còn lại đã do LIKE lo.
 *
 * @param string $s Từ khoá.
 * @return int[]
 */
function ecsges_post_ids_by_decomposed_title($s)
{
	$needle = ecsges_normalize_for_compare(trim($s));
	if ('' === $needle) {
		return array();
	}

	global $wpdb;
	$rows = $wpdb->get_results(
		"SELECT ID, post_title FROM {$wpdb->posts}
		 WHERE post_status = 'publish'
		   AND HEX(post_title) REGEXP 'CC[89AB]|CD[89A]'"
	);
	if (empty($rows)) {
		return array();
	}

	$ids = array();
	foreach ($rows as $row) {
		if (false !== strpos(ecsges_normalize_for_compare($row->post_title), $needle)) {
			$ids[] = (int) $row->ID;
		}
	}

	return $ids;
}

/**
 * Mở rộng mệnh đề search của query chính: khớp thêm bài thuộc CHUYÊN MỤC / THẺ
 * có tên chứa từ khoá (WP mặc định chỉ tìm title/excerpt/content). Danh sách ID
 * do ecsges_post_ids_by_term_name() tính sẵn ở tầng PHP nên không lệ thuộc dạng
 * Unicode mà DB đang lưu.
 *
 * Chèn bằng "ID IN (...)" nên không nhân bản dòng (khỏi cần DISTINCT), và chỉ
 * đụng vào ĐÚNG nhóm search — phần post_password cùng các điều kiện khác (bộ lọc
 * ngôn ngữ của Polylang nằm ở posts_where) giữ nguyên.
 *
 * @param string   $search Mệnh đề search do WP dựng.
 * @param WP_Query $query
 * @return string
 */
function ecsges_search_include_terms($search, $query)
{
	if (is_admin() || ! $query->is_main_query() || ! $query->is_search() || '' === $search) {
		return $search;
	}

	$s = trim((string) $query->get('s'));
	if ('' === $s) {
		return $search;
	}

	global $wpdb;

	// WP bọc: " AND (<điều kiện search>) " và có thể nối thêm
	// " AND (post_password = '') " cho khách. Tách phần đuôi đó ra để chỉ
	// chỉnh sửa nhóm search, rồi ghép lại nguyên trạng.
	$tail   = '';
	$marker = " AND ({$wpdb->posts}.post_password";
	$pos    = strpos($search, $marker);
	if (false !== $pos) {
		$tail   = substr($search, $pos);
		$search = substr($search, 0, $pos);
	}

	$head = rtrim($search);
	if ('' === $head || ')' !== substr($head, -1)) {
		return $search . $tail; // Dạng lạ — không đụng vào.
	}

	$ids = array_unique(
		array_merge(
			ecsges_post_ids_by_term_name($s),
			ecsges_post_ids_by_decomposed_title($s)
		)
	);
	if (empty($ids)) {
		return $search . $tail;
	}

	$in = implode(',', array_map('absint', $ids));

	// Bỏ ')' đóng của nhóm search, chèn thêm nhánh OR, đóng lại.
	$head = substr($head, 0, -1) . " OR {$wpdb->posts}.ID IN ({$in}))";

	return $head . ' ' . $tail;
}
add_filter('posts_search', 'ecsges_search_include_terms', 10, 2);
