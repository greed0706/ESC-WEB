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
	$locations = get_nav_menu_locations();
	if (!empty($locations['primary'])) {
		$menu_items = wp_get_nav_menu_items($locations['primary']);
		if ($menu_items) {
			foreach ($menu_items as $mi) {
				// Bỏ qua mục con (landing nav phẳng).
				if ((int) $mi->menu_item_parent !== 0) {
					continue;
				}
				$items[] = array(
					'label' => $mi->title,
					'href' => $mi->url,
				);
			}
		}
	}
	$items = $items ? $items : ecsges_nav_items();
	// Link "Về ECS" phải trỏ tới trang ve-ecs ĐÚNG NGÔN NGỮ hiện tại (Polylang).
	foreach ($items as &$it) {
		if (isset($it['href']) && false !== strpos($it['href'], 've-ecs')) {
			$it['href'] = ecsges_ve_ecs_url();
		}
	}
	unset($it);
	return ecsges_tr_deep($items);
}

/**
 * URL trang "Về ECS" theo ngôn ngữ hiện tại (Polylang). Fallback: bản gốc.
 *
 * @return string
 */
function ecsges_ve_ecs_url()
{
	$ref = 16; // trang ve-ecs (bản tiếng Anh gốc); Polylang trả bản dịch theo ngôn ngữ.
	if (function_exists('pll_get_post') && function_exists('pll_current_language')) {
		$id = pll_get_post($ref, pll_current_language('slug'));
		if ($id) {
			return get_permalink($id);
		}
	}
	return get_permalink($ref);
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
