<?php
/**
 * Phát triển bền vững — TRÁCH NHIỆM XÃ HỘI (KHUYẾN HỌC / CỘNG ĐỒNG / PHÁT TRIỂN).
 * Dùng chung thẻ "reveal" (template-parts/ptbv-reveal-card.php, xem CLAUDE.md mục Kiến trúc).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ptbv_resp = ecsges_tr_deep( ecsges_ptbv_responsibility() );
?>
<section id="trach-nhiem-xa-hoi" aria-labelledby="ptbv-responsibility-heading" class="ecs-responsibility">
	<div class="ecs-responsibility__inner">
		<h2 id="ptbv-responsibility-heading" data-aos="fade-up" class="ecs-responsibility__heading"><?php echo esc_html( ecsges_t( 'TRÁCH NHIỆM XÃ HỘI' ) ); ?></h2>

		<div class="ecs-reveal-grid" data-aos="fade-up">
			<?php foreach ( $ptbv_resp as $r ) : ?>
				<?php get_template_part( 'template-parts/ptbv-reveal-card', null, $r ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
