<?php
/**
 * Về ECS — Tầm nhìn + Sứ mệnh (port VeEcsVisionMission.tsx).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$vision  = ecsges_ve_ecs_vision();
$mission = ecsges_tr_deep( ecsges_ve_ecs_mission() );
?>
<section aria-label="Tầm nhìn và sứ mệnh" class="ecs-ve-vm">
	<div class="ecs-ve-vm__inner">
		<!-- Tầm nhìn — chữ trái, ảnh phải -->
		<div class="ecs-ve-vm__row">
			<div data-aos="fade-up">
				<?php
				ecsges_section_heading(
					array(
						'lines'  => array( 'TẦM NHÌN' ),
						'accent' => array(),
					)
				);
				?>
				<p class="ecs-ve-vm__text"><?php echo esc_html( $vision ); ?></p>
			</div>
			<img src="<?php echo esc_url( ecsges_img( 've-ecs/ve-ecs-vision.png' ) ); ?>" alt="Tầm nhìn ECSGES" loading="lazy" data-aos="fade-up" data-aos-delay="100" class="ecs-ve-vm__img">
		</div>

		<!-- Sứ mệnh — ảnh trái, chữ phải -->
		<div class="ecs-ve-vm__row">
			<div class="ecs-ve-vm__row-text ecs-ve-vm__row-text--mission" data-aos="fade-up">
				<?php
				ecsges_section_heading(
					array(
						'lines'  => array( 'SỨ MỆNH' ),
						'accent' => array(),
					)
				);
				?>
				<?php foreach ( $mission as $para ) : ?>
					<p class="ecs-ve-vm__text"><?php echo esc_html( $para ); ?></p>
				<?php endforeach; ?>
			</div>
			<img src="<?php echo esc_url( ecsges_img( 've-ecs/ve-ecs-mission.png' ) ); ?>" alt="Sứ mệnh ECSGES" loading="lazy" data-aos="fade-up" data-aos-delay="100" class="ecs-ve-vm__img ecs-ve-vm__img--mission">
		</div>
	</div>
</section>
