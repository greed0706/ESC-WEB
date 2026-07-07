<?php
/**
 * Về ECS — Hành trình phát triển (port VeEcsJourney.tsx).
 * Desktop: các mốc đặt tuyệt đối quanh ảnh cầu thang. Mobile: xếp dọc.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$milestones = ecsges_tr_deep( ecsges_milestones() );
$intro      = ecsges_ve_ecs_intro();
$stairs     = ecsges_img( 've-ecs/ve-ecs-journey-stairs.png' );

// Vị trí từng mốc (% theo khung 1920×1416). side: neo trái/phải; align: canh chữ body.
$positions = array(
	array( 'side' => 'left',  'align' => 'text-justify', 'box' => 'left:16.8%;top:71%;width:18%' ),
	array( 'side' => 'right', 'align' => 'text-right',   'box' => 'right:15.8%;top:59.8%;width:21%' ),
	array( 'side' => 'left',  'align' => 'text-justify', 'box' => 'left:16.8%;top:36.1%;width:19%' ),
	array( 'side' => 'right', 'align' => 'text-justify', 'box' => 'right:14.8%;top:25.3%;width:22%' ),
	array( 'side' => 'left',  'align' => 'text-justify', 'box' => 'left:26.1%;top:2.7%;width:22%' ),
);
?>
<section id="hanh-trinh-phat-trien" aria-labelledby="ve-ecs-journey-heading" class="ecs-ve-journey">
	<div class="ecs-ve-journey__inner">
		<div data-aos="fade-up">
			<?php
			ecsges_section_heading(
				array(
					'id'     => 've-ecs-journey-heading',
					'lines'  => array( 'HÀNH TRÌNH PHÁT TRIỂN' ),
					'accent' => array(),
					'align'  => 'center',
				)
			);
			?>
		</div>
		<div class="ecs-ve-journey__intro" data-aos="fade-up" data-aos-delay="100">
			<img src="<?php echo esc_url( ecsges_img( 've-ecs/icon-journey.svg' ) ); ?>" alt="" aria-hidden="true" class="ecs-ve-journey__intro-icon">
			<p class="ecs-ve-journey__intro-text"><?php echo esc_html( $intro ); ?></p>
		</div>
	</div>

	<!-- Desktop: mốc đặt quanh ảnh cầu thang -->
	<div class="ecs-ve-journey__stage">
		<img src="<?php echo esc_url( $stairs ); ?>" alt="Biểu đồ tăng trưởng của ECSGES qua các giai đoạn, trên nền bản đồ thế giới" class="ecs-ve-journey__stairs-img">
		<?php foreach ( $milestones as $i => $m ) : ?>
			<?php $pos = $positions[ $i ]; ?>
			<div class="ecs-ve-journey__milestone ecs-ve-journey__milestone--<?php echo 'right' === $pos['side'] ? 'right' : 'left'; ?>" style="<?php echo esc_attr( $pos['box'] ); ?>" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $i * 120 ); ?>">
				<p class="ecs-ve-journey__year"><?php echo esc_html( $m['years'] ); ?></p>
				<h3 class="ecs-ve-journey__milestone-title"><?php echo esc_html( $m['title'] ); ?></h3>
				<p class="ecs-ve-journey__milestone-body ecs-ve-journey__milestone-body--<?php echo 'text-right' === $pos['align'] ? 'right' : 'justify'; ?>"><?php echo esc_html( $m['body'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>

	<!-- Mobile/tablet: ảnh trên, mốc xếp dọc -->
	<div class="ecs-ve-journey__mobile">
		<img src="<?php echo esc_url( $stairs ); ?>" alt="Biểu đồ tăng trưởng của ECSGES qua các giai đoạn" class="ecs-ve-journey__mobile-img">
		<div class="ecs-ve-journey__mobile-list">
			<?php foreach ( $milestones as $mi => $m ) : ?>
				<div data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $mi * 80 ); ?>">
					<p class="ecs-ve-journey__mobile-year"><?php echo esc_html( $m['years'] ); ?></p>
					<h3 class="ecs-ve-journey__mobile-title"><?php echo esc_html( $m['title'] ); ?></h3>
					<p class="ecs-ve-journey__mobile-body"><?php echo esc_html( $m['body'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
