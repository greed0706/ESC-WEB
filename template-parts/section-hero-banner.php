<?php
/**
 * Section Hero — biến thể BANNER / SLIDER (Figma node 2:13 / rect 2:34, 1920x792).
 *
 * Ảnh và cấu hình lấy từ Theme Options → Hero Slider (inc/theme-options.php).
 * Chưa cấu hình gì → đúng 1 slide dùng ảnh tĩnh assets/img/hero-banner.jpg, và
 * vì chỉ có 1 slide nên dots/mũi tên/JS đều KHÔNG được in ra → giao diện y hệt
 * bản banner tĩnh trước đây.
 *
 * Toàn bộ chữ ("Kiến tạo hệ sinh thái / GIÁO DỤC TOÀN CẦU / VÌ TƯƠNG LAI VIỆT NAM")
 * đã bake sẵn trong ảnh nên KHÔNG render text overlay — chỉ một <h1> ẩn cho
 * screen reader / SEO, giống cách template-parts/page-hero.php xử lý
 * variant 'banner'.
 *
 * Class .owl-* đặt theo quy ước OwlCarousel cho quen mắt, nhưng chuyển động do
 * initHeroSlider() trong assets/js/main.js lo — theme KHÔNG nạp jQuery hay
 * OwlCarousel ở frontend.
 *
 * Bản hero cũ (emblem + chữ hiện từng ký tự) vẫn giữ nguyên ở
 * template-parts/section-hero.php để tái sử dụng — đổi lại một dòng
 * get_template_part() trong front-page.php là quay về được.
 *
 * @package ECSGES
 */

if (!defined('ABSPATH')) {
	exit;
}

$hero = ecsges_hero_slider();
$hero_slides = $hero['slides'];
$hero_count = count($hero_slides);
$hero_alt = ecsges_t('Kiến tạo hệ sinh thái giáo dục toàn cầu — Vì tương lai Việt Nam');
// Một slide thì chấm/mũi tên vô nghĩa — ẩn bất kể cấu hình.
$hero_dots = $hero['dots'] && $hero_count > 1;
$hero_nav = $hero['nav'] && $hero_count > 1;
?>
<section id="top" aria-labelledby="hero-heading" class="ecs-hero-banner<?php echo $hero_count > 1 ? ' ecs-hero-banner--slider' : ''; ?>"
	<?php if ($hero_count > 1): ?>
	data-hero-slider data-autoplay="<?php echo $hero['autoplay'] ? '1' : '0'; ?>" data-interval="<?php echo esc_attr($hero['interval']); ?>" data-speed="<?php echo esc_attr($hero['speed']); ?>"
	<?php endif; ?>>
	<h1 id="hero-heading" class="ecs-hero-banner__visually-hidden"><?php echo esc_html($hero_alt); ?></h1>

	<div class="owl-stage-outer">
		<div class="owl-stage" data-hero-track>
			<?php foreach ($hero_slides as $i => $slide): ?>
				<div class="owl-item<?php echo 0 === $i ? ' is-active' : ''; ?>" data-hero-slide <?php echo 0 === $i ? '' : 'aria-hidden="true"'; ?>>
					<?php if ($slide['link']): ?>
						<a href="<?php echo esc_url($slide['link']); ?>" class="ecs-hero-banner__link" <?php echo 0 === $i ? '' : 'tabindex="-1"'; ?>>
					<?php endif; ?>

					<picture>
						<?php if ($slide['mobile']): ?>
							<source media="(max-width: 767px)" srcset="<?php echo esc_url($slide['mobile']); ?>">
						<?php endif; ?>
						<img src="<?php echo esc_url($slide['url']); ?>" alt="<?php echo esc_attr($slide['alt']); ?>"
							<?php echo $slide['alt'] ? '' : 'aria-hidden="true"'; ?> width="1920" height="792"
							<?php echo 0 === $i ? '' : 'loading="lazy"'; ?>
							class="ecs-hero-banner__img<?php echo $slide['mobile'] ? ' ecs-hero-banner__img--has-mobile' : ''; ?>">
					</picture>

					<?php if ($slide['link']): ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<?php if ($hero_nav): ?>
		<button type="button" data-hero-prev aria-label="<?php echo esc_attr(ecsges_t('Trước')); ?>" class="owl-prev">
			<span aria-hidden="true">&#8249;</span>
		</button>
		<button type="button" data-hero-next aria-label="<?php echo esc_attr(ecsges_t('Sau')); ?>" class="owl-next">
			<span aria-hidden="true">&#8250;</span>
		</button>
	<?php endif; ?>

	<?php if ($hero_dots): ?>
		<div class="owl-dots">
			<?php foreach ($hero_slides as $i => $slide): ?>
				<button type="button" data-hero-dot class="owl-dot<?php echo 0 === $i ? ' is-active' : ''; ?>"
					aria-label="<?php echo esc_attr(sprintf(ecsges_t('Banner %d'), $i + 1)); ?>"
					aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"></button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
