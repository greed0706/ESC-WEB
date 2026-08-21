<?php
/**
 * THEME OPTIONS — trang cấu hình riêng trong admin.
 *
 * Vì sao không dùng ACF: site chạy ACF Free, không có Options Page và không
 * có Repeater. Hai thứ cần ở đây (danh sách slide, danh sách link footer) đều
 * là dữ liệu LẶP và thuộc về TOÀN SITE chứ không thuộc Trang chủ, nên dựng
 * bằng Settings API thuần của WordPress.
 *
 * Menu:
 *   Theme Options
 *     ├─ Hero Slider      → option 'ecsges_hero_slider'
 *     └─ Footer Settings  → option 'ecsges_footer_cols'
 *
 * Ảnh lưu bằng ID đính kèm (không lưu URL) để đổi domain / chuyển site không
 * chết ảnh; lúc render mới đổi ID → URL.
 *
 * Option trống → lùi về mặc định tĩnh trong inc/data.php
 * (ecsges_hero_slider_defaults / ecsges_footer_columns) nên trang không bao
 * giờ trắng, giống cơ chế ecsges_field() bên ACF.
 *
 * @package ECSGES
 */

if (!defined('ABSPATH')) {
	exit;
}

define('ECSGES_OPT_HERO', 'ecsges_hero_slider');
define('ECSGES_OPT_FOOTER', 'ecsges_footer_cols');

/* ------------------------------------------------------------------ *\
 * ĐỌC — helper dùng ở frontend
\* ------------------------------------------------------------------ */

/**
 * Cấu hình hero slider đã resolve sẵn cho template.
 *
 * Mỗi slide trả về: url (desktop), mobile (chuỗi rỗng nếu không đặt riêng),
 * link (đã ánh xạ ngôn ngữ), alt (đã dịch). Không có slide hợp lệ nào →
 * dựng 1 slide từ ảnh tĩnh hero-banner.jpg.
 *
 * @return array
 */
function ecsges_hero_slider()
{
	$conf = ecsges_hero_slider_defaults();
	$saved = get_option(ECSGES_OPT_HERO, array());
	if (is_array($saved)) {
		$conf = array_merge($conf, $saved);
	}

	$slides = array();
	foreach ((array) $conf['slides'] as $slide) {
		if (!is_array($slide)) {
			continue;
		}
		$desktop = empty($slide['image']) ? '' : wp_get_attachment_image_url((int) $slide['image'], 'full');
		$mobile = empty($slide['image_mobile']) ? '' : wp_get_attachment_image_url((int) $slide['image_mobile'], 'full');
		// Ảnh bị xoá khỏi Media Library → URL false; bỏ qua slide rỗng hẳn.
		if (!$desktop && !$mobile) {
			continue;
		}
		if (!$desktop) {
			$desktop = $mobile;
			$mobile = '';
		}
		$link = isset($slide['link']) ? trim((string) $slide['link']) : '';
		$slides[] = array(
			'url' => $desktop,
			'mobile' => $mobile ? $mobile : '',
			'link' => $link ? ecsges_translate_path($link) : '',
			'alt' => ecsges_t(isset($slide['alt']) ? (string) $slide['alt'] : ''),
		);
	}

	if (!$slides) {
		$slides[] = array(
			'url' => ecsges_img('hero-banner.jpg'),
			'mobile' => '',
			'link' => '',
			'alt' => '',
		);
	}

	$conf['slides'] = $slides;
	$conf['autoplay'] = !empty($conf['autoplay']);
	$conf['dots'] = !empty($conf['dots']);
	$conf['nav'] = !empty($conf['nav']);
	$conf['interval'] = (int) $conf['interval'];
	$conf['speed'] = (int) $conf['speed'];
	return $conf;
}

/**
 * Các cột link footer đã resolve sẵn cho template.
 *
 * Ưu tiên Theme Options; trống thì lùi về ecsges_footer_columns() tĩnh.
 * Nhãn/tiêu đề chạy qua từ điển ecsges_t() (bản EN), URL giữ nguyên nhưng
 * đường dẫn 1 cấp được ánh xạ sang Page cùng ngôn ngữ.
 *
 * @return array[] Mỗi cột: array( 'title' => ..., 'links' => array( array('label','url') ) ).
 */
function ecsges_footer_links()
{
	$saved = get_option(ECSGES_OPT_FOOTER, array());
	$cols = array();

	if (is_array($saved) && $saved) {
		foreach ($saved as $col) {
			if (!is_array($col)) {
				continue;
			}
			$links = array();
			foreach ((array) (isset($col['links']) ? $col['links'] : array()) as $link) {
				if (!is_array($link) || empty($link['label'])) {
					continue;
				}
				$url = isset($link['url']) ? trim((string) $link['url']) : '';
				$links[] = array(
					'label' => ecsges_t((string) $link['label']),
					'url' => $url ? ecsges_translate_path($url) : '#',
				);
			}
			$cols[] = array(
				'title' => ecsges_t(isset($col['title']) ? (string) $col['title'] : ''),
				'links' => $links,
			);
		}
		return $cols;
	}

	foreach (ecsges_footer_columns() as $col) {
		$links = array();
		foreach ($col['links'] as $link) {
			$links[] = array(
				'label' => ecsges_t($link['label']),
				'url' => ecsges_footer_static_url($link),
			);
		}
		$cols[] = array(
			'title' => ecsges_t($col['title']),
			'links' => $links,
		);
	}
	return $cols;
}

/**
 * Đích của 1 link footer tĩnh: 'cat' → link archive chuyên mục thật,
 * 'url' → đường dẫn tĩnh đã ánh xạ ngôn ngữ. Không khai gì → '#'.
 *
 * @param array $link
 * @return string
 */
function ecsges_footer_static_url($link)
{
	if (!empty($link['cat'])) {
		return ecsges_category_link($link['cat'], '#');
	}
	if (!empty($link['url'])) {
		return ecsges_translate_path($link['url']);
	}
	return '#';
}

/**
 * Link 3 trang pháp lý ở thanh cuối footer.
 *
 * BỎ QUA trang chưa tồn tại / chưa publish thay vì in link chết — theme không
 * tạo được Page, nội dung nằm trong DB. Nếu thanh cuối footer trống link thì
 * nguyên nhân là chưa tạo Page với đúng slug trong ecsges_footer_legal_pages(),
 * KHÔNG phải lỗi CSS.
 *
 * Nhãn chạy qua ecsges_t() và URL qua pll_get_post() để bản EN trỏ đúng bản dịch.
 *
 * @return array[] Mỗi mục: label, url.
 */
function ecsges_footer_legal_links()
{
	$out = array();
	foreach (ecsges_footer_legal_pages() as $item) {
		$page = get_page_by_path($item['slug']);
		if (!$page || 'publish' !== get_post_status($page)) {
			continue;
		}
		$id = (int) $page->ID;
		if (function_exists('pll_get_post') && function_exists('pll_current_language')) {
			$tr = pll_get_post($id, pll_current_language('slug'));
			if ($tr && 'publish' === get_post_status($tr)) {
				$id = (int) $tr;
			}
		}
		$out[] = array(
			'label' => ecsges_t($item['label']),
			'url' => get_permalink($id),
		);
	}
	return $out;
}

/* ------------------------------------------------------------------ *\
 * SEED — đổ sẵn dữ liệu đang dùng vào form ở lần mở đầu tiên
\* ------------------------------------------------------------------ */

/**
 * Giá trị hiển thị trong form Hero Slider.
 *
 * Chưa lưu lần nào → dựng 1 slide từ ảnh ACF 'hero_banner' cũ (nếu client đã
 * chọn) để không mất dữ liệu khi field ACF đó bị gỡ. Không có gì thì trả về
 * danh sách slide rỗng — frontend tự dùng hero-banner.jpg.
 *
 * @return array
 */
function ecsges_hero_slider_form_values()
{
	$saved = get_option(ECSGES_OPT_HERO, false);
	if (is_array($saved)) {
		return array_merge(ecsges_hero_slider_defaults(), $saved);
	}

	$conf = ecsges_hero_slider_defaults();
	$legacy = ecsges_legacy_acf_value('hero_banner');
	if (is_array($legacy)) {
		$legacy = isset($legacy['url']) ? $legacy['url'] : '';
	}
	if ($legacy) {
		$id = (int) attachment_url_to_postid((string) $legacy);
		if ($id) {
			$conf['slides'][] = array(
				'image' => $id,
				'image_mobile' => 0,
				'link' => '',
				'alt' => '',
			);
		}
	}
	return $conf;
}

/**
 * Giá trị hiển thị trong form Footer Settings.
 *
 * Chưa lưu lần nào → dựng từ mặc định tĩnh, nhưng NHÃN thì ưu tiên giá trị
 * client đã nhập ở các field ACF cũ (footer_col{n}_links, mỗi dòng 1 mục).
 * URL ghép theo VỊ TRÍ DÒNG — đúng bằng cách footer.php cũ vẫn ghép, nên
 * kết quả đổ ra khớp với những gì đang hiển thị trên site.
 *
 * @return array[]
 */
function ecsges_footer_cols_form_values()
{
	$saved = get_option(ECSGES_OPT_FOOTER, false);
	if (is_array($saved) && $saved) {
		return $saved;
	}

	$cols = array();
	foreach (ecsges_footer_columns() as $i => $col) {
		$n = $i + 1;

		$labels = array();
		$legacy_labels = ecsges_legacy_acf_value("footer_col{$n}_links");
		if (is_string($legacy_labels) && '' !== trim($legacy_labels)) {
			foreach (preg_split('/\R/u', $legacy_labels) as $line) {
				$line = trim($line);
				if ('' !== $line) {
					$labels[] = $line;
				}
			}
		}
		if (!$labels) {
			foreach ($col['links'] as $link) {
				$labels[] = $link['label'];
			}
		}

		$links = array();
		foreach ($labels as $li => $label) {
			$links[] = array(
				'label' => $label,
				'url' => isset($col['links'][$li]) ? ecsges_footer_seed_url($col['links'][$li]) : '',
			);
		}

		$legacy_title = ecsges_legacy_acf_value("footer_col{$n}_title");
		$cols[] = array(
			'title' => (is_string($legacy_title) && '' !== trim($legacy_title)) ? $legacy_title : $col['title'],
			'links' => $links,
		);
	}
	return $cols;
}

/**
 * Đường dẫn đổ sẵn vào ô URL cho 1 link footer tĩnh.
 *
 * KHÁC ecsges_footer_static_url() ở chỗ KHÔNG chạy ecsges_translate_path():
 * ô này là giá trị sẽ được LƯU LẠI, nên phải giữ đường dẫn gốc trung tính
 * ('/ve-ecs#tam-nhin') để lúc render mới ánh xạ sang Page cùng ngôn ngữ. Nếu
 * đổ vào đường dẫn đã ánh xạ ('/en/ve-ecs/#…') thì kể từ lần lưu đầu tiên,
 * người xem bản tiếng Việt sẽ bị đá sang bản tiếng Anh.
 *
 * Link chuyên mục không có dạng gốc để giữ nên đổ URL archive thật, rút về
 * dạng tương đối cho khỏi dính domain.
 *
 * @param array $link
 * @return string '' nếu không có đích.
 */
function ecsges_footer_seed_url($link)
{
	if (!empty($link['url'])) {
		return (string) $link['url'];
	}
	if (!empty($link['cat'])) {
		$url = ecsges_category_link($link['cat'], '');
		return $url ? wp_make_link_relative($url) : '';
	}
	return '';
}

/**
 * Đọc thô 1 ACF field trên Trang chủ (KHÔNG qua từ điển ecsges_t) — chỉ dùng
 * để seed form. Khác ecsges_field() vì ở admin ta cần đúng giá trị client đã
 * nhập, chưa dịch.
 *
 * @param string $name
 * @return mixed '' nếu ACF tắt / field trống.
 */
function ecsges_legacy_acf_value($name)
{
	if (!function_exists('get_field')) {
		return '';
	}
	$id = ecsges_home_id();
	if (!$id) {
		return '';
	}
	$value = get_field($name, $id);
	return (null === $value || false === $value) ? '' : $value;
}

/* ------------------------------------------------------------------ *\
 * ĐĂNG KÝ MENU + SETTING
\* ------------------------------------------------------------------ */

/**
 * Danh sách hook suffix của các trang Theme Options (để enqueue asset đúng chỗ).
 *
 * @param string|null $add
 * @return string[]
 */
function ecsges_options_hooks($add = null)
{
	static $hooks = array();
	if ($add) {
		$hooks[] = $add;
	}
	return $hooks;
}

/** Menu "Theme Options" + 2 trang con. */
function ecsges_options_menu()
{
	// add_menu_page tự sinh 1 submenu trùng tên menu cha; add_submenu_page
	// cùng slug ngay sau đó ghi đè nhãn của nó thành "Hero Slider".
	$hook = add_menu_page(
		'Theme Options',
		'Theme Options',
		'manage_options',
		'ecsges-hero-slider',
		'ecsges_options_page_hero',
		'dashicons-admin-generic',
		59
	);
	ecsges_options_hooks($hook);

	ecsges_options_hooks(
		add_submenu_page(
			'ecsges-hero-slider',
			'Hero Slider',
			'Hero Slider',
			'manage_options',
			'ecsges-hero-slider',
			'ecsges_options_page_hero'
		)
	);

	ecsges_options_hooks(
		add_submenu_page(
			'ecsges-hero-slider',
			'Footer Settings',
			'Footer Settings',
			'manage_options',
			'ecsges-footer-settings',
			'ecsges_options_page_footer'
		)
	);
}
add_action('admin_menu', 'ecsges_options_menu');

/** Đăng ký 2 option (mỗi trang 1 settings group riêng). */
function ecsges_options_register()
{
	register_setting(
		'ecsges_hero_slider_group',
		ECSGES_OPT_HERO,
		array(
			'type' => 'array',
			'sanitize_callback' => 'ecsges_hero_slider_sanitize',
			'default' => array(),
		)
	);
	register_setting(
		'ecsges_footer_cols_group',
		ECSGES_OPT_FOOTER,
		array(
			'type' => 'array',
			'sanitize_callback' => 'ecsges_footer_cols_sanitize',
			'default' => array(),
		)
	);
}
add_action('admin_init', 'ecsges_options_register');

/**
 * Làm sạch dữ liệu Hero Slider trước khi lưu.
 *
 * Hàng bị xoá để lại lỗ chỉ số trong POST → dồn lại bằng cách append. Slide
 * không có ảnh nào bị loại luôn, nên client xoá ảnh cũng đồng nghĩa xoá slide.
 *
 * @param mixed $raw
 * @return array
 */
function ecsges_hero_slider_sanitize($raw)
{
	$def = ecsges_hero_slider_defaults();
	if (!is_array($raw)) {
		$raw = array();
	}

	$out = array(
		'autoplay' => empty($raw['autoplay']) ? 0 : 1,
		'dots' => empty($raw['dots']) ? 0 : 1,
		'nav' => empty($raw['nav']) ? 0 : 1,
		'interval' => isset($raw['interval']) ? absint($raw['interval']) : $def['interval'],
		'speed' => isset($raw['speed']) ? absint($raw['speed']) : $def['speed'],
		'slides' => array(),
	);
	// Chặn giá trị vô lý (0ms = chớp liên tục, 60s = như đứng im).
	$out['interval'] = max(1000, min(60000, $out['interval']));
	$out['speed'] = max(0, min(5000, $out['speed']));

	$slides = (isset($raw['slides']) && is_array($raw['slides'])) ? $raw['slides'] : array();
	foreach ($slides as $slide) {
		if (!is_array($slide)) {
			continue;
		}
		$image = isset($slide['image']) ? absint($slide['image']) : 0;
		$mobile = isset($slide['image_mobile']) ? absint($slide['image_mobile']) : 0;
		if (!$image && !$mobile) {
			continue;
		}
		$out['slides'][] = array(
			'image' => $image,
			'image_mobile' => $mobile,
			'link' => isset($slide['link']) ? esc_url_raw(trim((string) $slide['link'])) : '',
			'alt' => isset($slide['alt']) ? sanitize_text_field($slide['alt']) : '',
		);
	}

	return $out;
}

/**
 * Làm sạch dữ liệu Footer Settings trước khi lưu.
 *
 * Link không có nhãn bị loại (nhãn mới là thứ hiển thị); cột không còn tiêu
 * đề lẫn link nào cũng bị loại.
 *
 * @param mixed $raw
 * @return array[]
 */
function ecsges_footer_cols_sanitize($raw)
{
	$out = array();
	$cols = (is_array($raw) && isset($raw['cols']) && is_array($raw['cols'])) ? $raw['cols'] : array();

	foreach ($cols as $col) {
		if (!is_array($col)) {
			continue;
		}
		$title = isset($col['title']) ? sanitize_text_field($col['title']) : '';

		$links = array();
		$rows = (isset($col['links']) && is_array($col['links'])) ? $col['links'] : array();
		foreach ($rows as $row) {
			if (!is_array($row)) {
				continue;
			}
			$label = isset($row['label']) ? sanitize_text_field($row['label']) : '';
			if ('' === $label) {
				continue;
			}
			$links[] = array(
				'label' => $label,
				'url' => isset($row['url']) ? esc_url_raw(trim((string) $row['url'])) : '',
			);
		}

		if ('' === $title && !$links) {
			continue;
		}
		$out[] = array(
			'title' => $title,
			'links' => $links,
		);
	}

	return $out;
}

/**
 * CSS/JS cho 2 trang Theme Options.
 *
 * Chỉ nạp đúng 2 hook của mình — không đụng phần còn lại của admin. Kéo sắp
 * xếp dùng jquery-ui-sortable có sẵn trong admin (frontend KHÔNG hề thêm jQuery).
 *
 * @param string $hook
 */
function ecsges_options_assets($hook)
{
	if (!in_array($hook, ecsges_options_hooks(), true)) {
		return;
	}
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_media();

	$css = $dir . '/assets/css/admin-options.css';
	wp_enqueue_style(
		'ecsges-admin-options',
		$uri . '/assets/css/admin-options.css',
		array(),
		file_exists($css) ? filemtime($css) : ECSGES_VERSION
	);

	$js = $dir . '/assets/js/admin-options.js';
	wp_enqueue_script(
		'ecsges-admin-options',
		$uri . '/assets/js/admin-options.js',
		array('jquery-ui-sortable'),
		file_exists($js) ? filemtime($js) : ECSGES_VERSION,
		true
	);
}
add_action('admin_enqueue_scripts', 'ecsges_options_assets');

/* ------------------------------------------------------------------ *\
 * RENDER — mảnh HTML dùng chung cho hàng có sẵn và cho <template>
\* ------------------------------------------------------------------ */

/**
 * Ô chọn ảnh (mở Media Library của WordPress).
 *
 * @param string $name  Tên input (đã gồm chỉ số).
 * @param int    $id    ID ảnh đang chọn.
 * @param string $label Nhãn hiển thị.
 * @param string $hint  Ghi chú nhỏ dưới nhãn.
 */
function ecsges_options_media_field($name, $id, $label, $hint = '')
{
	$id = (int) $id;
	$url = $id ? wp_get_attachment_image_url($id, 'medium') : '';
	?>
	<div class="ecsges-media" data-media>
		<span class="ecsges-field__label"><?php echo esc_html($label); ?></span>
		<?php if ($hint) : ?>
			<span class="ecsges-field__hint"><?php echo esc_html($hint); ?></span>
		<?php endif; ?>
		<div class="ecsges-media__preview<?php echo $url ? '' : ' is-empty'; ?>" data-media-preview>
			<?php if ($url) : ?>
				<img src="<?php echo esc_url($url); ?>" alt="">
			<?php endif; ?>
		</div>
		<input type="hidden" name="<?php echo esc_attr($name); ?>" value="<?php echo $id ? esc_attr($id) : ''; ?>" data-media-input>
		<p class="ecsges-media__actions">
			<button type="button" class="button button-small" data-media-pick><?php echo $url ? 'Đổi ảnh' : 'Chọn ảnh'; ?></button>
			<button type="button" class="button-link ecsges-media__clear<?php echo $url ? '' : ' is-hidden'; ?>" data-media-clear>Bỏ ảnh</button>
		</p>
	</div>
	<?php
}

/**
 * Một hàng slide trong form Hero Slider.
 *
 * @param string $i     Chỉ số (chuỗi '__i__' khi dựng <template>).
 * @param array  $slide Giá trị đang có.
 */
function ecsges_options_hero_row($i, $slide = array())
{
	$slide = array_merge(
		array(
			'image' => 0,
			'image_mobile' => 0,
			'link' => '',
			'alt' => '',
		),
		is_array($slide) ? $slide : array()
	);
	$base = ECSGES_OPT_HERO . '[slides][' . $i . ']';
	?>
	<div class="ecsges-row" data-repeat-row>
		<div class="ecsges-row__handle" title="Kéo để sắp xếp" aria-hidden="true"></div>
		<div class="ecsges-row__body">
			<div class="ecsges-row__media">
				<?php
				ecsges_options_media_field($base . '[image]', $slide['image'], 'Ảnh desktop', '1920 × 792');
				ecsges_options_media_field($base . '[image_mobile]', $slide['image_mobile'], 'Ảnh mobile', 'Để trống = dùng ảnh desktop');
				?>
			</div>
			<div class="ecsges-row__fields">
				<label class="ecsges-field">
					<span class="ecsges-field__label">Link</span>
					<input type="text" class="regular-text" name="<?php echo esc_attr($base . '[link]'); ?>" value="<?php echo esc_attr($slide['link']); ?>" placeholder="/ve-ecs hoặc https://…">
					<span class="ecsges-field__hint">Để trống = bấm vào banner không đi đâu cả.</span>
				</label>
				<label class="ecsges-field">
					<span class="ecsges-field__label">Alt (mô tả ảnh)</span>
					<input type="text" class="regular-text" name="<?php echo esc_attr($base . '[alt]'); ?>" value="<?php echo esc_attr($slide['alt']); ?>" placeholder="Kiến tạo hệ sinh thái giáo dục toàn cầu">
					<span class="ecsges-field__hint">Dành cho SEO và trình đọc màn hình.</span>
				</label>
			</div>
		</div>
		<button type="button" class="button-link ecsges-row__remove" data-repeat-remove>Xoá slide</button>
	</div>
	<?php
}

/**
 * Một hàng link trong 1 cột footer.
 *
 * @param string $c    Chỉ số cột ('__c__' khi dựng <template> cột).
 * @param string $i    Chỉ số link ('__i__' khi dựng <template> link).
 * @param array  $link Giá trị đang có.
 */
function ecsges_options_footer_link_row($c, $i, $link = array())
{
	$link = array_merge(array('label' => '', 'url' => ''), is_array($link) ? $link : array());
	$base = ECSGES_OPT_FOOTER . '[cols][' . $c . '][links][' . $i . ']';
	?>
	<div class="ecsges-row ecsges-row--inline" data-repeat-row>
		<div class="ecsges-row__handle" title="Kéo để sắp xếp" aria-hidden="true"></div>
		<input type="text" class="ecsges-row__label" name="<?php echo esc_attr($base . '[label]'); ?>" value="<?php echo esc_attr($link['label']); ?>" placeholder="Nhãn hiển thị">
		<input type="text" class="ecsges-row__url" name="<?php echo esc_attr($base . '[url]'); ?>" value="<?php echo esc_attr($link['url']); ?>" placeholder="/ve-ecs#tam-nhin">
		<button type="button" class="button-link ecsges-row__remove" data-repeat-remove>Xoá</button>
	</div>
	<?php
}

/**
 * Một cột trong form Footer Settings.
 *
 * @param string $c   Chỉ số cột ('__c__' khi dựng <template>).
 * @param array  $col Giá trị đang có.
 */
function ecsges_options_footer_col($c, $col = array())
{
	$col = array_merge(array('title' => '', 'links' => array()), is_array($col) ? $col : array());
	$links = is_array($col['links']) ? $col['links'] : array();
	?>
	<div class="ecsges-col" data-repeat-row>
		<div class="ecsges-col__head">
			<div class="ecsges-col__handle" title="Kéo để sắp xếp cột" aria-hidden="true"></div>
			<label class="ecsges-field ecsges-field--grow">
				<span class="ecsges-field__label">Tiêu đề cột</span>
				<input type="text" class="regular-text" name="<?php echo esc_attr(ECSGES_OPT_FOOTER . '[cols][' . $c . '][title]'); ?>" value="<?php echo esc_attr($col['title']); ?>" placeholder="VỀ ECSGES">
			</label>
			<button type="button" class="button-link ecsges-col__remove" data-repeat-remove>Xoá cột</button>
		</div>

		<div class="ecsges-col__links" data-repeat data-repeat-next="<?php echo esc_attr(count($links)); ?>">
			<?php foreach ($links as $i => $link) : ?>
				<?php ecsges_options_footer_link_row($c, (string) $i, $link); ?>
			<?php endforeach; ?>
			<template data-repeat-template><?php ecsges_options_footer_link_row($c, '__i__'); ?></template>
		</div>
		<p><button type="button" class="button button-small" data-repeat-add>+ Thêm link</button></p>
	</div>
	<?php
}

/* ------------------------------------------------------------------ *\
 * RENDER — 2 trang
\* ------------------------------------------------------------------ */

/** Trang Theme Options → Hero Slider. */
function ecsges_options_page_hero()
{
	if (!current_user_can('manage_options')) {
		return;
	}
	$conf = ecsges_hero_slider_form_values();
	$slides = is_array($conf['slides']) ? $conf['slides'] : array();
	$name = ECSGES_OPT_HERO;
	?>
	<div class="wrap ecsges-options">
		<h1>Hero Slider</h1>
		<p class="description">Banner đầu trang chủ. Chưa có slide nào thì trang chủ dùng ảnh mặc định của theme.</p>

		<form method="post" action="options.php">
			<?php settings_fields('ecsges_hero_slider_group'); ?>

			<h2 class="title">Cấu hình chung</h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">Tự động chạy</th>
					<td>
						<label>
							<input type="checkbox" name="<?php echo esc_attr($name . '[autoplay]'); ?>" value="1" <?php checked(!empty($conf['autoplay'])); ?>>
							Tự chuyển slide
						</label>
						<p class="description">Người dùng bật "giảm chuyển động" trong hệ điều hành thì tự tắt.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="ecsges-interval">Thời gian mỗi slide</label></th>
					<td>
						<input type="number" id="ecsges-interval" class="small-text" name="<?php echo esc_attr($name . '[interval]'); ?>" value="<?php echo esc_attr($conf['interval']); ?>" min="1000" max="60000" step="500"> ms
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="ecsges-speed">Tốc độ chuyển</label></th>
					<td>
						<input type="number" id="ecsges-speed" class="small-text" name="<?php echo esc_attr($name . '[speed]'); ?>" value="<?php echo esc_attr($conf['speed']); ?>" min="0" max="5000" step="50"> ms
					</td>
				</tr>
				<tr>
					<th scope="row">Điều hướng</th>
					<td>
						<label>
							<input type="checkbox" name="<?php echo esc_attr($name . '[dots]'); ?>" value="1" <?php checked(!empty($conf['dots'])); ?>>
							Hiện chấm (dots)
						</label><br>
						<label>
							<input type="checkbox" name="<?php echo esc_attr($name . '[nav]'); ?>" value="1" <?php checked(!empty($conf['nav'])); ?>>
							Hiện mũi tên trước/sau
						</label>
						<p class="description">Chỉ có 1 slide thì cả hai đều tự ẩn.</p>
					</td>
				</tr>
			</table>

			<h2 class="title">Danh sách slide</h2>
			<div class="ecsges-rows" data-repeat data-repeat-next="<?php echo esc_attr(count($slides)); ?>">
				<?php foreach ($slides as $i => $slide) : ?>
					<?php ecsges_options_hero_row((string) $i, $slide); ?>
				<?php endforeach; ?>
				<template data-repeat-template><?php ecsges_options_hero_row('__i__'); ?></template>
			</div>
			<p><button type="button" class="button" data-repeat-add>+ Thêm slide</button></p>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/** Trang Theme Options → Footer Settings. */
function ecsges_options_page_footer()
{
	if (!current_user_can('manage_options')) {
		return;
	}
	$cols = ecsges_footer_cols_form_values();
	?>
	<div class="wrap ecsges-options">
		<h1>Footer Settings</h1>
		<p class="description">
			Các cột link ở chân trang. URL nhập tự do: đường dẫn nội bộ
			(<code>/ve-ecs#tam-nhin</code>) hoặc link đầy đủ (<code>https://…</code>).
			Đường dẫn nội bộ 1 cấp sẽ tự trỏ đúng bản ngôn ngữ đang xem.
		</p>

		<form method="post" action="options.php">
			<?php settings_fields('ecsges_footer_cols_group'); ?>

			<div class="ecsges-cols" data-repeat data-repeat-handle=".ecsges-col__handle" data-repeat-next="<?php echo esc_attr(count($cols)); ?>">
				<?php foreach ($cols as $c => $col) : ?>
					<?php ecsges_options_footer_col((string) $c, $col); ?>
				<?php endforeach; ?>
				<template data-repeat-template><?php ecsges_options_footer_col('__c__'); ?></template>
			</div>
			<p><button type="button" class="button" data-repeat-add>+ Thêm cột</button></p>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
