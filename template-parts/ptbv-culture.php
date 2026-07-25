<?php
/**
 * Phát triển bền vững — VĂN HÓA ECS. Theo Figma: lưới 3 thẻ hiện cùng lúc, mỗi thẻ =
 * ảnh trên cùng + tiêu đề + mô tả (không còn carousel ảnh lớn).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ptbv_culture = ecsges_tr_deep( ecsges_ptbv_culture() );
?>
<section aria-labelledby="ptbv-culture-heading" class="ecs-culture">
	<div class="ecs-culture__inner">
		<h2 id="ptbv-culture-heading" data-aos="fade-up" class="ecs-culture__heading"><?php echo esc_html( ecsges_t( 'VĂN HÓA ECS' ) ); ?></h2>

		<div class="ecs-culture__grid" data-aos="fade-up">
			<?php foreach ( $ptbv_culture as $c ) : ?>
				<article class="ecs-culture__card">
					<img src="<?php echo esc_url( ecsges_img( $c['image'] ) ); ?>" alt="" aria-hidden="true" class="ecs-culture__image">
					<div class="ecs-culture__body">
						<h3 class="ecs-culture__title"><?php echo esc_html( $c['title'] ); ?></h3>
						<p class="ecs-culture__text"><?php echo esc_html( $c['text'] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
