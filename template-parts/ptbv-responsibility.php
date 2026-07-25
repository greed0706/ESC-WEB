<?php
/**
 * Phát triển bền vững — TRÁCH NHIỆM XÃ HỘI. 3 thẻ (TRI THỨC / NHÂN LỰC / TƯƠNG LAI);
 * thẻ đầu tô nền cam qua modifier .ecs-responsibility__card--accent.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ptbv_resp = ecsges_tr_deep( ecsges_ptbv_responsibility() );
?>
<section aria-labelledby="ptbv-responsibility-heading" class="ecs-responsibility">
	<div class="ecs-responsibility__inner">
		<h2 id="ptbv-responsibility-heading" data-aos="fade-up" class="ecs-responsibility__heading"><?php echo esc_html( ecsges_t( 'TRÁCH NHIỆM XÃ HỘI' ) ); ?></h2>

		<div class="ecs-responsibility__grid" data-aos="fade-up">
			<?php foreach ( $ptbv_resp as $r ) : ?>
				<article class="ecs-responsibility__card">
					<h3 class="ecs-responsibility__title"><?php echo esc_html( $r['title'] ); ?></h3>
					<p class="ecs-responsibility__text"><?php echo esc_html( $r['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
