<?php
/**
 * Banner tiêu đề trang (dùng chung cho các trang phụ: Lĩnh vực hoạt động,
 * Phát triển bền vững...). Nhận tiêu đề qua get_template_part($args).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_title = isset( $args['title'] ) ? $args['title'] : '';
$hero_id    = isset( $args['id'] ) ? $args['id'] : 'page-hero';
$hero_bg    = isset( $args['bg'] ) ? $args['bg'] : 've-ecs/ve-ecs-hero-bg.jpg';
?>
<section id="<?php echo esc_attr( $hero_id ); ?>" aria-labelledby="<?php echo esc_attr( $hero_id ); ?>-heading" class="ecs-page-hero">
	<img src="<?php echo esc_url( ecsges_img( $hero_bg ) ); ?>" alt="" aria-hidden="true" class="ecs-page-hero__bg">
	<div aria-hidden="true" class="ecs-page-hero__overlay"></div>
	<div class="ecs-page-hero__content">
		<h1 id="<?php echo esc_attr( $hero_id ); ?>-heading" data-aos="fade-up" class="ecs-page-hero__title"><?php echo esc_html( ecsges_t( $hero_title ) ); ?></h1>
	</div>
</section>
