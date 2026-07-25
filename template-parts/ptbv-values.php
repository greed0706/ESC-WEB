<?php
/**
 * Phát triển bền vững — CON NGƯỜI ECS / ĐỘI NGŨ LÃNH ĐẠO.
 * 3 thẻ giá trị (TẬN TÂM / ĐỒNG HÀNH / ĐỔI MỚI) theo Figma: mặt thẻ = icon line +
 * gạch chân + tiêu đề cam + ảnh; mô tả ẩn trong lớp .ecs-values__overlay, chỉ hiện
 * khi hover/focus (nền cam + nút "Xem thêm") — hiệu ứng slick-track. Thuần CSS, không JS.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ptbv_values = ecsges_tr_deep( ecsges_ptbv_values() );
?>
<section aria-labelledby="ptbv-values-heading" class="ecs-values">
	<div class="ecs-values__inner">
		<div class="ecs-values__header" data-aos="fade-up">
			<h2 id="ptbv-values-heading" class="ecs-values__heading"><?php echo esc_html( ecsges_t( 'CON NGƯỜI ECS' ) ); ?></h2>
			<p class="ecs-values__subheading"><?php echo esc_html( ecsges_t( 'ĐỘI NGŨ LÃNH ĐẠO' ) ); ?></p>
		</div>

		<div class="ecs-values__grid" data-aos="fade-up">
			<?php foreach ( $ptbv_values as $v ) : ?>
				<article class="ecs-values__item">
					<div class="ecs-values__face">
						<div class="ecs-values__iconrow">
							<img src="<?php echo esc_url( ecsges_img( $v['icon'] ) ); ?>" alt="" aria-hidden="true" class="ecs-values__icon">
							<span class="ecs-values__rule" aria-hidden="true"></span>
						</div>
						<h3 class="ecs-values__title"><?php echo esc_html( $v['title'] ); ?></h3>
						<img src="<?php echo esc_url( ecsges_img( $v['image'] ) ); ?>" alt="" aria-hidden="true" class="ecs-values__image">
					</div>

					<div class="ecs-values__overlay">
						<div class="ecs-values__iconrow ecs-values__iconrow--light">
							<img src="<?php echo esc_url( ecsges_img( $v['icon'] ) ); ?>" alt="" aria-hidden="true" class="ecs-values__icon ecs-values__icon--light">
							<span class="ecs-values__rule ecs-values__rule--light" aria-hidden="true"></span>
						</div>
						<h3 class="ecs-values__overlay-title"><?php echo esc_html( $v['title'] ); ?></h3>
						<p class="ecs-values__overlay-text"><?php echo esc_html( $v['text'] ); ?></p>
						<?php // Mỗi thẻ trỏ về chuyên mục riêng; chưa tạo chuyên mục thì giữ href cũ. ?>
						<a class="ecs-values__more" href="<?php echo esc_url( ecsges_category_link( $v['category'], $v['href'] ) ); ?>"><?php echo esc_html( ecsges_t( 'Xem thêm' ) ); ?></a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
