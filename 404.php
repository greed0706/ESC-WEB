<?php
/**
 * Trang 404 — không tìm thấy nội dung.
 *
 * WordPress tự đặt mã phản hồi HTTP 404 cho template này (is_404() → 404 header
 * do WP::handle_404() gửi ĐI TRƯỚC khi template chạy), nên KHÔNG cần và KHÔNG
 * nên gọi status_header(404) ở đây — gọi lại chỉ thừa, và nếu đặt sai chỗ (sau
 * khi đã xuất ra HTML) sẽ thành lỗi "headers already sent".
 *
 * Bố cục: một cột căn giữa — mã 404 lớn, tiêu đề, câu dẫn, ô tìm kiếm, rồi hai
 * lối thoát (về trang chủ / xem tin tức). Ô tìm kiếm đặt TRƯỚC nút vì phần lớn
 * người đến đây là gõ sai/theo link chết, tìm lại nhanh hơn là về trang chủ dò.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$ecsges_news_url = ecsges_translate_path( '/tin-tuc/' );
?>
	<main class="ecs-404">
		<div class="ecs-404__inner">
			<p class="ecs-404__code" aria-hidden="true">404</p>

			<h1 class="ecs-404__title"><?php echo esc_html( ecsges_t( 'Không tìm thấy trang' ) ); ?></h1>

			<p class="ecs-404__text">
				<?php echo esc_html( ecsges_t( 'Trang bạn tìm không tồn tại, đã được đổi đường dẫn hoặc đã bị gỡ. Hãy thử tìm kiếm bên dưới hoặc quay lại trang chủ.' ) ); ?>
			</p>

			<div class="ecs-404__search">
				<?php get_search_form(); ?>
			</div>

			<div class="ecs-404__actions">
				<?php ecsges_see_more( function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' ), 'VỀ TRANG CHỦ' ); ?>
				<a href="<?php echo esc_url( $ecsges_news_url ); ?>" class="ecs-404__link">
					<?php echo esc_html( ecsges_t( 'Xem tin tức mới nhất' ) ); ?>
				</a>
			</div>
		</div>
	</main>
<?php
get_footer();
