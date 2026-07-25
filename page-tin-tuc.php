<?php
/**
 * Template Name: Tin tức
 * Trang "Tin tức". Gán tự động cho Page slug 'tin-tuc' (nhờ tên file
 * page-tin-tuc.php) hoặc chọn template.
 *
 * Bố cục (theo Figma node 548:9518):
 *   1. page-hero (variant banner) — ảnh 1920x681, chữ "TIN TỨC" bake sẵn.
 *   2. tin-tuc-tabs      — 6 tab chủ đề, ĐIỀU HƯỚNG sang archive category thật.
 *   3. tin-tuc-featured  — khối TIN NỔI BẬT (1 bài lớn + 2 bài nhỏ).
 *   4. tin-tuc-knowledge — khối KIẾN THỨC, dải xám, 3 card/trang + phân trang JS.
 *
 * GHI CHÚ: nội dung bài viết hiện HARDCODE trong inc/data.php
 * (ecsges_news_featured / ecsges_news_knowledge). Chuyển sang bài WP thật =
 * đổi thân 2 hàm đó sang WP_Query, markup và SCSS không phải sửa.
 * `category.php` giữ nguyên — trang này KHÔNG thay thế archive category.
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
				'title'   => 'TIN TỨC',
				'id'      => 'tin-tuc-hero',
				'bg'      => 'tin-tuc/banner.png',
				'variant' => 'banner',
			)
		);
		// current = '' → tab "ECSGES" sáng (trang này là "tất cả tin").
		get_template_part( 'template-parts/tin-tuc', 'tabs', array( 'current' => '' ) );
		get_template_part( 'template-parts/tin-tuc', 'featured' );
		get_template_part( 'template-parts/tin-tuc', 'knowledge' );
		?>
	</main>
<?php
get_footer();
