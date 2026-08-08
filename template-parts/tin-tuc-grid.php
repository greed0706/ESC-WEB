<?php
/**
 * Trang Tin tức — lưới card 3 cột + phân trang (Figma node 746:1184).
 *
 * Hiển thị 3 bài (1 hàng) trước, kèm nút "XEM THÊM" ở giữa 2 đường kẻ mảnh
 * (Figma node 746:284) — mỗi lần bấm hiện thêm 1 hàng nữa, hết bài thì nút tự
 * ẩn. Không dùng phân trang số nữa.
 *
 * Đo từ Figma (frame 1920, container 316→1594 = 1278):
 *   - Lưới 3 cột, card 408×480, gap 27 (ngang) / 31 (dọc).
 *   - Card nền trắng: ảnh 408×244 (tỉ lệ 408/244), rồi lề trong 19/20px:
 *       chuyên mục 16px Light #747272   (cách đáy ảnh 18px)
 *       tiêu đề    22px Regular #000, line-height 28, tối đa 2 dòng
 *       tóm tắt    18px Light #747272, line-height 26, tối đa 2 dòng
 *       ngày 16px Light + nút "Xem thêm" 103×34 bo 20px nền #f05a28
 *   - Phân trang: 5 nút tròn Ø44, gap 13, canh giữa, cách lưới 77px.
 *     Nút đang chọn nền #f05a28 chữ trắng, còn lại nền #f3f3f3 chữ #a4a4a4.
 *
 * Thay cho tin-tuc-featured.php + tin-tuc-knowledge.php (bố cục "Tin nổi bật"
 * + carousel "Kiến thức" cũ). Dữ liệu là BÀI VIẾT WP THẬT, không còn hardcode.
 *
 * @package ECSGES
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Số bài hiện lúc mới vào trang, cũng là số bài hiện thêm sau mỗi lần bấm
// "XEM THÊM" — 3 = đúng 1 hàng của lưới 3 cột.
$tt_step = 3;

// Lấy TOÀN BỘ bài rồi ẩn bớt bằng CSS/JS (không phân trang). Đủ dùng cho một
// trang tin doanh nghiệp; nếu số bài lên tới hàng trăm thì nên đổi nút này
// sang tải thêm bằng AJAX thay vì render sẵn.
$tt_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => -1,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

$tt_total = (int) $tt_query->post_count;
$tt_index = 0;
?>
<section class="ecs-news-grid" aria-label="<?php echo esc_attr( ecsges_t( 'Danh sách tin tức' ) ); ?>">
	<div class="ecs-news-grid__inner">
		<?php if ( $tt_query->have_posts() ) : ?>
			<ul class="ecs-news-grid__list" data-aos="fade-up" data-news-grid data-news-step="<?php echo esc_attr( $tt_step ); ?>">
				<?php
				while ( $tt_query->have_posts() ) :
					$tt_query->the_post();

					// Nhãn chuyên mục = category đầu tiên của bài (Figma: "TIN BÁO CHÍ").
					$tt_cats  = get_the_category();
					$tt_label = ! empty( $tt_cats ) ? $tt_cats[0]->name : '';

					// Bài từ thứ 4 trở đi = phần "ẩn sẵn", chỉ hiện sau khi bấm
					// "XEM THÊM". Class --extra chỉ có tác dụng khi <html> có class
					// .js (header.php gắn trước lúc paint) → tắt JS thì hiện đủ bài.
					$tt_extra = ( $tt_index >= $tt_step ) ? ' ecs-news-grid__item--extra' : '';
					$tt_index++;
					?>
					<li class="ecs-news-grid__item<?php echo esc_attr( $tt_extra ); ?>" data-news-item>
						<article class="ecs-news-card">
							<a href="<?php the_permalink(); ?>" class="ecs-news-card__media" tabindex="-1" aria-hidden="true">
								<img
									src="<?php echo esc_url( ecsges_post_thumb( get_the_ID(), 'large' ) ); ?>"
									alt=""
									loading="lazy"
									decoding="async"
									class="ecs-news-card__img">
							</a>

							<div class="ecs-news-card__body">
								<?php if ( '' !== $tt_label ) : ?>
									<p class="ecs-news-card__cat"><?php echo esc_html( $tt_label ); ?></p>
								<?php endif; ?>

								<h3 class="ecs-news-card__title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>

								<p class="ecs-news-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>

								<div class="ecs-news-card__foot">
									<?php // Figma ghi ngày dạng 29/06/2026, không dùng định dạng mặc định 'M j, Y'. ?>
									<span class="ecs-news-card__date"><?php echo esc_html( ecsges_post_time( null, 'd/m/Y' ) ); ?></span>
									<a href="<?php the_permalink(); ?>" class="ecs-news-card__more"><?php echo esc_html( ecsges_t( 'Xem thêm' ) ); ?></a>
								</div>
							</div>
						</article>
					</li>
					<?php
				endwhile;
				?>
			</ul>

			<?php
			// "XEM THÊM" giữa 2 đường kẻ mảnh (Figma node 746:284): chữ cam 18px
			// gạch chân 3px. Chỉ render khi thực sự còn bài bị ẩn.
			?>
			<?php if ( $tt_total > $tt_step ) : ?>
				<div class="ecs-news-grid__more" data-news-more-wrap>
					<button type="button" class="ecs-news-grid__more-btn" data-news-more><?php echo esc_html( ecsges_t( 'XEM THÊM' ) ); ?></button>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<p class="ecs-news-grid__empty"><?php echo esc_html( ecsges_t( 'Chưa có bài viết.' ) ); ?></p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
