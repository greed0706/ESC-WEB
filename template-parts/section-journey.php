<?php
/**
 * Section Journey (port JourneySection.tsx) — dải cam + collage ảnh.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$journey_lines = ecsges_field_lines( 'journey_heading', array( 'ĐỒNG HÀNH CÙNG NHỮNG', 'HÀNH TRÌNH PHÁT TRIỂN' ) );
$journey_body  = ecsges_field( 'journey_body', 'ECSGES đồng hành cùng cá nhân, tổ chức và cộng đồng trên hành trình học tập, phát triển năng lực và mở rộng cơ hội trong bối cảnh hiện đại toàn cầu.' );
$journey_label = ecsges_field( 'journey_cta_label', 'Tìm hiểu thêm' );
$journey_link  = ecsges_field( 'journey_cta_link', '#linh-vuc' );

$ecsges_photos = array(
	array( 'src' => ecsges_field_img( 'journey_img_1', 'journey-1.png' ), 'alt' => 'Học viên ECS Global', 'cell' => 'ecs-journey__photo--1' ),
	array( 'src' => ecsges_field_img( 'journey_img_2', 'journey-2.png' ), 'alt' => 'Hoạt động đào tạo',    'cell' => 'ecs-journey__photo--2' ),
	array( 'src' => ecsges_field_img( 'journey_img_3', 'journey-4.png' ), 'alt' => 'Sự kiện ECS Global',   'cell' => 'ecs-journey__photo--3' ),
	array( 'src' => ecsges_field_img( 'journey_img_4', 'journey-3.png' ), 'alt' => 'Cộng đồng ECS Global',  'cell' => 'ecs-journey__photo--4' ),
);
?>
<section id="phat-trien-ben-vung" aria-labelledby="journey-heading" class="ecs-journey">
	<div aria-hidden="true" class="ecs-journey__gradient"></div>

	<div class="ecs-journey__inner">
		<div class="ecs-journey__text-col">
			<div class="ecs-journey__text-inner" data-aos="fade-right">
				<?php
				ecsges_section_heading(
					array(
						'id'    => 'journey-heading',
						'tone'  => 'light',
						'lines' => $journey_lines,
					)
				);
				?>
				<p class="ecs-journey__body"><?php echo esc_html( $journey_body ); ?></p>
				<div class="ecs-journey__cta-wrap">
					<?php ecsges_underline_link( $journey_link, $journey_label, 'white', 'ecs-journey__cta' ); ?>
				</div>
			</div>
		</div>

		<div class="ecs-journey__photos">
			<?php foreach ( $ecsges_photos as $pi => $photo ) : ?>
				<img src="<?php echo esc_url( $photo['src'] ); ?>" alt="<?php echo esc_attr( $photo['alt'] ); ?>" loading="lazy" data-aos="fade-left" data-aos-delay="<?php echo esc_attr( $pi * 120 ); ?>" class="ecs-journey__photo <?php echo esc_attr( $photo['cell'] ); ?>">
			<?php endforeach; ?>
		</div>
	</div>
</section>
