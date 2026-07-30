<?php
/**
 * Phát triển bền vững — VĂN HÓA ECS (HỌC HỎI / HỢP TÁC / PHỤNG SỰ). Dùng chung
 * thẻ "reveal" (template-parts/ptbv-reveal-card.php, xem CLAUDE.md mục Kiến trúc).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ptbv_culture = ecsges_tr_deep( ecsges_ptbv_culture() );
?>
<section id="van-hoa-ecs" aria-labelledby="ptbv-culture-heading" class="ecs-culture">
	<div class="ecs-culture__inner">
		<h2 id="ptbv-culture-heading" data-aos="fade-up" class="ecs-culture__heading"><?php echo esc_html( ecsges_t( 'VĂN HÓA ECS' ) ); ?></h2>

		<div class="ecs-reveal-grid" data-aos="fade-up">
			<?php foreach ( $ptbv_culture as $c ) : ?>
				<?php get_template_part( 'template-parts/ptbv-reveal-card', null, $c ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
