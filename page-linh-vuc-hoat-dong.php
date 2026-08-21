<?php
/**
 * Template Name: Lĩnh vực hoạt động
 * Trang "Lĩnh vực hoạt động". Gán tự động cho Page slug 'linh-vuc-hoat-dong'
 * (nhờ tên file page-linh-vuc-hoat-dong.php) hoặc chọn template.
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
				'title'   => 'LĨNH VỰC HOẠT ĐỘNG',
				'id'      => 'linh-vuc-hero',
				'bg'      => 'banner-page.png',
				'variant' => 'banner',
				'banner_title' => true,
			)
		);
				get_template_part( 'template-parts/linh-vuc', 'sections' );
		?>
	</main>
<?php
get_footer();
