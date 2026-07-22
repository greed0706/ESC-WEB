<?php
/**
 * Phát triển bền vững — VĂN HÓA ECS. Ảnh bên trái + thẻ nội dung chồng lên bên
 * phải, đổi nội dung theo 3 chấm phân trang. Điều khiển bằng initPtbvCulture()
 * (assets/js/main.js) qua data-ptbv-culture / data-culture-slide / data-culture-dot
 * — JS chỉ bật/tắt lớp .is-active (không toggle utility class).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ptbv_culture = ecsges_ptbv_culture();
?>
<section aria-labelledby="ptbv-culture-heading" class="ecs-culture">
	<div class="ecs-culture__inner">
		<h2 id="ptbv-culture-heading" data-aos="fade-up" class="ecs-culture__heading">VĂN HÓA ECS</h2>

		<div class="ecs-culture__stage" data-aos="fade-up" data-ptbv-culture>
			<img src="<?php echo esc_url( ecsges_img( 'phat-trien-ben-vung/van-hoa.png' ) ); ?>" alt="" aria-hidden="true" class="ecs-culture__image">

			<div class="ecs-culture__panel">
				<div class="ecs-culture__slides">
					<?php foreach ( $ptbv_culture as $i => $c ) : ?>
						<article class="ecs-culture__slide<?php echo 0 === $i ? ' is-active' : ''; ?>" data-culture-slide>
							<h3 class="ecs-culture__title"><?php echo esc_html( $c['title'] ); ?></h3>
							<p class="ecs-culture__text"><?php echo esc_html( $c['text'] ); ?></p>
						</article>
					<?php endforeach; ?>
				</div>

				<div class="ecs-culture__dots" role="tablist" aria-label="Chọn giá trị văn hóa">
					<?php foreach ( $ptbv_culture as $i => $c ) : ?>
						<button type="button" class="ecs-culture__dot<?php echo 0 === $i ? ' is-active' : ''; ?>" data-culture-dot role="tab" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr( $c['title'] ); ?>"></button>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
