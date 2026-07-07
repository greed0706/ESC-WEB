<?php
/**
 * Trang chủ — compose 6 section theo thứ tự Figma (port LandingPage.tsx).
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
		get_template_part( 'template-parts/section', 'hero' );
		get_template_part( 'template-parts/section', 'about' );
		get_template_part( 'template-parts/section', 'journey' );
		get_template_part( 'template-parts/section', 'ecosystem' );
		get_template_part( 'template-parts/section', 'news' );
		get_template_part( 'template-parts/section', 'branch' );
		?>
	</main>
<?php
get_footer();
