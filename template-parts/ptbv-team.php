<?php
/**
 * Phát triển bền vững — carousel nhân sự. Điều khiển bằng initPtbvCarousel()
 * (assets/js/main.js) qua data-ptbv-carousel / data-ptbv-track / prev / next.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ptbv_team = ecsges_tr_deep( ecsges_ptbv_team() );
?>
<section aria-labelledby="ptbv-team-heading" class="ecs-team">
	<div class="ecs-team__inner">
		<div class="ecs-team__header" data-aos="fade-up">
			<h2 id="ptbv-team-heading" class="ecs-team__heading"><?php echo esc_html( ecsges_t( 'CON NGƯỜI ECS' ) ); ?></h2>
			<p class="ecs-team__subheading"><?php echo esc_html( ecsges_t( 'ĐỘI NGŨ LÃNH ĐẠO' ) ); ?></p>
		</div>

		<div class="ecs-team__carousel" data-aos="fade-up" data-ptbv-carousel>
			<div class="ecs-team__viewport">
				<div class="ecs-team__track" data-ptbv-track>
					<?php foreach ( $ptbv_team as $m ) : ?>
						<article class="ecs-team__card">
							<img src="<?php echo esc_url( ecsges_img( $m['image'] ) ); ?>" alt="<?php echo esc_attr( $m['name'] ); ?>" class="ecs-team__photo">
							<div class="ecs-team__info">
								<p class="ecs-team__name"><?php echo esc_html( $m['name'] ); ?></p>
								<p class="ecs-team__title"><?php echo esc_html( $m['title'] ); ?></p>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>

			<button type="button" data-ptbv-prev aria-label="Trước" class="ecs-team__arrow ecs-team__arrow--prev">
				<span aria-hidden="true" class="ecs-team__arrow-icon">&#8249;</span>
			</button>
			<button type="button" data-ptbv-next aria-label="Sau" class="ecs-team__arrow ecs-team__arrow--next">
				<span aria-hidden="true" class="ecs-team__arrow-icon">&#8250;</span>
			</button>
		</div>
	</div>
</section>
