<?php
/**
 * Template Name: Phát triển bền vững
 * Trang "Phát triển bền vững". Gán tự động cho Page slug 'phat-trien-ben-vung'
 * (nhờ tên file page-phat-trien-ben-vung.php) hoặc chọn template.
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
				'title'   => 'PHÁT TRIỂN BỀN VỮNG',
				'id'      => 'ptbv-hero',
				'bg'      => 'phat-trien-ben-vung/hero-bg.png',
				'variant' => 'banner',
			)
		);
		get_template_part( 'template-parts/ptbv', 'team' );
		get_template_part( 'template-parts/ptbv', 'values' );
		get_template_part( 'template-parts/ptbv', 'culture' );
		get_template_part( 'template-parts/ptbv', 'responsibility' );
		?>
	</main>
<?php
get_footer();
