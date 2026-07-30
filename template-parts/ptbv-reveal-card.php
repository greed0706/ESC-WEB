<?php
/**
 * Thẻ "reveal" dùng chung cho 3 khối ở trang Phát triển bền vững (CON NGƯỜI ECS /
 * VĂN HÓA ECS / TRÁCH NHIỆM XÃ HỘI). Nhận icon/image/title/text/category qua
 * get_template_part($args). Hover: thẻ trắng→đỏ, ảnh mờ dần, panel mô tả + nút
 * "Xem thêm" hiện ra sau độ trễ ngắn — thuần CSS (.ecs-reveal-card, xem _pages.scss).
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title    = isset( $args['title'] ) ? $args['title'] : '';
$icon     = isset( $args['icon'] ) ? $args['icon'] : '';
$image    = isset( $args['image'] ) ? $args['image'] : '';
$text     = isset( $args['text'] ) ? $args['text'] : '';
$category = isset( $args['category'] ) ? $args['category'] : '';
$href     = $category ? home_url( '/category/' . $category . '/' ) : '';
?>
<article class="ecs-reveal-card">
	<div class="ecs-reveal-card__face">
		<div class="ecs-reveal-card__iconrow">
			<img src="<?php echo esc_url( ecsges_img( $icon ) ); ?>" alt="" aria-hidden="true" class="ecs-reveal-card__icon">
			<span class="ecs-reveal-card__rule" aria-hidden="true"></span>
		</div>
		<h3 class="ecs-reveal-card__title"><?php echo esc_html( $title ); ?></h3>
		<div class="ecs-reveal-card__stage">
			<img src="<?php echo esc_url( ecsges_img( $image ) ); ?>" alt="" aria-hidden="true" class="ecs-reveal-card__image">
			<div class="ecs-reveal-card__overlay">
				<p class="ecs-reveal-card__overlay-text"><?php echo esc_html( $text ); ?></p>
				<?php if ( $href ) : ?>
					<?php ecsges_see_more( $href, 'Xem thêm', 'ecs-see-more--on-brand ecs-reveal-card__more' ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</article>
