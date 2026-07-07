<?php
/**
 * Về ECS — Hero (port VeEcsHero.tsx): ảnh full-bleed + tiêu đề trang.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section id="top" aria-labelledby="ve-ecs-hero-heading" class="ecs-ve-hero">
	<img src="<?php echo esc_url( ecsges_img( 've-ecs/ve-ecs-hero-bg.jpg' ) ); ?>" alt="" aria-hidden="true" class="ecs-ve-hero__bg">
	<div aria-hidden="true" class="ecs-ve-hero__overlay"></div>

	<div class="ecs-ve-hero__content">
		<h1 id="ve-ecs-hero-heading" data-aos="fade-up" class="ecs-ve-hero__title"><?php echo esc_html( ecsges_t( 'Về ECS' ) ); ?></h1>
	</div>
</section>
