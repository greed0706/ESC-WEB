<?php
/**
 * Trang Tin tức — thanh 6 tab chủ đề. Cùng kiểu thẻ tab (icon trên, nhãn dưới,
 * nền cam + caret khi active) với "Lĩnh vực hoạt động" (template-parts/linh-vuc-tabs.php)
 * và "Hệ sinh thái" trang chủ (template-parts/section-ecosystem.php) — dùng lại
 * NGUYÊN các class .ecs-ecosystem__tablist/__tab-wrap/__tab/__icon/__label/__caret
 * (src/scss/components/_landing.scss), chỉ thêm biến thể 6 cột riêng cho trang
 * này trong _tin-tuc.scss.
 *
 * Khác với 2 nơi trên: đây là <a> ĐIỀU HƯỚNG tới archive category thật (render
 * bởi category.php), KHÔNG phải tab đổi nội dung tại chỗ — nên không có
 * role="tablist"/role="tab" hay JS, chỉ class .is-active + aria-current="page".
 * Tab "ECSGES" (cat rỗng) = chính trang này, không có icon riêng.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tt_tabs    = ecsges_news_tabs();
$tt_current = isset( $args['current'] ) ? $args['current'] : '';

// Có tab nào thực sự đang active không? Trên chính trang Tin tức thì KHÔNG
// (current = ''), nên tab đầu được tô cam "mặc định" (.is-default) để người
// dùng nhận ra hàng tab bấm được — rê chuột sang tab khác thì màu cam mặc định
// đó tắt, xem &__tablist trong src/scss/components/_tin-tuc.scss.
$tt_has_active = false;
foreach ( $tt_tabs as $tt_tab ) {
	if ( '' !== $tt_tab['cat'] && $tt_tab['cat'] === $tt_current ) {
		$tt_has_active = true;
		break;
	}
}
?>
<nav class="ecs-newsroom__tabs" aria-label="<?php echo esc_attr( ecsges_t( 'Chủ đề tin tức' ) ); ?>">
	<div class="ecs-newsroom__tabs-inner">
		<ul class="ecs-newsroom__tablist ecs-ecosystem__tablist">
			<?php foreach ( $tt_tabs as $tt_i => $tab ) : ?>
				<?php
				// Tab "ECSGES" (cat rỗng) không bao giờ tô cam — nó là lối về
				// trang Tin tức chung, không phải một chủ đề lọc như 5 tab kia.
				$is_active = ( '' !== $tab['cat'] ) && ( $tab['cat'] === $tt_current );
				// Cam "mặc định" (chỉ CSS, không phải trạng thái chọn): tab đầu
				// tiên khi cả hàng chưa có tab nào active.
				$is_default = ( 0 === $tt_i ) && ! $tt_has_active;
				// cat rỗng = trang Tin tức; ngược lại lấy link category thật,
				// category chưa tồn tại thì rơi về trang Tin tức.
				$tt_home = ecsges_translate_path( '/tin-tuc/' );
				$tt_href = '' === $tab['cat'] ? $tt_home : ecsges_category_link( $tab['cat'], $tt_home );
				?>
				<li class="ecs-ecosystem__tab-wrap">
					<a
						href="<?php echo esc_url( $tt_href ); ?>"
						class="ecs-ecosystem__tab<?php echo $is_active ? ' is-active' : ''; ?><?php echo $is_default ? ' is-default' : ''; ?>"
						<?php echo $is_active ? ' aria-current="page"' : ''; ?>>
						<?php if ( ! empty( $tab['icon'] ) ) : ?>
							<?php
							// hero-mark.svg tô đặc (fill) chứ không phải icon outline (stroke)
							// như 5 icon lĩnh vực kia — cần ép fill theo currentColor mới ăn
							// màu ghi/trắng-khi-hover chung, xem &__icon--fill trong _tin-tuc.scss.
							$tt_icon_class = 'ecs-ecosystem__icon' . ( 'hero-mark' === $tab['icon'] ? ' ecs-ecosystem__icon--fill' : '' );
							?>
							<span aria-hidden="true" class="<?php echo esc_attr( $tt_icon_class ); ?>">
								<?php echo ecsges_inline_svg( $tab['icon'] . '.svg' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
						<?php endif; ?>
						<span class="ecs-ecosystem__label"><?php echo esc_html( ecsges_t( $tab['label'] ) ); ?></span>
					</a>
					<span aria-hidden="true" class="ecs-ecosystem__caret"></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</nav>
