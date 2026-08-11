<?php
/**
 * Trang Tin tức — thanh 6 tab chủ đề, kiểu CHỮ GẠCH CHÂN (Figma node 746:1184,
 * hàng y=721).
 *
 * Đo từ Figma: nhãn 26px, tab đang chọn Roboto Flex Medium #f26522, còn lại
 * Light #747272; khoảng cách giữa các nhãn 90px; hàng canh giữa container.
 * Gạch cam dưới tab đang chọn cao 4px, nằm trên đường kẻ mảnh chạy hết
 * chiều ngang container (y=785).
 *
 * Tab lọc TẠI CHỖ trên chính page-tin-tuc.php — <a> trỏ về '/tin-tuc/?chuyen-muc=<slug>'
 * (KHÔNG còn điều hướng sang archive category.php); tin-tuc-grid.php đọc lại
 * query string đó (qua ecsges_tin_tuc_active_cat()) để lọc WP_Query. Do vẫn là
 * link <a> thường (không phải tab đổi nội dung bằng JS) nên không có
 * role="tablist"/role="tab", chỉ class .is-active + aria-current="page". Tab
 * "Về ECSGES" (cat rỗng) = tất cả tin, link về thẳng '/tin-tuc/' không kèm query.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tt_tabs    = ecsges_news_tabs();
$tt_current = isset( $args['current'] ) ? $args['current'] : '';

// Không ở trong archive category nào (current = '') thì tab đầu — "Về ECSGES",
// tức toàn bộ tin — chính là tab đang xem.
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
		<ul class="ecs-newsroom__tablist">
			<?php foreach ( $tt_tabs as $tt_i => $tab ) : ?>
				<?php
				$is_active = ( '' === $tab['cat'] )
					? ! $tt_has_active
					: ( $tab['cat'] === $tt_current );

				// cat rỗng = trang Tin tức (tất cả tin), không kèm query; ngược lại
				// gắn ?chuyen-muc=<slug> vào CHÍNH trang Tin tức — không rời trang.
				$tt_home = ecsges_translate_path( '/tin-tuc/' );
				$tt_href = '' === $tab['cat'] ? $tt_home : add_query_arg( 'chuyen-muc', $tab['cat'], $tt_home );
				?>
				<li class="ecs-newsroom__tab-wrap">
					<a
						href="<?php echo esc_url( $tt_href ); ?>"
						class="ecs-newsroom__tab<?php echo $is_active ? ' is-active' : ''; ?>"
						<?php echo $is_active ? ' aria-current="page"' : ''; ?>><?php echo esc_html( ecsges_t( $tab['label'] ) ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</nav>
