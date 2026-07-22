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
				'bg'      => 'linh-vuc-hoat-dong/hero-bg.png',
				'variant' => 'banner',
			)
		);
		get_template_part( 'template-parts/linh-vuc', 'tabs' );
		get_template_part( 'template-parts/section', 'news' );
		?>
	</main>
<?php
get_footer();
