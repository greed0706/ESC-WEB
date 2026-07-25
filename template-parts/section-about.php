<?php
/**
 * Section About (port AboutSection.tsx) — bản đồ thế giới + pin.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ecsges_pins   = ecsges_about_pins();
$about_eyebrow = ecsges_field( 'about_eyebrow', 'ECSGES' );
$about_lines   = ecsges_field_lines( 'about_heading', array( 'VƯƠN RA THẾ GIỚI', 'VỚI HỆ SINH THÁI GIÁO DỤC KẾT NỐI' ) );
$about_paras   = ecsges_field_paragraphs(
	'about_body',
	array(
		'ECSGES phát triển hệ sinh thái giáo dục với mạng lưới đơn vị thành viên, đối tác và các lĩnh vực hoạt động được kết nối trong một chiến lược thống nhất, hướng tới nâng cao chất lượng giáo dục và phát triển nguồn nhân lực Việt Nam.'
	)
);
$about_label   = ecsges_field( 'about_cta_label', 'Tìm hiểu thêm' );
// Để trống field trong admin → nút trỏ về chuyên mục riêng
// (/category/linh-vuc-hoat-dong/); chưa tạo chuyên mục thì lùi về neo cũ.
$about_link    = ecsges_field( 'about_cta_link', ecsges_category_link( 'linh-vuc-hoat-dong', '#linh-vuc' ) );
?>
<section id="ve-ecs" aria-labelledby="about-heading" class="ecs-about">
	<div class="ecs-about__inner">
		<div class="ecs-about__content">
			<?php
			ecsges_section_heading(
				array(
					'id'      => 'about-heading',
					'eyebrow' => $about_eyebrow,
					'lines'   => $about_lines,
				)
			);
			?>
			<div class="ecs-about__text" data-chars-reveal>
				<?php foreach ( $about_paras as $para ) : ?>
					<p>
						<?php
						$about_words = preg_split( '/\s+/u', trim( $para ) );
						foreach ( $about_words as $awi => $aword ) {
							if ( '' === $aword ) {
								continue;
							}
							if ( $awi > 0 ) {
								echo ' ';
							}
							$achars = function_exists( 'mb_str_split' ) ? mb_str_split( $aword ) : preg_split( '//u', $aword, -1, PREG_SPLIT_NO_EMPTY );
							echo '<span class="rword">';
							foreach ( $achars as $ach ) {
								echo '<span class="rchar">' . esc_html( $ach ) . '</span>';
							}
							echo '</span>';
						}
						?>
					</p>
				<?php endforeach; ?>
			</div>
			<div class="ecs-about__cta-wrap">
				<?php ecsges_see_more( $about_link, $about_label, 'ecs-about__cta' ); ?>
			</div>
		</div>

		<div class="ecsges-earth-ping ecs-about__map" data-aos="fade-up" data-pins-reveal>
			<span aria-hidden="true" class="ecs-about__ring ecs-about__ring--outer"></span>
			<span aria-hidden="true" class="ecs-about__ring ecs-about__ring--inner"></span>
			<img src="<?php echo esc_url( ecsges_img( 'earth.svg' ) ); ?>" alt="" class="ecs-about__earth">
			<?php foreach ( $ecsges_pins as $p ) : ?>
				<?php if ( ! empty( $p['lg'] ) ) : ?>
					<span aria-hidden="true" class="ecsges-pin ecs-about__pin--lg" style="left:<?php echo esc_attr( $p['x'] ); ?>%;top:<?php echo esc_attr( $p['y'] ); ?>%;width:7%">
						<img src="<?php echo esc_url( ecsges_img( 'map-pin-center.svg' ) ); ?>" alt="" class="ecs-about__pin-icon">
						<img src="<?php echo esc_url( ecsges_img( 'hero-mark.svg' ) ); ?>" alt="" class="ecs-about__pin-mark">
					</span>
				<?php else : ?>
					<img src="<?php echo esc_url( ecsges_img( 'map-pin.svg' ) ); ?>" alt="" aria-hidden="true" class="ecsges-pin ecs-about__pin--sm" style="left:<?php echo esc_attr( $p['x'] ); ?>%;top:<?php echo esc_attr( $p['y'] ); ?>%;width:3%">
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
