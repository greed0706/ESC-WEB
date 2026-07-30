<?php
/**
 * Section About (port AboutSection.tsx) — bản đồ thế giới + pin.
 *
 * @package ECSGES
 */

if (!defined('ABSPATH')) {
	exit;
}

$ecsges_pins = ecsges_about_pins();
$about_eyebrow = ecsges_field('about_eyebrow', 'ECSGES');
$about_lines = ecsges_field_lines('about_heading', array('VƯƠN RA THẾ GIỚI', 'VỚI HỆ SINH THÁI GIÁO DỤC KẾT NỐI'));
$about_paras = ecsges_field_paragraphs(
	'about_body',
	array(
		'Trong một thế giới không ngừng kết nối, giáo dục không thể phát triển trong những giới hạn đơn lẻ. ECSGES mở rộng mạng lưới hợp tác với nhà trường, doanh nghiệp, tổ chức giáo dục và các đối tác trong nước, quốc tế; kết nối tri thức, nguồn lực và cơ hội để đưa giáo dục Việt Nam đến gần hơn với những chuẩn mực toàn cầu.',
		'Từ nền tảng giáo dục và nguồn nhân lực Việt Nam, ECSGES hướng tới xây dựng một hệ sinh thái giáo dục có khả năng kết nối rộng hơn, hợp tác sâu hơn và tạo ra những giá trị có sức lan tỏa vượt qua biên giới.'
	)
);
$about_label = ecsges_field('about_cta_label', 'Xem thêm');
// Để trống field trong admin → nút trỏ về chuyên mục riêng
// (/category/linh-vuc-hoat-dong/); chưa tạo chuyên mục thì lùi về neo cũ.
$about_link = ecsges_field('about_cta_link', ecsges_category_link('linh-vuc-hoat-dong', 'http://103.154.62.159:8090/doi-tac/'));
?>
<section id="ve-ecs" aria-labelledby="about-heading" class="ecs-about">
	<div class="ecs-about__inner">
		<div class="ecs-about__content">
			<?php
			ecsges_section_heading(
				array(
					'id' => 'about-heading',
					'eyebrow' => $about_eyebrow,
					'lines' => $about_lines,
				)
			);
			?>
			<div class="ecs-about__text" data-chars-reveal>
				<?php foreach ($about_paras as $para): ?>
					<p>
						<?php
						$about_words = preg_split('/\s+/u', trim($para));
						foreach ($about_words as $awi => $aword) {
							if ('' === $aword) {
								continue;
							}
							if ($awi > 0) {
								echo ' ';
							}
							$achars = function_exists('mb_str_split') ? mb_str_split($aword) : preg_split('//u', $aword, -1, PREG_SPLIT_NO_EMPTY);
							echo '<span class="rword">';
							foreach ($achars as $ach) {
								echo '<span class="rchar">' . esc_html($ach) . '</span>';
							}
							echo '</span>';
						}
						?>
					</p>
				<?php endforeach; ?>
			</div>
			<div class="ecs-about__cta-wrap">
				<?php ecsges_see_more($about_link, $about_label, 'ecs-about__cta'); ?>
			</div>
		</div>

		<div class="ecsges-earth-ping ecs-about__map" data-aos="fade-up" data-pins-reveal>
			<span aria-hidden="true" class="ecs-about__ring ecs-about__ring--outer"></span>
			<span aria-hidden="true" class="ecs-about__ring ecs-about__ring--inner"></span>
			<img src="<?php echo esc_url(ecsges_img('earth.svg')); ?>" alt="" class="ecs-about__earth">
			<?php foreach ($ecsges_pins as $p): ?>
				<?php if (!empty($p['lg'])): ?>
					<span aria-hidden="true" class="ecsges-pin ecs-about__pin--lg"
						style="left:<?php echo esc_attr($p['x']); ?>%;top:<?php echo esc_attr($p['y']); ?>%;width:7%">
						<img src="<?php echo esc_url(ecsges_img('map-pin-center.svg')); ?>" alt=""
							class="ecs-about__pin-icon">
						<img src="<?php echo esc_url(ecsges_img('hero-mark.svg')); ?>" alt="" class="ecs-about__pin-mark">
					</span>
				<?php else: ?>
					<img src="<?php echo esc_url(ecsges_img('map-pin.svg')); ?>" alt="" aria-hidden="true"
						class="ecsges-pin ecs-about__pin--sm"
						style="left:<?php echo esc_attr($p['x']); ?>%;top:<?php echo esc_attr($p['y']); ?>%;width:3%">
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>