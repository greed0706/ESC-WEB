<?php
/**
 * Template Name: Trang nội dung chung
 *
 * Template DÙNG CHUNG cho mọi Page mà nội dung được gõ thẳng trong trình soạn
 * thảo WordPress thay vì dựng cứng bằng template riêng — hiện dùng cho 3 trang
 * pháp lý (Chính sách quyền riêng tư / Chính sách cookie / Điều khoản dịch vụ),
 * và dùng lại được cho bất kỳ trang chữ nào về sau (Tuyển sinh, FAQ, thông báo…).
 *
 * CÁCH DÙNG (trong admin):
 *   1. Trang → Thêm trang mới, đặt tiêu đề + slug.
 *      3 slug mà footer đang chờ (xem ecsges_footer_legal_pages() trong
 *      inc/data.php) là: chinh-sach-quyen-rieng-tu, chinh-sach-cookie,
 *      dieu-khoan-dich-vu. Đúng slug thì link tự hiện ở thanh cuối footer.
 *   2. Dán nội dung vào ô soạn thảo (h2/h3, đoạn văn, danh sách, bảng đều đã
 *      có style sẵn — xem .ecs-doc__content trong components/_posts.scss).
 *   3. Page Attributes → Template → chọn "Trang nội dung chung".
 *
 * BẮT BUỘC phải chọn template ở bước 3: theme này CỐ Ý không có page.php
 * (ecsges_translated_page_template() trong functions.php bám vào việc WP rơi
 * xuống index.php để định tuyến trang bản dịch). Page không chọn template sẽ
 * rơi xuống index.php và hiện ra trơ trụi.
 *
 * Bản dịch Polylang KHÔNG cần chọn lại: filter nói trên tự lấy template mà bản
 * gốc đã chọn tay.
 *
 * Bố cục cố ý mộc, một cột hẹp — đây là trang để ĐỌC, không phải trang
 * marketing: dải breadcrumb xám full-bleed (dùng lại của single.php), tiêu đề,
 * ngày cập nhật, rồi phần chữ.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
	<main class="ecs-doc">
		<?php // Breadcrumb nằm NGOÀI container: nền xám chạy hết chiều ngang. ?>
		<?php ecsges_breadcrumb(); ?>

		<div class="ecs-doc__inner">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class( 'ecs-doc__article' ); ?>>
					<h1 class="ecs-doc__title"><?php the_title(); ?></h1>

					<?php
					// Ngày cập nhật: trang pháp lý bắt buộc phải cho người đọc biết
					// bản đang xem có từ bao giờ. So sánh timestamp thay vì chuỗi đã
					// định dạng — hai lần sửa trong CÙNG một ngày vẫn khác giờ, so
					// chuỗi ngày sẽ ra "đã sửa" trong khi thực chất chưa từng sửa.
					$ecsges_published = (int) get_post_time( 'U', true );
					$ecsges_modified  = (int) get_post_modified_time( 'U', true );
					$ecsges_is_edited = ( $ecsges_modified - $ecsges_published ) > MINUTE_IN_SECONDS;
					?>
					<p class="ecs-doc__meta">
						<?php echo esc_html( ecsges_t( $ecsges_is_edited ? 'Cập nhật lần cuối:' : 'Ngày đăng:' ) ); ?>
						<time datetime="<?php echo esc_attr( get_post_modified_time( 'c', true ) ); ?>"><?php echo esc_html( get_post_modified_time( 'd/m/Y' ) ); ?></time>
					</p>

					<div class="ecs-doc__content">
						<?php
						the_content();

						// Nội dung dài thường bị cắt trang bằng <!--nextpage-->.
						wp_link_pages(
							array(
								'before' => '<div class="ecs-doc__pagination">' . esc_html( ecsges_t( 'Trang:' ) ) . ' ',
								'after'  => '</div>',
							)
						);
						?>
					</div>
				</article>
				<?php
			endwhile;
			?>
		</div>
	</main>
<?php
get_footer();
