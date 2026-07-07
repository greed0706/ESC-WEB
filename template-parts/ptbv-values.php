<?php
/**
 * Phát triển bền vững — 3 giá trị (TẬN TÂM / ĐỒNG HÀNH / ĐỔI MỚI) + icon tròn.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ptbv_values = ecsges_ptbv_values();
?>
<section aria-labelledby="ptbv-values-heading" class="ecs-values">
	<div class="ecs-values__inner">
		<h2 id="ptbv-values-heading" class="ecs-values__visually-hidden">Giá trị</h2>

		<div class="ecs-values__grid" data-aos="fade-up">
			<?php foreach ( $ptbv_values as $v ) : ?>
				<div class="ecs-values__item">
					<img src="<?php echo esc_url( ecsges_img( $v['icon'] ) ); ?>" alt="" aria-hidden="true" class="ecs-values__icon">
					<h3 class="ecs-values__title"><?php echo esc_html( $v['title'] ); ?></h3>
					<?php if ( ! empty( $v['text'] ) ) : ?>
						<p class="ecs-values__text"><?php echo esc_html( $v['text'] ); ?></p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
