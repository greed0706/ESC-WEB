<?php
/**
 * Trang Tin tức — lưới card 3 cột + phân trang (Figma node 746:1184).
 *
 * Mỗi trang tối đa 9 bài (3 hàng). TRANG 1 hiển thị 3 bài (1 hàng) trước, kèm
 * nút "XEM THÊM" ở giữa 2 đường kẻ mảnh (Figma node 746:284) — mỗi lần bấm hiện
 * thêm 1 hàng, đủ 9 bài thì nút tự ẩn. TỪ TRANG 2 trở đi (người dùng đã chủ động
 * bấm số trang) hiện thẳng đủ 9 bài, không còn nút "XEM THÊM".
 *
 * Khi tổng số bài > 9 thì dưới lưới có dãy nút số trang tròn.
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

// Số bài hiện lúc mới vào trang 1, cũng là số bài hiện thêm sau mỗi lần bấm
// "XEM THÊM" — 3 = đúng 1 hàng của lưới 3 cột.
$tt_step = 3;

// 9 bài/trang = 3 hàng (Figma node 746:1184 vẽ đúng lưới 3×3 + dãy nút số trang).
$tt_per_page = 9;

// Template này chạy trên một PAGE, nên rewrite rule của WP đổ số trang vào
// query var `page` (/tin-tuc/page/2/ → page=2), KHÔNG phải `paged` như archive.
// Đọc cả hai để còn dùng lại được nếu sau này gắn vào ngữ cảnh khác.
$tt_paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );

$tt_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $tt_per_page,
		'paged'               => $tt_paged,
		'ignore_sticky_posts' => true,
	)
);

$tt_total = (int) $tt_query->post_count;
$tt_pages = (int) $tt_query->max_num_pages;
$tt_index = 0;

// Chỉ trang 1 mới ẩn bớt bài + hiện nút "XEM THÊM". Từ trang 2 người dùng đã
// chủ động chọn trang nên đổ thẳng đủ 9 bài.
$tt_lazy = ( 1 === $tt_paged );
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

					// Trang 1: bài từ thứ 4 trở đi = phần "ẩn sẵn", chỉ hiện sau khi bấm
					// "XEM THÊM". Class --extra chỉ có tác dụng khi <html> có class
					// .js (header.php gắn trước lúc paint) → tắt JS thì hiện đủ bài.
					$tt_extra = ( $tt_lazy && $tt_index >= $tt_step ) ? ' ecs-news-grid__item--extra' : '';
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
			<?php
			$tt_has_more_btn = ( $tt_lazy && $tt_total > $tt_step );
			?>
			<?php if ( $tt_has_more_btn ) : ?>
				<div class="ecs-news-grid__more" data-news-more-wrap>
					<button type="button" class="ecs-news-grid__more-btn" data-news-more><?php echo esc_html( ecsges_t( 'XEM THÊM' ) ); ?></button>
				</div>
			<?php endif; ?>

			<?php
			// Dãy nút số trang tròn (Figma: Ø44, gap 13, canh giữa, cách lưới 77px).
			// Chỉ có khi tổng số bài vượt 9 → $tt_pages > 1.
			//
			// Chừng nào còn nút "XEM THÊM" thì dãy số trang bị ẩn (class .is-pending);
			// initNewsLoadMore() gỡ class đó đúng lúc nút biến mất, tức khi trang 1 đã
			// mở đủ 9 bài. Từ trang 2 không có nút nên dãy số hiện ngay. CSS gate bằng
			// .js nên tắt JS thì dãy số vẫn hiện bình thường.
			//
			// paginate_links() tự dựng URL từ get_pagenum_link(), vốn đã xử lý đúng
			// dạng /tin-tuc/page/2/ cho Page, nên không truyền 'base'/'format' thủ công.
			// prev_next = false vì Figma chỉ vẽ số, không có mũi tên.
			if ( $tt_pages > 1 ) :
				$tt_links = paginate_links(
					array(
						'current'   => $tt_paged,
						'total'     => $tt_pages,
						'mid_size'  => 2,
						'end_size'  => 1,
						'prev_next' => false,
						'type'      => 'array',
					)
				);

				if ( ! empty( $tt_links ) ) :
					$tt_pending = $tt_has_more_btn ? ' is-pending' : '';
					?>
					<nav class="ecs-news-grid__pagination<?php echo esc_attr( $tt_pending ); ?>" data-news-pages aria-label="<?php echo esc_attr( ecsges_t( 'Phân trang tin tức' ) ); ?>">
						<ul class="ecs-news-grid__pages">
							<?php foreach ( $tt_links as $tt_link ) : ?>
								<li class="ecs-news-grid__page"><?php echo wp_kses_post( $tt_link ); ?></li>
							<?php endforeach; ?>
						</ul>
					</nav>
					<?php
				endif;
			endif;
			?>
		<?php else : ?>
			<p class="ecs-news-grid__empty"><?php echo esc_html( ecsges_t( 'Chưa có bài viết.' ) ); ?></p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
