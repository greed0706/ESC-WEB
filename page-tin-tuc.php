<?php
/**
 * Template Name: Tin tức
 * Trang "Tin tức". Gán tự động cho Page slug 'tin-tuc' (nhờ tên file
 * page-tin-tuc.php) hoặc chọn template.
 *
 * Bố cục (theo Figma node 746:1184):
 *   1. page-hero (variant banner) — ảnh 1920x681, chữ "TIN TỨC" bake sẵn.
 *   2. tin-tuc-tabs — 6 tab chữ gạch chân, ĐIỀU HƯỚNG sang archive category thật.
 *   3. tin-tuc-grid — lưới card 3 cột (9 bài/trang) + phân trang tròn.
 *
 * Nội dung là BÀI VIẾT WP THẬT (WP_Query trong tin-tuc-grid.php), không còn
 * hardcode trong inc/data.php. `category.php` giữ nguyên — trang này KHÔNG
 * thay thế archive category.
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
		// current = '' → tab "ECSGES" sáng (trang này là "tất cả tin").
		get_template_part( 'template-parts/tin-tuc', 'tabs', array( 'current' => '' ) );
		get_template_part( 'template-parts/tin-tuc', 'grid' );
		?>
	</main>
<?php
get_footer();
