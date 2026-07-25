<?php
/**
 * Template Name: Đối tác
 * Trang "Đối tác". Gán tự động cho Page slug 'doi-tac' (nhờ tên file
 * page-doi-tac.php) hoặc chọn template.
 *
 * Bố cục (theo Figma node 539:372):
 *   1. page-hero (variant banner) — ảnh banner 1920x681, chữ "ĐỐI TÁC" bake sẵn.
 *   2. doi-tac-groups — 4 khối lưới logo đối tác.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
	<main>
		<?php
		get_template_part(
			'template-parts/page',
			'hero',
			array(
				'title'   => 'ĐỐI TÁC',
				'id'      => 'doi-tac-hero',
				'bg'      => 'doi-tac/banner.png',
				'variant' => 'banner',
			)
		);
		get_template_part( 'template-parts/doi-tac', 'groups' );
		?>
	</main>
<?php
get_footer();
