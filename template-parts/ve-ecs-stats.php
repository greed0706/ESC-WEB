<?php
/**
 * Về ECS — Những con số ấn tượng (port VeEcsStats.tsx).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stats = ecsges_tr_deep( ecsges_ve_ecs_stats() );
?>
<section aria-labelledby="ve-ecs-stats-heading" class="ecs-ve-stats">
	<div class="ecs-ve-stats__inner">
		<div data-aos="fade-up">
			<?php
			ecsges_section_heading(
				array(
					'id'     => 've-ecs-stats-heading',
					'lines'  => array( 'NHỮNG CON SỐ ẤN TƯỢNG' ),
					'accent' => array(),
					'align'  => 'center',
				)
			);
			?>
		</div>

		<dl class="ecs-ve-stats__grid">
			<?php foreach ( $stats as $si => $stat ) : ?>
				<div class="ecs-ve-stats__item" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $si * 80 ); ?>">
					<img src="<?php echo esc_url( ecsges_img( 've-ecs/last-section/' . $stat['icon'] ) ); ?>" alt="" aria-hidden="true" class="ecs-ve-stats__icon">
					<dd class="ecs-ve-stats__value"><?php echo esc_html( $stat['value'] ); ?></dd>
					<dt class="ecs-ve-stats__label"><?php echo esc_html( $stat['label'] ); ?></dt>
				</div>
			<?php endforeach; ?>
		</dl>
	</div>
</section>
