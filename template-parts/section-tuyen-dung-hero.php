<?php
/**
 * Section Hero — trang Tuyển dụng. Ảnh nền (2 người + sóng cam, đã dựng sẵn
 * trong assets/img/tuyen-dung/hero.jpg) + tiêu đề lớn phủ lên trên.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section id="tuyen-dung-hero" aria-labelledby="tuyen-dung-hero-heading" class="ecs-recruit-hero">
	<img src="<?php echo esc_url( ecsges_img( 'tuyen-dung/hero.jpg' ) ); ?>" alt="" class="ecs-recruit-hero__bg">
	<h1 id="tuyen-dung-hero-heading" data-aos="fade-up" class="ecs-recruit-hero__title"><?php echo esc_html( ecsges_t( 'Tuyển dụng' ) ); ?></h1>
</section>
