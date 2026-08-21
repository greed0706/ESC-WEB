<?php
/**
 * Template Name: Tin tức
 * Trang "Tin tức". Gán tự động cho Page slug 'tin-tuc' (nhờ tên file
 * page-tin-tuc.php) hoặc chọn template.
 *
 * Bố cục (theo Figma node 746:1184):
 *   1. page-hero (variant banner) — ảnh 1920x681, chữ "TIN TỨC" bake sẵn.
 *   2. tin-tuc-tabs — 6 tab chữ gạch chân, LỌC BẰNG JS (không round-trip).
 *   3. tin-tuc-grid — query TẤT CẢ bài 1 lần, lưới card 3 cột (9 bài/trang) +
 *      phân trang tròn; tab ở (2) chỉ ẩn/hiện <li> đã có sẵn trong DOM, xem
 *      initNewsTabsGrid() trong assets/js/main.js.
 *
 * Nội dung là BÀI VIẾT WP THẬT (WP_Query trong tin-tuc-grid.php), không còn
 * hardcode trong inc/data.php. `category.php` giữ nguyên cho các link chuyên
 * mục khác trên site — trang này không điều hướng sang đó.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
	<main class="ecs-newsroom">
		<?php
		get_template_part(
			'template-parts/page',
			'hero',
			array(
				'title'   => 'TIN TỨC VỀ ECS',
				'id'      => 'tin-tuc-hero',
				'bg'      => 'banner-page.png',
				'variant' => 'banner',
				'banner_title' => true,
			)
		);
		// Breadcrumb đặt NGAY SAU banner (không đặt trên): banner là phần mở đầu
		// của trang, chèn dải xám lên trên sẽ cắt ngang hero.
		ecsges_breadcrumb();

		get_template_part( 'template-parts/tin-tuc', 'tabs' );
		get_template_part( 'template-parts/tin-tuc', 'grid' );
		?>
	</main>
<?php
get_footer();
