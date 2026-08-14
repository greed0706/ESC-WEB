<?php
/**
 * Trang Tin tức — lưới card 3 cột + phân trang (Figma node 746:1184).
 *
 * QUERY 1 LẦN DUY NHẤT — TẤT CẢ bài viết in thẳng ra DOM (data-news-item, kèm
 * data-cats liệt kê slug MỌI category của bài đó). Tab chuyên mục
 * (tin-tuc-tabs.php) và phân trang không còn round-trip WP_Query/URL nữa —
 * initNewsTabsGrid() trong assets/js/main.js chỉ ẨN/HIỆN <li> theo tab đang
 * chọn (đúng kiểu "query trước, ẩn hiện sau" của bản React cũ), giống hệt cách
 * initJobsFilter() làm với danh sách việc làm.
 *
 * Mỗi trang tối đa 9 bài (3 hàng). TRANG 1 hiển thị 3 bài (1 hàng) trước, kèm
 * nút "XEM THÊM" ở giữa 2 đường kẻ mảnh (Figma node 746:284) — mỗi lần bấm hiện
 * thêm 1 hàng, đủ 9 bài thì nút tự ẩn. TỪ TRANG 2 trở đi (người dùng đã chủ động
 * bấm số trang) hiện thẳng đủ 9 bài. Đổi tab luôn reset về trang 1.
 *
 * Không JS: KHÔNG có markup nào bị ẩn sẵn bằng PHP (không còn class --extra khi
 * SSR) — mọi bài viết hiện đủ, phẳng, không phân trang/lọc (tab lúc đó chỉ là
 * nhãn, không làm gì) — đúng nguyên tắc cũ "tắt JS thì hiện đủ bài", còn rộng
 * rãi hơn cả danh sách việc làm (vốn chỉ hiện trang 1 khi tắt JS).
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

// Số bài hiện lúc mới vào trang 1 (và sau mỗi lần đổi tab), cũng là số bài hiện
// thêm sau mỗi lần bấm "XEM THÊM" — 3 = đúng 1 hàng của lưới 3 cột.
$tt_step = 3;

// 9 bài/trang = 3 hàng (Figma node 746:1184 vẽ đúng lưới 3×3 + dãy nút số trang).
$tt_per_page = 9;

// Lấy TẤT CẢ bài viết 1 lần — JS lọc/phân trang lại tại chỗ nên không cần
// WP_Query theo 'paged' hay 'category_name' nữa.
$tt_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => -1,
		'orderby'             => 'date',
		'order'               => 'DESC',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);
?>
<section class="ecs-news-grid" aria-label="<?php echo esc_attr( ecsges_t( 'Danh sách tin tức' ) ); ?>">
	<div class="ecs-news-grid__inner">
		<?php if ( $tt_query->have_posts() ) : ?>
			<ul
				id="tin-tuc-grid-list"
				class="ecs-news-grid__list"
				data-aos="fade-up"
				data-news-grid
				data-news-step="<?php echo esc_attr( $tt_step ); ?>"
				data-news-per="<?php echo esc_attr( $tt_per_page ); ?>"
			>
				<?php
				while ( $tt_query->have_posts() ) :
					$tt_query->the_post();

					$tt_cats  = get_the_category();
					// Nhãn hiển thị trên card = category đầu tiên (Figma: "TIN BÁO CHÍ").
					$tt_label = ! empty( $tt_cats ) ? $tt_cats[0]->name : '';
					// data-cats = MỌI slug của bài (không chỉ cái đầu) để JS khớp đúng
					// khi bài thuộc nhiều chuyên mục cùng lúc.
					$tt_cat_slugs = implode( ' ', wp_list_pluck( $tt_cats, 'slug' ) );
					?>
					<li class="ecs-news-grid__item" data-news-item data-cats="<?php echo esc_attr( $tt_cat_slugs ); ?>">
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

			<?php // "XEM THÊM" (Figma node 746:284) — JS hiện/ẩn tuỳ trang + tab, mặc định ẩn tới khi initNewsTabsGrid() tính lại. ?>
			<div class="ecs-news-grid__more" data-news-more-wrap hidden>
				<button type="button" class="ecs-news-grid__more-btn" data-news-more><?php echo esc_html( ecsges_t( 'XEM THÊM' ) ); ?></button>
			</div>

			<?php // Dãy nút số trang tròn (Figma: Ø44, gap 13) — JS dựng lại mỗi khi tab/trang đổi, xem initNewsTabsGrid(). ?>
			<nav
				class="ecs-news-grid__pagination"
				data-news-pagination
				data-page-label="<?php echo esc_attr( ecsges_t( 'Trang' ) ); ?>"
				hidden
				aria-label="<?php echo esc_attr( ecsges_t( 'Phân trang tin tức' ) ); ?>"
			>
				<ul class="ecs-news-grid__pages" data-news-pages></ul>
			</nav>

			<p class="ecs-news-grid__empty" data-news-empty hidden><?php echo esc_html( ecsges_t( 'Chưa có bài viết.' ) ); ?></p>
		<?php else : ?>
			<p class="ecs-news-grid__empty"><?php echo esc_html( ecsges_t( 'Chưa có bài viết.' ) ); ?></p>
		<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
