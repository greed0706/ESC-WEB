<?php
/**
 * Template Name: Về ECS
 * Trang "Về ECS" (port VeEcsPage.tsx). Gán cho Page có slug 've-ecs'
 * (tự áp dụng nhờ tên file page-ve-ecs.php) hoặc chọn template "Về ECS".
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
		get_template_part( 'template-parts/ve-ecs', 'hero' );
		get_template_part( 'template-parts/ve-ecs', 'journey' );
		get_template_part( 'template-parts/ve-ecs', 'vision-mission' );
		get_template_part( 'template-parts/ve-ecs', 'values' );
		get_template_part( 'template-parts/ve-ecs', 'stats' );
		?>
	</main>
<?php
get_footer();
