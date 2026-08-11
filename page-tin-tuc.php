<?php
/**
 * Template Name: Tin tức
 * Trang "Tin tức". Gán tự động cho Page slug 'tin-tuc' (nhờ tên file
 * page-tin-tuc.php) hoặc chọn template.
 *
 * Bố cục (theo Figma node 746:1184):
 *   1. page-hero (variant banner) — ảnh 1920x681, chữ "TIN TỨC" bake sẵn.
 *   2. tin-tuc-tabs — 6 tab chữ gạch chân, LỌC TẠI CHỖ qua ?chuyen-muc=<slug>.
 *   3. tin-tuc-grid — lưới card 3 cột (9 bài/trang) + phân trang tròn, tự lọc
 *      theo đúng chuyên mục đang chọn.
 *
 * Nội dung là BÀI VIẾT WP THẬT (WP_Query trong tin-tuc-grid.php), không còn
 * hardcode trong inc/data.php. `category.php` giữ nguyên cho các link chuyên
 * mục khác trên site — trang này không còn điều hướng sang đó nữa.
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
		// Chuyên mục đang lọc đọc từ ?chuyen-muc=<slug> (rỗng = tab "Về ECSGES",
		// tất cả tin) — dùng chung cho cả tabs (tô sáng đúng tab) và grid (lọc post).
		$ecsges_tt_active_cat = ecsges_tin_tuc_active_cat();
		get_template_part( 'template-parts/tin-tuc', 'tabs', array( 'current' => $ecsges_tt_active_cat ) );
		get_template_part( 'template-parts/tin-tuc', 'grid', array( 'current' => $ecsges_tt_active_cat ) );
		?>
	</main>
<?php
get_footer();
