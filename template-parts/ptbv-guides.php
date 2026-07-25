<?php
/**
 * Phát triển bền vững — banner "Click here" + 4 thẻ hướng dẫn.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ptbv_guides = ecsges_tr_deep( ecsges_ptbv_guides() );
?>
<section aria-labelledby="ptbv-guides-heading" class="ecs-guides">
	<div class="ecs-guides__inner">
		<h2 id="ptbv-guides-heading" class="ecs-guides__visually-hidden"><?php echo esc_html( ecsges_t( 'Hướng dẫn' ) ); ?></h2>

		<!-- Cụm promo: banner "Click here" + 4 thẻ, bọc trong container bo góc nền sáng -->
		<div class="ecs-guides__promo" data-aos="fade-up">
			<!-- Banner "Click here" -->
			<a href="#" class="ecs-guides__banner">
				<img src="<?php echo esc_url( ecsges_img( 'phat-trien-ben-vung/click.svg' ) ); ?>" alt="" aria-hidden="true" class="ecs-guides__banner-icon">
				<span class="ecs-guides__banner-text">Click here &gt;&gt;</span>
			</a>

			<!-- 4 thẻ hướng dẫn -->
			<div class="ecs-guides__grid">
				<?php foreach ( $ptbv_guides as $g ) : ?>
					<a href="<?php echo esc_url( $g['href'] ); ?>" class="ecs-guides__card">
						<div class="ecs-guides__card-media">
							<img src="<?php echo esc_url( ecsges_img( $g['image'] ) ); ?>" alt="<?php echo esc_attr( $g['title'] ); ?>" class="ecs-guides__card-img">
						</div>
						<p class="ecs-guides__card-title"><?php echo esc_html( $g['title'] ); ?></p>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
