<?php
/**
 * Phát triển bền vững — CON NGƯỜI ECS / ĐỘI NGŨ LÃNH ĐẠO.
 * 3 thẻ giá trị (TẬN TÂM / ĐỒNG HÀNH / ĐỔI MỚI) dùng chung thẻ "reveal"
 * (template-parts/ptbv-reveal-card.php, xem CLAUDE.md mục Kiến trúc).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ptbv_values = ecsges_tr_deep( ecsges_ptbv_values() );
?>
<section id="con-nguoi-ecs" aria-labelledby="ptbv-values-heading" class="ecs-values">
	<div class="ecs-values__inner">
		<div class="ecs-values__header" data-aos="fade-up">
			<h2 id="ptbv-values-heading" class="ecs-values__heading"><?php echo esc_html( ecsges_t( 'CON NGƯỜI ECS' ) ); ?></h2>
		</div>

		<div class="ecs-reveal-grid" data-aos="fade-up">
			<?php foreach ( $ptbv_values as $v ) : ?>
				<?php get_template_part( 'template-parts/ptbv-reveal-card', null, $v ); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
