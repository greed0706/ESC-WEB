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
 * Tab lọc TẠI CHỖ bằng JS — giống initEcosystemTabs()/initJobsFilter(): toàn bộ
 * bài viết đã được tin-tuc-grid.php query & in ra DOM sẵn (data-news-item), tab
 * chỉ ẩn/hiện chứ KHÔNG điều hướng/reload (bỏ hẳn cách cũ dùng ?chuyen-muc= +
 * WP_Query lại). Vì vậy đây là <button role="tab"> (giống section-ecosystem.php),
 * không phải <a> — initNewsTabsGrid() trong assets/js/main.js gắn JS lọc theo
 * data-news-tab, khớp data-cats của từng bài (template-parts/tin-tuc-grid.php).
 * Tab "Về ECSGES" (cat rỗng) = tất cả tin, LUÔN active mặc định lúc tải trang.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tt_tabs = ecsges_news_tabs();
?>
<nav class="ecs-newsroom__tabs" aria-label="<?php echo esc_attr( ecsges_t( 'Chủ đề tin tức' ) ); ?>">
	<div class="ecs-newsroom__tabs-inner">
		<ul class="ecs-newsroom__tablist" role="tablist" data-news-tabs>
			<?php foreach ( $tt_tabs as $tab ) : ?>
				<?php $is_active = ( '' === $tab['cat'] ); ?>
				<li class="ecs-newsroom__tab-wrap">
					<button
						type="button"
						role="tab"
						data-news-tab="<?php echo esc_attr( $tab['cat'] ); ?>"
						aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
						aria-controls="tin-tuc-grid-list"
						class="ecs-newsroom__tab<?php echo $is_active ? ' is-active' : ''; ?>"
					><?php echo esc_html( ecsges_t( $tab['label'] ) ); ?></button>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</nav>
